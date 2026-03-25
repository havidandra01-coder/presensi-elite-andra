<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LokasiPresensiModel;
use App\Models\SiswaModel;
use App\Models\PresensiModel;

class Home extends BaseController
{
    public function index()
    {
        $lokasi_presensi_model = new LokasiPresensiModel();
        $siswa_model = new SiswaModel();
        $presensi_model = new PresensiModel();
        $id_siswa = session()->get('id_siswa');

        // 1. Ambil data siswa secara lengkap
        $siswa = $siswa_model->where('id', $id_siswa)->first();

        // 2. REFRESH SESSION (Agar Foto & Jabatan Sinkron)
// Bagian ini penting supaya layout.php bisa baca data terbaru
$SiswaModel = new SiswaModel();
session()->set([
    'foto'    => $siswa['foto'],    // Pastikan nama kolom di DB adalah 'foto'
    'jabatan' => $siswa['jabatan'], // Pastikan nama kolom di DB adalah 'jabatan'
]);


        if ($siswa && !empty($siswa['lokasi_presensi'])) {
            $lokasi = $lokasi_presensi_model
                ->where('id', $siswa['lokasi_presensi'])
                ->first();
        } else {
            $lokasi = null;
        }

        $data = [
            'title'                => '',
            'siswa'                => $siswa, // 2. Tambahkan ini agar view bisa baca data profile
            'lokasi_presensi'      => $lokasi,
            'cek_presensi'         => $presensi_model->where('id_siswa', $id_siswa)->where('tanggal_masuk', date('Y-m-d'))->countAllResults(),
            'ambil_presensi_masuk' => $presensi_model->where('id_siswa', $id_siswa)->where('tanggal_masuk', date('Y-m-d'))->first()    
        ];

        return view('siswa/home', $data);
    }

    public function presensi_masuk()
    {
        // Ambil data dari form
        $latitude_sekolah = (float) $this->request->getPost('latitude_sekolah');
        $longitude_sekolah = (float) $this->request->getPost('longitude_sekolah');
        $latitude_siswa = (float) $this->request->getPost('latitude_siswa');
        $longitude_siswa = (float) $this->request->getPost('longitude_siswa');
        $radius = (int) $this->request->getPost('radius');

        // Rumus Hitung Jarak (Haversine Formula)
        $theta = $longitude_sekolah - $longitude_siswa;
        $jarak = sin(deg2rad($latitude_sekolah)) * sin(deg2rad($latitude_siswa)) +  cos(deg2rad($latitude_sekolah)) * cos(deg2rad($latitude_siswa)) * cos(deg2rad($theta));
        $jarak = acos($jarak);
        $jarak = rad2deg($jarak);
        $mil = $jarak * 60 * 1.1515;
        $km = $mil * 1.609344;
        $jarak_meter = floor($km * 1000);

        // Logika Pengecekan Radius (Sesuai Gambar Anda)
        if ($jarak_meter > $radius) {
            // Jika di luar radius, kirim flashdata gagal
            session()->setFlashdata('gagal', 'Presensi gagal, lokasi Anda berada di luar radius kantor');
            return redirect()->to(base_url('siswa/home'));
        } else {
            // Jika di dalam radius, lanjut ke halaman ambil foto selfie
            $data = [
                'title'         => "",
                'id_siswa'      => $this->request->getPost('id_siswa'),
                'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
                'jam_masuk'     => $this->request->getPost('jam_masuk'),
            ];
            
            return view('siswa/ambil_foto_masuk', $data);
        



            // Jika masuk radius, lanjutkan proses simpan data ke database
            // Contoh: $presensiModel->save([...]);
            
            session()->setFlashdata('berhasil', 'Presensi masuk berhasil simpan.');
            return redirect()->to(base_url('siswa/home'));
        }
    }

    public function presensi_masuk_aksi()
    {
        $request = \Config\Services::request();
        
        // Ambil data dari POST
        $id_siswa = $request->getPost('id_siswa');
        $tanggal_masuk = $request->getPost('tanggal_masuk');
        $jam_masuk = $request->getPost('jam_masuk');
        $foto_masuk = $request->getPost('foto_masuk');

        // Decode Base64 Foto
        $foto_masuk = str_replace('data:image/jpeg;base64,', '', $foto_masuk);
        $foto_masuk = str_replace(' ', '+', $foto_masuk); // Tambahan untuk keamanan decode
        $foto_masuk = base64_decode($foto_masuk);

        // Penamaan File
        $nama_foto = $id_siswa . '_' . time() . '.jpg';
        
        // Path: pastikan folder public/uploads sudah dibuat secara manual
        $path = FCPATH . 'uploads/' . $nama_foto;

        // Simpan file ke folder
        file_put_contents($path, $foto_masuk);

        // Simpan data ke Database
        $presensi_model = new PresensiModel();
        $presensi_model->insert([
            'id_siswa'      => $id_siswa, // Sesuai kolom di phpMyAdmin kamu
            'jam_masuk'     => $jam_masuk,
            'tanggal_masuk' => $tanggal_masuk,
            'foto_masuk'    => $nama_foto
        ]);

        session()->setFlashdata('berhasil', 'Presensi masuk berhasil');
        
        // Karena ini request AJAX, return redirect() biasanya tidak mempan di sisi browser, 
        // tapi tetap bagus untuk fallback. Redirect dilakukan oleh JavaScript di View kamu.
        return "success"; 
    }

  public function presensi_keluar($id)
{
    // Ambil data dari form (koordinat & radius)
    $latitude_sekolah = (float) $this->request->getPost('latitude_sekolah');
    $longitude_sekolah = (float) $this->request->getPost('longitude_sekolah');
    $latitude_siswa = (float) $this->request->getPost('latitude_siswa');
    $longitude_siswa = (float) $this->request->getPost('longitude_siswa');
    $radius = (int) $this->request->getPost('radius');

    // Rumus Haversine
    $theta = $longitude_sekolah - $longitude_siswa;
    $jarak = sin(deg2rad($latitude_sekolah)) * sin(deg2rad($latitude_siswa)) +  cos(deg2rad($latitude_sekolah)) * cos(deg2rad($latitude_siswa)) * cos(deg2rad($theta));
    $jarak = acos($jarak);
    $jarak = rad2deg($jarak);
    $mil = $jarak * 60 * 1.1515;
    $km = $mil * 1.609344;
    $jarak_meter = floor($km * 1000);
    
    if ($jarak_meter > $radius) {
        session()->setFlashdata('gagal', 'Lokasi Anda di luar radius sekolah');
        return redirect()->to(base_url('siswa/home'));
    } else {
        $data = [
            'title'          => "",
            'id_presensi'    => $id,
            'id_siswa'       => session()->get('id_siswa'),
            'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
            'jam_keluar'     => $this->request->getPost('jam_keluar'),
        ];
        return view('siswa/ambil_foto_keluar', $data);
    }
}

public function presensi_keluar_aksi($id_presensi)
{
    $id_siswa = session()->get('id_siswa');
    $foto_keluar    = $this->request->getPost('foto_keluar');
    $tanggal_keluar = $this->request->getPost('tanggal_keluar');
    $jam_keluar     = $this->request->getPost('jam_keluar');

    // Decode Base64
    $foto_keluar    = str_replace('data:image/jpeg;base64,', '', $foto_keluar);
    $foto_keluar    = str_replace(' ', '+', $foto_keluar);
    $data_foto      = base64_decode($foto_keluar);

    // Penamaan file (Sudah diperbaiki dari $nama_foto ke $nama_file)
    $nama_file = $id_siswa . '_' . time() . '.jpg';
    $path = FCPATH . 'uploads/' . $nama_file;

    // Simpan ke folder public/uploads
    if (!is_dir(FCPATH . 'uploads')) {
        mkdir(FCPATH . 'uploads', 0777, true);
    }
    file_put_contents($path, $data_foto);

    // Update Database
    $presensiModel = new \App\Models\PresensiModel(); 
    $presensiModel->update($id_presensi, [
        'tanggal_keluar' => $tanggal_keluar,
        'jam_keluar'     => $jam_keluar,
        'foto_keluar'    => $nama_file
    ]);

    return "success";
}
}