<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\LokasiPresensiModel;
use App\Models\JabatanModel;

class DataSiswa extends BaseController
{

    public function index()
    {
        $siswaModel = new SiswaModel();

        return view('admin/data_siswa/data_siswa', [
            'title' => '',
            'siswa' => $siswaModel->findAll()
        ]);
    }

    public function detail($id)
    {
        $siswaModel = new SiswaModel();

        return view('admin/data_siswa/detail', [
            'title' => '',
            'siswa' => $siswaModel->detailSiswa($id)
        ]);
    }

    public function create()
    {
        return view('admin/data_siswa/create', [
            'title' => '',
            'lokasi_presensi' => (new LokasiPresensiModel())->findAll(),
            'jabatan' => (new JabatanModel())->findAll(),
            'validation' => \Config\Services::validation()
        ]);
    }

    private function generateNIS()
    {
        $siswaModel = new SiswaModel();
        $last = $siswaModel->select('nis')->orderBy('id', 'DESC')->first();

        $lastNis = $last ? $last['nis'] : '23.0000';
        $number = (int) substr($lastNis, 3);
        $number++;

        return '23.' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_handphone' => 'required',
            'jabatan' => 'required',
            'lokasi_presensi' => 'required',
            'foto' => 'uploaded[foto]|max_size[foto,10240]|mime_in[foto,image/png,image/jpeg]',
            'username' => 'required',
            'password' => 'required',
            'konfirmasi_password' => 'required|matches[password]',
            'role' => 'required',
        ];

        $messages = [
            'nama' => ['required' => 'Nama wajib diisi!'],
            'jenis_kelamin' => ['required' => 'Jenis kelamin wajib dipilih!'],
            'alamat' => ['required' => 'Alamat wajib diisi!'],
            'no_handphone' => ['required' => 'Nomor handphone wajib diisi!'],
            'jabatan' => ['required' => 'Jabatan wajib dipilih!'],
            'lokasi_presensi' => ['required' => 'Lokasi presensi wajib dipilih!'],
            'foto' => [
                'uploaded'  => 'Foto wajib diunggah!',
                'max_size'  => 'Ukuran foto maksimal 10 MB!',
                'mime_in'   => 'Format foto harus PNG atau JPEG!'
            ],
            'username' => ['required' => 'Username wajib diisi!'],
            'password' => ['required' => 'Password wajib diisi!'],
            'konfirmasi_password' => [
                'required' => 'Konfirmasi password wajib diisi!',
                'matches'  => 'Konfirmasi password harus sama dengan password!'
            ],
            'role' => ['required' => 'Role wajib dipilih!'],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput();
        }

        $siswaModel = new SiswaModel();
        $userModel  = new UserModel();

        $nisBaru = $this->generateNIS();

        $foto = $this->request->getFile('foto');

        if ($foto->getError() == 4) {
            $nama_foto = ''; 
        } else {
            $nama_foto = $foto->getRandomName();
            $foto->move('profile', $nama_foto);
        }

        // 1. Simpan data ke tabel siswa
        $siswaModel->insert([
            'nis' => $nisBaru,
            'nama' => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat' => $this->request->getPost('alamat'),
            'no_handphone' => $this->request->getPost('no_handphone'),
            'jabatan' => $this->request->getPost('jabatan'),
            'lokasi_presensi' => $this->request->getPost('lokasi_presensi'),
            'foto' => $nama_foto
        ]);

        // 2. Ambil ID yang baru saja dibuat di tabel siswa
        $id_siswa = $siswaModel->insertID();

        // 3. Simpan ke tabel users (Memaksa 'id' dan 'id_siswa' SAMA)
        $userModel->insert([
            'id'        => $id_siswa, // Ini kunci perbaikannya
            'id_siswa'  => $id_siswa,
            'username'  => $this->request->getPost('username'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status'    => 'Aktif',
            'role'      => $this->request->getPost('role'),
        ]);

        session()->setFlashdata('berhasil', 'Data siswa berhasil ditambahkan');

        return redirect()->to(base_url('admin/data_siswa'));
    }

    public function edit($id)
    {
        return view('admin/data_siswa/edit', [
            'title' => '',
            'siswa' => (new SiswaModel())->editSiswa($id),
            'lokasi_presensi' => (new LokasiPresensiModel())->findAll(),
            'jabatan' => (new JabatanModel())->findAll(),
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        $rules = [
            'nama' => ['rules'  => 'required'],
            'jenis_kelamin' => ['rules'  => 'required'],
            'alamat' => ['rules'  => 'required'],
            'no_handphone' => ['rules'  => 'required'],
            'jabatan' => ['rules'  => 'required'],
            'lokasi_presensi' => ['rules'  => 'required'],
            'username' => ['rules'  => 'required'],
            'role' => ['rules'  => 'required'],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $siswaModel = new SiswaModel();
        $userModel  = new UserModel();
        $foto = $this->request->getFile('foto');
        if ($foto->getError() == 4) {
            $nama_foto = $this->request->getPost('foto_lama'); 
        } else {
            $nama_foto = $foto->getRandomName();
            $foto->move('profile', $nama_foto);
        }

        $siswaModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat' => $this->request->getPost('alamat'),
            'no_handphone' => $this->request->getPost('no_handphone'),
            'jabatan' => $this->request->getPost('jabatan'),
            'lokasi_presensi' => $this->request->getPost('lokasi_presensi'),
            'foto' => $nama_foto
        ]);

        $userLama = $userModel->where('id_siswa', $id)->first();
        if ($this->request->getPost('password') == '') {
            $password = $userLama['password']; 
        } else {
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->where('id_siswa', $id)->set([
            'username' => $this->request->getPost('username'),
            'password' => $password,
            'status' => $this->request->getPost('status'),
            'role' => $this->request->getPost('role'),
        ])->update();

        session()->setFlashdata('berhasil', 'Data siswa berhasil diupdate');

        return redirect()->to(base_url('admin/data_siswa'));
    }

    public function delete($id)
    {
        $siswaModel = new SiswaModel();
        $userModel  = new UserModel();

        $siswaModel->delete($id);
        $userModel->where('id_siswa', $id)->delete();

        session()->setFlashdata('berhasil', 'Data siswa berhasil dihapus');

        return redirect()->to(base_url('admin/data_siswa'));
    }
}