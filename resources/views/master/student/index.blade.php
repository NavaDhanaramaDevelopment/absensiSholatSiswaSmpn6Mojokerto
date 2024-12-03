@extends('layouts.app')
@section('title', 'Siswa')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="exampleSelectGender">Kelas</label>
                            <select class="form-control text-center" id="kelas" name="kelas">
                                <option value="" selected disabled>===== Kelas =====</option>
                                @foreach ($kelas_data as $kelas_data)
                                <option value="{{ $kelas_data->nama_kelas }}" @if($kelas == $kelas_data->nama_kelas) selected @endif>{{ $kelas_data->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 text-center mt-4">
                            <button class="btn btn-outline-success btn-sm mb-0" id="searchData"><i class="mdi mdi-cloud-search"></i> Search Data</button>

                            @if(getModuleAccess('MB2'))
                                <a href="{{ route('student.add') }}" class="btn btn-outline-primary btn-sm mb-0"><i class="mdi mdi-plus"></i> Tambah Data</a>
                                <button class="btn btn-outline-success btn-sm mb-0" data-toggle="modal" data-target="#importModal"><i class="mdi mdi-cloud-upload"></i> Import Data</button>
                                <button class="btn btn-outline-warning btn-sm mb-0" id="exportBtn"><i class="mdi mdi-cloud-download"></i> Export Data</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Data Siswa</h4>
                        </div>
                    </div>

                  <div class="table-responsive">
                    <table class="table" id="data-table">
                      <thead>
                        <tr>
                          <th class="text-center">No</th>
                          <th class="text-center">NISN</th>
                          <th class="text-center">Nama</th>
                          <th class="text-center">Kelas</th>
                          <th class="text-center">No Telepon</th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Impor Data Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="file">Pilih File Excel</label>
          <input type="file" class="form-control-file" id="file" name="file">
        </div>
        <div class="form-group">
          <label for="format">Format Excel Import Siswa</label>
          <br>
          <a href="{{ asset('docs/Format Import Siswa.xlsx') }}" class="form-control" download>Unduh Format Import Siswa.xlsx</a>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="importBtn">Impor</button>
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

    getData()

    function getData() {
        var htmlview
        let no = 0;
        $.ajax({
            // url: "{{ secure_url('siswa/get-data') }}",
            url: "{{ route('student.data') }}",
            type: 'GET',
            data: {
                kelas: $('#kelas').val()
            },
            beforeSend: function(){
                $(document).ajaxSend(function() {
                    $("#overlay").fadeIn(300);
                });
            },
            success: function(res) {
                $('tbody').html('')
                $.each(res, function(i, data) {
                    htmlview += `<tr>
                        <td class="font-weight-bold">`+( no += 1 )+`</td>
                        <td class="text-center">`+data.nisn+`</td>
                        <td class="text-center">`+data.nama_lengkap+`</td>
                        <td class="text-center">`+data.kelas+`</td>
                        <td class="text-center">`+data.no_telepon+`</td>
                        <td class="text-center">`

                    @if(getModuleAccess('MB4'))
                        htmlview += `<button class="btn btn-danger" onClick="deleteData('`+data.id+`')"><i class="mdi mdi-delete"></i></button>`
                    @endif

                    @if(getModuleAccess('MB3'))
                        htmlview += `<a href="{{ url('siswa/edit-data') }}/${data.id}" class="btn btn-warning">
                            <i class="mdi mdi-border-color text-dark" aria-hidden="true"></i>
                        </a>`
                    @endif

                    htmlview += `</td>
                    </tr>`;
                });

                $('tbody').html(htmlview)
                $("#data-table").DataTable(dtTableOption)
            },
            error: function(response){
                Swal.fire({
                    title: "Gagal!",
                    text: response.message,
                    icon: "error"
                });
            }
        })
    }

    function deleteData(id) {
        var urlRedirect = "{{ route('student') }}"
        var _url = "{{ route('student.delete', ':id') }}".replace(':id', id)
        // var urlRedirect = "{{ secure_url('student') }}"
        // var _url = "{{ secure_url('student/delete-data/') }}"+id
        // _url = _url.replace(':id', id),
        Swal.fire({
                title: "Apakah anda yakin hapus data ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Tidak",
            })
            .then((result) => {
                if (result.isConfirmed) {
                    var _token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: _url,
                        type: 'DELETE',
                        data: {
                            _token: _token
                        },
                        success: function(res) {
                            if(res.code == 200){
                                Notif.fire({
                                    icon: 'success',
                                    title: res.message,
                                })
                                $("#data-table").DataTable().destroy();
                                getData();
                            }else{
                                Notif.fire({
                                    icon: 'error',
                                    title: res.message,
                                })
                                $("#data-table").DataTable().destroy();
                                getData();
                            }
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    })
                }
            });
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#searchData').click(function(){
        var htmlview
        let no = 0;
            $.ajax({
                url: "{{ route('student.data') }}",
                // url: "{{ secure_url('siswa/get-data') }}",
                type: 'POST',
                data: {
                    kelas: $('#kelas').val()
                },
                beforeSend: function(){
                    $(document).ajaxSend(function() {
                        $("#overlay").fadeIn(300);
                    });
                },
                success: function(res) {
                    $('tbody').html('')
                    if(res.length > 0){
                        $.each(res, function(i, data) {
                            htmlview += `<tr>
                                <td class="font-weight-bold">`+( no += 1 )+`</td>
                                <td class="text-center">`+data.nisn+`</td>
                                <td class="text-center">`+data.nama_lengkap+`</td>
                                <td class="text-center">`+data.kelas+`</td>
                                <td class="text-center">`+data.no_telepon+`</td>
                                <td class="text-center">
                                <button class="btn btn-danger" onClick="deleteData('`+data.id+`')"><i class="mdi mdi-delete"></i></button>
                                <a href="{{ url('siswa/edit-data') }}/${data.id}" class="btn btn-warning">
                                    <i class="mdi mdi-border-color text-dark" aria-hidden="true"></i>
                                </a>
                                </td>
                            </tr>`
                        });
                    }else{
                        htmlview += `<tr><td colspan="6"> <p class="text-center text-danger">Tidak Ada Data</p> </td></tr>`
                    }

                    $('tbody').html(htmlview)
                    $("#data-table").DataTable(dtTableOption)
                },
                error: function(response){
                    Swal.fire({
                        title: "Gagal!",
                        text: response.message,
                        icon: "error"
                    });
                }
            })
        })

        $('#importBtn').click(function() {
            var fileInput = $('#file')[0].files[0];

            if (!fileInput) {
                Swal.fire(
                    'Gagal!',
                    'Pilih file Excel terlebih dahulu!',
                    'error'
                );
                return;
            }

            var formData = new FormData();
            formData.append('file', fileInput);

            $.ajax({
                url: '{{ route("student.import") }}',
                // url: '{{ secure_url("student/import") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    Swal.fire(
                        'Tunggu Sebentar',
                        'Sedang Proses import....',
                        'warning'
                    );
                },
                success: function(response) {
                    if(response.code == 200){
                        Swal.fire(
                            'Berhasil!',
                            response.message,
                            'success'
                        );
                        getData()
                    }else{
                        Swal.fire(
                            'Gagal!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Gagal!',
                        'Terdapat Kesalahan Program!',
                        'error'
                    );
                    console.error(xhr.responseText);
                }
            });
        });

        $('#exportBtn').click(function() {
            $.ajax({
                url: '{{ route("student.export") }}',
                // url: '{{ secure_url("student/export") }}',
                method: 'GET',
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    var blob = new Blob([response], { type: xhr.getResponseHeader('Content-Type') });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'Download Siswa.xlsx';
                    link.click();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Terjadi kesalahan saat mengekspor data.');
                }
            });
        });
    })
</script>
@stop
