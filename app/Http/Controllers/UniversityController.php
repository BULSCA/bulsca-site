<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUniversity;
use App\Models\University;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniversityController extends Controller
{

    public function update(Request $request, University $university)
    {





        $validated = Validator::make($request->all(), [

            'name' => 'required|min:8',

        ])->validate();





        $university->name = $validated['name'];

        $university->save();

        return redirect()->back();
    }

    public function updateUniPhoto(Request $request)
    {

        $validated = $request->validate([
            'image' => 'required|file',
            'uni' => 'required'
        ]);

        $uni = University::findOrFail($validated['uni']);

        // User isn't authed or user isn't a admin for this uni
        if ((!auth()->user() || !auth()->user()->isUniAdmin($uni->id)) && auth()->user()->cannot('admin.universities.manage')) {
            abort(403);
        }

        $photoId = ImageService::store($request, '/logos/unis');

        $uni->image_path = 'logos/unis/' . $photoId;

        $uni->save();

        return redirect()->back();
    }

    public function create(CreateUniversity $request)
    {
        $validated = $request->validated();

        $uni = new University();

        $uni->name = $validated['name'];

        if (array_key_exists('image', $validated)) {
            $photoId = ImageService::store($request, '/logos/unis');

            $uni->image_path = 'logos/unis/' . $photoId;
        }

        $uni->save();

        return redirect()->route('admin.university.view', $uni)->with('message', 'University created!');
    }

    public function delete(Request $request)
    {
        $uni = University::findOrFail($request->input('id'));

        $uni->delete();

        return redirect()->route('admin.universities')->with('message', 'University deleted!');
    }

    public function getLogo(string $uni_name)
    {
        $uni = University::where('name', $uni_name)->first();

        if (!$uni) {
            abort(404);
        }

        return response()->redirectTo("img/" . $uni->image_path);
    }
}
