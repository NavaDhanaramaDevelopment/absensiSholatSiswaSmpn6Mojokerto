@extends('layouts.app')
@section('title', 'Siswa')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Data Kelas</h4>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('classes.create') }}" class="btn btn-outline-primary btn-sm mb-0"><i class="mdi mdi-plus"></i> Tambah Data</a>
                        </div>
                    </div>

                  <div class="table-responsive">
                    <table class="table" id="data-table">
                      <thead>
                        <tr>
                          <th class="text-center">No</th>
                          <th class="text-center">Nama Kelas</th>
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
            url: "{{ route('classes.data') }}",
            // url: "{{ secure_url('get-data') }}",
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
                        <td class="text-center">`+data.nama_kelas+`</td>
                        <td class="text-center">
                        <button class="btn btn-danger" onClick="deleteData('`+data.id+`')"><i class="mdi mdi-delete"></i></button>
                        <a href="{{ url('classes') }}/${data.id}" class="btn btn-warning">
                            <i class="mdi mdi-border-color text-dark" aria-hidden="true"></i>
                        </a>
                        </td>
                    </tr>`
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
        var urlRedirect = "{{ route('classes.index') }}"
        var _url = "{{ route('classes.destroy', ':id') }}"
        // var urlRedirect = "{{ secure_url('classes') }}"
        // var _url = "{{ secure_url('classes/destroy/') }}"+id
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
@stop
