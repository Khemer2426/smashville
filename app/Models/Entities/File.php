<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mime_type', 'path', 'file_type_id',
    ];
    
    public function file_type()
    {
        return $this->belongsTo('App\Models\Entities\FileType');
    }
}