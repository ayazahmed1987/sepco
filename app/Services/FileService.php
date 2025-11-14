<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public static function upload(UploadedFile $file, $folder = 'uploads/general/media')
    {
        return $file->store($folder, 'public');
    }

    public static function delete($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }
        \Log::error("File Upload Service Delete: ",[$filePath]);
        return false;
    }
}
