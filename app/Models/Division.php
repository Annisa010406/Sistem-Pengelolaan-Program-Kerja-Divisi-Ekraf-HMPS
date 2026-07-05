<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    // Beritahu Laravel bahwa primary key-nya bukan 'id'
    protected $primaryKey = 'division_id';

    // Jika division_id berbentuk auto-incrementing integer (bigint)
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'description',
    ];

    // Relasi ke Users jika dibutuhkan nanti
    public function users()
    {
        return $this->hasMany(User::class, 'division_id', 'division_id');
    }
}
