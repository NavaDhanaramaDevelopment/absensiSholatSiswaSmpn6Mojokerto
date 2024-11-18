@extends('layouts.app')
@section('title', 'Siswa')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center mt-4">
                            @if(getModuleAccess('S2'))
                                <a href="{{ route('sholat.add') }}" class="btn btn-outline-primary btn-sm mb-0"><i class="mdi mdi-plus"></i> Tambah Data</a>
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
                            <h4 class="card-title">Data Sholat</h4>
                        </div>
                    </div>

                  <div class="table-responsive">
                    <table class="table" id="data-table">
                      <thead>
                        <tr>
                          <th class="text-center">No</th>
                          <th class="text-center">Sholat</th>
                          <th class="text-center">Jam Sholat Dimulai</th>
                          <th class="text-center">Jam Sholat Berakhir</th>
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
            url: "{{ route('sholat.data') }}",
            type: 'GET',
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
                        <td class="text-center">`+data.sholat+`</td>
                        <td class="text-center">`+data.start_clock+`</td>
                        <td class="text-center">`+data.end_clock+`</td>
                        <td class="text-center">`

                    @if(getModuleAccess('S4'))
                        htmlview += `<button class="btn btn-danger" onClick="deleteData('`+data.id+`')"><i class="mdi mdi-delete"></i></button>`
                    @endif

                    @if(getModuleAccess('S3'))
                        htmlview += `<a href="{{ url('sholat/edit-data') }}/${data.id}" class="btn btn-warning">
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
        var urlRedirect = "{{ route('sholat') }}"
        var _url = "{{ route('sholat.delete', ':id') }}"
        _url = _url.replace(':id', id),
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
                url: "{{ route('sholat.data') }}",
                type: 'POST',
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
                                <td class="text-center">`+data.sholat+`</td>
                                <td class="text-center">`+data.start_clock+`</td>
                                <td class="text-center">`+data.end_clock+`</td>
                                <td class="text-center">
                                <button class="btn btn-danger" onClick="deleteData('`+data.id+`')"><i class="mdi mdi-delete"></i></button>
                                <a href="{{ url('sholat/edit-data') }}/${data.id}" class="btn btn-warning">
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
    })
</script>
@stop
