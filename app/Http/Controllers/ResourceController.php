<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourceController extends Controller
{


    public function get(Request $req, $id)
    {

        $resource = Resource::find($id);
        $extension = pathinfo($resource->location)['extension'];

        if (!$resource) {
            abort(404);
        }

        if ($req->has('dl')) {
            return Storage::download($resource->location, $resource->name . '.' . $extension);
        }

        return response()->file(Storage::path($resource->location), ["Content-Disposition" => "filename=" . $resource->name . "." . $extension]);




    }



    public function upload(Request $request)
    {



        $path = $request->file('fupload')->store('resources');



        $res = new Resource();
        $res->location = $path;
        $res->name = $request->input('name', 'file');
        $res->save();

        return $res->id;
    }

    static function storeFile($file, $where, $fileName = 'file')
    {

        if ($fileName == "self") {
            $fileName = $file->getClientOriginalName();
        }

        $storeName = Str::random(40) . "." . $file->getClientOriginalExtension();
        $path = Storage::putFileAs($where, $file, $storeName);

        $res = new Resource();
        $res->location = $path;
        $res->name = $fileName;
        $res->save();

        return $res;
    }

    static function storeResource(Request $request, $postFileName, $where, $fileName = 'file')
    {
        //die($request->file($postFileName)->getClientOriginalName());
        //$path = $request->file($postFileName)->store($where);



        if ($fileName == "self") {
            $fileName = $request->file($postFileName)->getClientOriginalName();
        }

        $storeName = Str::random(40) . "." . $request->file($postFileName)->getClientOriginalExtension();
        $path = Storage::putFileAs($where, $request->file($postFileName), $storeName);



        $res = new Resource();
        $res->location = $path;
        $res->name = $request->input('name', $fileName);
        $res->save();

        return $res;
    }

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => "required"
        ]);

        $res = Resource::findOrFail($validated['id']);

        Storage::delete($res->location);

        $res->delete();

        if ($request->input('redirect')) return redirect()->route($request->input('redirect'));

        return redirect()->back();
    }

    public function editResource(Resource $resource)
    {
        return view('admin.resources.edit', ['resource' => $resource]);
    }

    public function editResourcePost(Request $request, Resource $resource)
    {

        $resource->name = $request->input('name', $resource->name);
        $resource->save();

        return redirect()->back();
    }

    public function reupload(Request $request, Resource $resource)
    {
        Storage::delete($resource->location);
        $storeName = Str::random(40) . "." . $request->file("resource")->getClientOriginalExtension();
        $path = Storage::putFileAs("resources/resources", $request->file("resource"), $storeName);

        $resource->location = $path;
        $resource->name = $request->input('name', $resource->name);
        $resource->save();

        return redirect()->back();
    }
}


class ResourcePack
{

    private $resources = [];
    private $name;
    private $count = 1;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function add($name)
    {
        array_push($this->resources, [
            'name' => $name,
            'id' => $this->count
        ]);
        $this->count++;
    }

    public function bundle()
    {
        return [
            'name' => $this->name,
            'resources' => $this->resources
        ];
    }
}
