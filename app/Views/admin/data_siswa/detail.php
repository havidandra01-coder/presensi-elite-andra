<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root {
        --primary-green: #10b981;
        --dark-emerald: #064e3b;
        --bg-soft: #f0fdf4;
        --white: #ffffff;
        --text-slate: #475569;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-soft);
        color: #1e293b;
    }

    /* Memastikan container memenuhi layar dan konten di tengah secara vertikal/horizontal */
    .content-wrapper-center {
        min-height: 80vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }


    /* Header Styling */
    .header-section {
        margin-bottom: 2rem;
        animation: fadeInDown 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .header-section h2 {
        font-weight: 800;
        color: var(--dark-emerald);
        letter-spacing: -0.02em;
    }

    /* Profile Card Container */
    .profile-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        padding: 40px;
        border: 1px solid rgba(255, 255, 255, 1);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Photo Styling */
    .photo-wrapper {
        position: relative;
        display: inline-block;
        padding: 8px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .profile-photo {
        border-radius: 15px;
        object-fit: cover;
        width: 150px;
        height: 180px;
    }

    /* Detail Table Styling */
    .detail-container {
        width: 100%;
    }

    .info-row {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        width: 200px;
        font-weight: 600;
        color: var(--text-slate);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-value {
        flex: 1;
        font-weight: 700;
        color: #1e293b;
    }

    /* Badges */
    .badge-info {
        background: #f1f5f9;
        color: #475569;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
    }

    .badge-status-active {
        background: #dcfce7;
        color: #15803d;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
    }

    /* Button Back */
    .btn-back {
        background: #ffffff;
        color: var(--text-slate);
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        margin-top: 2rem;
    }

    .btn-back:hover {
        background: #f8fafc;
        transform: translateX(-5px);
        color: var(--dark-emerald);
    }

    /* Animations */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container py-5">
    <div class="header-section text-center text-md-start">
        <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
            <div style="background: var(--primary-green); padding: 10px; border-radius: 12px; color: white;">
                <i data-lucide="user-search" size="24"></i>
            </div>
            <h2>Detail Informasi Siswa</h2>
        </div>
    </div>

    <div class="row justify-content-center justify-content-md-start">
        <div class="col-lg-10">
            <div class="profile-card">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center">
                        <div class="photo-wrapper">
                            <img class="profile-photo" 
                                 src="<?= base_url('profile/' . $siswa['foto']) ?>" 
                                 alt="Foto Profil">
                        </div>
                        <h4 class="fw-bold mb-1"><?= $siswa['nama'] ?></h4>
                        <p class="text-muted small">NIS: <?= $siswa['nis'] ?></p>
                    </div>

                    <div class="col-md-8">
                        <div class="detail-container">
                            <div class="info-row">
                                <div class="info-label"><i data-lucide="user" size="18"></i> Username</div>
                                <div class="info-value"><?= $siswa['username'] ?></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><i data-lucide="users" size="18"></i> Jenis Kelamin</div>
                                <div class="info-value">
                                    <?= $siswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><i data-lucide="map" size="18"></i> Alamat</div>
                                <div class="info-value text-muted"><?= $siswa['alamat'] ?></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><i data-lucide="phone" size="18"></i> No. Handphone</div>
                                <div class="info-value"><?= $siswa['no_handphone'] ?></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><i data-lucide="map-pin" size="18"></i> Lokasi Presensi</div>
                                <div class="info-value">
                                    <span class="badge-info"><?= $siswa['lokasi_presensi'] ?></span>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><i data-lucide="shield-check" size="18"></i> Status</div>
                                <div class="info-value">
                                    <span class="badge-status-active"><?= $siswa['status'] ?></span>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><i data-lucide="fingerprint" size="18"></i> Role Access</div>
                                <div class="info-value text-uppercase" style="letter-spacing: 1px; color: var(--primary-green);">
                                    <?= $siswa['role'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center text-md-start">
                    <a href="<?= base_url('admin/data_siswa') ?>" class="btn-back">
                        <i data-lucide="arrow-left" size="18"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?= $this->endSection() ?>