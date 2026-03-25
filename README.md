# Dokumentasi Aplikasi Presensi Siswa

Aplikasi manajemen kehadiran siswa berbasis web yang mengutamakan validitas data melalui verifikasi lokasi (GPS) dan verifikasi visual (Selfie). Dibangun menggunakan framework CodeIgniter 4 dengan antarmuka modern yang responsif.

---

## Pembuat Aplikasi
* **Nama:** Andra Rizky Fauzi
* **Peran:** Lead Developer / Programmer

---

## Fitur Utama

1. Presensi Berbasis Lokasi (Geolocation): Menggunakan Formula Haversine untuk menghitung jarak presisi antara posisi siswa dan titik koordinat sekolah yang telah ditentukan.
2. Verifikasi Selfie: Integrasi Webcam.js untuk pengambilan foto secara langsung saat melakukan presensi guna menghindari kecurangan.
3. Laporan Excel Otomatis: Ekspor data kehadiran harian dan bulanan ke format .xlsx menggunakan library PhpSpreadsheet.
4. Peta Interaktif: Visualisasi titik lokasi presensi siswa menggunakan Leaflet.js.
5. Antarmuka Modern: Desain menggunakan konsep Glassmorphism dengan transisi sidebar yang halus.
6. Notifikasi Sistem: Penggunaan SweetAlert2 untuk dialog konfirmasi dan pesan status aplikasi.

---

## Spesifikasi Teknologi

* Bahasa Pemrograman: PHP 8.2.x
* Framework: CodeIgniter 4.6.4
* Database: MySQL / MariaDB
* Frontend: Bootstrap 5, FontAwesome, CSS3 Custom Transitions
* Library Javascript:
    * Webcam.js (Penanganan Kamera)
    * Leaflet.js (Render Peta)
    * SweetAlert2 (Notifikasi UI)

---

## Panduan Instalasi

### 1. Persiapan Lingkungan
Pastikan perangkat Anda telah terinstal server lokal (seperti XAMPP atau Laragon) dengan versi PHP minimal 8.2.

### 2. Persiapan Proyek
Letakkan folder proyek ke dalam direktori server Anda (misalnya htdocs atau www).

### 3. Konfigurasi Database
1. Buat database baru di phpMyAdmin dengan nama: db_presensi.
2. Ubah nama file env di folder root proyek menjadi .env.
3. Sesuaikan pengaturan database di dalam file .env tersebut:

```bash
database.default.hostname = localhost
database.default.database = db_presensi
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi`
```

### 4. Menjalankan Migrasi
Buka terminal atau CMD pada direktori proyek, lalu jalankan perintah berikut untuk membuat tabel secara otomatis:
```bash
php spark migrate
```

### 5. Menjalankan Server
Jalankan perintah berikut untuk mengaktifkan server lokal:
```bash
php spark serve
```

Akses aplikasi melalui browser pada alamat: http://localhost:8080


## Konfigurasi Geolocation dan Radius

Untuk mengatur batasan lokasi presensi, ikuti langkah-langkah berikut:

1. Akses tabel atau menu pengaturan lokasi di dalam aplikasi.
2. Masukkan koordinat Latitude dan Longitude sekolah (dapat diperoleh dari Google Maps).
3. Tentukan nilai Radius dalam satuan meter.
   * Contoh: Jika diisi 50, maka siswa hanya dapat melakukan presensi jika berada dalam radius 50 meter dari titik koordinat sekolah.
4. Sistem akan secara otomatis menolak proses presensi jika posisi perangkat siswa berada di luar radius tersebut.



## Catatan Teknis

* Perubahan Terminologi: Sesuai instruksi pengembangan, seluruh istilah "Pegawai" di dalam sistem telah diubah menjadi "Siswa".
* Izin Perangkat: Aplikasi memerlukan izin akses Kamera dan Lokasi (GPS) dari browser pengguna agar fitur utama dapat berjalan.
* Keamanan Profil: Halaman profil dibatasi hanya untuk pembaruan foto mandiri oleh siswa untuk menjaga integritas data identitas.

---

## Kontribusi
Aplikasi ini dikembangkan oleh Andra Rizky Fauzi untuk kebutuhan sistem informasi sekolah yang transparan dan akuntabel.