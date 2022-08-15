<?php 
namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImageService {

    static function server() {

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

    static function get($path) {
    
        return self::server()->getImageResponse($path, request()->all());

    }

    static function store(Request $request, $locationExtra = '') {
        $filePath = $request->file('image')->store('img/source' . $locationExtra);

        return basename($filePath);

    }

    

}

?>