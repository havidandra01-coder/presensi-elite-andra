<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    
    // TAMBAHKAN 'id' ke dalam allowedFields agar bisa diisi manual
    protected $allowedFields    = [
        'id', 
        'id_siswa',
        'username',
        'password',
        'status',
        'role'
    ];

    // TAMBAHKAN baris ini agar model tahu kita akan mengisi ID sendiri
    protected $useAutoIncrement = false;
}