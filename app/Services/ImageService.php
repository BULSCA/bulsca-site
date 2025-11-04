<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Glide\ServerFactory;
use League\Glide\Responses\ResponseFactoryInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageService
{
    public static function server()
    {
        $driver = Storage::disk('local')->path('');

        $server = ServerFactory::create([
            'response' => new LaravelGlideResponseFactory(),
            'source' => $driver.'img/source',
            'cache' => $driver.'img/cache',
            'cache_path_prefix' => '.cache',
            'base_url' => 'img',
        ]);

        return $server;
    }

    public static function get($path)
    {
        return self::server()->getImageResponse($path, request()->all());
    }

    public static function getUrl($path)
    {
        return route('image', ['path' => $path]);
    }

    public static function store(Request $request, $locationExtra = '', $paramName = 'image', $fullPath = false)
    {
        $filePath = $request->file($paramName)->store('img/source'.$locationExtra);

        if ($fullPath) {
            return substr($filePath, 11);
        }

        return basename($filePath);
    }

    public static function delete($path)
    {
        Storage::delete('img/source/'.$path);
        Storage::delete('img/cache/'.$path);
    }
}

class LaravelGlideResponseFactory implements ResponseFactoryInterface
{
    public function create($cache, $content)
    {
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', $cache->getMimeType());
        $response->headers->set('Content-Length', $cache->getSize());
        $response->headers->set('Cache-Control', 'max-age=31536000, public');
        $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
        
        $stream = $cache->getStream();
        $response->setCallback(function () use ($stream) {
            if (ftell($stream) !== 0) {
                rewind($stream);
            }
            fpassthru($stream);
            fclose($stream);
        });

        return $response;
    }
}