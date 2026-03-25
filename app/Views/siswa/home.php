<?= $this->extend('siswa/layout') ?>

<?php
// Set Timezone
if ($lokasi_presensi['zona_waktu'] == 'WIB') date_default_timezone_set('Asia/Jakarta');
elseif ($lokasi_presensi['zona_waktu'] == 'WITA') date_default_timezone_set('Asia/Makassar');
elseif ($lokasi_presensi['zona_waktu'] == 'WIT') date_default_timezone_set('Asia/Jayapura');

// Logika Format Tanggal Indonesia
$formatter = new IntlDateFormatter(
    'id_ID', 
    IntlDateFormatter::FULL, 
    IntlDateFormatter::NONE
);
// Mengatur pola agar menjadi "Hari, Tanggal Bulan Tahun"
$formatter->setPattern('EEEE, dd MMMM yyyy'); 
$tanggal_indonesia = $formatter->format(new DateTime());
?>

<?= $this->section('content') ?>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root { --neon-green: #4ade80; --deep-green: #1a2e15; --glass: rgba(255, 255, 255, 0.8); }
    body { background: #f4f7f4; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
    
    /* Background Decoration */
    .bg-glow {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
        background: radial-gradient(circle at 80% 20%, rgba(74, 222, 128, 0.1) 0%, transparent 40%),
                    radial-gradient(circle at 10% 80%, rgba(74, 222, 128, 0.05) 0%, transparent 40%);
    }

    /* Welcome Hero - Update Point 1: Interactive & Text Color */
    .hero-banner {
        background: var(--deep-green); color: white; border-radius: 35px;
        padding: 40px; position: relative; overflow: hidden; margin-bottom: 30px;
        box-shadow: 0 20px 40px rgba(26, 46, 21, 0.2);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(74, 222, 128, 0.1);
    }
    .hero-banner:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 30px 60px rgba(26, 46, 21, 0.3);
    }
    .hero-banner h1 {
        background: linear-gradient(to right, #ffffff, var(--neon-green));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800 !important;
    }
    .hero-banner::after {
        content: ""; position: absolute; top: -20%; right: -10%; width: 300px; height: 300px;
        background: var(--neon-green); filter: blur(100px); opacity: 0.2;
        transition: 0.5s;
    }
    .hero-banner:hover::after { opacity: 0.4; transform: scale(1.2); }

    /* Glass Cards */
    .glass-card {
        background: var(--glass); backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.5); border-radius: 30px;
        padding: 25px; height: 100%; transition: 0.3s;
    }
    .glass-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); }

    /* Modern Clock - Update Point 2: Uniform Size */
    .time-display { 
        font-family: 'Space Grotesk', sans-serif; 
        font-size: 3.5rem; 
        font-weight: 700; 
        color: var(--deep-green); 
        line-height: 1; 
        display: flex;
        justify-content: center;
        align-items: baseline;
        gap: 5px;
    }
    .time-unit { color: var(--deep-green); }
    .time-sec { color: var(--neon-green); font-size: 3.5rem; } /* Ukuran disamakan */

    /* Buttons */
    .btn-elite {
        height: 55px; border-radius: 18px; font-weight: 700; border: none; width: 100%;
        display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s;
    }
    .btn-masuk { background: var(--neon-green); color: var(--deep-green); box-shadow: 0 10px 20px rgba(74, 222, 128, 0.3); }
    .btn-masuk:hover:not(:disabled) { transform: scale(1.02); box-shadow: 0 15px 25px rgba(74, 222, 128, 0.5); }
    .btn-keluar { background: #ff5e5e; color: white; }
    .btn-elite:disabled { opacity: 0.5; cursor: not-allowed; filter: grayscale(1); }

    /* Map - Update Point 3: Address Header */
    .map-container { 
        border-radius: 35px; overflow: hidden; 
        border: 1px solid rgba(0,0,0,0.05); 
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        background: white;
    }
    .map-header {
        padding: 20px 25px;
        background: white;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #f0f0f0;
    }
    .map-header i { color: var(--neon-green); }
    .map-header span { font-weight: 700; color: var(--deep-green); text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem; }
    
    #map { height: 400px; width: 100%; }

    .stat-box {
        background: white; border-radius: 20px; padding: 15px; display: flex; align-items: center; gap: 15px;
        margin-bottom: 15px; border: 1px solid rgba(0,0,0,0.05);
    }
    .stat-icon { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: rgba(74, 222, 128, 0.1); color: var(--neon-green); }
</style>

<div class="bg-glow"></div>

<div class="container-fluid py-4">
    <div class="row" data-aos="fade-down">
        <div class="col-12">
            <div class="hero-banner">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <span class="badge bg-success mb-2 px-3" style="background-color: rgba(74, 222, 128, 0.2) !important; color: var(--neon-green) !important; border: 1px solid var(--neon-green);">Student Presence Elite</span>
                        <h1 class="fw-bold">Selamat Pagi <?= explode(' ', session()->get('nama'))[0] ?>!</h1>
                        <p class="opacity-75 mb-0">Jangan lupa untuk melakukan presensi tepat waktu hari ini.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="bg-white bg-opacity-10 p-3 rounded-4 d-inline-block text-start" style="backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                            <small class="d-block opacity-50 text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 1px;">Lokasi Anda</small>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <i data-lucide="map-pin" size="14" class="text-success"></i> 
                                <small class="fw-medium"><?= $lokasi_presensi['alamat_lokasi'] ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
            <div class="stat-box">
                <div class="stat-icon"><i data-lucide="calendar-check"></i></div>
                <div><h6 class="mb-0 fw-bold">Presensi</h6><small class="text-muted">Tercatat Bulan Ini</small></div>
            </div>
            <div class="stat-box">
                <div class="stat-icon" style="color:#f59e0b; background:rgba(245,158,11,0.1)"><i data-lucide="clock"></i></div>
                <div><h6 class="mb-0 fw-bold">08:00 AM</h6><small class="text-muted">Batas Waktu Masuk</small></div>
            </div>
            <div class="stat-box">
                <div class="stat-icon" style="color:#3b82f6; background:rgba(59,130,246,0.1)"><i data-lucide="shield-check"></i></div>
                <div><h6 class="mb-0 fw-bold">Secure Mode</h6><small class="text-muted">GPS & Foto Aktif</small></div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="glass-card text-center d-flex flex-column justify-content-center">
                <p class="text-uppercase fw-bold text-muted small mb-2" style="letter-spacing: 2px;">Waktu Real-time</p>
                <div class="time-display">
                    <span id="jam" class="time-unit">00</span>
                    <span style="opacity: 0.3;">:</span>
                    <span id="menit" class="time-unit">00</span>
                    <span style="opacity: 0.3;">:</span>
                    <span id="detik" class="time-sec">00</span>
                </div>
                <div class="mt-3 fw-bold opacity-75">
                    <i data-lucide="calendar" class="me-2" size="18"></i> <?= $tanggal_indonesia ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-left" data-aos-delay="300">
            <div class="glass-card d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-bold mb-2">Aksi Presensi</h5>
                    <p class="small text-muted mb-4">Pastikan berada dalam radius <?= $lokasi_presensi['radius'] ?>m.</p>
                </div>

                <div id="jarak-info" class="mb-3 d-none">
                    <div class="p-2 rounded-3 text-center" style="background: rgba(255, 94, 94, 0.1); border: 1px dashed #ff5e5e;">
                        <span class="text-danger fw-bold small">
                            <i data-lucide="map-pin-off" class="me-1"></i> LUAR JANGKAUAN: <span id="text-jarak">0</span>m
                        </span>
                    </div>
                </div>

                <div class="d-grid gap-3">
                    <?php if ($cek_presensi < 1) : ?>
                        <form method="POST" action="<?= base_url('siswa/presensi_masuk') ?>">
                            <input type="hidden" name="latitude_sekolah" value="<?= $lokasi_presensi['latitude'] ?>">
                            <input type="hidden" name="longitude_sekolah" value="<?= $lokasi_presensi['longitude'] ?>">
                            <input type="hidden" name="radius" value="<?= $lokasi_presensi['radius'] ?>">
                            <input type="hidden" name="latitude_siswa" class="lat_siswa">
                            <input type="hidden" name="longitude_siswa" class="long_siswa">
                            <input type="hidden" name="id_siswa" value="<?= session()->get('id_siswa') ?>">
                            <input type="hidden" name="tanggal_masuk" value="<?= date('Y-m-d') ?>">
                            <input type="hidden" name="jam_masuk" value="<?= date('H:i:s') ?>">
                            
                            <button type="submit" class="btn-elite btn-masuk btn-absen">
                                <i data-lucide="scan-face"></i> ABSEN MASUK
                            </button>
                        </form>
                    <?php else : ?>
                        <div class="p-3 rounded-4 text-center" style="background: rgba(74, 222, 128, 0.1); border: 1px dashed var(--neon-green);">
                            <span class="text-success fw-bold"><i data-lucide="check-circle" class="me-2"></i>Sesi Masuk Berhasil</span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($ambil_presensi_masuk)) : ?>
                        <?php if ($ambil_presensi_masuk['jam_keluar'] == '00:00:00' || is_null($ambil_presensi_masuk['jam_keluar'])) : ?>
                            <form method="POST" action="<?= base_url('siswa/presensi_keluar/' . $ambil_presensi_masuk['id']) ?>">
                                <input type="hidden" name="latitude_sekolah" value="<?= $lokasi_presensi['latitude'] ?>">
                                <input type="hidden" name="longitude_sekolah" value="<?= $lokasi_presensi['longitude'] ?>">
                                <input type="hidden" name="radius" value="<?= $lokasi_presensi['radius'] ?>">
                                <input type="hidden" name="latitude_siswa" class="lat_siswa">
                                <input type="hidden" name="longitude_siswa" class="long_siswa">
                                <input type="hidden" name="tanggal_keluar" value="<?= date('Y-m-d') ?>">
                                <input type="hidden" name="jam_keluar" value="<?= date('H:i:s') ?>">
                                <button type="submit" class="btn-elite btn-keluar btn-absen">
                                    <i data-lucide="log-out"></i> ABSEN PULANG
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row" data-aos="fade-up">
        <div class="col-12">
            <div class="map-container">
                <div class="map-header">
                    <i data-lucide="map-pinned" size="20"></i>
                    <span>Alamat Lokasi Presensi</span>
                </div>
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    lucide.createIcons();
    AOS.init({ duration: 800, once: true });

    function updateClock() {
        const now = new Date();
        document.getElementById('jam').innerText = now.getHours().toString().padStart(2, '0');
        document.getElementById('menit').innerText = now.getMinutes().toString().padStart(2, '0');
        document.getElementById('detik').innerText = now.getSeconds().toString().padStart(2, '0');
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Map Setup
    var latSekolah = <?= $lokasi_presensi['latitude'] ?>;
    var longSekolah = <?= $lokasi_presensi['longitude'] ?>;
    var radius = <?= $lokasi_presensi['radius'] ?>;

    var map = L.map('map', { zoomControl: false }).setView([latSekolah, longSekolah], 16);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png').addTo(map);

    L.circle([latSekolah, longSekolah], { color: '#4ade80', weight: 2, fillOpacity: 0.1, radius: radius }).addTo(map);
    L.marker([latSekolah, longSekolah]).addTo(map).bindPopup("Titik Sekolah");

    var markerSiswa;
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                var lat = pos.coords.latitude;
                var lng = pos.coords.longitude;
                
                document.querySelectorAll('.lat_siswa').forEach(el => el.value = lat);
                document.querySelectorAll('.long_siswa').forEach(el => el.value = lng);

                if (markerSiswa) map.removeLayer(markerSiswa);
                markerSiswa = L.circleMarker([lat, lng], { radius: 8, color: 'white', weight: 3, fillColor: '#3b82f6', fillOpacity: 1 }).addTo(map);
                
                var group = new L.featureGroup([L.marker([latSekolah, longSekolah]), markerSiswa]);
                map.fitBounds(group.getBounds().pad(0.5));

                // Logika Validasi Jarak
                var siswaPos = L.latLng(lat, lng);
                var sekolahPos = L.latLng(latSekolah, longSekolah);
                var jarakMeter = Math.round(siswaPos.distanceTo(sekolahPos));

                var infoBox = document.getElementById('jarak-info');
                var textJarak = document.getElementById('text-jarak');
                var btnAbsen = document.querySelectorAll('.btn-absen');

                if (jarakMeter > radius) {
                    // Jika di luar radius
                    infoBox.classList.remove('d-none');
                    textJarak.innerText = jarakMeter;
                    btnAbsen.forEach(btn => btn.disabled = true);
                } else {
                    // Jika di dalam radius
                    infoBox.classList.add('d-none');
                    btnAbsen.forEach(btn => btn.disabled = false);
                }
            });
        }
    }
    window.onload = getLocation;
</script>

<?= $this->endSection() ?>