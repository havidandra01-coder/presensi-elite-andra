<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';

    protected $allowedFields = [
        'nis',
        'nama',
        'jenis_kelamin',
        'alamat',
        'no_handphone',
        'jabatan',
        'lokasi_presensi',
        'foto'
    ];

    public function detailSiswa($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('siswa');
        $builder->select('siswa.*, users.username, users.status, users.role');
        $builder->join('users', 'users.id_siswa = siswa.id', 'left');
        $builder->where('siswa.id', $id);
        return $builder->get()->getRowArray();
    }


    public function editSiswa($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('siswa');
        $builder->select('siswa.*, users.username, users.password, users.status, users.role');
        $builder->join('users', 'users.id_siswa = siswa.id', 'left');
        $builder->where('siswa.id', $id);
        return $builder->get()->getRowArray();
    }

}





