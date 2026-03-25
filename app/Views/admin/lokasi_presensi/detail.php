<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    :root { 
        --primary-green: #10b981; 
        --dark-emerald: #064e3b; 
        --bg-soft: #f8fafc; 
        --base-mint: #f0fdf4;
    }

    body {
        background-color: var(--base-mint) !important;
    }

    
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-soft); }

    /* Card Wrappers */
    .info-card { 
        background: white; 
        border-radius: 24px; 
        padding: 35px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.03); 
        border: 1px solid rgba(0,0,0,0.02);
        height: 100%;
        animation: fadeInLeft 0.8s ease;
    }

    .map-card { 
        background: white;
        border-radius: 24px; 
        overflow: hidden; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
        border: 4px solid white;
        animation: fadeInRight 0.8s ease;
        display: flex;
        flex-direction: column;
        height: 100%; /* Menyamakan tinggi dengan info-card */
    }

    /* Map Address Header */
    .map-header-info {
        padding: 15px 20px;
        background: #f0fdf4;
        border-bottom: 1px solid #d1fae5;
    }

    #map { 
        flex-grow: 1; /* Peta mengambil sisa ruang yang tersedia */
        width: 100%; 
        z-index: 1; 
        min-height: 400px;
    }
    
    /* Typography & Items */
    .data-item { 
        display: flex; 
        justify-content: space-between; 
        padding: 15px 0; 
        border-bottom: 1px dashed #e2e8f0; 
    }
    
    .data-label { color: #64748b; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; }
    .data-value { color: var(--dark-emerald); font-weight: 700; text-align: right; }
    
    .badge-radius { 
        background: #ecfdf5; 
        color: #059669; 
        padding: 6px 14px; 
        border-radius: 20px; 
        font-size: 0.8rem;
        font-weight: 700;
        border: 1px solid #d1fae5;
    }

    .btn-back {
        background: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: 0.3s;
        color: var(--dark-emerald);
    }
    .btn-back:hover { transform: translateX(-5px); background: var(--primary-green); color: white; }

    @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes fadeInRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
</style>

<div class="container-fluid py-4 px-4">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="<?= base_url('admin/lokasi_presensi') ?>" class="btn-back">
            <i data-lucide="chevron-left" size="24"></i>
        </a>
        <div>
            <h3 style="font-weight: 800; color: var(--dark-emerald); margin:0;">Detail Lokasi</h3>
            <p class="text-muted small mb-0">Informasi lengkap titik presensi pegawai</p>
        </div>
    </div>

    <div class="row g-4 d-flex align-items-stretch">
        <div class="col-lg-5">
            <div class="info-card">
                <div class="text-center mb-4">
                    <div style="background: #f0fdf4; width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: var(--primary-green);">
                        <i data-lucide="map-pin" size="32"></i>
                    </div>
                    <h4 class="mb-1" style="font-weight: 800; color: var(--dark-emerald);"><?= $lokasi_presensi['nama_lokasi'] ?></h4>
                    <span class="badge-radius text-uppercase small"><?= $lokasi_presensi['tipe_lokasi'] ?></span>
                </div>

                <div class="data-list mt-2">
                    <div class="data-item">
                        <span class="data-label"><i data-lucide="navigation-2" size="16"></i> Koordinat</span>
                        <span class="data-value"><?= $lokasi_presensi['latitude'] ?>, <br> <?= $lokasi_presensi['longitude'] ?></span>
                    </div>
                    <div class="data-item">
                        <span class="data-label"><i data-lucide="maximize" size="16"></i> Radius</span>
                        <span class="data-value"><span class="badge-radius"><?= $lokasi_presensi['radius'] ?> Meter</span></span>
                    </div>
                    <div class="data-item">
                        <span class="data-label"><i data-lucide="globe" size="16"></i> Zona Waktu</span>
                        <span class="data-value"><?= $lokasi_presensi['zona_waktu'] ?></span>
                    </div>
                    <div class="data-item">
                        <span class="data-label"><i data-lucide="clock" size="16"></i> Jam Kerja</span>
                        <span class="data-value" style="color: #059669;"><?= $lokasi_presensi['jam_masuk'] ?> - <?= $lokasi_presensi['jam_pulang'] ?></span>
                    </div>
                    <div class="data-item" style="border-bottom: none;">
                        <span class="data-label"><i data-lucide="map" size="16"></i> Alamat</span>
                    </div>
                    <p class="text-muted small mt-1" style="line-height: 1.6;"><?= $lokasi_presensi['alamat_lokasi'] ?></p>
                </div>
                
                <div class="row g-2 mt-3">
                    <div class="col-12">
                        <a href="<?= base_url('admin/lokasi_presensi/edit/'.$lokasi_presensi['id']) ?>" class="btn btn-success w-100 py-3 rounded-4 fw-bold shadow-sm" style="background: var(--primary-green); border: none;">
                           <i data-lucide="edit-3" size="18" class="me-1"></i> Edit Data Lokasi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="map-card">
                <div class="map-header-info">
                    <div class="d-flex align-items-center gap-2">
                        <i data-lucide="info" size="18" class="text-success"></i>
                        <span class="small fw-bold text-success text-uppercase" style="letter-spacing: 0.5px;">Alamat Lokasi:</span>
                    </div>
                    <div class="mt-1 ps-4">
                        <span class="text-dark fw-bold"><?= $lokasi_presensi['alamat_lokasi'] ?></span>
                    </div>
                </div>
                
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Inisialisasi Ikon Lucide
    lucide.createIcons();

    // Data dari Database
    var lat = <?= $lokasi_presensi['latitude'] ?>;
    var lng = <?= $lokasi_presensi['longitude'] ?>;
    var rad = <?= $lokasi_presensi['radius'] ?>;
    var nama = "<?= $lokasi_presensi['nama_lokasi'] ?>";

    // Setup Map
    var map = L.map('map').setView([lat, lng], 17);

    // Tambahkan Layer Peta
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Tambahkan Marker
    var marker = L.marker([lat, lng]).addTo(map)
        .bindPopup('<b>' + nama + '</b><br>Titik Pusat Presensi')
        .openPopup();

    // Tambahkan Lingkaran Radius
    var circle = L.circle([lat, lng], {
        color: '#10b981',      // Warna garis luar
        fillColor: '#10b981',   // Warna isi
        fillOpacity: 0.2,       // Transparansi isi
        radius: rad             // Radius dalam meter
    }).addTo(map);

    // Fix bug leaflet agar merender ukuran dengan benar dalam container fleksibel
    setTimeout(function() {
        map.invalidateSize();
    }, 500);
</script>
<?= $this->endSection() ?>