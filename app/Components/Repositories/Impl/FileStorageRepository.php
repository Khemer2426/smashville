<?php

namespace App\Components\Repositories\Impl;

use App\Components\Repositories\IFileStorageRepository;
use App\Models\Entities\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FileStorageRepository implements IFileStorageRepository
{
    public function getFileFromStorage($path, $disk = null)
    { 
        return Storage::disk($disk)->get($path);
    }

    public function uploadFileToStorage($file, $hash_name, $disk = null)
    {
        $now = Carbon::now();
        $target_path = sprintf('files/%s/%s/%s/%s', $now->year, $now->month, $now->day, $hash_name);
        Storage::disk($disk)->put($target_path, $file);

        return $target_path;
    }

    public function deleteFileFromStorage($path, $disk = null)
    {
        Storage::disk($disk)->delete($path);
    }

    public function createFile($name, $mime_type, $path, $file_type_id)
    {
        return File::create([
            'name' => $name,
            'mime_type' => $mime_type,
            'path' => $path,
            'file_type_id' => $file_type_id
        ]);
    }

    public function getFile($id)
    {
        return File::find($id);
    }

    public function deleteFile($id)
    {
        File::where('id', $id)->delete();
    }

    public function deleteFileByPath($path)
    {
        File::where('path', $path)->delete();
    }
}
