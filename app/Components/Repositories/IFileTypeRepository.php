<?php

namespace App\Components\Repositories;

interface IFileTypeRepository
{
    public function getByName($name);

    public function getById($id);

    public function getAll();
}
