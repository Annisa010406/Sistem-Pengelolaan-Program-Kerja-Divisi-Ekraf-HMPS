<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $primaryKey = 'report_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'program_id',
        'result',
    ];

    // Relasi balik ke Program Kerja
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }
}
