<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root { --primary-green: #10b981; --dark-emerald: #064e3b; --bg-soft: #f0fdf4; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-soft); overflow-x: hidden; }

    /* Header Section */
    .header-rekap { margin-bottom: 2rem; }
    .filter-card {
        background: white; border-radius: 20px; padding: 15px 20px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        border: 1px solid rgba(16,185,129,0.1);
        display: inline-block;
    }

    /* Input & Select Styling - Menyamakan Tinggi (48px) */
    .form-select, .form-control { 
        height: 48px; 
        border-radius: 12px; 
        padding: 0 15px; 
        border: 1px solid #e2e8f0; 
        transition: 0.3s; 
        cursor: pointer;
        min-width: 140px;
        font-size: 0.9rem;
    }
    .form-select:focus, .form-control:focus { 
        border-color: var(--primary-green); 
        box-shadow: 0 0 0 4px rgba(16,185,129,0.1); 
        outline: none;
    }

    /* Button Styling - Tinggi Setara 48px */
    .btn-emerald { 
        height: 48px;
        background: #10b981; color: white;
        border-radius: 12px; padding: 0 24px; font-weight: 600; border: none; 
        display: inline-flex; align-items: center; justify-content: center; transition: 0.3s;
        font-size: 0.95rem;
    }
    .btn-emerald:hover { background: #059669; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(16,185,129,0.3); color: white; }
    
    .btn-excel {
        height: 48px;
        background: white; color: #15803d; border: 1.5px solid #15803d;
        border-radius: 12px; padding: 0 20px; font-weight: 600;
        display: inline-flex; align-items: center; justify-content: center; transition: 0.3s;
        font-size: 0.95rem;
    }
    .btn-excel:hover { background: #f0fdf4; transform: translateY(-2px); }

    /* Modern Table Styling */
    .table-container { 
        background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); 
        border-radius: 24px; padding: 25px; border: 1px solid white;
    }
    #rekap-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    #rekap-table thead th { border: none; padding: 15px; color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
    #rekap-table tbody tr { background: white; transition: 0.3s; }
    #rekap-table tbody td { padding: 15px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    #rekap-table tbody tr td:first-child { border-left: 1px solid #f1f5f9; border-radius: 15px 0 0 15px; }
    #rekap-table tbody tr td:last-child { border-right: 1px solid #f1f5f9; border-radius: 0 15px 15px 0; }
    #rekap-table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(16,185,129,0.1); }

    /* Info Badge & Text */
    .info-period { background: white; padding: 10px 20px; border-radius: 12px; border-left: 5px solid var(--primary-green); display: inline-flex; align-items: center; gap: 10px; }
    .badge-ontime { background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.75rem; }
    .text-late { color: #ef4444; font-weight: 600; font-size: 0.85rem; }
</style>

<div class="container-fluid py-5 px-4">
    <div class="header-rekap d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
        <div>
            <h2 style="font-weight: 800; color: var(--dark-emerald); margin:0;">Rekap Presensi Bulanan</h2>
            <p class="text-muted mb-0">Laporan performa kehadiran per periode</p>
        </div>

        <div class="filter-card shadow-sm">
            <form class="d-flex align-items-center gap-2" method="get">
                <div>
                    <select name="filter_bulan" class="form-select">
                        <option value="">— Pilih Bulan</option>
                        <?php 
                        $months = [
                            "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April",
                            "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus",
                            "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"
                        ];
                        foreach ($months as $m_val => $m_name) : ?>
                            <option value="<?= $m_val ?>" <?= $bulan == $m_val ? 'selected' : '' ?>><?= $m_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <select name="filter_tahun" class="form-select" style="min-width: 100px;">
                        <option value="2026" <?= $tahun == '2026' ? 'selected' : '' ?>>2026</option>
                        <option value="2027" <?= $tahun == '2027' ? 'selected' : '' ?>>2027</option>
                        <option value="2028" <?= $tahun == '2028' ? 'selected' : '' ?>>2028</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-emerald">
                    <i data-lucide="refresh-cw" size="20" class="me-2"></i> Tampilkan
                </button>
                <button type="submit" name="excel" class="btn btn-excel">
                    <i data-lucide="download" size="20" class="me-2"></i> Excel
                </button>
            </form>
        </div>
    </div>

    <div class="mb-4" data-aos="fade-right" data-aos-delay="100">
        <div class="info-period shadow-sm">
            <i data-lucide="calendar-days" class="text-success"></i>
            <span class="text-muted small fw-bold">PERIODE LAPORAN:</span>
            <strong class="text-dark"><?= $bulan ? $months[$bulan] . ' ' . $tahun : date('F Y') ?></strong>
        </div>
    </div>

    <div class="table-container shadow-sm" data-aos="fade-up" data-aos-delay="200">
        <div class="table-responsive">
            <table id="rekap-table" class="text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-start">Nama Siswa</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Total Durasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($rekap_bulanan)) : ?>
                    <?php $no = 1; foreach ($rekap_bulanan as $rekap) : ?>
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
                                <small class="text-muted">Siswa Aktif</small>
                            </td>
                            <td><span class="text-muted small"><?= date('d M Y', strtotime($rekap['tanggal_masuk'])) ?></span></td>
                            <td style="font-weight: 600; color: #334155;"><?= $rekap['jam_masuk'] ?></td>
                            <td style="font-weight: 600; color: #334155;">
                                <?= ($rekap['jam_keluar'] == '00:00:00') ? '<span class="text-secondary">-</span>' : $rekap['jam_keluar'] ?>
                            </td>
                            <td>
                                <?php if ($rekap['jam_keluar'] == '00:00:00' || $selisih <= 0) : ?>
                                    <span class="text-muted italic small">Belum Checkout</span>
                                <?php else : ?>
                                    <div class="fw-bold" style="color: var(--dark-emerald)"><?= $jam ?>j <?= $menit ?>m</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($selisih_terlambat <= 0) : ?>
                                    <span class="badge-ontime"><i data-lucide="check" size="14" class="me-1"></i> On Time</span>
                                <?php else : ?>
                                    <?php 
                                        $jam_t = floor($selisih_terlambat / 3600);
                                        $menit_t = floor(($selisih_terlambat % 3600) / 60);
                                        echo "<div class='text-late'><i data-lucide='alert-circle' size='14' class='me-1'></i> {$jam_t}j {$menit_t}m</div>";
                                    ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i data-lucide="folder-open" size="48" class="mb-3 opacity-20"></i>
                                <p>Data tidak ditemukan untuk periode ini</p>
                            </div>
                        </td>
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