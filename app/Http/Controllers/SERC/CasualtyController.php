<?php

namespace App\Http\Controllers\SERC;

use App\Http\Controllers\Controller;
use App\Http\Requests\SERC\StoreCasualtyRequest;
use App\Models\Casualty\Casualty;
use App\Models\Casualty\CasualtyGroup;
use App\Models\SERC\SERCTag;
use App\Services\ImageService;
use DB;
use Illuminate\Http\Request;

class CasualtyController extends Controller
{
    public function index()
    {

        $casualties = null;

        if (request('s') != null) {
            $casualties = Casualty::where('name', 'LIKE', '%'.request('s').'%')->orderBy('name');
        } else {
            $casualties = Casualty::orderBy('name');
        }

        return view('admin.sercs.casualties.index', ['casualties' => $casualties->paginate(12)]);
    }

    public function add()
    {

        $groups = CasualtyGroup::orderBy('name')->get();

        return view('admin.sercs.casualties.add', ['groups' => $groups]);
    }

    public function store(StoreCasualtyRequest $request)
    {

        $casualty = new Casualty;
        $casualty->name = $request->name;
        $casualty->description = $request->description;
        $casualty->manual_reference = $request->manual;
        $casualty->group = $request->group;

        $casualty->save();

        $tags = explode(',', $request->tags);
        foreach ($tags as $tag) {
            if ($tag == '') {
                continue;
            }
            $tag = SERCTag::firstOrCreate(['name' => $tag]);
            $tag->save();
            DB::table('tagged_casualties')->insert(['casualty_id' => $casualty->id, 'serc_tag_id' => $tag->id]);
        }

        return redirect()->route('admin.sercs.casualties')->with('success', 'Created casualty!');
    }

    public function show(Casualty $casualty)
    {

        $groups = CasualtyGroup::orderBy('name')->get();

        return view('admin.sercs.casualties.show', ['casualty' => $casualty, 'groups' => $groups]);
    }

    public function update(Casualty $casualty, StoreCasualtyRequest $request)
    {

        $casualty->name = $request->name;
        $casualty->description = $request->description;
        $casualty->manual_reference = $request->manual;
        $casualty->group = $request->group;

        $casualty->save();

        // Handle tags - remove all tags and re-add
        $tags = explode(',', $request->tags);
        DB::table('tagged_casualties')->where('casualty_id', $casualty->id)->delete();
        foreach ($tags as $tag) {
            if ($tag == '') {
                continue;
            }
            $tag = SercTag::firstOrCreate(['name' => $tag]);
            $tag->save();
            DB::table('tagged_casualties')->insert(['casualty_id' => $casualty->id, 'serc_tag_id' => $tag->id]);
        }

        return redirect()->back()->with('message', 'Updated Casualty!');
    }

    public function addImage(Casualty $casualty, Request $request)
    {

        $path = ImageService::store($request, '/casualties/'.$casualty->id, 'image', true);

        $img = $casualty->getImages()->create(['path' => $path]);

        $imageUrl = ImageService::getUrl($path);

        return response()->json(['success' => true, 'url' => $imageUrl, 'id' => $img->id]);
    }

    public function deleteImage(Casualty $casualty, Request $request)
    {

        $image = $casualty->getImages->where('id', $request->id)->first();

        if ($image == null) {
            return response()->json(['success' => false]);
        }

        ImageService::delete($image->path);

        $image->delete();

        return response()->json(['success' => true]);
    }

    public function delete(Casualty $casualty)
    {

        $casualty->delete();

        return redirect()->route('admin.sercs.casualties')->with('message', 'Deleted casualty!');
    }

    public function publicCasualties()
    {
        $casualties = Casualty::orderBy('name')->paginate(12);

        $filterOptions['groups'] = CasualtyGroup::orderBy('name')->get();

        return view('resources.casualties', ['casualties' => $casualties, 'filterOptions' => $filterOptions]);
    }

    public function publicSearch()
    {

        // Two queries - one for searching with no tags as its simple

        $query = Casualty::with('getCasualtyGroup:name,id')->with('getImages', function ($query) {
            $query->limit(1);
        });

        if (request('group') != 'all') {

            $groupId = CasualtyGroup::where('id', request('group'))->first()->id;

            $query = $query->where('group', $groupId);
        }

        if (request('search') != '') {
            $query = $query->where('name', 'LIKE', '%'.request('search').'%');
        }

        $result = $query->orderBy('name', 'ASC')->get();

        $casualties = $result->map(function ($item) {

            $images = $item->getImages()->get()->map(function ($image) {
                return ImageService::getUrl($image->path);
            });

            if (count($images) == 0) {
                $images = ['/storage/logo/blogo.png'];
            }

            return [
                'id' => $item->id,
                'name' => $item->name,
                'group' => $item->getCasualtyGroup->name,
                'images' => $images,
                'link' => route('resources.casualties.get', $item->getSlug()),
            ];
        });

        return response()->json($casualties);
    }

    public function publicView(string $slug)
    {

        $id = explode('.', $slug)[1];

        $casualty = Casualty::find($id);

        if ($casualty == null) {
            return redirect()->route('resources.casualties');
        }

        $images = $casualty->getImages->map(function ($image) {
            return ImageService::getUrl($image->path);
        });

        return view('resources.casualty', ['casualty' => $casualty, 'images' => $images]);
    }
}
