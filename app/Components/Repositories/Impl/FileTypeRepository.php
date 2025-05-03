<?php

namespace App\Components\Repositories\Impl;

use App\Models\Entities\FileType;
use App\Components\Repositories\IFileTypeRepository;

class FileTypeRepository implements IFileTypeRepository
{
    public function getByName($name)
    {
        return FileType::where('name', $name)->first();
    }

    public function getById($id)
    {
        return FileType::find($id);
    }

    public function getAll()
    {
        return FileType::all();
    }
}
