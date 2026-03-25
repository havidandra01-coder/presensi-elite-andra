<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel; 
use App\Models\PresensiModel;
use App\Models\KetidakhadiranModel;

class Home extends BaseController
{
    public function index()
    {
        // 1. Set zona waktu agar sesuai dengan Indonesia (WIB)
        date_default_timezone_set('Asia/Jakarta');

        // 2. Inisialisasi Model
        $siswaModel = new SiswaModel();
        $presensiModel = new PresensiModel();
        $ketidakhadiranModel = new KetidakhadiranModel();

        $hari_ini = date('Y-m-d');

        // 3. Ambil data presensi terbaru untuk Leaderboard
        // Menggunakan join ke tabel siswa berdasarkan id_siswa agar nama & foto muncul
        $presensi_terakhir = $presensiModel->select('presensi.*, siswa.nama, siswa.foto')
            ->join('siswa', 'siswa.id = presensi.id_siswa') 
            ->where('tanggal_masuk', $hari_ini)
            ->orderBy('jam_masuk', 'ASC') // Urutkan yang paling pagi (rajin)
            ->limit(5)
            ->get()
            ->getResultArray();

        // 4. Persiapkan Data untuk View
        $data = [
            'title'             => '',
            'total_siswa'       => $siswaModel->countAllResults(),
            'total_hadir'       => $presensiModel->where('tanggal_masuk', $hari_ini)->countAllResults(),
            'total_tidak_hadir' => $ketidakhadiranModel->where('tanggal', $hari_ini)->countAllResults(), 
            'presensi_terakhir' => $presensi_terakhir, // Data ini yang akan dibaca oleh tabel leaderboard
        ];

        // 5. Kirim data ke view
        return view('admin/home', $data);
    }
}