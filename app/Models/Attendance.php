<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'latitude', 
        'longitude', 
        'tipe_absen', 
        'status_lokasi',
        'image_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
