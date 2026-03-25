<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;

class Ketidakhadiran extends BaseController
{
    protected $helpers = ['url', 'form'];

    public function index()
    {
        $ketidakhadiranModel = new KetidakhadiranModel();
        $id_siswa = session()->get('id_siswa');

        $data = [
            'title' => '',
            'ketidakhadiran' => $ketidakhadiranModel->where('id_siswa', $id_siswa)->findAll()
        ];
        return view('siswa/ketidakhadiran', $data);
    }

    public function create()
    {
        $data = ['title' => ''];
        return view('siswa/create_ketidakhadiran', $data);
    }

    public function store()
    {
        // Validasi Input
        if (!$this->validate([
            'keterangan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Silakan pilih keterangan (Izin/Sakit).']
            ],
            'tanggal' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tanggal wajib diisi.']
            ],
            'deskripsi' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Deskripsi wajib diisi.']
            ],
            'file' => [
                'rules'  => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,jpg,png,jpeg]',
                'errors' => [
                    'uploaded' => 'Silakan unggah file bukti.',
                    'max_size' => 'Ukuran file maksimal 10MB.',
                    'ext_in'   => 'Format file harus PDF, JPG, atau PNG.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $ketidakhadiranModel = new KetidakhadiranModel();
        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $file->move('file_ketidakhadiran', $namaFile);

        $ketidakhadiranModel->insert([
            'id_siswa'   => $this->request->getPost('id_siswa'),
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal'    => $this->request->getPost('tanggal'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'file'       => $namaFile,
            'status'     => 'Pending'
        ]);

        // Key 'berhasil' disesuaikan dengan script SweetAlert di View
        return redirect()->to('/siswa/ketidakhadiran')->with('berhasil', 'Pengajuan ketidakhadiran berhasil dikirim.');
    }

    public function edit($id)
    {
        $ketidakhadiranModel = new KetidakhadiranModel();
        $data = [
            'title' => '',
            'ketidakhadiran' => $ketidakhadiranModel->find($id)
        ];
        return view('siswa/edit_ketidakhadiran', $data);
    }

    public function update($id)
    {
        $ketidakhadiranModel = new KetidakhadiranModel();
        $file = $this->request->getFile('file');
        $fileLama = $this->request->getPost('fileLama');

        if ($file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('file_ketidakhadiran', $namaFile);
            
            // Hapus file lama dari folder jika ganti file
            if (file_exists('file_ketidakhadiran/' . $fileLama)) {
                unlink('file_ketidakhadiran/' . $fileLama);
            }
        } else {
            $namaFile = $fileLama;
        }

        $ketidakhadiranModel->update($id, [
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal'    => $this->request->getPost('tanggal'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'file'       => $namaFile
        ]);

        return redirect()->to('/siswa/ketidakhadiran')->with('berhasil', 'Data ketidakhadiran berhasil diperbarui.');
    }

    public function delete($id)
    {
        $ketidakhadiranModel = new KetidakhadiranModel();
        $data = $ketidakhadiranModel->find($id);

        if ($data) {
            // Pastikan kolom file tidak kosong dan filenya benar-benar ada
            if (!empty($data['file']) && is_file('file_ketidakhadiran/' . $data['file'])) {
                unlink('file_ketidakhadiran/' . $data['file']);
            }
            
            $ketidakhadiranModel->delete($id);
            return redirect()->to('/siswa/ketidakhadiran')->with('berhasil', 'Data ketidakhadiran berhasil dihapus.');
        }

        return redirect()->to('/siswa/ketidakhadiran')->with('error', 'Data tidak ditemukan.');
    }
}