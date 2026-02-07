<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function upload($file, $folder)
    {
        return Storage::disk('public')->put($folder, $file);
    }

    public function updateImage($oldPath, $newFile, $folder)
    {
        if($oldPath && Storage::disk('public')->exists($oldPath)){
            Storage::disk('public')->delete($oldPath);
        }
        return $this->upload($newFile, $folder);
    }

    public function uploadMultiple($files, $folder)
    {
        $paths = [];
        foreach ($files as $file) {
            $paths[] = $this->upload($file, $folder);
        }
        return $paths;
    }

    public function updateMultiple($oldPaths, $newFiles, $folder)
    {
        foreach ($oldPaths as $oldPath) {
             if($oldPath && Storage::disk('public')->exists($oldPath)){
                Storage::disk('public')->delete($oldPath);
            }
        }
        $paths = [];
        foreach ($newFiles as $file) {
            $paths[] = $this->upload($file, $folder);
        }
        return $paths;
    }
}