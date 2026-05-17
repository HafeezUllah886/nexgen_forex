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

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'account_id');
    }

    public function getBalance()
    {
        $creditSum = $this->transactions()->sum('credit');
        $debitSum = $this->transactions()->sum('debit');

        return $creditSum - $debitSum;
    }
}
