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
                                <label for="exampleInputName1">Kode Siswa (NISN)</label>
                                <input type="number" name="nisn" class="form-control" id="nisn" value="{{ isset($student) ? $student->nisn : old('nisn') }}"  placeholder="Kode Siswa">
                            <div id="nisn-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName1">Nama Depan</label>
                                <input type="text" name="nama_depan" class="form-control" id="nama_depan" value="{{ isset($student) ? $student->nama_depan : old('nama_depan') }}"  placeholder="Nama Depan">
                            <div id="nama_depan-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName1">Nama Belakang</label>
                                <input type="text" name="nama_belakang" class="form-control" id="nama_belakang" value="{{ isset($student) ? $student->nama_belakang : old('nama_belakang') }}" placeholder="Nama Depan">
                            <div id="nama_belakang-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleSelectGender">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="" selected disabled>===== Pilih Jenis Kelamin =====</option>
                                    <option value="Laki-Laki" @if(isset($student) && $student->jenis_kelamin == 'Laki-Laki') selected @endif>Laki-Laki</option>
                                    <option value="Perempuan" @if(isset($student) && $student->jenis_kelamin == 'Perempuan') selected @endif>Perempuan</option>
                                </select>
                            <div id="jenis_kelamin-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Nomor Telepon</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ isset($student) ? $student->no_telepon : old('no_telepon') }}" placeholder="Nomor Telepon">
                                <div id="no_telepon-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if(!isset($student))
                        <div class="col-md-6">
                        @else
                        <div class="col-md-12">
                        @endif
                            <div class="form-group">
                                <label for="exampleSelectGender">Kelas</label>
                                <select class="form-control" id="kelas" name="kelas">
                                    <option value="" selected disabled>===== Kelas =====</option>
                                    <option value="7A" @if(isset($student) && $student->kelas == '7A') selected @endif>7A</option>
                                    <option value="7B" @if(isset($student) && $student->kelas == '7B') selected @endif>7B</option>
                                    <option value="7C" @if(isset($student) && $student->kelas == '7C') selected @endif>7C</option>
                                    <option value="7D" @if(isset($student) && $student->kelas == '7D') selected @endif>7D</option>
                                    <option value="7E" @if(isset($student) && $student->kelas == '7E') selected @endif>7E</option>
                                    <option value="7F" @if(isset($student) && $student->kelas == '7F') selected @endif>7F</option>
                                    <option value="7G" @if(isset($student) && $student->kelas == '7G') selected @endif>7G</option>
                                    <option value="7H" @if(isset($student) && $student->kelas == '7H') selected @endif>7H</option>
                                    <option value="7I" @if(isset($student) && $student->kelas == '7I') selected @endif>7I</option>
                                    <option value="7J" @if(isset($student) && $student->kelas == '7J') selected @endif>7J</option>
                                </select>
                                <div id="kelas-error" class="invalid-feedback"></div>
                            </div>
                        </div>

                        @if(!isset($student))
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password (Password Default)</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="password" name="password" placeholder="Ketik Password" value="" readonly>
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
                        @else
                        @endif
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
            var nisn = $('#nisn').val();
            var nama_depan = $('#nama_depan').val();
            var nama_belakang = $('#nama_belakang').val();
            var jenis_kelamin = $('#jenis_kelamin').val();
            var no_telepon = $('#no_telepon').val();
            var kelas = $('#kelas').val();
            @if(isset($student))
                if (nisn == '' || nama_depan == '' || nama_belakang == '' || jenis_kelamin == null || no_telepon == '' || kelas == null) {
                    $('#nisn').addClass('is-invalid').siblings('.invalid-feedback').text(nisn == '' ? 'Kode Siswa harus diisi!' : '');
                    $('#nama_depan').addClass('is-invalid').siblings('.invalid-feedback').text(nama_depan == '' ? 'Nama Depan harus diisi!' : '');
                    $('#nama_belakang').addClass('is-invalid').siblings('.invalid-feedback').text(nama_belakang == '' ? 'Nama Belakang harus diisi!' : '');
                    $('#jenis_kelamin').addClass('is-invalid').siblings('.invalid-feedback').text(jenis_kelamin == null ? 'Jenis Kelamin harus diisi!' : '');
                    $('#no_telepon').addClass('is-invalid').siblings('.invalid-feedback').text(no_telepon == '' ? 'Nomor Telepon harus diisi!' : '');

                    Swal.fire({
                        title: "Error!",
                        text: "Setidaknya satu input harus diisi!",
                        icon: "error"
                    });
                    return;
                }
            @else
                var password = $('#password').val();
                if (nisn == '' || nama_depan == '' || nama_belakang == '' || jenis_kelamin == null || no_telepon == '' || kelas == null || password == '') {
                    $('#nisn').addClass('is-invalid').siblings('.invalid-feedback').text(nisn == '' ? 'Kode Siswa harus diisi!' : '');
                    $('#nama_depan').addClass('is-invalid').siblings('.invalid-feedback').text(nama_depan == '' ? 'Nama Depan harus diisi!' : '');
                    $('#nama_belakang').addClass('is-invalid').siblings('.invalid-feedback').text(nama_belakang == '' ? 'Nama Belakang harus diisi!' : '');
                    $('#jenis_kelamin').addClass('is-invalid').siblings('.invalid-feedback').text(jenis_kelamin == null ? 'Jenis Kelamin harus diisi!' : '');
                    $('#no_telepon').addClass('is-invalid').siblings('.invalid-feedback').text(no_telepon == '' ? 'Nomor Telepon harus diisi!' : '');
                    $('#kelas').addClass('is-invalid').siblings('.invalid-feedback').text(kelas == null ? 'Kelas harus diisi!' : '');

                    Swal.fire({
                        title: "Error!",
                        text: "Setidaknya satu input harus diisi!",
                        icon: "error"
                    });
                    return;
                }
            @endif



            var formData = new FormData();
            formData.append('nisn', nisn);
            formData.append('nama_depan', nama_depan);
            formData.append('nama_belakang', nama_belakang);
            formData.append('jenis_kelamin', jenis_kelamin);
            formData.append('no_telepon', no_telepon);
            formData.append('kelas', kelas);
            @if(!isset($student))
                formData.append('password', password);
            @endif
            formData.append('_token', '{{ csrf_token() }}');


            // Kirim data ke controller Laravel menggunakan AJAX
            $.ajax({
                @if(isset($student))
                    url: "{{ route('student.update', $id) }}",
                    // url: "{{ secure_url('siswa/update-data/', $id) }}",
                    method: "POST",
                @else
                    url: "{{ route('student.store') }}",
                    // url: "{{ secure_url('siswa/add-data') }}",
                    method: "POST",
                @endif
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response)
                    if (response && response.success) {

                        @if(isset($student))
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
                            window.location.href = "{{ route('student') }}";
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
