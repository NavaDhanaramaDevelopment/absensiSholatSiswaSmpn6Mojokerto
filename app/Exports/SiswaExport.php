<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Student::whereNull('deleted_at')->get();
    }

    public function headings(): array
    {
        return [
            'NISN',
            'Nama',
            'Kelas',
            'Jenis Kelamin',
            'Nomor Telepon',
            'Alamat',
        ];
    }

    public function map($siswa): array
    {
        $nama = $siswa->nama_depan . ' ' . $siswa->nama_belakang;

        return [
            $siswa->nisn,
            $nama,
            $siswa->kelas,
            $siswa->jenis_kelamin,
            $siswa->no_telepon,
            $siswa->alamat,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F' . $sheet->getHighestRow())
              ->applyFromArray([
                  'borders' => [
                      'allBorders' => [
                          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Tampilkan semua tepi
                      ],
                  ],
              ]);

        // Style untuk header
        $sheet->getStyle('A1:F1')
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
