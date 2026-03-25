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

    /* Header Styling */
    .header-section {
        margin-bottom: 2.5rem;
        animation: fadeInDown 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .header-section h2 {
        font-weight: 800;
        color: var(--dark-emerald);
        letter-spacing: -0.02em;
    }

    .badge-elite {
        background: #dcfce7;
        color: #15803d;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Glassmorphism Card */
    .main-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        padding: 40px;
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        max-width: 950px;
        margin: 0 auto;
    }

    /* Section Divider */
    .form-section-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-slate);
        font-weight: 700;
        margin: 2rem 0 1.2rem 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    /* Form Controls */
    .form-label {
        font-weight: 600;
        color: var(--dark-emerald);
        font-size: 0.85rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    /* Submit Button Gradient */
    .btn-submit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.3);
        filter: brightness(1.1);
        color: white;
    }

    /* Animations */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
</style>

<?php $validation = \Config\Services::validation(); ?>

<div class="container-fluid py-5 px-4">
    <div class="header-section text-center">
        <div class="d-inline-flex align-items-center gap-3 mb-2">
            <div style="background: var(--primary-green); padding: 12px; border-radius: 16px; color: white;">
                <i data-lucide="user-plus" size="28"></i>
            </div>
            <div class="text-start">
                <div class="badge-elite">Elite Edition</div>
                <h2 class="mb-0">Tambah Data Siswa</h2>
            </div>
        </div>
        <p class="text-muted">Lengkapi formulir di bawah untuk mendaftarkan siswa baru</p>
    </div>

    <div class="main-card">
        <form method="post" action="<?= base_url('admin/data_siswa/store') ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="form-section-title">
                <i data-lucide="info" size="14"></i> Informasi Identitas
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label"><i data-lucide="user" size="16"></i> Nama Lengkap</label>
                    <input type="text" name="nama" value="<?= old('nama') ?>"
                        class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" placeholder="Contoh: Budi Santoso">
                    <div class="invalid-feedback"><?= $validation->getError('nama') ?></div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i data-lucide="venn-diagram" size="16"></i> Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : '' ?>">
                        <option value="" disabled selected>— Pilih Jenis Kelamin —</option>
                        <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                    <div class="invalid-feedback"><?= $validation->getError('jenis_kelamin') ?></div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i data-lucide="phone" size="16"></i> No. Handphone</label>
                    <input type="text" name="no_handphone" value="<?= old('no_handphone') ?>"
                        class="form-control <?= ($validation->hasError('no_handphone')) ? 'is-invalid' : '' ?>" placeholder="08xxxxxxx">
                    <div class="invalid-feedback"><?= $validation->getError('no_handphone') ?></div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i data-lucide="briefcase" size="16"></i> Jabatan</label>
                    <select name="jabatan" class="form-select <?= ($validation->hasError('jabatan')) ? 'is-invalid' : '' ?>">
                        <option value="">— Pilih Jabatan —</option>
                        <?php foreach ($jabatan as $jab) : ?>
                            <option value="<?= $jab['jabatan'] ?>" <?= old('jabatan') == $jab['jabatan'] ? 'selected' : '' ?>>
                                <?= $jab['jabatan'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label"><i data-lucide="map-pin" size="16"></i> Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" 
                        placeholder="Masukkan alamat domisili..."><?= old('alamat') ?></textarea>
                    <div class="invalid-feedback"><?= $validation->getError('alamat') ?></div>
                </div>
            </div>

            <div class="form-section-title">
                <i data-lucide="lock" size="14"></i> Keamanan & Hak Akses
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label"><i data-lucide="map" size="16"></i> Lokasi Presensi</label>
                    <select name="lokasi_presensi" class="form-select <?= ($validation->hasError('lokasi_presensi')) ? 'is-invalid' : '' ?>">
                        <option value="">— Pilih Lokasi —</option>
                        <?php foreach ($lokasi_presensi as $lok) : ?>
                            <option value="<?= $lok['id'] ?>" <?= old('lokasi_presensi') == $lok['id'] ? 'selected' : '' ?>>
                                <?= $lok['nama_lokasi'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i data-lucide="fingerprint" size="16"></i> Role</label>
                    <select name="role" class="form-select <?= ($validation->hasError('role')) ? 'is-invalid' : '' ?>">
                        <option value="">— Pilih Role —</option>
                        <option value="Admin" <?= old('role') == 'Admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="Siswa" <?= old('role') == 'Siswa' ? 'selected' : '' ?>>Siswa</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label"><i data-lucide="at-sign" size="16"></i> Username</label>
                    <input type="text" name="username" value="<?= old('username') ?>"
                        class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" placeholder="Username">
                </div>

                <div class="col-md-4">
                    <label class="form-label"><i data-lucide="key" size="16"></i> Password</label>
                    <input type="password" name="password" 
                        class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" placeholder="••••••••">
                </div>

                <div class="col-md-4">
                    <label class="form-label"><i data-lucide="check-circle" size="16"></i> Konfirmasi</label>
                    <input type="password" name="konfirmasi_password" 
                        class="form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>" placeholder="••••••••">
                </div>

                <div class="col-12">
                    <label class="form-label"><i data-lucide="image" size="16"></i> Unggah Foto Profil</label>
                    <div class="p-3 border rounded-3 bg-light">
                        <input type="file" name="foto" class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>">
                        <small class="text-muted mt-2 d-block">Format: JPG, PNG, JPEG. Maksimal ukuran file: 10MB.</small>
                    </div>
                    <div class="invalid-feedback d-block"><?= $validation->getError('foto') ?></div>
                </div>
            </div>

            <div class="mt-5 d-flex flex-column gap-2">
                <button type="submit" class="btn btn-submit w-100">
                    <i data-lucide="save" size="20" class="me-2"></i> Daftarkan Siswa Sekarang
                </button>
                <a href="<?= base_url('admin/data_siswa') ?>" class="btn btn-link text-muted text-decoration-none">
                    Batal dan Kembali
                </a>
            </div>

        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?= $this->endSection() ?>