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

    public function governance()
    {

        $cmr = new ResourcePack('Competition Manual and Rules');
        $cmr->add('BULSCA COVID-19 Guidance (Sept 2021)');
        $cmr->add('BULSCA Championships Rules 2022');
        $cmr->add('RLSS Speeds Rules 2020');
        $cmr->add('CM 2021 - Part 1 - Manual');
        $cmr->add('CM 2021 - Part 2 - Events');
        $cmr->add('CM 2021 - Part 3 - Disqualification and Penalty Codes');
        $cmr->add('CM 2021 - Part 4 - Forms');
        $cmr->add('RLSS Nationals Rules 2018');

        $og = new ResourcePack('Other Governance');
        $og->add('Constitution v2.5');
        $og->add('Judges Panel Guidelines V2.2');
        $og->add('Online Voting Procedures');
        $og->add('Disciplinary Procedure V1.3');
        $og->add('Competition Finance Pack');
        $og->add('League Competition Application Pack (2021-22)');
        $og->add('Calculation of Results');
        $og->add('Alterations for First Competition of Season');
        $og->add('Officiating Pathway');
        $og->add('SERC Writing Guidelines v2.0');
        $og->add('Procedures for Dealing with Proposals v1.0');
        $og->add('Competition Allocation Policy');

        $oc = new ResourcePack('Organising a Competition');
        $oc->add('Competition Scoresheet v17.3 - Blank');
        $oc->add('Competition Speeds - Lane Template');
        $oc->add('Competition Speeds - Chief Template');
        $oc->add('SERC Setter and Judges Allocation Guidelines');
        $oc->add('Competition Finance Pack');
        $oc->add('Competition Preparation Gantt Chart');
        $oc->add('Competition Day Gantt Chart');
        $oc->add('Competition Checklist');
        $oc->add('Quick Guide to Scoring');
        $oc->add('Judge Allocation Sheet');
        $oc->add('Organising Officials');

        $res = [
            $cmr->bundle(),
            $og->bundle(),
            $oc->bundle()
        ];

        return view('resources.governance', ['res' => $res]);
    }

    public function get(Request $req, $id)
    {

        $resource = Resource::find($id);

        if ($req->has('dl')) {
            return Storage::download($resource->location);
        }

        if (!$resource) {
            abort(404);
        }


        $fileContents = Storage::get($resource->location);
        $type = File::mimeType(Storage::path($resource->location));

        $response = Response::make($fileContents, 200);
        $response->header("Content-Type", $type);
        $response->header("Content-Disposition", "filename=" . $resource->name . "." . pathinfo($resource->location)['extension'] . "");
        return $response;
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
