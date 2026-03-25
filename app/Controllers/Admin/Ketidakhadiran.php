<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;

class Ketidakhadiran extends BaseController
{
    public function index()
    {
        $ketidakhadiranModel = new KetidakhadiranModel();
        $data = [
            'title' => '',
            'ketidakhadiran' => $ketidakhadiranModel->findAll()
        ];
        return view('admin/ketidakhadiran', $data);
    }

   public function approve($id)
    {
        $ketidakhadiranModel = new \App\Models\KetidakhadiranModel();
        
        // Pastikan status diubah menjadi 'Approved' (sesuaikan dengan database Anda)
        $ketidakhadiranModel->update($id, [
            'status' => 'Approved'
        ]);

        // Pesan sukses untuk SweetAlert
        session()->setFlashdata('message', 'Pengajuan ketidakhadiran berhasil di approved');
        
        return redirect()->to(base_url('admin/ketidakhadiran'));
    }

public function delete($id)
{
    $db = \Config\Database::connect();
    $ketidakhadiranModel = new \App\Models\KetidakhadiranModel();

    // 1. Matikan pengecekan foreign key
    $db->query("SET FOREIGN_KEY_CHECKS = 0");

    $data = $ketidakhadiranModel->find($id);
    if ($data) {
        $ketidakhadiranModel->delete($id);
        session()->setFlashdata('message', 'Data berhasil dihapus paksa');
    }

    // 2. Hidupkan kembali pengecekan foreign key
    $db->query("SET FOREIGN_KEY_CHECKS = 1");

    return redirect()->to(base_url('admin/ketidakhadiran'));
}
}