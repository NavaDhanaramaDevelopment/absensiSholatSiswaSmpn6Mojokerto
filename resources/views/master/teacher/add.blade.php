@extends('layouts.app')
@section('title', 'Tambah Guru')

@section('content')
<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Master Guru</h4>
                <form id="teacherForm" class="forms-sample" method="POST" >
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName1">Kode Guru</label>
                                <input type="number" name="kode_guru" class="form-control" id="kode_guru" value="{{ isset($teacher) ? $teacher->kode_guru : old('kode_guru') }}"  placeholder="Kode Guru">
                            <div id="kode_guru-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName1">Nama Depan</label>
                                <input type="text" name="nama_depan" class="form-control" id="nama_depan" value="{{ isset($teacher) ? $teacher->nama_depan : old('nama_depan') }}"  placeholder="Nama Depan">
                            <div id="nama_depan-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName1">Nama Belakang</label>
                                <input type="text" name="nama_belakang" class="form-control" id="nama_belakang" value="{{ isset($teacher) ? $teacher->nama_belakang : old('nama_belakang') }}" placeholder="Nama Depan">
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
                                    <option value="Laki-Laki" @if(isset($teacher) && $teacher->jenis_kelamin == 'Laki-Laki') selected @endif>Laki-Laki</option>
                                    <option value="Perempuan" @if(isset($teacher) && $teacher->jenis_kelamin == 'Perempuan') selected @endif>Perempuan</option>
                                </select>
                            <div id="jenis_kelamin-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Nomor Telepon</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ isset($teacher) ? $teacher->no_telepon : old('no_telepon') }}" placeholder="Nomor Telepon">
                                <div id="no_telepon-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleSelectGender">Wali Kelas</label>
                                <select class="form-control" id="wali_kelas" name="wali_kelas">
                                    <option value="" selected disabled>===== Wali Kelas =====</option>
                                    <option value="7A" @if(isset($teacher) && $teacher->wali_kelas == '7A') selected @endif>7A</option>
                                    <option value="7B" @if(isset($teacher) && $teacher->wali_kelas == '7B') selected @endif>7B</option>
                                    <option value="7C" @if(isset($teacher) && $teacher->wali_kelas == '7C') selected @endif>7C</option>
                                    <option value="7D" @if(isset($teacher) && $teacher->wali_kelas == '7D') selected @endif>7D</option>
                                    <option value="7E" @if(isset($teacher) && $teacher->wali_kelas == '7E') selected @endif>7E</option>
                                    <option value="7F" @if(isset($teacher) && $teacher->wali_kelas == '7F') selected @endif>7F</option>
                                    <option value="7G" @if(isset($teacher) && $teacher->wali_kelas == '7G') selected @endif>7G</option>
                                    <option value="7H" @if(isset($teacher) && $teacher->wali_kelas == '7H') selected @endif>7H</option>
                                    <option value="7I" @if(isset($teacher) && $teacher->wali_kelas == '7I') selected @endif>7I</option>
                                    <option value="7J" @if(isset($teacher) && $teacher->wali_kelas == '7J') selected @endif>7J</option>
                                </select>
                                <div id="wali_kelas-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password (Password Default)</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="password" name="password" placeholder="Ketik Password" value="guru123" readonly>
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

        $('#wali_kelas').select2();

        $('#togglePassword').click(function(){
            var type = $('#password').attr('type') === 'password' ? 'text' : 'password';
            $('#password').attr('type', type);
            $(this).html(type === 'password' ? '<i class="mdi mdi-eye"></i>' : '<i class="mdi mdi-eye-off"></i>');
        });

        $('#btn-save').on('click', function(){
            var kode_guru = $('#kode_guru').val();
            var nama_depan = $('#nama_depan').val();
            var nama_belakang = $('#nama_belakang').val();
            var jenis_kelamin = $('#jenis_kelamin').val();
            var no_telepon = $('#no_telepon').val();
            var wali_kelas = $('#wali_kelas').val();
            var password = $('#password').val();

            if (kode_guru == '' || nama_depan == '' || nama_belakang == '' || jenis_kelamin == null || no_telepon == '' || wali_kelas == null || password == '') {
                $('#kode_guru').addClass('is-invalid').siblings('.invalid-feedback').text(kode_guru == '' ? 'Kode Guru harus diisi!' : '');
                $('#nama_depan').addClass('is-invalid').siblings('.invalid-feedback').text(nama_depan == '' ? 'Nama Depan harus diisi!' : '');
                $('#nama_belakang').addClass('is-invalid').siblings('.invalid-feedback').text(nama_belakang == '' ? 'Nama Belakang harus diisi!' : '');
                $('#jenis_kelamin').addClass('is-invalid').siblings('.invalid-feedback').text(jenis_kelamin == null ? 'Jenis Kelamin harus diisi!' : '');
                $('#no_telepon').addClass('is-invalid').siblings('.invalid-feedback').text(no_telepon == '' ? 'Nomor Telepon harus diisi!' : '');
                $('#wali_kelas').addClass('is-invalid').siblings('.invalid-feedback').text(wali_kelas == null ? 'Wali kelas harus diisi!' : '');

                Swal.fire({
                    title: "Error!",
                    text: "Setidaknya satu input harus diisi!",
                    icon: "error"
                });
                return;
            }

            var formData = new FormData();
            formData.append('kode_guru', kode_guru);
            formData.append('nama_depan', nama_depan);
            formData.append('nama_belakang', nama_belakang);
            formData.append('jenis_kelamin', jenis_kelamin);
            formData.append('no_telepon', no_telepon);
            formData.append('wali_kelas', wali_kelas);
            formData.append('password', password);
            formData.append('_token', '{{ csrf_token() }}');

            console.log([...formData]);

            // Kirim data ke controller Laravel menggunakan AJAX
            $.ajax({
                @if(isset($teacher))
                    url: "{{ route('teacher.update', $id) }}",
                    method: "POST",
                @else
                    url: "{{ route('teacher.store') }}",
                    method: "POST",
                @endif
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response)
                    if (response && response.success) {

                        @if(isset($teacher))
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
                            window.location.href = "{{ route('teacher') }}";
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
