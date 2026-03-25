<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $session;
    protected $db;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load Service
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();

        // OTOMATISASI: Sinkronisasi data Foto & Nama ke Session
        if ($this->session->get('id_siswa')) {
            $user = $this->db->table('siswa')
                             ->where('id', $this->session->get('id_siswa'))
                             ->get()
                             ->getRowArray();
            
            if ($user) {
                // Update session agar selalu fresh tanpa harus buka menu profil
                $this->session->set([
                    'nama' => $user['nama'],
                    'foto' => $user['foto']
                ]);
            }
        }
    }
}