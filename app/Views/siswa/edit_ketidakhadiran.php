<?= $this->extend('siswa/layout') ?>

<?= $this->section('content') ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
    :root {
        --primary-mint: #00a67e;
        --secondary-mint: #d1f7ea;
        --bg-body: #f4fbf9;
        --text-dark: #1a332d;
        --soft-gray: #8e9fa7;
    }

    body {
        background-color: var(--bg-body);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Animasi Masuk */
    .animate-up {
        animation: slideUp 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header Section */
    .header-box {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 35px;
    }

    .icon-wrapper {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, var(--primary-mint), #008f6d);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(0, 166, 126, 0.2);
        color: white;
        font-size: 24px;
    }

    .badge-elite {
        background: var(--secondary-mint);
        color: var(--primary-mint);
        font-weight: 800;
        font-size: 10px;
        padding: 4px 12px;
        border-radius: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Elite Card Styling */
    .elite-card {
        background: white;
        border-radius: 28px;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .elite-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 6px;
        background: linear-gradient(90deg, var(--primary-mint), var(--secondary-mint));
    }

    /* Form Elements */
    .form-label-elite {
        font-weight: 700;
        font-size: 0.85rem;
        color: #445650;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control-elite {
        background-color: #f8fafb !important;
        border: 2px solid transparent !important;
        border-radius: 15px !important;
        padding: 12px 18px !important;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control-elite:focus {
        background-color: #fff !important;
        border-color: var(--primary-mint) !important;
        box-shadow: 0 8px 15px rgba(0, 166, 126, 0.05) !important;
    }

    /* File Section Styling */
    .current-file-box {
        background: #f1f5f9;
        padding: 12px 18px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        border: 1px dashed #cbd5e1;
    }

    /* Button Actions */
    .btn-save-elite {
        background: linear-gradient(135deg, var(--primary-mint), #008f6d);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 14px 30px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 20px rgba(0, 166, 126, 0.2);
    }

    .btn-save-elite:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(0, 166, 126, 0.3);
        color: white;
    }

    .btn-cancel-elite {
        background: #edf2f0;
        color: #64748b;
        border-radius: 15px;
        padding: 14px 25px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-cancel-elite:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
</style>

<div class="container py-5 animate-up">
    
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="header-box">
                <div class="icon-wrapper">
                    <i class="ti ti-edit-circle"></i>
                </div>
                <div>
                    <span class="badge-elite">Elite Edition</span>
                    <h1 style="font-weight: 800; color: #0d2a23; margin: 0; font-size: 1.75rem;">Edit Pengajuan</h1>
                    <p class="text-muted m-0 small">Perbarui data ketidakhadiran Anda di sini.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="elite-card">
                
                <form action="<?= base_url('siswa/ketidakhadiran/update/' . $ketidakhadiran['id']) ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label-elite"><i class="ti ti-calendar-event text-success"></i> TANGGAL IZIN</label>
                                <input type="date" name="tanggal" class="form-control form-control-elite" value="<?= $ketidakhadiran['tanggal'] ?>" required />
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label-elite"><i class="ti ti-category text-success"></i> JENIS KETERANGAN</label>
                                <select name="keterangan" class="form-select form-control-elite" required>
                                    <option value="Sakit" <?= $ketidakhadiran['keterangan'] == 'Sakit' ? 'selected' : '' ?>>Sakit (Perlu Istirahat)</option>
                                    <option value="Izin" <?= $ketidakhadiran['keterangan'] == 'Izin' ? 'selected' : '' ?>>Izin (Ada Keperluan)</option>
                                    <option value="Dispen" <?= $ketidakhadiran['keterangan'] == 'Dispen' ? 'selected' : '' ?>>Dispen (Kegiatan Luar)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label-elite"><i class="ti ti-notes text-success"></i> DESKRIPSI / ALASAN</label>
                                <textarea name="deskripsi" class="form-control form-control-elite" rows="5" placeholder="Tuliskan alasan perubahan..." required><?= $ketidakhadiran['deskripsi'] ?></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label-elite"><i class="ti ti-file-upload text-success"></i> UPDATE FILE BUKTI</label>
                            <input type="file" name="file" class="form-control form-control-elite" />
                            
                            <div class="current-file-box">
                                <i class="ti ti-file-description fs-4 text-primary"></i>
                                <div>
                                    <div style="font-size: 11px; font-weight: 700; color: var(--soft-gray); text-transform: uppercase;">File Saat Ini</div>
                                    <div style="font-size: 13px; font-weight: 600; color: var(--text-dark);"><?= $ketidakhadiran['file'] ?></div>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2" style="font-size: 11px;">*Kosongkan jika Anda tidak ingin mengganti file bukti.</small>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mt-5 gap-3">
                        <a href="<?= base_url('siswa/ketidakhadiran') ?>" class="btn-cancel-elite w-100 w-md-auto text-center">
                            <i class="ti ti-arrow-left me-1"></i> Batal & Kembali
                        </a>
                        <button type="submit" class="btn-save-elite w-100 w-md-auto justify-content-center">
                            Simpan Perubahan <i class="ti ti-device-floppy"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>