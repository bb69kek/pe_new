<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    //
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $fillable = [
        'user_id',
        'status',
        'address',
        'default',
    ];
}