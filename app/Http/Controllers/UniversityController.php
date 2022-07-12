<?php

namespace App\Http\Controllers;

use App\Models\University;
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


}
