@extends('layouts.app')
@if(isset($kelas))
@section('title', 'Edit Siswa')
@else
@section('title', 'Tambah Siswa')
@endif

@section('content')
<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Master Siswa</h4>
                <form id="teacherForm" class="forms-sample" method="POST" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputName1">Nama Kelas</label>
                                <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" value="{{ isset($kelas) ? $kelas->nama_kelas : old('nama_kelas') }}"  placeholder="Nama Kelas">
                            <div id="nama_kelas-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="btn-save" class="btn btn-primary me-2">Submit</button>
                    <a href="{{ route('classes.index') }}" class="btn btn-light">Cancel</a>
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

        $('#kelas').select2();

        $('#nisn').on('input', function(){
            let data = $(this).val()
            $('#password').val(data)
        })

        $('#togglePassword').click(function(){
            var type = $('#password').attr('type') === 'password' ? 'text' : 'password';
            $('#password').attr('type', type);
            $(this).html(type === 'password' ? '<i class="mdi mdi-eye"></i>' : '<i class="mdi mdi-eye-off"></i>');
        });

        $('#btn-save').on('click', function(){
            var nama_kelas = $('#nama_kelas').val();
            var teacher_id = $('#teacher_id').val();
            @if(isset($student))
                if ( nama_kelas == '') {
                    $('#nama_kelas').addClass('is-invalid').siblings('.invalid-feedback').text(nama_kelas == '' ? 'Nama Kelas harus diisi!' : '');


                    Swal.fire({
                        title: "Error!",
                        text: "Setidaknya satu input harus diisi!",
                        icon: "error"
                    });
                    return;
                }
            @else
                var password = $('#password').val();
                if (nama_kelas == '') {
                    $('#nama_kelas').addClass('is-invalid').siblings('.invalid-feedback').text(nama_kelas == '' ? 'Nama Kelas harus diisi!' : '');


                    Swal.fire({
                        title: "Error!",
                        text: "Setidaknya satu input harus diisi!",
                        icon: "error"
                    });
                    return;
                }
            @endif



            var formData = new FormData();
            formData.append('nama_kelas', nama_kelas);
            @if(isset($kelas))
                formData.append('_method', 'PUT');
            @endif
            formData.append('_token', '{{ csrf_token() }}');


            // Kirim data ke controller Laravel menggunakan AJAX
            $.ajax({
                url: @if(isset($kelas)) "{{ route('classes.update', $id) }}" @else "{{ route('classes.store') }}" @endif,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    if (response && response.success) {

                        @if(isset($kelas))
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
                            window.location.href = "{{ route('classes.index') }}";
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
