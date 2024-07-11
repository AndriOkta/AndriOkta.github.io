<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JemaatController extends Controller
{
    public function index()
    {
        $anggota = Anggota::with('keluarga')->orderBy('no_ktp', 'asc')->get();
        return view('jemaat.index', compact('anggota'));
    }
    
    public function anggotaData()
    {
        $anggota = Anggota::with('keluarga')->orderBy('nama', 'asc')->get();
        return DataTables::of($anggota)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                return view('jemaat.tombol')->with('data', $data);
            })
            ->make(true);
    }
    
}
