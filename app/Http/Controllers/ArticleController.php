<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Models\Article;
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

        return view('articles.view', ['article' => Article::findOrFail($id)]);
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

        return view('articles.edit', ['article' => Article::findOrFail($id)]);
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
}
