<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root { --primary-green: #10b981; --dark-emerald: #064e3b; --bg-soft: #f0fdf4; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-soft); overflow-x: hidden; }

    /* Header & Filter Section */
    .header-rekap { margin-bottom: 2rem; }
    .filter-card {
        background: white; border-radius: 20px; padding: 20px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        border: 1px solid rgba(16,185,129,0.1);
    }

    /* Form Styling */
    .form-control { border-radius: 12px; padding: 10px 15px; border: 1px solid #e2e8f0; }
    .form-control:focus { border-color: var(--primary-green); box-shadow: 0 0 0 4px rgba(16,185,129,0.1); }

    /* Button Styling */
    .btn-emerald { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;
        border-radius: 12px; padding: 10px 20px; font-weight: 600; border: none; transition: 0.3s;
    }
    .btn-emerald:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(16,185,129,0.3); color: white; }
    
    .btn-excel {
        background: white; color: #15803d; border: 2px solid #15803d;
        border-radius: 12px; padding: 10px 20px; font-weight: 600; transition: 0.3s;
    }
    .btn-excel:hover { background: #15803d; color: white; transform: translateY(-2px); }

    /* Modern Table Styling */
    .table-container { 
        background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); 
        border-radius: 24px; padding: 25px; border: 1px solid white;
    }
    #rekap-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    #rekap-table thead th { border: none; padding: 15px; color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
    #rekap-table tbody tr { background: white; transition: 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    #rekap-table tbody td { padding: 15px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    #rekap-table tbody tr td:first-child { border-left: 1px solid #f1f5f9; border-radius: 15px 0 0 15px; }
    #rekap-table tbody tr td:last-child { border-right: 1px solid #f1f5f9; border-radius: 0 15px 15px 0; }
    #rekap-table tbody tr:hover { transform: scale(1.01); box-shadow: 0 10px 20px rgba(0,0,0,0.05); z-index: 10; }

    /* Status & Badges */
    .badge-ontime { background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.75rem; }
    .text-late { color: #ef4444; font-weight: 600; font-size: 0.85rem; }
    .info-date { background: white; padding: 8px 16px; border-radius: 10px; border-left: 4px solid var(--primary-green); }
</style>

<div class="container-fluid py-5 px-4">
    <div class="header-rekap d-flex justify-content-between align-items-end mb-4" data-aos="fade-down">
        <div>
            <h2 style="font-weight: 800; color: var(--dark-emerald); margin:0;">Rekap Presensi Harian</h2>
            <p class="text-muted mb-3">Pantau kehadiran siswa secara real-time</p>
            <div class="info-date shadow-sm d-inline-block">
                <i data-lucide="calendar" size="18" class="me-2 text-success"></i>
                <strong>Data Tanggal: </strong> 
                <span class="text-success"><?= $tanggal ? date('d F Y', strtotime($tanggal)) : date('d F Y') ?></span>
            </div>
        </div>
        
        <div class="filter-card shadow-sm">
            <form class="row g-2" method="get">
                <div class="col-auto">
                    <input type="date" class="form-control" name="filter_tanggal" value="<?= $tanggal ?? date('Y-m-d') ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-emerald d-flex align-items-center gap-2">
                        <i data-lucide="search" size="18"></i> Tampilkan
                    </button>
                </div>
                <div class="col-auto">
                    <button type="submit" name="excel" class="btn btn-excel d-flex align-items-center gap-2">
                        <i data-lucide="file-spreadsheet" size="18"></i> Export
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-container" data-aos="fade-up" data-aos-delay="200">
        <div class="table-responsive">
            <table id="rekap-table" class="text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-start">Nama Siswa</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Durasi Kerja</th>
                        <th>Status / Keterlambatan</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($rekap_harian)) : ?>
                    <?php $no = 1; foreach ($rekap_harian as $rekap) : ?>
                        <?php   
                        $timestamp_jam_masuk = strtotime($rekap['tanggal_masuk'] . ' ' . $rekap['jam_masuk']);
                        $timestamp_jam_keluar = strtotime($rekap['tanggal_keluar'] . ' ' . $rekap['jam_keluar']);
                        $selisih = $timestamp_jam_keluar - $timestamp_jam_masuk;
                        $jam = ($selisih > 0) ? floor($selisih / 3600) : 0;
                        $menit = ($selisih > 0) ? floor(($selisih % 3600) / 60) : 0;

                        $jam_masuk_real = strtotime($rekap['jam_masuk']);
                        $jam_masuk_sekolah = strtotime($rekap['jam_masuk_sekolah'] ?? '07:00:00');
                        $selisih_terlambat = $jam_masuk_real - $jam_masuk_sekolah;
                        ?>
                        <tr>
                            <td style="font-weight: 800; color: var(--primary-green);"><?= $no++ ?></td>
                            <td class="text-start">
                                <div style="font-weight: 700; color: #1e293b;"><?= $rekap['nama'] ?></div>
                                <small class="text-muted">ID: #<?= rand(1000, 9999) ?></small>
                            </td>
                            <td><span class="text-muted"><?= date('d M Y', strtotime($rekap['tanggal_masuk'])) ?></span></td>
                            <td style="font-weight: 600;"><?= $rekap['jam_masuk'] ?></td>
                            <td style="font-weight: 600;">
                                <?= ($rekap['jam_keluar'] == '00:00:00') ? '<span class="badge bg-light text-dark">-</span>' : $rekap['jam_keluar'] ?>
                            </td>
                            <td>
                                <?php if ($rekap['jam_keluar'] == '00:00:00' || $selisih <= 0) : ?>
                                    <span class="text-muted italic small">Sedang Berlangsung</span>
                                <?php else : ?>
                                    <div class="fw-bold" style="color: var(--dark-emerald)"><?= $jam ?>h <?= $menit ?>m</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($selisih_terlambat <= 0) : ?>
                                    <span class="badge-ontime"><i data-lucide="check-circle" size="14"></i> On Time</span>
                                <?php else : ?>
                                    <?php 
                                        $jam_t = floor($selisih_terlambat / 3600);
                                        $menit_t = floor(($selisih_terlambat % 3600) / 60);
                                        echo "<div class='text-late'><i data-lucide='clock-alert' size='14'></i> Terlambat: {$jam_t}j {$menit_t}m</div>";
                                    ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Data tidak tersedia untuk tanggal ini</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    lucide.createIcons();
    AOS.init({ duration: 800, once: true });
</script>

<?= $this->endSection() ?>