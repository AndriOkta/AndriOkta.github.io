
<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('template') }}/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('template') }}/assets/img/LogoGMII-HD.png">
  <title>
    @yield('title')
  </title>
  <!-- Load Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('template/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('template/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('template/assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- DataTable CSS  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
  {{-- SweetAlert --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3  bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" {{ route('dashboard') }} " target="_blank">
        <img src="{{ asset('template/assets/img/LogoGMII-HD.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">GMII Sola Gratia PTK</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
           <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{ route('dashboard') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
           <a class="nav-link text-white {{ request()->routeIs('kk') ? 'active bg-gradient-primary' : '' }}" href="{{ route('kk') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">family_restroom</i>
            </div>
            <span class="nav-link-text ms-1">Kepala Keluarga</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->routeIs('jemaat') ? 'active bg-gradient-primary' : '' }}" href="{{ route('jemaat') }}">
           <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
             <i class="material-icons opacity-10">people</i>
           </div>
           <span class="nav-link-text ms-1">Data Jemaat</span>
         </a>
       </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar"> 
          <ul class="navbar-nav ms-auto">
            <li class="nav-item d-flex align-items-center">
              <a href="#" id="logout-btn" class="nav-link text-body font-weight-bold px-0">
                  <i class="fa fa-user me-sm-1"></i>
                  <span class="d-sm-inline d-none">Log Out</span>
              </a>
          </li>
          <!-- Formulir logout tersembunyi untuk digunakan jika konfirmasi logout diterima -->
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
            {{-- <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li> --}}
          </ul>
        </div>
      </div>
    </nav>

    <!-- Flash Messages -->
      @if (session('success'))
      <script>
          Swal.fire({
              title: "Success!",
              text: "{{ session('success') }}",
              icon: "success",
              confirmButtonText: "OK"
          });
      </script>
      @endif

      @if ($errors->has('error'))
      <script>
          Swal.fire({
              title: "Error!",
              text: "{{ $errors->first('error') }}",
              icon: "error",
              confirmButtonText: "OK"
            });
        </script>
      @endif

    <!-- End Navbar -->
    <div class="container-fluid py-4">
      @yield('content')
      <!--footer-->
      
      <!--footer-->
    </div>
  </main>
  
  <!--modal-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Data Keluarga</h5>
          <button type="button" class="close" data-color="#0000" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form -->
          <div class="alert alert-danger d-none"></div>
          <div class="alert alert-success d-none"></div>
            <div class="form-group">
              <label for="no_kk" class="text-uppercase text-secondary text-xxs font-weight-bolder">Nomor KK</label>
              <input type="text" class="form-control" id="no_kk" placeholder="Masukkan Nomor KK">
            </div>
            <div class="form-group">
              <label for="nama_kepala_keluarga" class="text-uppercase text-secondary text-xxs font-weight-bolder">Nama Kepala Keluarga</label>
              <input class="form-control" id="nama_kepala_keluarga"  placeholder="Masukkan Nama"></input>
            </div>
            <div class="form-group">
              <label for="alamat" class="text-uppercase text-secondary text-xxs font-weight-bolder">Alamat</label>
              <textarea class="form-control" id="alamat"  placeholder="Masukkan Alamat"></textarea>
            </div>
            <div class="form-group">
              <label for="rt_rw" class="text-uppercase text-secondary text-xxs font-weight-bolder">RT/RW</label>
              <input class="form-control" id="rt_rw"  placeholder="Masukkan RT/RW"></input>
            </div>
            <div class="form-group">
              <label for="kode_pos" class="text-uppercase text-secondary text-xxs font-weight-bolder">Kode Pos</label>
              <input class="form-control" id="kode_pos"  placeholder="Masukkan Kode Pos"></input>
            </div>
            <div class="form-group">
              <label for="desa_kelurahan" class="text-uppercase text-secondary text-xxs font-weight-bolder">Desa/Kelurahan</label>
              <input class="form-control" id="desa_kelurahan"  placeholder="Masukkan Desa/kelurahan"></input>
            </div>
            <div class="form-group">
              <label for="kecamatan" class="text-uppercase text-secondary text-xxs font-weight-bolder">Kecamatan</label>
              <input class="form-control" id="kecamatan" placeholder="Masukkan Kecamatan"></input>
            </div>
            <div class="form-group">
              <label for="kabupaten_kota" class="text-uppercase text-secondary text-xxs font-weight-bolder">Kabupaten/Kota</label>
              <input class="form-control" id="kabupaten_kota" placeholder="Masukkan Kabupaten/Kota"></input>
            </div>
            <div class="form-group">
              <label for="provinsi" class="text-uppercase text-secondary text-xxs font-weight-bolder">Provinsi</label>
              <input class="form-control" id="provinsi" placeholder="Masukkan Provinsi"></input>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary tombol-simpan">Simpan</button>
        </div>
      </div>
    </div>
  </div>
  @include('script')
</body>

</html>