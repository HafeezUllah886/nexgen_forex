<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Accounts::class);
    }
}
