@extends('layouts.app')
@section('title', 'Data Absensi Siswa')

@section('content')
<div class="content-wrapper">
    @if(session('alert'))
        <div class="alert alert-danger text-white">
            {{ session('alert') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success text-white">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Data Absensi</h4>
                        </div>
                    </div>

                  <div class="table-responsive">
                    <table class="table" id="data-table">
                      <thead>
                        <tr>
                          <th class="text-center">No</th>
                          <th class="text-center">NISN</th>
                          <th class="text-center">Nama Siswa</th>
                          <th class="text-center">Jadwal</th>
                          <th class="text-center">Check In</th>
                          <th class="text-center">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $attendance->nisn }}</td>
                                    <td>{{ $attendance->nama_lengkap }}</td>
                                    <td>{{ $attendance->sholat }}</td>
                                    <td>{{ $attendance->check_in }}</td>
                                    @if(!is_null($attendance->is_late) || $attendance->is_late == 0)
                                        <td class="text-center">
                                            <button class="btn btn-danger" disabled>Terlambat</button>
                                        </td>
                                    @else
                                        <td class="text-center">
                                            <button class="btn btn-success" disabled>Tepat Waktu</button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>
@stop



@section('footer')
<script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var dtTableOption = {
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "stateSave": true
    };

    var Notif = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        })


        $("#data-table").DataTable(dtTableOption)
</script>
@stop
