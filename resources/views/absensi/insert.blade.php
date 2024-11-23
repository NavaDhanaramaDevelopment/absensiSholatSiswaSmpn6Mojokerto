@extends('layouts.app')
@section('title', 'Tambah Absensi manual Siswa')


@section('content')

<div class="content-wrapper">
    @if(session('alert'))
        <div class="alert alert-danger text-white">
            {{ session('alert') }}
        </div>
    @endif
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Master Guru</h4>
                <form id="teacherForm" class="forms-sample" method="POST" action="{{ route('attendance.manualAdd') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleSelectGender">Pilih Kelas Terlebih Dahulu</label>
                                <select class="form-control" id="kelas" name="kelas">
                                    <option value="" selected disabled>===== Pilih Kelas =====</option>
                                    @foreach ($kelas as $k)
                                    <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                <div id="kelas-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleSelectGender">Pilih Jadwal Sholat</label>
                                <select class="form-control" id="jadwal_sholat" name="jadwal_sholat">
                                    <option value="" selected disabled>===== Pilih Jadwal Sholaat =====</option>
                                    @foreach ($prayerList as $pl)
                                    <option value="{{ $pl->id }}">{{ $pl->sholat }}</option>
                                    @endforeach
                                </select>
                                <div id="jadwal_sholat-error" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="students-container" style="display: none;">
                        <div class="col-md-12">
                            <h5>Daftar Siswa</h5>
                            <table id="students-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="check-all"></th>
                                        <th>Nama Siswa</th>
                                        <th>NISN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Daftar siswa akan dimuat di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="submit" id="btn-save" class="btn btn-primary me-2" disabled>Submit</button>
                    <a href="{{ route('attendance') }}" type="reset" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
<script type="text/javascript">
     $(document).ready(function() {
        $('#kelas').change(function() {
            let kelasId = $(this).val();
            if (kelasId) {
                $('#students-container').hide();
                $('#students-table tbody').html('');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route("student.data") }}',
                    type: 'POST',
                    data: { kelas: kelasId },
                    success: function(response) {
                        if (response.length > 0) {
                            let studentsHtml = '';
                            if ($.fn.DataTable.isDataTable('#students-table')) {
                                $('#students-table').DataTable().destroy();
                            }
                            response.forEach(student => {
                                studentsHtml += `
                                    <tr>
                                        <td><input type="checkbox" name="students[]" value="${student.id}" class="student-checkbox"></td>
                                        <td>${student.nama_lengkap}</td>
                                        <td>${student.nisn}</td>
                                    </tr>`;
                            });
                            $('#students-table tbody').html(studentsHtml);
                            $('#students-container').show();
                            $('#btn-save').prop('disabled', false);

                            $('#students-table').DataTable();

                            if (!$.fn.DataTable.isDataTable('#students-table')) {
                                studentsTable = $('#students-table').DataTable();
                            } else {
                                studentsTable.destroy();
                                studentsTable = $('#students-table').DataTable();
                            }
                        } else {
                            $('#students-table tbody').html('<tr><td colspan="2" class="text-danger">Tidak ada siswa di kelas ini.</td></tr>');
                            $('#students-container').show();
                            $('#btn-save').prop('disabled', true);

                            if ($.fn.DataTable.isDataTable('#students-table')) {
                                $('#students-table').DataTable().destroy();
                            }
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat memuat data siswa.');
                    }
                });
            }
        });

        $('#check-all').click(function() {
            let isChecked = $(this).is(':checked');
            $('.student-checkbox').prop('checked', isChecked);
        });
    });
</script>
@stop
