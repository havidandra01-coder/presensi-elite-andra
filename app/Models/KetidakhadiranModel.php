<?php

namespace App\Models;
use CodeIgniter\Model;

class KetidakhadiranModel extends Model {
    protected $table = 'ketidakhadiran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_siswa', 'keterangan', 'tanggal', 'deskripsi', 'file', 'status'];
}