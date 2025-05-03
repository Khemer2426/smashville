<?php

namespace App\Components\Repositories;

interface IFileStorageRepository
{
    public function getFileFromStorage($path,  $disk = null);

    public function uploadFileToStorage($file, $hash_name,  $disk = null);

    public function deleteFileFromStorage($path,  $disk = null);

    public function createFile($name, $mime_type, $path, $file_type_id);

    public function getFile($id);

    public function deleteFile($id);

    public function deleteFileByPath($path);
}
