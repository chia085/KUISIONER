<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaans';

    protected $fillable = [
        'kuisioner_id',
        'role',
        'pertanyaan',
        'tipe',
    ];

    public function kuisioner()
    {
        return $this->belongsTo(Kuisioner::class, 'kuisioner_id');
    }
}
