<?php

namespace App\Http\Controllers\SERC;

use App\Http\Controllers\Controller;
use App\Models\Casualty\Casualty;
use Illuminate\Http\Request;

class CasualtyController extends Controller
{
    public function index() {
        return view('admin.sercs.casualties.index', ['casualties' => Casualty::paginate(12)]);
    }

    public function add() {

    }

    public function store() {

    }

    public function show() {

    }

    public function update() {

    }

    public function delete() {

    }
}
