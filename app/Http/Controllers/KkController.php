<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Kk::orderBy('no_kk', 'asc')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('jumlah_anggota', function($keluarga) {
            return $this->hitungAnggota($keluarga);
        })
        ->addColumn('aksi', function($keluarga) {
            return view('kk.tombol')->with('data',$keluarga);
        })
        ->make(true);

    } private function hitungAnggota($keluarga){return $keluarga->anggotas()->count();}

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
            'no_kk' => 'required|unique:kks,no_kk',
            'nama_kepala_keluarga' => 'required',
            'alamat' => 'required',
            'rt_rw' => 'required',
            'kode_pos' => 'required',
            'desa_kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten_kota' => 'required',
            'provinsi' => 'required',
        ], [
            'no_kk.required' => 'Nomor KK Wajib Diisi!',
            'no_kk.unique' => 'Nomor KK sudah ada',
            'nama_kepala_keluarga.required' => 'Nama Wajib Diisi!',
            'alamat.required' => 'Alamat wajib diisi!',
            'rt_rw.required' => 'RT/RW wajib Diisi!',
            'kode_pos.required' => 'Kode Pos wajib Diisi!',
            'desa_kelurahan.required' => 'Desa/Kelurahan Wajib Diisi!',
            'kecamatan.required' => 'Kecamatan Wajib Diisi!',
            'kabupaten_kota.required' => 'Kabupaten/Kota Wajib Diisi!',
            'provinsi.required' => 'Provinsi Wajib Diisi!',
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'no_kk' => $request->no_kk,
                'nama_kepala_keluarga' => $request->nama_kepala_keluarga,
                'alamat' => $request->alamat,
                'rt_rw' => $request->rt_rw,
                'kode_pos' => $request->kode_pos,
                'desa_kelurahan' => $request->desa_kelurahan,
                'kecamatan' => $request->kecamatan,
                'kabupaten_kota' => $request->kabupaten_kota,
                'provinsi' => $request->provinsi
            ];
            Kk::create($data);
            return response()->json(['success' => 'Data Berhasil Disimpan']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($kkId)
    {
    $kk = Kk::findOrFail($kkId);
    $anggota = Anggota::where('kk_id', $kkId)->get();
    return view('kk.detail.index', ['kkdata' => $kk, 'anggotaData' => $anggota, 'kkId' => $kkId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Kk::where('id', $id)->first();
        return response()->json(['result'=>$data]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'no_kk' => 'required|unique:kks,no_kk,' . $id . ',id',
            'nama_kepala_keluarga' => 'required',
            'alamat' => 'required',
            'rt_rw' => 'required',
            'kode_pos' => 'required',
            'desa_kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten_kota' => 'required',
            'provinsi' => 'required',
        ], [
            'no_kk.required' => 'Nomor KK Wajib Diisi!',
            'no_kk.unique' => 'Nomor KK sudah ada!',
            'nama_kepala_keluarga.required' => 'Nama Wajib Diisi!',
            'alamat.required' => 'Alamat wajib diisi!',
            'rt_rw.required' => 'RT/RW wajib Diisi!',
            'kode_pos.required' => 'Kode Pos wajib Diisi!',
            'desa_kelurahan.required' => 'Desa/Kelurahan Wajib Diisi!',
            'kecamatan.required' => 'Kecamatan Wajib Diisi!',
            'kabupaten_kota.required' => 'Kabupaten/Kota Wajib Diisi!',
            'provinsi.required' => 'Provinsi Wajib Diisi!',
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'no_kk' => $request->no_kk,
                'nama_kepala_keluarga' => $request->nama_kepala_keluarga,
                'alamat' => $request->alamat,
                'rt_rw' => $request->rt_rw,
                'kode_pos' => $request->kode_pos,
                'desa_kelurahan' => $request->desa_kelurahan,
                'kecamatan' => $request->kecamatan,
                'kabupaten_kota' => $request->kabupaten_kota,
                'provinsi' => $request->provinsi
            ];
            Kk::where('id', $id)->update($data);
            return response()->json(['success' => "Data Berhasil Diupdate"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        kk::where('id', $id)->delete();
    }
}
