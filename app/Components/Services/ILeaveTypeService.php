<?php

namespace App\Components\Services;

interface ILeaveTypeService
{
    public function getAll();

    public function getById($id);

    public function getByIdOrThrow($id);

    public function getByType($type);

    public function addLeaveTermination($name, $type);
}