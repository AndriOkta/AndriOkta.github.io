@extends('layout.app1')
@section('title', 'dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Status Baptis</div>
                    <div class="card-body">
                        {!! $baptis_chart->container() !!}
                    </div>
                </div>
            </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Usia</div>
                <div class="card-body">
                    {!! $age_chart->container() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Jenis Kelamin</div>
                <div class="card-body">
                    {!! $gender_chart->container() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
