@extends('layouts.app')
@section('title', 'Data Absensi Siswa')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="start_date">Start Date and Time:</label>
                                    <input type="datetime-local" id="start_date" name="start_date" class="form-control" value="{{ $start_date }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date">End Date and Time:</label>
                                    <input type="datetime-local" id="end_date" name="end_date" class="form-control" value="{{ $end_date }}" required>
                                </div>
                                <div class="col-md-3 mt-4">
                                    <button class="btn btn-outline-success btn-sm mb-0" id="searchData"><i class="mdi mdi-cloud-search"></i> Search Data</button>
                                    <button class="btn btn-outline-warning btn-sm mb-0" id="exportBtn"><i class="mdi mdi-cloud-download"></i> Export Data</button>
                                </div>
                            </div>
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
                          <th class="text-center">Status Absen</th>
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
            url: "{{ route('attendance.data') }}",
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
                        <td class="text-center">`+data.sholat+`</td>
                        <td class="text-center">`+data.check_in+`</td>`;
                    if(data.is_late != null || data.is_late != 0){
                        htmlview += `<td class="text-center">
                                <button class="btn btn-danger" disabled>Terlambat</button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success" onClick="kirimWhatsapp('`+data.nama_lengkap+`', '`+data.sholat+`', '`+data.kelas+`', '`+data.no_telepon+`')">Kirim Whatsapp</button>
                            </td>
                        </tr>`
                    }else{
                        htmlview += `<td class="text-center">
                                <button class="btn btn-primary" disabled>Masuk</button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-success" disabled>Kirim Wa</button>
                            </td>
                        </tr>`

                    }
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

    function kirimWhatsapp(nama_lengkap, sholat, kelas, no_telepon) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan mengirim pesan WhatsApp.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                let message = `Yth Bapak/Ibu Siswa ${nama_lengkap},\n\n`;
                message += `Siswa dengan nama *${nama_lengkap}* kelas *${kelas}* terlambat melaksanakan ibadah sholat ${sholat}.\n`;
                message += "Dimohon untuk disiplinkan anak Bapak/Ibu supaya tetap rajin dan tepat waktu ibadah.\n\n";
                message += "Terima Kasih";

                let encodedMessage = encodeURIComponent(message);
                let phone_number = replaceZeroWith62(no_telepon);

                let waLink = `https://wa.me/${phone_number}?text=${encodedMessage}`;
                window.open(waLink, '_blank');
            }
        });
    }

    function replaceZeroWith62(phoneNumber) {
        if (phoneNumber.startsWith('0')) {
            return '62' + phoneNumber.slice(1);
        }
        return phoneNumber;
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#searchData').click(function() {
            $('tbody').html('')
            $.ajax({
                url: '{{ route("attendance.data") }}',
                method: 'POST',
                data: {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                },
                success: function(response, status, xhr) {
                    Swal.fire({
                        title: "Success!",
                        text: "Search Data Berhasil",
                        icon: "success"
                    });

                    var htmlview
                    let no = 0;
                    if(response.length != 0){
                        $.each(response, function(i, data) {
                            htmlview += `<tr>
                                <td class="font-weight-bold">`+( no += 1 )+`</td>
                                <td class="text-center">`+data.nisn+`</td>
                                <td class="text-center">`+data.nama_lengkap+`</td>
                                <td class="text-center">`+data.sholat+`</td>
                                <td class="text-center">`+data.check_in+`</td>`;
                            if(data.is_late != null || data.is_late != 0){
                                htmlview += `<td class="text-center">
                                        <button class="btn btn-danger" disabled>Terlambat</button>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-success" onClick="kirimWhatsapp('`+data.no_telepon+`', '`+data.id+`', '`+data.idSiswa+`')">Kirim Whatsapp</button>
                                    </td>
                                </tr>`
                            }else{
                                htmlview += `<td class="text-center">
                                        <button class="btn btn-primary" disabled>Masuk</button>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-success" disabled>Kirim Wa</button>
                                    </td>
                                </tr>`
                            }
                        });
                    }else{
                        htmlview += `<tr>
                            <td colspan="7" class="text-danger text-center">Tidak Ada Data</td>
                            </tr>`
                    }

                    console.log(htmlview)
                    $('tbody').html(htmlview)
                    $("#data-table").DataTable(dtTableOption)
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "Warning!",
                        text: "Terjadi Kesalahan Saat Search Data!",
                        icon: "warning"
                    });
                }
            });
        });

        $('#exportBtn').click(function() {
            $.ajax({
                url: '{{ route("attendance.export") }}',
                method: 'GET',
                data: {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    var blob = new Blob([response], { type: xhr.getResponseHeader('Content-Type') });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'Absensi Siswa.xlsx';
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
