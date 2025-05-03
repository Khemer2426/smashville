<?php

namespace App\Components\Repositories\Impl;

use App\Components\Repositories\ILocalityRepository;
use App\Models\Entities\Locality;

class LocalityRepository implements ILocalityRepository
{
    public function getAll()
    {
        return Locality::where('loc_name', '!=', '')->whereNotNull('loc_name')->orderBy('loc_name', 'asc')->get();
    }

    public function getById($id)
    {
        return Locality::where('id', $id)->first();
    }

    public function create($name)
    {
        return Locality::create([
            'loc_name' => $name,
        ]);
    }

    public function getLocalitiesDatatable($keyword = null)
    {
        $keyword = trim($keyword);

        $localities = Locality::whereNotNull('loc_name')->where('loc_name', '!=', '');

        $datatables = datatables()::of($localities);

        if (!empty($keyword)) {
            $datatables->filter(function ($query) use ($keyword) {
                return $query->where(function ($sql) use ($keyword) {
                    $sql->orWhere("loc_name", 'LIKE', "%$keyword%");
                });
            });
        }

        return $datatables->make(true);
    }
}