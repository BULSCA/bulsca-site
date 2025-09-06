<?php 
namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class PdfService {

    static function extractText($filePath) {
        return shell_exec('pdftotext '.$filePath.' -');
    }

    

}
