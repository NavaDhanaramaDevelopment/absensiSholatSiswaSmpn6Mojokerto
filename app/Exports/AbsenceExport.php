<?php

namespace App\Exports;

use App\Models\Absence;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class AbsenceExport implements  FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $startDate;
    protected $endDate;
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Absence::select('s.nisn',  DB::raw("CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap"), 't_absences.check_in', 't_absences.is_late', 't_absences.is_alpha',  'jps.sholat', 's.no_telepon')
                        ->join('m_students as s', 's.id', '=', 't_absences.student_id')
                        ->join('m_prayer_schedules as jps', 'jps.id', '=', 't_absences.prayer_schedule_id')
                        ->whereBetween('check_in', [$this->startDate, $this->endDate])
                        ->get();
    }

    public function headings(): array
    {
        return [
            'NISN',
            'Nama Lengkap',
            'Check In',
            'Is Late',
            'Is Alpha',
            'Sholat',
            'No Telepon',
        ];
    }

    public function map($siswa): array
    {
        $nama = $siswa->nama_depan . ' ' . $siswa->nama_belakang;

        return [
            $siswa->nisn,
            $siswa->nama_lengkap,
            $siswa->check_in,
            $siswa->is_late == 1 ? "Terlambat" : "Tepat Waktu",
            $siswa->is_alpha == 1 ? "Tidak Masuk" : "Masuk",
            $siswa->sholat,
            $siswa->no_telepon,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G' . $sheet->getHighestRow())
              ->applyFromArray([
                  'borders' => [
                      'allBorders' => [
                          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Tampilkan semua tepi
                      ],
                  ],
              ]);

        // Style untuk header
        $sheet->getStyle('A1:G1')
              ->applyFromArray([
                  'font' => [
                      'bold' => true, 
                  ],
                  'alignment' => [
                      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Pusatkan teks horizontal
                  ],
                  'fill' => [
                      'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                      'startColor' => [
                          'argb' => '00FF00', // Warna latar belakang lime (AA = alpha, RR = red, GG = green, BB = blue)
                      ],
                  ],
              ]);

        return [];
    }
}
