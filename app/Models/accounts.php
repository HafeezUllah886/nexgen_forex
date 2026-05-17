<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class accounts extends Model
{
    protected $guarded = [];

    public function assignedArea()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
