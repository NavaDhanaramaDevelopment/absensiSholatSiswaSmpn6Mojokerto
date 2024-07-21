@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-6 mb-4 mb-xl-0">
            <div class="d-lg-flex align-items-center">
                <div>
                    <h3 class="text-dark font-weight-bold mb-2">Hi, welcome back!</h3>
                    <h6 class="font-weight-normal mb-2">{{ 'User: '.Auth()->user()->username }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 flex-column d-flex stretch-card">
            <div class="row">
                <div class="col-lg-3 d-flex grid-margin stretch-card">
                    <div class="card sale-diffrence-border">
                        <div class="card-body">
                            <h2 class="text-dark mb-2 font-weight-bold">{{ totalSiswa() }}</h2>
                            <h4 class="card-title mb-2">Anggota Siswa</h4>
                            <small class="text-mute">Total Siswa</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 d-flex grid-margin stretch-card">
                    <div class="card sale-visit-statistics-border">
                        <div class="card-body">
                            <h2 class="text-dark mb-2 font-weight-bold">{{ totalMasukAbsen() }}</h2>
                            <h4 class="card-title mb-2">Kehadiran</h4>
                            <small class="text-muted">Siswa Masuk</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 d-flex grid-margin stretch-card">
                    <div class="card sale-diffrence-border">
                        <div class="card-body">
                            <h2 class="text-dark mb-2 font-weight-bold">{{ totalLateAbsen() }}</h2>
                            <h4 class="card-title mb-2">Kehadiran</h4>
                            <small class="text-muted">Siswa Terlambat</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 d-flex grid-margin stretch-card">
                    <div class="card sale-visit-statistics-border">
                        <div class="card-body">
                            <h2 class="text-dark mb-2 font-weight-bold">{{ totalAlphaAbsen() }}</h2>
                            <h4 class="card-title mb-2">Kehadiran</h4>
                            <small class="text-muted">Siswa Alpha</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop