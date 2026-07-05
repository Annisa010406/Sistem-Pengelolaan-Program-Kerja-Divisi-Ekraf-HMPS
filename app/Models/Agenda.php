<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $primaryKey = 'agenda_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'program_id',
        'agenda_name',
        'agenda_date',
        'status',
    ];

    // Casts tipe data tanggal agar otomatis menjadi instance Carbon
    protected $casts = [
        'agenda_date' => 'datetime',
    ];

    // Relasi balik ke Program
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }
}
