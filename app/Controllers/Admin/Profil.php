<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Profil extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        helper(['form', 'url']);
    }

    public function index()
    {
        // 1. Ambil ID dari session
        $id_admin = $this->session->get('id_siswa');

        if (!$id_admin) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Ambil data terbaru dari database tabel siswa
        $admin = $this->db->table('siswa')
                          ->where('id', $id_admin)
                          ->get()
                          ->getRowArray();

        if (!$admin) {
            return redirect()->to(base_url('login'))->with('error', 'Data tidak ditemukan.');
        }

        // 3. SINKRONISASI SESSION (Kunci agar Navbar selalu update)
        $this->session->set([
            'nama' => $admin['nama'],
            'foto' => $admin['foto']
        ]);

        $data = [
            'title' => '',
            'admin' => $admin
        ];

        return view('admin/profil', $data);
    }

    public function update_foto()
    {
        $id_admin = $this->session->get('id_siswa');
        $fileFoto = $this->request->getFile('foto');

        // Validasi: Pastikan ada file yang diupload dan valid
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            
            // Ambil data lama untuk menghapus file fisik foto lama
            $adminLama = $this->db->table('siswa')->where('id', $id_admin)->get()->getRowArray();

            // Generate nama file unik
            $namaFotoBaru = $fileFoto->getRandomName();
            
            // Pindahkan file ke folder public/profile
            if ($fileFoto->move('profile', $namaFotoBaru)) {
                
                // Hapus foto lama dari folder jika bukan default.png
                if (!empty($adminLama['foto']) && $adminLama['foto'] != 'default.png') {
                    $pathLama = 'profile/' . $adminLama['foto'];
                    if (file_exists($pathLama)) {
                        unlink($pathLama);
                    }
                }

                // Update nama file foto di Database
                $this->db->table('siswa')->where('id', $id_admin)->update([
                    'foto' => $namaFotoBaru
                ]);

                // Update Session foto agar Navbar langsung berubah tanpa relogin
                $this->session->set('foto', $namaFotoBaru);

                session()->setFlashdata('pesan', 'Foto profil berhasil diperbarui!');
            } else {
                session()->setFlashdata('error', 'Gagal memindahkan file foto.');
            }
        } else {
            session()->setFlashdata('error', 'File tidak valid atau tidak ditemukan.');
        }

        return redirect()->to(base_url('admin/profil'));
    }
}