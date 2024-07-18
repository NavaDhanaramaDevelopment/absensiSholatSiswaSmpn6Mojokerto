@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-6 mb-4 mb-xl-0">
            <div class="d-lg-flex align-items-center">
                <div>
                    <h3 class="text-dark font-weight-bold mb-2">Hallo, Selamat Datang!</h3>
                    <h6 class="font-weight-normal mb-2">{{ $siswa->nama_depan.' '.$siswa->nama_belakang }}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12 d-flex grid-margin stretch-card">
            <div class="card bg-primary">
                <div class="card-body text-white text-center">
                    <h3 class="font-weight-bold mb-3">Barcode Anda</h3>
                    <p class="pb-0 mb-0">Silahkan Scan Barcode Anda untuk Absen Sholat</p>
                    <br>
                    <div class="row justify-content-center">
                        <div class="col-md-4 bg-white text-center">
                            <img src="data:image/png;base64, {!! base64_encode($barcode) !!}" alt="QR Code" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
