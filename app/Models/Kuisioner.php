<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuisioner extends Model
{
    protected $table = 'kuisioners';

    protected $fillable = [
        'judul',
        'deskripsi',
        'status',
        'start_date',
        'end_date',
        'target_user',
    ];

    // Eloquent akan mencoba cast ke array jika JSON valid
    protected $casts = [
        'target_user' => 'array',
    ];

    /**
     * Accessor super-aman untuk mengambil target roles (selalu array)
     */
    public function getTargetRolesAttribute(): array
    {
        $raw = $this->target_user;

        // Jika sudah array dari cast Eloquent
        if (is_array($raw)) {
            return $raw;
        }

        // Jika null atau kosong
        if (empty($raw)) {
            return [];
        }

        // Jika JSON valid
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        // Jika JSON ESCAPED (mengandung backslash) → decode ulang
        $unescaped = stripslashes($raw);
        $decoded2 = json_decode($unescaped, true);
        if (is_array($decoded2)) {
            return $decoded2;
        }

        // Jika string biasa: "mahasiswa, lulusan"
        if (is_string($raw)) {
            return array_filter(array_map('trim', explode(',', $raw)));
        }

        // Default paling aman → array kosong
        return [];
    }

    /**
     * Relasi ke pertanyaan
     */
    public function pertanyaans()
    {
        return $this->hasMany(Pertanyaan::class, 'kuisioner_id');
    }
}
