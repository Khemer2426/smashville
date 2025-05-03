<?php

namespace App\Components\Repositories\Impl;

use App\Components\Repositories\IYearRepository;
use App\Models\Entities\Year;

class YearRepository implements IYearRepository
{
    public function getAll()
    {
        return Year::where('yr_name', '!=', '')->whereNotNull('yr_name')->orderBy('yr_name', 'asc')->get();
    }

    public function getById($id)
    {
        return Year::find($id);
    }

    public function create($name)
    {
        return Year::create([
            'yr_name' => $name
        ]);
    }
}