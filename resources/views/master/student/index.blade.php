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
                            <h4 class="card-title">Data Siswa</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('student.add') }}" class="btn btn-outline-primary btn-sm mb-0">Tambah Data</a>
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
            url: "{{ route('student.data') }}",
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

                $('tbody').html(htmlview)
                $("#data-table").DataTable(dtTableOption)
            },
            error: function(res){
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
            var _url = "{{ route('student.delete', ':id') }}"
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
@stop