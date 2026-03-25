<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PresensiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RekapPresensi extends BaseController
{
    // --- REKAP HARIAN ---
    public function rekap_harian()
    {
        $presensi_model = new PresensiModel();
        $filter_tanggal = $this->request->getGet('filter_tanggal') ?: date('Y-m-d');
        $rekap_harian = $presensi_model->rekap_harian_filter($filter_tanggal);

        if ($this->request->getGet('excel') !== null) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // 1. Setup Logo (Kop Surat)
            $this->applyHeaderLogos($sheet, 'G1');

            // 2. Judul Laporan
            $sheet->mergeCells('B2:F2');
            $sheet->setCellValue('B2', 'LAPORAN PRESENSI HARIAN SISWA');
            $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->mergeCells('B3:F3');
            $sheet->setCellValue('B3', 'Tanggal: ' . date('d F Y', strtotime($filter_tanggal)));
            $sheet->getStyle('B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // 3. Header Tabel (Baris 6)
            $headerRow = 6;
            $headers = ['No', 'Nama Siswa', 'Tanggal', 'Jam Masuk', 'Jam Keluar', 'Total Durasi', 'Status'];
            $sheet->fromArray($headers, NULL, 'A' . $headerRow);

            $this->applyHeaderStyle($sheet, "A$headerRow:G$headerRow");

            // 4. Looping Data
            $row = $headerRow + 1;
            $no = 1;
            foreach ($rekap_harian as $rekap) {
                $masuk = strtotime($rekap['jam_masuk']);
                $keluar = strtotime($rekap['jam_keluar']);
                $durasi = ($rekap['jam_keluar'] != '00:00:00') ? floor(($keluar - $masuk) / 3600) . 'j ' . floor((($keluar - $masuk) % 3600) / 60) . 'm' : '-';
                
                $jam_sekolah = $rekap['jam_masuk_sekolah'] ?? '07:00:00';
                $is_late = $rekap['jam_masuk'] > $jam_sekolah;
                $status = $is_late ? 'Terlambat' : 'Tepat Waktu';

                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $rekap['nama']);
                $sheet->setCellValue('C' . $row, date('d-m-Y', strtotime($rekap['tanggal_masuk'])));
                $sheet->setCellValue('D' . $row, $rekap['jam_masuk']);
                $sheet->setCellValue('E' . $row, $rekap['jam_keluar']);
                $sheet->setCellValue('F' . $row, $durasi);
                $sheet->setCellValue('G' . $row, $status);

                $this->applyBodyStyle($sheet, $row, $is_late, 'G');
                $row++;
            }

            $this->finalizeSheet($sheet, $headerRow, $row - 1, 'G');

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rekap_Harian_' . $filter_tanggal . '.xlsx"');
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }

        return view('admin/rekap_presensi/rekap_harian', [
            'title' => '',
            'tanggal' => $filter_tanggal,
            'rekap_harian' => $rekap_harian
        ]);
    }

    // --- REKAP BULANAN ---
    public function rekap_bulanan()
    {
        $presensi_model = new PresensiModel();
        $filter_bulan = $this->request->getVar('filter_bulan') ?: date('m');
        $filter_tahun = $this->request->getVar('filter_tahun') ?: date('Y');
        $rekap_bulanan = $presensi_model->rekap_bulanan_filter($filter_bulan, $filter_tahun);

        if ($this->request->getVar('excel') !== null) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $this->applyHeaderLogos($sheet, 'G1');

            $sheet->mergeCells('B2:F2');
            $sheet->setCellValue('B2', 'LAPORAN PRESENSI BULANAN SISWA');
            $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->mergeCells('B3:F3');
            $sheet->setCellValue('B3', "Periode: Bulan $filter_bulan Tahun $filter_tahun");
            $sheet->getStyle('B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $headerRow = 6;
            $headers = ['No', 'Nama Siswa', 'Tanggal', 'Jam Masuk', 'Jam Keluar', 'Total Durasi', 'Status'];
            $sheet->fromArray($headers, NULL, 'A' . $headerRow);

            $this->applyHeaderStyle($sheet, "A$headerRow:G$headerRow");

            $row = $headerRow + 1;
            $no = 1;
            foreach ($rekap_bulanan as $rekap) {
                $masuk = strtotime($rekap['tanggal_masuk'] . ' ' . $rekap['jam_masuk']);
                $keluar = strtotime($rekap['tanggal_keluar'] . ' ' . $rekap['jam_keluar']);
                $selisih = $keluar - $masuk;
                $durasi = ($rekap['jam_keluar'] != '00:00:00' && $selisih > 0) ? floor($selisih / 3600) . 'j ' . floor(($selisih % 3600) / 60) . 'm' : '-';

                $jam_sekolah = $rekap['jam_masuk_sekolah'] ?? '07:00:00';
                $is_late = strtotime($rekap['jam_masuk']) > strtotime($jam_sekolah);
                $status = $is_late ? 'Terlambat' : 'Tepat Waktu';

                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $rekap['nama']);
                $sheet->setCellValue('C' . $row, date('d-m-Y', strtotime($rekap['tanggal_masuk'])));
                $sheet->setCellValue('D' . $row, $rekap['jam_masuk']);
                $sheet->setCellValue('E' . $row, $rekap['jam_keluar']);
                $sheet->setCellValue('F' . $row, $durasi);
                $sheet->setCellValue('G' . $row, $status);

                $this->applyBodyStyle($sheet, $row, $is_late, 'G');
                $row++;
            }

            $this->finalizeSheet($sheet, $headerRow, $row - 1, 'G');

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rekap_Bulanan_' . $filter_bulan . '_' . $filter_tahun . '.xlsx"');
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }

        return view('admin/rekap_presensi/rekap_bulanan', [
            'title' => '',
            'bulan' => $filter_bulan,
            'tahun' => $filter_tahun,
            'rekap_bulanan' => $rekap_bulanan,
            'tanggal' => ''
        ]);
    }

    // --- HELPER FUNCTIONS (VERSI FIX) ---

    private function applyHeaderLogos($sheet, $rightCoord) {
        if (file_exists(FCPATH . 'assets/images/logosmk.png')) {
            $draw = new Drawing();
            $draw->setPath(FCPATH . 'assets/images/logosmk.png')->setHeight(65)->setCoordinates('A1')->setWorksheet($sheet);
        }
        if (file_exists(FCPATH . 'assets/images/logo.png')) {
            $draw2 = new Drawing();
            $draw2->setPath(FCPATH . 'assets/images/logo.png')->setHeight(65)->setCoordinates($rightCoord)->setWorksheet($sheet);
        }
    }

    private function applyHeaderStyle($sheet, $range) {
        $sheet->getStyle($range)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10B981']], // Emerald Green
        ]);
        
        // Ambil nomor baris dari range (misal A6:G6 diambil angka 6-nya saja)
        $rowNumber = preg_replace('/[^0-9]/', '', explode(':', $range)[0]);
        $sheet->getRowDimension($rowNumber)->setRowHeight(30);
    }

    private function applyBodyStyle($sheet, $row, $is_late, $lastCol) {
        // PERBAIKAN: Menambahkan $row setelah $lastCol agar menjadi koordinat lengkap (misal: G7)
        $sheet->getStyle("A$row:$lastCol$row")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Di sini tadi kesalahannya: $lastCol saja, seharusnya $lastCol$row
        $sheet->getStyle("C$row:$lastCol$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        if ($is_late) {
            $sheet->getStyle($lastCol . $row)->getFont()->getColor()->setRGB('EF4444');
            $sheet->getStyle($lastCol . $row)->getFont()->setBold(true);
        }
    }

    private function finalizeSheet($sheet, $startRow, $endRow, $lastCol) {
        $sheet->getStyle("A$startRow:$lastCol$endRow")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}