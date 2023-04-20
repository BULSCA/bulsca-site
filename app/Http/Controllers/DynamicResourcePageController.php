<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourceSearch;
use App\Models\Resource;
use App\Models\ResourcePage;
use App\Models\ResourcePageSection;
use App\Models\ResourcePageSectionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class DynamicResourcePageController extends Controller
{

    public function adminUpload(Request $request)
    {

        $validated = $request->validate([
            'resource' => 'file|required',
            'section' => 'required',
            'name' => 'required'
        ]);






        $storedRes = ResourceController::storeResource($request, 'resource', 'resources/resources', $validated['name']);

        $rps = ResourcePageSection::findOrFail($validated['section']);
        $rpsr = new ResourcePageSectionResource();


        $content = "";

        if ($request->file('resource')->extension() == "pdf") {
            $fullTarget = storage_path('app') . '/' . $storedRes->location;
            $content = shell_exec("pdftotext {$fullTarget} -");
        }

        $rpsr->section = $rps->id;
        $rpsr->resource = $storedRes->id;
        $rpsr->name = $storedRes->name;
        $rpsr->short = "";
        $rpsr->content = $content;

        $rpsr->save();

        $sec = ResourcePageSection::find($rps->id);
        $page = ResourcePage::find($sec->page);

        Cache::forget('resource-page-' . Str::replace(' ', '-', Str::lower($page->name)));

        return redirect()->back();
    }

    public function createNewSection(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'page' => 'required'
        ]);


        $rps = new ResourcePageSection();
        $rps->name = $validated['name'];
        $rps->page = $validated['page'];

        $rps->save();

        return redirect()->back();
    }

    public function deleteSection(Request $request)
    {
        $sec = ResourcePageSection::findOrFail($request->input('id', -1));

        $page = ResourcePage::find($sec->page);

        Cache::forget('resource-page-' . Str::replace(' ', '-', Str::lower($page->name)));

        $sec->delete();

        return redirect()->back();
    }

    public function createNewPage(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
        ]);


        $rp = new ResourcePage();
        $rp->name = $validated['name'];


        $rp->save();

        return redirect()->back();
    }

    public function deletePage(Request $request)
    {
        $p = ResourcePage::findOrFail($request->input('id', -1));

        $p->delete();

        return redirect()->route('admin.resources');
    }

    public function index()
    {
        return view('resources.index', ['pages' => ResourcePage::orderBy('ordering')->orderBy('name')->get()]);
    }

    public function view($page)
    {

        $defPage = $page;

        $page = Str::replace('-', ' ', $page);

        $p = Cache::rememberForever('resource-page-' . $defPage, function () use ($page) {
            return ResourcePage::where('name', 'like', $page)->first()->load('getSections');
        });

        if (!$p) {
            $data['title'] = '404';
            $data['name'] = 'Page not found';
            return response()->view('errors.404', $data, 404);
        }

        return view('resources.view', ['p' => $p]);
    }

    public function search($search)
    {




        $found = ResourcePageSectionResource::where('name', 'LIKE', "%{$search}%")->orWhere('content', 'LIKE', "%{$search}%")->limit(10)->get(['name', 'resource']);

        return response()->json($found);
    }

    public function move(Request $request,  Resource $resource)
    {

        $rprsr = $resource->getPageResource;

        if ($rprsr == null) return redirect()->back();


        $rprsr->section = $request->input('section');
        $rprsr->save();

        return redirect()->back();
    }


    public function changePageOrder(Request $request, ResourcePage $page)
    {
        $direction = $request->input('direction', "false") == "true" ? true : false; // DOWN: false, UP: true

        $currentPageOrderIndex = $page->ordering;


        $pageToSwapWith = ResourcePage::where('ordering', $currentPageOrderIndex + ($direction ? -1 : +1))->first();

        if ($pageToSwapWith == null) return redirect()->back(); // If no page it means its either the first or last item (or both)

        $targetOrder = $pageToSwapWith->ordering;
        $pageToSwapWith->ordering = null;
        $pageToSwapWith->save();

        $page->ordering = $targetOrder;
        $page->save();

        $pageToSwapWith->ordering = $currentPageOrderIndex;
        $pageToSwapWith->save();

        return redirect()->back();
    }
}
