<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Profil extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        helper(['form', 'url']);
    }

    // Menampilkan profil siswa
    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        
        // Mengambil data siswa dengan join (sesuai fungsi di model Anda)
        $siswa = $this->siswaModel->editSiswa($id_siswa);

        if (!$siswa) {
            return redirect()->to(base_url('login'))->with('error', 'Profil tidak ditemukan.');
        }

        $data = [
            'title' => '', // Menambahkan title agar tidak kosong
            'siswa' => $siswa
        ];

        return view('siswa/profil', $data);
    }

    // Fungsi baru: Update Foto Profil secara langsung (Auto-submit)
    public function update_foto()
    {
        $id_siswa = session()->get('id_siswa');
        $fileFoto = $this->request->getFile('foto');

        // 1. Validasi apakah ada file yang diunggah
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            
            // 2. Ambil data lama untuk menghapus file foto lama (agar storage tidak penuh)
            $siswaLama = $this->siswaModel->find($id_siswa);

            // 3. Olah file foto baru
            $namaFotoBaru = $fileFoto->getRandomName();
            
            // Pindahkan ke folder public/profile
            if ($fileFoto->move('profile', $namaFotoBaru)) {
                
                // 4. Hapus foto lama jika bukan default.png
                if (!empty($siswaLama['foto']) && $siswaLama['foto'] != 'default.png') {
                    $pathLama = 'profile/' . $siswaLama['foto'];
                    if (file_exists($pathLama)) {
                        unlink($pathLama);
                    }
                }

                // 5. Update nama file di database
                $this->siswaModel->update($id_siswa, [
                    'foto' => $namaFotoBaru
                ]);

                session()->setFlashdata('pesan', 'Foto profil berhasil diperbarui!');
            } else {
                session()->setFlashdata('error', 'Gagal memindahkan file foto.');
            }
        } else {
            session()->setFlashdata('error', 'File tidak valid atau tidak ditemukan.');
        }

        return redirect()->to(base_url('siswa/profil'));
    }
}