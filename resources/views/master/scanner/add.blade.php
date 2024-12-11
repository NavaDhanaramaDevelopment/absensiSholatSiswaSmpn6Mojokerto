@extends('layouts.app')
@if(isset($scanner))
@section('title', 'Edit Scanner')
@else
@section('title', 'Tambah Scanner')
@endif

@section('content')
<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Master Scanner</h4>
                <form id="teacherForm" class="forms-sample" method="POST" >
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">Username</label>
                                <input type="text" name="username" class="form-control" id="username" value="{{ isset($scanner) ? $scanner->username : old('username') }}"  placeholder="Username">
                            <div id="username-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">@if(!isset($scanner)) Password (Password Default) @else Ubah Password @endif</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="password" name="password" placeholder="Ketik Password" value="{{ isset($scanner) ? $scanner->username : '' }}" @if(!isset($scanner)) readonly @endif>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="mdi mdi-eye"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div id="password-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="btn-save" class="btn btn-primary me-2">Submit</button>
                    <a href="{{ route('scanner.index') }}" class="btn btn-light">Cancel</a>
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

        $('#username').on('input', function(){
            let data = $(this).val()
            $('#password').val(data)
        })

        $('#togglePassword').click(function(){
            var type = $('#password').attr('type') === 'password' ? 'text' : 'password';
            $('#password').attr('type', type);
            $(this).html(type === 'password' ? '<i class="mdi mdi-eye"></i>' : '<i class="mdi mdi-eye-off"></i>');
        });

        $('#btn-save').on('click', function(){
            var username = $('#username').val();
            var password = $('#password').val();
            @if(isset($student))
                if ( username == '') {
                    $('#username').addClass('is-invalid').siblings('.invalid-feedback').text(username == '' ? 'Username harus diisi!' : '');


                    Swal.fire({
                        title: "Error!",
                        text: "Setidaknya satu input harus diisi!",
                        icon: "error"
                    });
                    return;
                }
            @else
                var password = $('#password').val();
                if (username == '') {
                    $('#username').addClass('is-invalid').siblings('.invalid-feedback').text(username == '' ? 'Username harus diisi!' : '');


                    Swal.fire({
                        title: "Error!",
                        text: "Setidaknya satu input harus diisi!",
                        icon: "error"
                    });
                    return;
                }
            @endif



            var formData = new FormData();
            formData.append('username', username);
            formData.append('password', password);
            @if(isset($scanner))
                formData.append('_method', 'PUT');
            @endif
            formData.append('_token', '{{ csrf_token() }}');


            // Kirim data ke controller Laravel menggunakan AJAX
            $.ajax({
                url: @if(isset($scanner)) "{{ route('scanner.update', $id) }}" @else "{{ route('scanner.store') }}" @endif,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    if (response && response.success) {

                        @if(isset($scanner))
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
                            window.location.href = "{{ route('scanner.index') }}";
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
