<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = ['no_ktp', 'nama', 'ttl', 'jenis_kelamin', 'status', 'pekerjaan', 'baptis', 'kk_id'];

    public function keluarga()
    {
        return $this->belongsTo(Kk::class, 'kk_id', 'id');
    }

}
