<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRatingRequest;
use App\Http\Requests\CreateArticleRequest;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index()
    {

        $pinned = Article::where('pinned', true)->orderBy('created_at', 'DESC')->get('id');


        return view('articles.index', ['catagoryName' => 'Latest', 'pinned' => Article::where('pinned', true)->orderBy('created_at', 'DESC')->get(), 'articles' => Article::orderBy('created_at', 'DESC')->whereNotIn('id', $pinned)->paginate(8)]);
    }

    public function view($slug)
    {
        $exp = explode('.', $slug);

        $id = $exp[count($exp) - 1];

        $article = Article::findOrFail($id);

        $article->views = $article->views + 1;
        $article->save();

        return view('articles.view', ['article' => $article]);
    }

    public function create(CreateArticleRequest $request)
    {
        $validated = $request->validated();

        $a = new Article();
        $a->title = $validated['title'];
        $a->content = $validated['content'];

        if (array_key_exists('pinned', $validated)) {
            $a->pinned = true;
        }

        $a->save();

        return redirect()->route('article.view', $a->getSlug())->with('message', 'Created article!');
    }

    public function createView()
    {
        return view('articles.create', ['tags' => Tag::all()]);
    }

    public function editView($slug)
    {
        $exp = explode('.', $slug);

        $id = $exp[count($exp) - 1];

        return view('articles.edit', ['article' => Article::findOrFail($id), 'tags' => Tag::all()]);
    }

    public function edit(CreateArticleRequest $request, $slug)
    {
        $validated = $request->validated();

        $exp = explode('.', $slug);

        $id = $exp[count($exp) - 1];

        $a = Article::findOrFail($id);
        $a->title = $validated['title'];
        $a->content = $validated['content'];

        // Sync tags
        $a->tags()->sync($request->input('tags', []));
    

        if (array_key_exists('pinned', $validated)) {
            $a->pinned = true;
        } else {
            $a->pinned = false;
        }

        $a->save();

        return redirect()->route('article.view', $a->getSlug())->with('message', 'Article updated successfully!');
    }

    public function delete($slug)
    {


        $a = Article::findOrFail($slug);
        $a->delete();

        return redirect()->route('latest')->with('message', 'Article deleted!');
    }

    public function ratingChange(ArticleRatingRequest $request)
    {
        $validated = $request->validated();

        if (!in_array($validated['type'], ['up', 'down'])) return;

        $article = Article::findOrFail($validated['article']);

        if ($validated['type'] === "up") {
            $article->thumbs_up = $article->thumbs_up + 1;
        } else {
            $article->thumbs_down = $article->thumbs_down + 1;
        }

        $article->save();

        return response(200);
    }

    public function byTag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        
        // Get pinned articles that have this tag
        $pinnedIds = Article::where('pinned', true)
            ->whereHas('tags', function($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->orderBy('created_at', 'DESC')
            ->pluck('id');
        
        $pinned = Article::whereIn('id', $pinnedIds)->get();
        
        // Get non-pinned articles with this tag
        $articles = Article::whereHas('tags', function($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->whereNotIn('id', $pinnedIds)
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        
        return view('articles.index', [
            'catagoryName' => 'Catagory: ' . $tag->name,
            'pinned' => $pinned,
            'articles' => $articles,
            'tagFilter' => $tag, // Optional: to show which tag is filtered
        ]);
    }
}
