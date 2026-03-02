<?php

namespace App\Repositories;

use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

use App\Models\Article;
use App\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function index()
    {
        return Article::all();
    }

    public function getById($id)
    {
        return Article::findOrFail($id);
    }

    public function store(array $data)
    {
        return Article::create($data);
    }

    public function update(array $data,$id)
    {
        return Article::whereId($id)->update($data);
    }
    
    public function delete($id)
    {
        Article::destroy($id);
    }
}
