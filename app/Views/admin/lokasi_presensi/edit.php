<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root { 
        --primary-green: #10b981; 
        --dark-emerald: #064e3b; 
        --bg-soft: #f0fdf4; 
    }
    
    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background-color: var(--bg-soft); 
        overflow-x: hidden;
    }
    
    /* Animasi Floating untuk Card */
    .main-card { 
        background: white; 
        border-radius: 24px; 
        padding: 40px; 
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); 
        max-width: 900px; 
        margin: 0 auto;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .main-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 40px -10px rgba(16,185,129,0.1);
    }
    
    .form-label { 
        font-weight: 600; 
        color: var(--dark-emerald); 
        font-size: 0.85rem; 
        margin-bottom: 8px; 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        transition: 0.3s;
    }
    
    .form-control, .form-select { 
        border-radius: 12px; 
        padding: 12px; 
        border: 1px solid #e2e8f0; 
        transition: all 0.3s ease; 
    }
    
    /* Efek Focus Micro-scaling */
    .form-control:focus { 
        border-color: var(--primary-green); 
        box-shadow: 0 0 0 4px rgba(16,185,129,0.1); 
        transform: scale(1.01);
    }
    
    /* Tombol Update dengan Efek Shimmer */
    .btn-update { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
        color: white; 
        padding: 14px; 
        border-radius: 12px; 
        font-weight: 700; 
        border: none; 
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .btn-update::after {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: rgba(255,255,255,0.2);
        transform: rotate(45deg);
        transition: 0.5s;
        opacity: 0;
    }

    .btn-update:hover::after {
        left: 120%;
        opacity: 1;
    }
    
    .btn-update:hover { 
        transform: translateY(-2px); 
        filter: brightness(1.1); 
        box-shadow: 0 10px 15px rgba(16,185,129,0.2); 
        color: white;
    }
    
    .section-title { 
        font-size: 0.75rem; 
        text-transform: uppercase; 
        letter-spacing: 0.1em; 
        color: #94a3b8; 
        font-weight: 700; 
        margin: 2rem 0 1rem; 
        display: flex; 
        align-items: center; 
        gap: 10px; 
    }
    
    .section-title::after { 
        content: ""; 
        flex: 1; 
        height: 1px; 
        background: #e2e8f0; 
    }

    /* Hover effect pada row */
    .row div:hover > .form-label {
        color: var(--primary-green);
    }
</style>

<div class="container py-5">
    <div class="text-center mb-5" data-aos="fade-down" data-aos-duration="1000">
        <h2 style="font-weight: 800; color: var(--dark-emerald);">Edit Lokasi</h2>
        <p class="text-muted">Perbarui kordinat atau waktu operasional instansi</p>
    </div>

    <div class="main-card" data-aos="fade-up" data-aos-delay="200">
        <?php $validation = \Config\Services::validation(); ?>
        <form method="post" action="<?= base_url('admin/lokasi_presensi/update/' . $lokasi_presensi['id']) ?>">
            <?= csrf_field(); ?>

            <div class="section-title"><i data-lucide="edit-3" size="14"></i> Identitas Lokasi</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label"><i data-lucide="map"></i> Nama Lokasi</label>
                    <input type="text" name="nama_lokasi" value="<?= old('nama_lokasi', $lokasi_presensi['nama_lokasi']) ?>" class="form-control <?= ($validation->hasError('nama_lokasi')) ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback"><?= $validation->getError('nama_lokasi') ?></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i data-lucide="tag"></i> Tipe Lokasi</label>
                    <input type="text" name="tipe_lokasi" value="<?= old('tipe_lokasi', $lokasi_presensi['tipe_lokasi']) ?>" class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label"><i data-lucide="map-pin"></i> Alamat Lengkap</label>
                    <textarea name="alamat_lokasi" rows="3" class="form-control"><?= old('alamat_lokasi', $lokasi_presensi['alamat_lokasi']) ?></textarea>
                </div>
            </div>

            <div class="section-title"><i data-lucide="navigation" size="14"></i> Koordinat & Radius</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Latitude</label>
                    <input type="text" name="latitude" value="<?= old('latitude', $lokasi_presensi['latitude']) ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Longitude</label>
                    <input type="text" name="longitude" value="<?= old('longitude', $lokasi_presensi['longitude']) ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Radius (Meter)</label>
                    <input type="number" name="radius" value="<?= old('radius', $lokasi_presensi['radius']) ?>" class="form-control">
                </div>
            </div>

            <div class="section-title"><i data-lucide="clock" size="14"></i> Jam Kerja</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Zona Waktu</label>
                    <select name="zona_waktu" class="form-select">
                        <?php $zw = old('zona_waktu', $lokasi_presensi['zona_waktu']); ?>
                        <option value="WIB" <?= $zw == 'WIB' ? 'selected' : '' ?>>WIB</option>
                        <option value="WITA" <?= $zw == 'WITA' ? 'selected' : '' ?>>WITA</option>
                        <option value="WIT" <?= $zw == 'WIT' ? 'selected' : '' ?>>WIT</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" value="<?= old('jam_masuk', $lokasi_presensi['jam_masuk']) ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jam Pulang</label>
                    <input type="time" name="jam_pulang" value="<?= old('jam_pulang', $lokasi_presensi['jam_pulang']) ?>" class="form-control">
                </div>
            </div>

            <div class="mt-5" data-aos="zoom-in" data-aos-delay="400">
                <button type="submit" class="btn btn-update w-100">
                    <i data-lucide="save" size="18"></i> Simpan Perubahan
                </button>
                <a href="<?= base_url('admin/lokasi_presensi') ?>" class="btn btn-link w-100 mt-2 text-muted text-decoration-none small">
                    Batalkan Perubahan
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        easing: 'ease-out-back',
        duration: 800
    });
    lucide.createIcons();
</script>
<?= $this->endSection() ?>