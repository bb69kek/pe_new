<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Halt extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'method',
        'slots',
        'day',
        'hour',
        'dataSent',
        'target',
        'port',
        'duration',
        'status',
        'mode',
        'type',
        'haltStart',
        'haltEnd',
        'lastDown'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
