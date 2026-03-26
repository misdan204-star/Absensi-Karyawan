<?php

namespace App\Models;

use App\Models\FieldWorkReport;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    protected $fillable = [
        'ba_number',
        'field_work_report_id',
        'client_name',
        'signature',
        'date',
    ];

    public function fieldWorkReport()
    {
        return $this->belongsTo(FieldWorkReport::class);
    }
}
