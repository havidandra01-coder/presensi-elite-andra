<?= $this->extend('siswa/layout') ?>

<?= $this->section('content') ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
    :root {
        --primary-mint: #00a67e;
        --secondary-mint: #d1f7ea;
        --bg-light: #f8fbf9;
        --text-main: #1a332d;
        --glass-white: rgba(255, 255, 255, 0.9);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
    }

    /* Animasi Masuk Smooth */
    .elite-entrance {
        animation: slideInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header Styling */
    .header-box {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 35px;
    }

    .icon-wrapper {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, var(--primary-mint), #008f6d);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(0, 166, 126, 0.2);
        color: white;
        font-size: 24px;
    }

    .badge-elite {
        background-color: var(--secondary-mint);
        color: var(--primary-mint);
        font-size: 11px;
        font-weight: 800;
        padding: 5px 12px;
        border-radius: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
    }

    /* Card Premium */
    .elite-card {
        background: var(--glass-white);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 30px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.04);
        padding: 45px;
        position: relative;
        overflow: hidden;
    }

    .elite-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 5px;
        background: linear-gradient(90deg, var(--primary-mint), var(--secondary-mint));
    }

    /* Form Design */
    .form-group-custom { margin-bottom: 25px; }

    .form-label-elite {
        font-weight: 700;
        font-size: 0.85rem;
        color: #445650;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-control-elite {
        background-color: #f1f5f4 !important;
        border: 2px solid transparent !important;
        border-radius: 15px !important;
        padding: 14px 20px !important;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .form-control-elite:focus {
        background-color: #fff !important;
        border-color: var(--primary-mint) !important;
        box-shadow: 0 10px 20px rgba(0, 166, 126, 0.05) !important;
        transform: translateY(-2px);
    }

    /* Custom File Input */
    .file-drop-zone {
        border: 2px dashed #ccd6d3;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        background: #f8faf9;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-drop-zone:hover {
        border-color: var(--primary-mint);
        background: #f0fffb;
    }

    /* Button Action */
    .btn-submit-elite {
        background: linear-gradient(135deg, var(--primary-mint), #008f6d);
        color: white;
        border: none;
        border-radius: 18px;
        padding: 16px 40px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 10px 25px rgba(0, 166, 126, 0.25);
    }

    .btn-submit-elite:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 15px 30px rgba(0, 166, 126, 0.35);
        color: white;
    }

    .btn-back-elite {
        background: #edf2f0;
        color: #64748b;
        border-radius: 18px;
        padding: 16px 30px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-back-elite:hover { background: #e2e8f0; color: #1e293b; }

</style>

<div class="container py-5 elite-entrance">
    
    <div class="row justify-content-center mb-2">
        <div class="col-lg-10">
            <div class="header-box">
                <div class="icon-wrapper">
                    <i class="ti ti-mail-forward"></i>
                </div>
                <div>
                    <span class="badge-elite">Elite Edition</span>
                    <h1 style="font-weight: 800; color: #0d2a23; margin: 0;">Pengajuan Izin</h1>
                    <p class="text-muted m-0">Silakan lengkapi formulir ketidakhadiran di bawah ini.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="elite-card">
                
                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert shadow-sm border-0 mb-4" style="background: #fff5f5; border-radius: 15px;">
                        <div class="d-flex align-items-center gap-2 text-danger fw-bold mb-2">
                            <i class="ti ti-alert-circle fs-4"></i> Terjadi Kesalahan:
                        </div>
                        <ul class="mb-0 small text-danger">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('siswa/ketidakhadiran/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_siswa" value="<?= session()->get('id_siswa'); ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <label class="form-label-elite"><i class="ti ti-category text-success"></i> JENIS KETERANGAN</label>
                                <select name="keterangan" class="form-select form-control-elite" required>
                                    <option value="" disabled selected>Pilih alasan...</option>
                                    <option value="Izin" <?= old('keterangan') == 'Izin' ? 'selected' : '' ?>>Izin (Ada Keperluan)</option>
                                    <option value="Sakit" <?= old('keterangan') == 'Sakit' ? 'selected' : '' ?>>Sakit (Perlu Istirahat)</option>
                                </select>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-elite"><i class="ti ti-calendar text-success"></i> TANGGAL IZIN</label>
                                <input type="date" name="tanggal" class="form-control form-control-elite" value="<?= old('tanggal') ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <label class="form-label-elite"><i class="ti ti-file-description text-success"></i> ALASAN / DESKRIPSI</label>
                                <textarea name="deskripsi" class="form-control form-control-elite" rows="5" placeholder="Tuliskan detail alasan Anda di sini..." required><?= old('deskripsi') ?></textarea>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label class="form-label-elite"><i class="ti ti-cloud-upload text-success"></i> UNGGAH BUKTI PENDUKUNG</label>
                            <div class="file-drop-zone" onclick="document.getElementById('file-upload').click()">
                                <i class="ti ti-upload text-success fs-1 mb-2"></i>
                                <h6 class="fw-bold mb-1">Klik untuk memilih file</h6>
                                <p class="text-muted small mb-0">Format: JPG, PNG, atau PDF (Maks. 2MB)</p>
                                <input type="file" name="file" id="file-upload" class="d-none" required onchange="updateFileName(this)">
                                <div id="file-name-display" class="mt-2 fw-bold text-primary small"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mt-5 gap-3">
                        <a href="<?= base_url('siswa/ketidakhadiran') ?>" class="btn-back-elite w-100 w-md-auto text-center">
                            <i class="ti ti-arrow-narrow-left me-1"></i> Kembali ke Rekap
                        </a>
                        <button type="submit" class="btn-submit-elite w-100 w-md-auto">
                            Kirim Pengajuan <i class="ti ti-send"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    function updateFileName(input) {
        const display = document.getElementById('file-name-display');
        if (input.files.length > 0) {
            display.innerHTML = `<i class="ti ti-file-check me-1"></i> Terpilih: ${input.files[0].name}`;
        }
    }
</script>

<?= $this->endSection() ?>