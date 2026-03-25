<?= $this->extend('siswa/layout') ?>

<?= $this->section('content') ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    /* Custom Styling sesuai Gambar */
    :root {
        --primary-mint: #00a67e;
        --bg-light: #f4fbf9;
        --text-dark: #1a332d;
        --soft-gray: #8e9fa7;
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-dark);
    }

    .page-title {
        color: #0d4436;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 2px;
    }

    .badge-elite {
        background-color: #d1f7ea;
        color: var(--primary-mint);
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Card Styling */
    .custom-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: transform 0.3s ease;
    }

    /* Button Styling */
    .btn-mint {
        background-color: var(--primary-mint);
        color: white;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-mint:hover {
        background-color: #008f6d;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 166, 126, 0.3);
    }

    /* Table Styling */
    .table thead th {
        background: transparent;
        color: var(--soft-gray);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        border: none;
        padding: 20px;
    }

    .table tbody tr {
        background: white;
        border-radius: 15px;
        transition: all 0.3s ease;
        border-bottom: 8px solid var(--bg-light); /* Jarak antar baris */
    }

    .table tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .table td {
        padding: 20px;
        vertical-align: middle;
        border: none;
    }

    .row-number {
        color: var(--primary-mint);
        font-weight: 700;
        font-size: 1.1rem;
    }

    /* Status Badge */
    .status-pill {
        padding: 6px 16px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        border: 1px solid #eee;
    }

    .input-custom {
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        padding: 10px 15px;
    }

    /* Animations */
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out both;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid py-4 fade-in-up">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-success d-flex align-items-center justify-content-center rounded-3 me-3" style="width: 45px; height: 45px; background-color: var(--primary-mint) !important;">
            <i class="bi bi-people-fill text-white fs-4"></i>
        </div>
        <div>
            <h1 class="page-title">Rekap Presensi</h1>
            <span class="text-muted">Presence System</span> <span class="badge-elite ms-1">Elite Edition</span>
        </div>
    </div>

    <div class="card custom-card mb-4">
        <div class="card-body p-4">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted">FILTER TANGGAL</label>
                    <input type="date" name="filter_tanggal" class="form-control input-custom" value="<?= isset($_GET['filter_tanggal']) ? $_GET['filter_tanggal'] : '' ?>">
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-mint">
                        <i class="bi bi-filter-right me-2"></i> Filter
                    </button>
                    <button type="submit" name="excel" class="btn btn-light ms-2" style="border-radius:12px; padding: 10px 20px;">
                        <i class="bi bi-file-earmark-excel text-success me-1"></i> Export
                    </button>
                    <a href="<?= base_url('siswa/rekap_presensi') ?>" class="btn btn-link text-decoration-none text-muted ms-2">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th width="80">NO</th>
                    <th>TANGGAL</th>
                    <th>WAKTU MASUK/KELUAR</th>
                    <th>DURASI KERJA</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rekap_presensi)) : ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data presensi.</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; foreach ($rekap_presensi as $rekap) : ?>
                        <tr class="fade-in-up" style="animation-delay: <?= $no * 0.1 ?>s">
                            <td class="row-number text-center"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold"><?= date('d M Y', strtotime($rekap['tanggal_masuk'])) ?></div>
                                <small class="text-muted">Hari Sekolah</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-dark border me-2" style="border-radius: 8px;"><?= $rekap['jam_masuk'] ?></span>
                                    <i class="bi bi-arrow-right text-muted me-2"></i>
                                    <?php if ($rekap['jam_keluar'] == '00:00:00' || empty($rekap['jam_keluar'])) : ?>
                                        <span class="text-danger fw-bold small">Belum Absen</span>
                                    <?php else : ?>
                                        <span class="badge bg-light text-dark border" style="border-radius: 8px;"><?= $rekap['jam_keluar'] ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <i class="bi bi-clock-history me-1 text-primary"></i>
                                <?php 
                                if ($rekap['jam_keluar'] != '00:00:00' && !empty($rekap['jam_keluar'])) {
                                    $masuk = strtotime($rekap['jam_masuk']);
                                    $keluar = strtotime($rekap['jam_keluar']);
                                    $selisih = $keluar - $masuk;
                                    echo "<strong>" . floor($selisih / 3600) . "</strong> Jam " . floor(($selisih % 3600) / 60) . " Menit";
                                } else {
                                    echo '<span class="text-muted">-</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                $jam_sekolah = $rekap['jam_masuk_lokasi'] ?? '07:00:00'; 
                                if ($rekap['jam_masuk'] > $jam_sekolah) : ?>
                                    <span class="status-pill" style="background-color: #fff5f5; color: #e53e3e; border-color: #feb2b2;">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i> Terlambat
                                    </span>
                                <?php else : ?>
                                    <span class="status-pill" style="background-color: #f0fff4; color: #38a169; border-color: #9ae6b4;">
                                        <i class="bi bi-check-circle-fill me-1"></i> Tepat Waktu
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>