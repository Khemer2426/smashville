<?php

namespace App\Components\Services;

interface IFileService 
{
    public function getFile($id);

    public function uploadFile($file, $file_type_id, $disk = null);

    public function deleteFile($id, $disk = null);

    public function downloadFile($id, $disk = null);
}