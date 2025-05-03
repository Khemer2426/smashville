<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class UniqueLinkType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function unique_links()
    {
        return $this->hasMany('App\Models\Entities\UniqueLink', 'link_type_id', 'id');
    }
}