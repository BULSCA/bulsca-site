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


        //return view('articles.index', ['catagoryName' => 'Latest', 'pinned' => Article::where('pinned', true)->orderBy('created_at', 'DESC')->get(), 'articles' => Article::orderBy('created_at', 'DESC')->whereNotIn('id', $pinned)->paginate(8)]);
        return response()->json(['message' => 'Results saved!']);
    }
}