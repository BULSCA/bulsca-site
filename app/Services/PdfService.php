<?php

namespace App\Services;

class PdfService
{
    public static function extractText($filePath)
    {
        return shell_exec('pdftotext '.$filePath.' -');
    }
}
