<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    
    public function get($path) {
        return ImageService::get($path);
    }

    public function upload(Request $request) {
        return ImageService::store($request);
    }

}
