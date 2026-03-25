<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\PresensiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// Tambahkan library style dan drawing
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RekapPresensi extends BaseController
{
    public function index()
    {
        $presensiModel = new PresensiModel();
        $filter_tanggal = $this->request->getGet('filter_tanggal');

        if ($filter_tanggal) {
            $rekap_presensi = $presensiModel->rekap_presensi_siswa_filter($filter_tanggal);
        } else {
            $rekap_presensi = $presensiModel->rekap_presensi_siswa();
        }

// ... (Bagian atas controller tetap sama)

if (isset($_GET['excel'])) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 1. Menambahkan Logo SMK (Kiri)
    $drawingSMK = new Drawing();
    $drawingSMK->setName('Logo SMK');
    $drawingSMK->setPath(FCPATH . 'assets/images/logosmk.png'); // Path sesuai info Anda
    $drawingSMK->setHeight(70);
    $drawingSMK->setCoordinates('A1');
    $drawingSMK->setOffsetX(10); // Margin kiri
    $drawingSMK->setOffsetY(10); // Margin atas
    $drawingSMK->setWorksheet($sheet);

    // 2. Menambahkan Logo Kelas (Kanan)
    $drawingKelas = new Drawing();
    $drawingKelas->setName('Logo Kelas');
    $drawingKelas->setPath(FCPATH . 'assets/images/logo.png'); // Path sesuai info Anda
    $drawingKelas->setHeight(70);
    $drawingKelas->setCoordinates('F1');
    $drawingKelas->setOffsetX(-10); // Geser sedikit ke kiri agar tidak mepet pinggir
    $drawingKelas->setOffsetY(10);
    $drawingKelas->setWorksheet($sheet);

    // 3. Judul Laporan (Diletakkan di Tengah antara dua logo)
    $sheet->mergeCells('B2:E2');
    $sheet->setCellValue('B2', 'REKAP PRESENSI SISWA');
    $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $sheet->mergeCells('B3:E3');
    $sheet->setCellValue('B3', 'SMK NEGERI 1 ADIWERNA- LAPORAN KEHADIRAN');
    $sheet->getStyle('B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // 4. Styling Header Tabel (Mulai dari Baris 6)
    $headerRow = 6;
    $headers = ['No', 'Tanggal', 'Jam Masuk', 'Jam Keluar', 'Total Jam Kerja', 'Status'];
    $sheet->fromArray($headers, NULL, 'A' . $headerRow);

    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '2C3E50'], // Warna gelap elegan
        ],
    ];

    $sheet->getStyle("A$headerRow:F$headerRow")->applyFromArray($headerStyle);
    $sheet->getRowDimension($headerRow)->setRowHeight(30);

    // 5. Input Data
    $column = $headerRow + 1;
    $no = 1;

    foreach ($rekap_presensi as $rekap) {
        $masuk = strtotime($rekap['jam_masuk']);
        $keluar = strtotime($rekap['jam_keluar']);
        $total_jam = ($rekap['jam_keluar'] != '00:00:00') ? floor(($keluar - $masuk) / 3600) . ' Jam ' . floor((($keluar - $masuk) % 3600) / 60) . ' Menit' : '-';

        $jam_sekolah = $rekap['jam_masuk_lokasi'] ?? '07:00:00';
        $status = ($rekap['jam_masuk'] > $jam_sekolah) ? 'Terlambat' : 'Tepat Waktu';

        $sheet->setCellValue('A' . $column, $no++);
        $sheet->setCellValue('B' . $column, date('d-m-Y', strtotime($rekap['tanggal_masuk'])));
        $sheet->setCellValue('C' . $column, $rekap['jam_masuk']);
        $sheet->setCellValue('D' . $column, $rekap['jam_keluar']);
        $sheet->setCellValue('E' . $column, $total_jam);
        $sheet->setCellValue('F' . $column, $status);

        // Styling baris data (Alignment tengah)
        $sheet->getStyle("A$column:F$column")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Warna merah jika terlambat
        if ($status == 'Terlambat') {
            $sheet->getStyle('F' . $column)->getFont()->getColor()->setRGB('E74C3C');
        }

        $column++;
    }

    // 6. Border & Auto-Size
    $lastRow = $column - 1;
    $sheet->getStyle("A$headerRow:F$lastRow")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    foreach (range('A', 'F') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Rekap_Siswa_' . date('d-m-Y') . '.xlsx"');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}

        $data = [
            'title'          => 'Rekap Presensi',
            'rekap_presensi' => $rekap_presensi,
            'tanggal'        => $filter_tanggal
        ];

        return view('siswa/rekap_presensi', $data);
    }
}