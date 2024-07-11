@extends('layout.app')
@section('title', 'Kepala Keluarga')
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Kepala Keluarga</h6>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <button type="button" class="btn btn-primary btn-sm tombol-tambah" style="margin-left: 10px; padding: 0.25rem 0.5rem; font-size: 0.875rem; border-radius: 0.2rem;" data-toggle="modal" data-target="#exampleModal" onclick="setModalTitle('Tambah Data Keluarga')">
              <i class="fas fa-plus mr-2"></i> Tambah Data
            </button>
            <table class="table align-items-center mb-0" id="myTable">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor KK</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Kepala Keluarga</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RT/RW</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Anggota</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
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