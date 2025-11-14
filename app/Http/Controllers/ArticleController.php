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


        return view('articles.index', ['pinned' => Article::where('pinned', true)->orderBy('created_at', 'DESC')->get(), 'articles' => Article::orderBy('created_at', 'DESC')->whereNotIn('id', $pinned)->paginate(8)]);
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

        if (array_key_exists('pinned', $validated)) {
            $a->pinned = true;
        } else {
            $a->pinned = false;
        }

        $a->save();

        return redirect()->route('article.view', $a->getSlug())->with('message', 'Updated article!');
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
}
