@extends('layouts.app')
@section('title', 'Scan Absensi Siswa')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scan Absensi Siswa</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Scan Absensi Siswa</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if(Auth::user()->hasAccess('SC1'))
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h5 class="card-title">Data Scan QR Code</h5>
                        <div class="card-tools">
                            <button class="btn btn-success btn-sm" id="refresh">
                                <i class="fas fa-sync"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body text-center">
                      <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div id="reader"></div>
                            {{-- <video id="my_camera" class="solid"></video> --}}
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-12" id="result">

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
                @if(Auth::user()->hasAccess('SC1'))
                <div class="col-md-12">
                    <div class="card collapsed-card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Data Absensi Siswa</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool"
                                    data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4 table-responsive text-nowrap" id="tbl_data_wrapper">
                                <table id="tbl_data" class="table table-bordered table-striped"
                                aria-describedby="tbl_data" style="width: 100%;">
                                    <thead>
                                          <tr>
                                              <th width="5%" style="text-align: center;">No</th>
                                              <th>Nama</th>
                                              <th>NISN</th>
                                              <th>Jadwal Sholat</th>
                                              <th>Check In</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                          </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

@endsection

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
            "destroy": true,
            "autoWidth": true,
            "responsive": true,
            "buttons": [
                // {
                //     text: "<i class='fas fa-copy' title='Copy Table to Clipboard'></i>",
                //     className: "btn btn-outline-secondary",
                //     extend: 'copy'
                // },
                // {
                //     text: "<i class='fas fa-file-excel' title='Download File Excel'></i>",
                //     className: "btn btn-outline-success",
                //     extend: 'excel'
                // },
                // {
                //     text: "<i class='fas fa-file-pdf' title='Download File PDF'></i>",
                //     className: "btn btn-outline-danger",
                //     extend: 'pdf'
                // },
                // {
                //     text: "<i class='fas fa-print' title='Print Table'></i>",
                //     className: "btn btn-outline-primary",
                //     extend: 'print'
                // },
                {
                    text: "<i class='fas fa-cog' title='Coloum Visible Option'></i>",
                    className: "btn btn-outline-info",
                    extend: 'colvis'
                }
            ]
        };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.2.0/html5-qrcode.min.js"></script>
    @if(Auth::user()->hasAccess('SC1'))
    <script type="text/javascript">
        // Setting up Qr Scanner properties
        var html5QrCodeScanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: 500
        });

        let qrScanValue = '';
        // When scan is successful fucntion will produce data
        function onScanSuccess(qrCodeMessage) {
            if(qrCodeMessage !== qrScanValue){
                $.ajax({
                    url: "{{ route('scanBarcode.attendanceGuest') }}",
                    // url: "{{ secure_url('scan-barcode') }}",
                    type: "POST",
                    data: {'qrCodeMessage' : qrCodeMessage},
                    dataType: 'json',
                    success: function(res) {
                        console.log(res)

                        // $('#modalAddGuestType').modal('hide')
                        if (res.code == 200) {

                            if(res.status == true){
                                Swal.fire(
                                    'Success!',
                                    res.message,
                                    'success'
                                )
                            }

                            if(res.status == false){
                                qrScanValue = qrCodeMessage
                                Swal.fire(
                                    'Failed!',
                                    res.message,
                                    'warning'
                                )
                                setTimeout(() => {
                                    qrScanValue = ''
                                }, 5000);
                            }
                            $("#tbl_data").DataTable().destroy();
                            getAttendance()
                        }

                        if(res.code == 419){
                            qrScanValue = qrCodeMessage
                            Swal.fire(
                                'Failed!',
                                res.message,
                                'warning'
                            )
                            setTimeout(() => {
                                qrScanValue = ''
                            }, 3000);
                        }

                        if(res.code == 409){
                            qrScanValue = qrCodeMessage
                            Swal.fire(
                                'Failed!',
                                res.message,
                                'error'
                            )
                            setTimeout(() => {
                                qrScanValue = ''
                            }, 3000);
                        }
                    },
                    error: function(err) {
                        Swal.fire(
                            'Error!',
                            'Failed To Attendance Guest! Please Contant Developer!',
                            'error'
                        )
                        setTimeout(() => {
                            qrScanValue = ''
                        }, 1000);
                    }
                });

                qrScanValue = qrCodeMessage;
            }
        }

        // When scan is unsuccessful fucntion will produce error message
        function onScanError(errorMessage) {
            Notif.fire({
                icon: 'error',
                title: 'Error When Scanning Data! Please Contact Developer',
                text: 'Server Error!'
            });
        }

        function stopScanning() {
            // Stop the QR code scanning process
            html5QrcodeScanner.stop();
            qrScanValue = ''; // Update the scanning status
        }

        // in
        html5QrCodeScanner.render(onScanSuccess);

        $(document).ready(function(){
            $('#refresh').on('click', function(){
                qrScanValue = '';
            })
        })
    </script>
    @endif
    @if(Auth::user()->hasAccess('SC1'))
        <script type="text/javascript">
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

            getAttendance()

            function getAttendance(){
                let htmlview = ''
                let no = 1;
                $.ajax({
                    url: "{{ route('getDataScanAbsensi') }}",
                    // url: "{{ secure_url('Scan-Absensi/get-data-scan-absensi') }}",
                    type: 'GET',
                    success: function(response) {
                        console.log(response)
                        $('tbody').html('')
                        $.each(response, function(i, data) {
                            htmlview += `<tr>
                            <td style="text-align: center;">` + (no++) + `</td>
                            <td>` + data.nama_lengkap + `</td>
                            <td>` + data.nisn + `</td>
                            <td>` + data.sholat + `</td>
                            <td>` + data.check_in + `</td>
                        </tr>`
                        });

                        $('tbody').html(htmlview)
                        $("#tbl_data").DataTable(dtTableOption)
                    }
                })
            }


        </script>
    @endif
    {{-- <script src="{{ asset('plugins/instascan/instascan.min.js') }}"></script>
    <script src="{{ asset('plugins/webcamjs/webcam.min.js') }}"></script>
    <script>
        Webcam.set({
            width: 560,
            height: 340,
            image_format: 'jpeg',
            jpeg_quality: 100
        });
        Webcam.attach('#my_camera');

        $(document).ready(function(){
            let scanner = new Instascan.Scanner({
                video: document.getElementById('my_camera'),
                mirror: false
            });
            scanner.addListener('scan', function(content) {
                console.log('ok')
            });
        });
    </script> --}}
@endsection
