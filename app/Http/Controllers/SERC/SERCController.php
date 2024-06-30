<?php

namespace App\Http\Controllers\SERC;

use App\Http\Controllers\Controller;
use App\Http\Requests\SERC\StoreSERCRequest;
use App\Models\SERC\SERC;
use Illuminate\Http\Request;

class SERCController extends Controller
{
    public function index() {

        return view('admin.sercs.index', ['sercs' => \App\Models\SERC\SERC::paginate(10)]);

    }

    public function add() {

        return view('admin.sercs.add');

    }

    public function store(StoreSERCRequest $request) {
            
            $serc = new \App\Models\SERC\SERC();
            $serc->name = $request->name;
            $serc->description = $request->description;
            $serc->when = $request->when;
            $serc->where = $request->where;
            $serc->save();
    
            return redirect()->route('admin.sercs');
    }

    public function show(SERC $serc) {
            
            return view('admin.sercs.show', ['serc' => $serc]);
    }

    public function update(StoreSERCRequest $request, SERC $serc) {
            
            $serc->name = $request->name;
            $serc->description = $request->description;
            $serc->when = $request->when;
            $serc->where = $request->where;
            $serc->save();
    
            return redirect()->route('admin.sercs.show', $serc)->with('message', 'Updated SERC!');
    }
}
