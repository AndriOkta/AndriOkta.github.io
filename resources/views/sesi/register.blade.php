@extends('layout.applog')
@section('title', 'Register')
@section('content')
<div class="container my-auto">
    <div class="row">
      <div class="col-lg-4 col-md-8 col-12 mx-auto">
        <div class="card z-index-0 fadeIn3 fadeInBottom">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
              <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Register</h4>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('create') }}" method="POST" role="form" class="text-start">
            @csrf
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Nama</label>
              <input type="name" value="{{ Session::get('name') }}" name="name" class="form-control">
            </div>
              <div class="input-group input-group-outline my-3">
                <label class="form-label">Email</label>
                <input type="email" value="{{ Session::get('email') }}" name="email" class="form-control">
              </div>
              <div class="input-group input-group-outline mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
              </div>
              <div class="text-center">
                <button name="submit" type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Daftar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--footer-->
  
  <!--footer-->
@endsection

