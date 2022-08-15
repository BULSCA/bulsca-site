<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniversityController extends Controller
{
    
    public function update(Request $request, University $university) {

    

        

        $validated = Validator::make($request->all(), [
         
            'name' => 'required|min:8',
         
        ])->validate();



  

        $university->name = $validated['name'];

        $university->save();

        return redirect()->back();
    }

    public function updateUniPhoto(Request $request) {

        $validated = $request->validate([
            'image' => 'required|file',
            'uni' => 'required'
        ]);

        $uni = University::findOrFail($validated['uni']);

        // User isn't authed or user isn't a admin for this uni
        if (!auth()->user() || !auth()->user()->isUniAdmin($uni->id)) {
            abort(403);
        }

        $photoId = ImageService::store($request, '/logos/unis');

        $uni->image_path = 'logos/unis/' . $photoId;

        $uni->save();

        return redirect()->back();

    }


}
