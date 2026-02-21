<?php

namespace App\Services;

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
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        if ($name) {
            $fileName = $this->sanitizeFileName($name . '.' . $newFile->getClientOriginalExtension());
        } else {
            $fileName = $this->sanitizeFileName($newFile->getClientOriginalName());
        }

        return Storage::disk('public')->putFileAs($folder, $newFile, $fileName);
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