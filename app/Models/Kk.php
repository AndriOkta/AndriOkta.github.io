<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kk extends Model
{
    use HasFactory; 

    protected $fillable = [
        'no_kk', 
        'nama_kepala_keluarga', 
        'alamat', 
        'rt_rw', 
        'kode_pos', 
        'desa_kelurahan', 
        'kecamatan', 
        'kabupaten_kota',
        'provinsi'
    ];
    
    public function anggotas()
    {
        return $this->hasMany(Anggota::class, 'kk_id', 'id');
    } 

    
}