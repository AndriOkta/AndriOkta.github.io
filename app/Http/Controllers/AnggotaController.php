<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kkId)
    {
    $data = Anggota::where('kk_id', $kkId)->orderBy('no_ktp', 'asc')->get();
    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return view('kk.detail.tombol')->with('data', $data);
        })
        ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'no_ktp' => 'required|unique:anggotas',
            'nama' => 'required',
            'ttl' => 'required',
            'jenis_kelamin' => 'required',
            'status' => 'required',
            'pekerjaan' => 'required',
            'baptis' => 'required',
            'kk_id' => 'required|exists:kks,id'
        ], [
            'no_ktp.required' => 'Nomor NIK Wajib Diisi!',
            'no_ktp.unique' => 'Nomor NIK sudah ada',
            'nama.required' => 'Nama Wajib Diisi!',
            'ttl.required' => 'Tempat/ Tgl Lahir Wajib Diisi!',
            'jenis_kelamin.required' => 'Pilih Jenis Kelamin!',
            'status.required' => 'Pilih Status!',
            'pekerjaan.required' => 'Pekerjaan Wajib Diisi!',
            'baptis.required' => 'Pilih Baptis!',
            'kk_id.required' => 'Kartu Keluarga Wajib Diisi!',
            'kk_id.exists' => 'Kartu Keluarga Tidak Tersedia!'
        ]);
    
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'no_ktp' => $request->no_ktp,
                'nama' => $request->nama,
                'ttl' => $request->ttl,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status' => $request->status,
                'pekerjaan' => $request->pekerjaan,
                'baptis' => $request->baptis,
                'kk_id' => $request->kk_id
            ];
    
            Anggota::create($data);
    
            return response()->json(['success' => 'Data Berhasil Disimpan']);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($kkId, $anggotaId)
    {
        try {
            $anggota = Anggota::where('kk_id', $kkId)->where('id', $anggotaId)->first();
            if ($anggota) {
                return response()->json(['result' => $anggota]);
            } else {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat mengambil data'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kkId, $anggotaId)
    {
        $validasi = Validator::make($request->all(), [
            'no_ktp' => 'required|unique:anggotas,no_ktp,' . $anggotaId,
            'nama' => 'required',
            'ttl' => 'required',
            'jenis_kelamin' => 'required',
            'status' => 'required',
            'pekerjaan' => 'required',
            'baptis' => 'required',
        ], [
            'no_ktp.required' => 'NIK Wajib Diisi!',
            'no_ktp.unique' => 'NIK sudah ada!',
            'nama.required' => 'Nama Wajib Diisi!',
            'ttl.required' => 'Tempat tanggal lahir wajib diisi!',
            'jenis_kelamin.required' => 'Pilih jenis Kelamin! ',
            'status.required' => 'Pilih status!',
            'pekerjaan.required' => 'Pekerjaan Wajib Diisi!',
            'baptis.required' => 'Kecamatan Wajib Diisi!',
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'no_ktp' => $request->no_ktp,
                'nama' => $request->nama,
                'ttl' => $request->ttl,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status' => $request->status,
                'pekerjaan' => $request->pekerjaan,
                'baptis' => $request->baptis
            ];
            Anggota::where('kk_id', $kkId)->where('id', $anggotaId)->update($data);
            return response()->json(['success' => "Data Berhasil Diupdate"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kkId, $anggotaId)
    {
    // Validasi untuk memastikan ID yang diterima valid
    $anggota = Anggota::where('kk_id', $kkId)->where('id', $anggotaId)->first();
        if ($anggota) {
            $anggota->delete();
            return response()->json(['success' => 'Data anggota berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Data anggota tidak ditemukan.'], 404);
        }
    }

}
