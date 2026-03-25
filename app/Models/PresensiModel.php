<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table            = 'presensi';
    protected $allowedFields    = [
        'id_siswa',
        'tanggal_masuk',
        'jam_masuk',
        'foto_masuk',
        'tanggal_keluar',
        'jam_keluar',
        'foto_keluar',
    ];

    public function rekap_harian()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, siswa.nama', 'lokasi_presensi.jam_masuk as jam_masuk_sekolah');
        $builder->join('siswa', 'siswa.id = presensi.id_siswa');
        $builder->join('lokasi_presensi', 'lokasi_presensi.id = siswa.lokasi_presensi');
        $builder->where('tanggal_masuk', date('Y-m-d'));
        return $builder->get()->getResultArray();

    }

    public function rekap_harian_filter($filter_tanggal)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, siswa.nama', 'lokasi_presensi.jam_masuk as jam_masuk_sekolah');
        $builder->join('siswa', 'siswa.id = presensi.id_siswa');
        $builder->join('lokasi_presensi', 'lokasi_presensi.id = siswa.lokasi_presensi');
        $builder->where('tanggal_masuk', $filter_tanggal);
        return $builder->get()->getResultArray();

    }

    public function rekap_bulanan()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, siswa.nama', 'lokasi_presensi.jam_masuk as jam_masuk_sekolah');
        $builder->join('siswa', 'siswa.id = presensi.id_siswa');
        $builder->join('lokasi_presensi', 'lokasi_presensi.id = siswa.lokasi_presensi');
        $builder->where('MONTH(tanggal_masuk)', date('m'));
        $builder->where('YEAR(tanggal_masuk)', date('Y'));
        return $builder->get()->getResultArray();

    }

    public function rekap_bulanan_filter($filter_bulan, $filter_tahun)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, siswa.nama, lokasi_presensi.jam_masuk');
        $builder->join('siswa', 'siswa.id = presensi.id_siswa');
        $builder->join('lokasi_presensi', 'lokasi_presensi.id = siswa.lokasi_presensi');
        $builder->where('MONTH(tanggal_masuk)', $filter_bulan);
        $builder->where('YEAR(tanggal_masuk)', $filter_tahun);
        
        return $builder->get()->getResultArray();
    }

    // Fungsi Utama
    public function rekap_presensi_siswa() {
        $id_siswa = session()->get('id_siswa');
        return $this->db->table('presensi')
            ->select('presensi.*, siswa.nama, lokasi_presensi.jam_masuk AS jam_masuk_lokasi') // TAMBAHKAN INI
            ->join('siswa', 'siswa.id = presensi.id_siswa')
            ->join('lokasi_presensi', 'lokasi_presensi.id = siswa.lokasi_presensi')
            ->where('presensi.id_siswa', $id_siswa)
            ->get()->getResultArray();
    }

    // Fungsi Filter
    public function rekap_presensi_siswa_filter($filter_tanggal) {
        $id_siswa = session()->get('id_siswa');
        return $this->db->table('presensi')
            ->select('presensi.*, siswa.nama, lokasi_presensi.jam_masuk AS jam_masuk_lokasi') // TAMBAHKAN INI
            ->join('siswa', 'siswa.id = presensi.id_siswa')
            ->join('lokasi_presensi', 'lokasi_presensi.id = siswa.lokasi_presensi')
            ->where('presensi.id_siswa', $id_siswa)
            ->where('presensi.tanggal_masuk', $filter_tanggal)
            ->get()->getResultArray();
    }

}
