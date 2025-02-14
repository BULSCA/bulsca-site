<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImageService
{

    static function server()
    {

        $driver = Storage::disk('local')->path('');



        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => $driver . "img/source",
            'cache' => $driver . "img/cache",
            'cache_path_prefix' => '.cache',
            'base_url' => 'img',
        ]);

        return $server;
    }

    static function get($path)
    {

        return self::server()->getImageResponse($path, request()->all());
    }

    static function getUrl($path)
    {

        return route('image', ['path' => $path]);
    }

    static function store(Request $request, $locationExtra = '', $paramName = 'image', $fullPath = false)
    {
        $filePath = $request->file($paramName)->store('img/source' . $locationExtra);

        if ($fullPath) {
            return substr($filePath, 11);
        }

        return basename($filePath);
    }

    static function delete($path)
    {
        Storage::delete('img/source/' . $path);
        Storage::delete('img/cache/' . $path);
    }
}
