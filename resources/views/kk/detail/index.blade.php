@extends('kk.detail.app')
@section('title', 'Detail Keluarga')
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Anggota Keluarga</h6>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <button type="button" class="btn btn-primary btn-sm tombol-tambah" style="margin-left: 10px; padding: 0.25rem 0.5rem; font-size: 0.875rem; border-radius: 0.2rem;" data-toggle="modal" data-target="#exampleModal" data-id="{{ $kkId }}">
              <i class="fas fa-plus mr-2"></i> Tambah Data
            </button>          
              <table class="table align-items-center mb-0 table-responsive table-striped nowrap" style="width:100%" id="myTable">
                <thead>
                  <tr>
                    <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">No</th>
                    <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">NIK</th>
                    <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Nama Lengkap</th>
                    <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">TTL</th>
                    <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">Jenis Kelamin</th>
                    <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">Pekerjaan</th>
                    <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">Baptis</th>
                    <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">Aksi</th>
                  </tr>
                </thead>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--footer-->
  
  <!--footer-->
@endsection

{{-- <h1>Detail Kartu Keluarga</h1>
<p>No. KK: {{ $kkdata->no_kk }}</p>
<p>Nama Kepala Keluarga: {{ $kkdata->nama_kepala_keluarga }}</p>
<p>Alamat: {{ $kkdata->alamat }}</p>
<p>RT/RW: {{ $kkdata->rt_rw }}</p>
<p>Kode Pos: {{ $kkdata->kode_pos }}</p>
<p>Desa/Kelurahan: {{ $kkdata->desa_kelurahan }}</p>
<p>Kecamatan: {{ $kkdata->kecamatan }}</p>
<p>Kabupaten/Kota: {{ $kkdata->kabupaten_kota }}</p>
<p>Provinsi: {{ $kkdata->provinsi }}</p>

<h2>Anggota Keluarga</h2>
<table>
    <thead>
        <tr>
            <th>No. KTP</th>
            <th>Nama</th>
            <th>TTL</th>
            <th>Jenis Kelamin</th>
            <th>Status</th>
            <th>Pekerjaan</th>
            <th>Baptis</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($anggotaData as $anggota)
        <tr>
            <td>{{ $anggota->no_ktp }}</td>
            <td>{{ $anggota->nama }}</td>
            <td>{{ $anggota->ttl }}</td>
            <td>{{ $anggota->jenis_kelamin }}</td>
            <td>{{ $anggota->status }}</td>
            <td>{{ $anggota->pekerjaan }}</td>
            <td>{{ $anggota->baptis }}</td>
        </tr>
        @endforeach
    </tbody>
</table> --}}
