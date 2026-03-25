<?= $this->extend('siswa/layout') ?>

<?= $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root {
        --primary: #10b981;
        --primary-dark: #059669;
        --bg-soft: #f8fafc;
        --text-main: #1e293b;
        --text-light: #64748b;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #effaf3;
        color: var(--text-main);
    }

    /* Header Section */
    .header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .title-icon {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 10px;
        border-radius: 12px;
        display: flex;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .header-wrapper h2 {
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.5px;
    }

    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, var(--primary), #34d399);
    }

    /* Photo Section */
    .photo-container {
        position: relative;
        width: 180px;
        margin: 0 auto 20px;
    }

    .profile-photo {
        width: 180px;
        height: 220px;
        object-fit: cover;
        border-radius: 24px;
        box-shadow: 0 15px 25px -10px rgba(0,0,0,0.15);
        border: 4px solid white;
        transition: transform 0.3s ease;
    }

    .photo-container:hover .profile-photo {
        transform: scale(1.02);
    }

    /* Loading Overlay */
    #loading-overlay {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 24px;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        z-index: 10;
    }

    /* Info List */
    .info-grid {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 16px;
        border-radius: 16px;
        transition: background 0.2s;
    }

    .info-item:hover {
        background: #f1f5f9;
    }

    .info-label {
        width: 180px;
        font-weight: 600;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.9rem;
    }

    .info-value {
        font-weight: 700;
        color: var(--text-main);
    }

    /* Badges & Buttons */
    .custom-badge {
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .bg-active { background: #dcfce7; color: #166534; }
    .bg-location { background: #e0f2fe; color: #0369a1; }

    .btn-action {
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }

    .btn-home {
        background: white;
        color: var(--text-light);
        border: 1px solid #e2e8f0;
    }

    .btn-home:hover {
        background: #f8fafc;
        color: var(--text-main);
    }

    .btn-edit-photo {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
    }

    .btn-edit-photo:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .info-label { width: 140px; }
        .header-wrapper { flex-direction: column; align-items: flex-start; gap: 1rem; }
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="header-wrapper">
        <div class="page-title">
            <div class="title-icon">
                <i data-lucide="user" size="24"></i>
            </div>
            <h2>Profil Siswa</h2>
        </div>
        <a href="<?= base_url('siswa/home') ?>" class="btn-action btn-home">
            <i data-lucide="home" size="18"></i> Kembali ke Home
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="profile-card">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <div class="photo-container">
                            <img id="preview-foto" class="profile-photo" 
                                 src="<?= base_url('profile/' . ($siswa['foto'] ?: 'default.png')) ?>" 
                                 alt="Foto Profil">
                            
                            <div id="loading-overlay">
                                <div class="spinner-border text-primary" role="status"></div>
                                <small class="mt-2 fw-bold text-primary">Mengupload...</small>
                            </div>
                        </div>
                        <h3 class="fw-800 mb-1"><?= $siswa['nama'] ?></h3>
                        <p class="text-muted">NIS: <?= $siswa['nis'] ?></p>
                        
                        <div class="mt-4">
                            <form action="<?= base_url('siswa/update_foto') ?>" method="post" enctype="multipart/form-data" id="form-foto">
                                <?= csrf_field() ?>
                                <input type="file" name="foto" id="input-foto" accept="image/*" style="display: none;" onchange="prosesUpload()">
                                
                                <button type="button" class="btn-action btn-edit-photo" onclick="triggerPilihFile()">
                                    <i data-lucide="camera" size="18"></i> Ganti Foto Profil
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label"><i data-lucide="at-sign" size="18"></i> Username</div>
                                <div class="info-value"><?= $siswa['username'] ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i data-lucide="users" size="18"></i> Jenis Kelamin
                                </div>
                                <div class="info-value">
                                    <?php 
                                        $jk = $siswa['jenis_kelamin'] ?? '';
                                        echo ($jk == 'L') ? 'Laki-laki' : (($jk == 'P') ? 'Perempuan' : '-'); 
                                    ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i data-lucide="map-pin" size="18"></i> Alamat</div>
                                <div class="info-value text-muted"><?= $siswa['alamat'] ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i data-lucide="smartphone" size="18"></i> No. Handphone</div>
                                <div class="info-value"><?= $siswa['no_handphone'] ?: '-' ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i data-lucide="map" size="18"></i> Lokasi Presensi</div>
                                <div class="info-value">
                                    <span class="custom-badge bg-location">Zone <?= $siswa['lokasi_presensi'] ?></span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i data-lucide="check-circle" size="18"></i> Status Akun</div>
                                <div class="info-value">
                                    <span class="custom-badge bg-active">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    function triggerPilihFile() {
        document.getElementById('input-foto').click();
    }

    function prosesUpload() {
        const input = document.getElementById('input-foto');
        if (input.files && input.files[0]) {
            // Tampilkan loading overlay
            document.getElementById('loading-overlay').style.display = 'flex';
            // Submit form secara otomatis
            document.getElementById('form-foto').submit();
        }
    }
</script>

<?= $this->endSection() ?>