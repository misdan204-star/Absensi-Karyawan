<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FieldWorkReport extends Model
{
    protected $fillable = [
        'user_id',
        'work_name',
        'location',
        'date',
        'description',
        'photo_before',
        'photo_after',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
