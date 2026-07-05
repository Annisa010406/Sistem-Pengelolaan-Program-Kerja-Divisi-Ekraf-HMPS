<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;

    protected $table = 'documentations';
    protected $primaryKey = 'documentation_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'program_id',
        'file_path',
        'description',
    ];

    // Relasi ke Program
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }
}
