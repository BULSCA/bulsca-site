<?php

namespace App\Repositories;

use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

use App\Models\Competition;
use App\Interfaces\CompetitionRepositoryInterface;

class CompetitionRepository implements CompetitionRepositoryInterface
{
    public function index()
    {
        return Competition::all();
    }

    public function getById($id)
    {
        return Competition::findOrFail($id);
    }

    public function store(array $data)
    {
        return Competition::create($data);
    }

    public function update(array $data, $id)
    {
        return Competition::whereId($id)->update($data);
    }

    public function delete($id)
    {
        Competition::destroy($id);
    }
}
