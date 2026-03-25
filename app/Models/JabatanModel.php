<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table      = 'jabatan_master';
    protected $primaryKey = 'id';   // BENAR
    protected $allowedFields = ['jabatan'];
}

