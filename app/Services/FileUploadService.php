<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    private function sanitizeFileName(string $fileName): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $baseName  = pathinfo($fileName, PATHINFO_FILENAME);

        return Str::slug($baseName) . ($extension ? '.' . strtolower($extension) : '');
    }

    public function upload($file, $folder, $name = null)
    {
        if ($name) {
            $fileName = $this->sanitizeFileName($name . '.' . $file->getClientOriginalExtension());
        } else {
            $fileName = $this->sanitizeFileName($file->getClientOriginalName());
        }

        return Storage::disk('public')->putFileAs($folder, $file, $fileName);
    }

    public function updateImage($oldPath, $newFile, $folder, $name = null)
    {
        try {
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            if ($name) {
                $fileName = $this->sanitizeFileName($name . rand(1,9) . '.' . $newFile->getClientOriginalExtension());
            } else {
                $fileName = $this->sanitizeFileName($newFile->getClientOriginalName());
            }
            return Storage::disk('public')->putFileAs($folder, $newFile, $fileName);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Error updating image: ' . $th->getMessage(), ['method' => __METHOD__]);
            return $oldPath; // Return old path if update fails
        }
    }

    public function uploadMultiple($files, $folder, $name = null)
    {
        $paths = [];
        foreach ($files as $file) {
            $paths[] = $this->upload($file, $folder, $name);
        }

        return $paths;
    }

    public function updateMultiple($oldPaths, $newFiles, $folder, $name = null)
    {
        foreach ($oldPaths as $oldPath) {
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $paths = [];
        foreach ($newFiles as $file) {
            $paths[] = $this->upload($file, $folder, $name);
        }

        return $paths;
    }
}