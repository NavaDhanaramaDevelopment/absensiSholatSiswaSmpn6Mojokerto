@extends('layouts.app')
@section('title', 'Tambah Siswa')

@section('content')
<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Master Siswa</h4>
                <form id="teacherForm" class="forms-sample" method="POST" >
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName1">Sholat</label>
                                <input type="text" name="sholat" class="form-control" id="sholat" value="{{ isset($sholat) ? $sholat->sholat : old('sholat') }}"  placeholder="Nama Sholat">
                            <div id="sholat-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName1">Jam Sholat Dimulai</label>
                                <input type="time" name="start_clock" class="form-control" id="start_clock" value="{{ isset($sholat) ? $sholat->start_clock : old('start_clock') }}"  placeholder="Nama Depan">
                            <div id="start_clock-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName1">Jam Sholat Berakhir</label>
                                <input type="time" name="end_clock" class="form-control" id="end_clock" value="{{ isset($sholat) ? $sholat->end_clock : old('end_clock') }}" placeholder="Nama Depan">
                            <div id="end_clock-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="btn-save" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#btn-save').on('click', function(){
            var sholat = $('#sholat').val();
            var start_clock = $('#start_clock').val();
            var end_clock = $('#end_clock').val();
            @if(isset($sholat))
                if (sholat == '' || start_clock == '' || end_clock == '') {
                    $('#sholat').addClass('is-invalid').siblings('.invalid-feedback').text(sholat == '' ? 'Sholat harus diisi!' : '');
                    $('#start_clock').addClass('is-invalid').siblings('.invalid-feedback').text(start_clock == '' ? 'Jam Sholat Dimulai harus diisi!' : '');
                    $('#end_clock').addClass('is-invalid').siblings('.invalid-feedback').text(end_clock == '' ? 'Jam Sholat Berakhir harus diisi!' : '');

                    Swal.fire({
                        title: "Error!",
                        text: "Setidaknya satu input harus diisi!",
                        icon: "error"
                    });
                    return;
                }
            @else
                if (sholat == '' || start_clock == '' || end_clock == '') {
                    $('#sholat').addClass('is-invalid').siblings('.invalid-feedback').text(sholat == '' ? 'Sholat harus diisi!' : '');
                    $('#start_clock').addClass('is-invalid').siblings('.invalid-feedback').text(start_clock == '' ? 'Jam Sholat Dimulai harus diisi!' : '');
                    $('#end_clock').addClass('is-invalid').siblings('.invalid-feedback').text(end_clock == '' ? 'Jam Sholat Berakhir harus diisi!' : '');

                    Swal.fire({
                        title: "Error!",
                        text: "Setidaknya satu input harus diisi!",
                        icon: "error"
                    });
                    return;
                }
            @endif



            var formData = new FormData();
            formData.append('sholat', sholat);
            formData.append('start_clock', start_clock);
            formData.append('end_clock', end_clock);
            formData.append('_token', '{{ csrf_token() }}');


            // Kirim data ke controller Laravel menggunakan AJAX
            $.ajax({
                @if(isset($sholat))
                    url: "{{ route('sholat.update', $id) }}",
                    method: "POST",
                @else
                    url: "{{ route('sholat.store') }}",
                    method: "POST",
                @endif
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response)
                    if (response && response.success) {

                        @if(isset($sholat))
                            Swal.fire({
                                title: "Success!",
                                text: "Data Berhasil Diedit!",
                                icon: "success"
                            });
                        @else
                            Swal.fire({
                                title: "Success!",
                                text: "Data Berhasil Ditambahkan!",
                                icon: "success"
                            });
                        @endif
                        setInterval(() => {
                            window.location.href = "{{ route('sholat') }}";
                        }, 1000);
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: response.message || "Terjadi kesalahan saat menghubungi server.",
                            icon: "error"
                        });
                    }
                },
                error: function(xhr, status, error){
                    Swal.fire({
                        title: "Gagal Server!",
                        text: "Terjadi kesalahan saat menghubungi server.",
                        icon: "error"
                    });
                }
            });
        });
    });
</script>

@stop
