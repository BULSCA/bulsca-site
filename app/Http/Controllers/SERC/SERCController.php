<?php

namespace App\Http\Controllers\SERC;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\SERC\StoreSERCRequest;
use App\Models\Resource;
use App\Models\SERC\SERC;
use App\Models\SERC\SERCTag;
use DB;
use Illuminate\Http\Request;
use Storage;

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

            $tags = explode(',', $request->tags);
            foreach ($tags as $tag) {
                if ($tag == '') continue;
                $tag = SERCTag::firstOrCreate(['name' => $tag]);
                $tag->save();
                DB::table('tagged_sercs')->insert(['serc_id' => $serc->id, 'serc_tag_id' => $tag->id]);
            }
    
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

            // Handle files
     
            $files = $request->file('files');
            if ($files != null) {
           
                foreach ($files as $file) {
                  
                   
                  
                    $res = ResourceController::storeFile($file, 'sercs/' . $serc->id, 'self');
                    $res->save();

                    DB::table('serc_resources')->insert(['serc_id' => $serc->id, 'resource_id' => $res->id]);

                }
            }

         
            
            
            // Handle tags - remove all tags and re-add
            $tags = explode(',', $request->tags);
            DB::table('tagged_sercs')->where('serc_id', $serc->id)->delete();
            foreach ($tags as $tag) {
                if ($tag == '') continue;
                $tag = SERCTag::firstOrCreate(['name' => $tag]);
                $tag->save();
                DB::table('tagged_sercs')->insert(['serc_id' => $serc->id, 'serc_tag_id' => $tag->id]);
            }
    
            return redirect()->route('admin.sercs.show', $serc)->with('message', 'Updated SERC!');
    }

    public function tags() {
        return response()->json(SERCTag::select('name')->distinct()->pluck('name')->toArray());
    }

    public function delete(SERC $serc) {

        $serc->delete();
        return redirect()->route('admin.sercs')->with('message', 'SERC Deleted!');
    }

    public function deleteResource(SERC $serc, Request $request) {
        $validated = $request->validate([
            'id' => 'required'
        ]);

        DB::table('serc_resources')->where('serc_id', $serc->id)->where('resource_id', $validated['id'])->delete();
        
        $res = Resource::findOrFail($validated['id']);

        Storage::delete($res->location);

        $res->delete();

        return;
    }
}
