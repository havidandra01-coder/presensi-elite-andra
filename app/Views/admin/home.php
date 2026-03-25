<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

    :root {
        --base-mint: #f0fdf4;
        --elite-green: #14532d;
        --accent-glow: #22c55e;
        --glass-white: rgba(255, 255, 255, 0.85);
        --text-main: #1e293b;
        --text-light: #64748b;
    }

    body {
        background-color: var(--base-mint) !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
    }

    .dashboard-container {
        padding: 25px;
        animation: fadeIn 0.8s ease;
    }

    /* --- Header Typography --- */
    .elite-header {
        background: white;
        border-radius: 25px;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(20, 83, 45, 0.05);
        border: 1px solid rgba(20, 83, 45, 0.08);
    }

    .header-title h2 {
        font-weight: 800;
        letter-spacing: -1.2px;
        color: var(--text-main);
        line-height: 1.1;
    }

    .header-title p {
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-size: 10px !important;
        font-weight: 800;
        color: var(--text-light);
    }

    .header-logo {
        height: 60px;
        width: auto;
        object-fit: contain;
    }

    /* --- Stats Grid Typography --- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .stats-grid { grid-template-columns: 1fr; } }

    .elite-card {
        background: var(--glass-white);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 24px;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .elite-card:hover {
        transform: translateY(-8px);
        background: #ffffff;
        box-shadow: 0 20px 25px -5px rgba(20, 83, 45, 0.1);
    }

    .stat-label { 
        display: block; 
        color: var(--text-light); 
        font-size: 10px; 
        font-weight: 800; 
        text-transform: uppercase; 
        letter-spacing: 1.2px;
        margin-bottom: 4px;
    }
    
    .stat-value { 
        display: block; 
        color: var(--text-main); 
        font-size: 30px; 
        font-weight: 800; 
        letter-spacing: -1px;
        line-height: 1;
        text-shadow: 0.5px 0.5px 0px rgba(0,0,0,0.05);
    }

    .icon-circle {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: white;
        flex-shrink: 0;
    }

    .bg-total { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
    .bg-hadir { background: linear-gradient(135deg, #22c55e, #15803d); }
    .bg-alpa  { background: linear-gradient(135deg, #ef4444, #b91c1c); }
    .bg-izin  { background: linear-gradient(135deg, #f59e0b, #b45309); }

    /* --- Feature Box & Leaderboard --- */
    .feature-box {
        background: white;
        border-radius: 30px;
        padding: 30px;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.04);
    }

    .feature-box h5 {
        font-weight: 800;
        letter-spacing: -0.8px;
        color: var(--text-main);
    }

    .attendance-circle {
        width: 150px;
        height: 150px;
        margin: 20px auto;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: radial-gradient(closest-side, white 82%, transparent 0 100%),
                    conic-gradient(var(--accent-glow) <?= ($total_siswa > 0) ? ($total_hadir/$total_siswa)*100 : 0 ?>%, #f1f5f9 0);
        box-shadow: inset 0 0 15px rgba(0,0,0,0.02);
    }

    .circle-value { font-size: 32px; font-weight: 800; color: var(--elite-green); letter-spacing: -1px; }

    .table thead th {
        font-weight: 800;
        font-size: 10px;
        color: var(--text-light) !important;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        border-bottom: 2px solid #f8fafc;
    }

    .student-name {
        font-weight: 700;
        color: var(--text-main);
        font-size: 15px;
        letter-spacing: -0.3px;
    }

    .rank-badge {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: 800;
        font-size: 14px;
    }
    .rank-1 { background: #fef3c7; color: #92400e; border: 1.5px solid #f59e0b; }
    .rank-other { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="dashboard-container">
    
    <div class="elite-header">
        <div class="d-flex align-items-center gap-3">
            <img src="<?= base_url('assets/images/logosmk.png') ?>" alt="Logo SMK" class="header-logo">
            <div class="header-title" style="border-left: 2px solid #f1f5f9; padding-left: 20px;">
                <h2 class="m-0">Dashboard Admin</h2>
                <p class="text-muted m-0 fw-bold">Presence System <span style="color: var(--accent-glow); font-weight: 900;">Elite</span></p>
            </div>
        </div>
        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Kelas" class="header-logo d-none d-md-block">
    </div>

    <div class="stats-grid">
        <a href="<?= base_url('admin/data_siswa') ?>" class="elite-card">
            <div class="icon-circle bg-total"><i class="ti ti-users"></i></div>
            <div>
                <span class="stat-label">Total Siswa</span>
                <h3 class="stat-value counter" data-target="<?= $total_siswa ?>">0</h3>
            </div>
        </a>

        <a href="<?= base_url('admin/rekap_harian') ?>" class="elite-card">
            <div class="icon-circle bg-hadir"><i class="ti ti-user-check"></i></div>
            <div>
                <span class="stat-label">Siswa Hadir</span>
                <h3 class="stat-value counter" data-target="<?= $total_hadir ?>">0</h3>
            </div>
        </a>

        <a href="<?= base_url('admin/ketidakhadiran') ?>" class="elite-card">
            <div class="icon-circle bg-alpa"><i class="ti ti-user-x"></i></div>
            <div>
                <?php $alpa = $total_siswa - $total_hadir - $total_tidak_hadir; ?>
                <span class="stat-label">Absen / Alpa</span>
                <h3 class="stat-value counter" data-target="<?= $alpa < 0 ? 0 : $alpa ?>">0</h3>
            </div>
        </a>

        <a href="<?= base_url('admin/ketidakhadiran') ?>" class="elite-card">
            <div class="icon-circle bg-izin"><i class="ti ti-user-exclamation"></i></div>
            <div>
                <span class="stat-label">Izin & Sakit</span>
                <h3 class="stat-value counter" data-target="<?= $total_tidak_hadir ?>">0</h3>
            </div>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="feature-box text-center">
                <h5 class="mb-4">Efektivitas Kehadiran</h5>
                <div class="attendance-circle">
                    <span class="circle-value"><?= ($total_siswa > 0) ? round(($total_hadir / $total_siswa) * 100) : 0 ?>%</span>
                </div>
                <p class="text-muted small mt-3">Persentase kehadiran siswa hari ini.</p>
                <div class="d-flex justify-content-center gap-4 mt-3">
                    <div class="text-center">
                        <small class="stat-label">Target</small>
                        <span class="fw-bold" style="font-size: 16px;"><?= $total_siswa ?></span>
                    </div>
                    <div style="border-left: 2px solid #f1f5f9;"></div>
                    <div class="text-center">
                        <small class="stat-label">Hadir</small>
                        <span class="fw-bold text-success" style="font-size: 16px;"><?= $total_hadir ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="feature-box">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="m-0">Leaderboard Kedisiplinan</h5>
                        <small class="text-muted">Siswa yang hadir paling awal hari ini</small>
                    </div>
                    <div class="icon-circle bg-hadir shadow-sm" style="width: 42px; height: 42px;">
                        <i class="ti ti-trophy" style="font-size: 1.2rem;"></i>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle m-0">
                        <thead>
                            <tr>
                                <th class="pb-3" style="width: 15%;">Rank</th>
                                <th class="pb-3" style="width: 45%;">Nama Siswa</th>
                                <th class="pb-3" style="width: 25%;">Waktu Masuk</th>
                                <th class="pb-3 text-end" style="width: 15%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($presensi_terakhir)): 
                                $rank = 1;
                                foreach($presensi_terakhir as $p): ?>
                                <tr style="border-bottom: 1px solid #f8fafc;">
                                    <td class="py-3">
                                        <div class="rank-badge <?= $rank == 1 ? 'rank-1' : 'rank-other' ?>">
                                            <?= $rank++ ?>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="student-name"><?= $p['nama'] ?></div>
                                        <div class="text-muted" style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Siswa Terdaftar</div>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-clock-check text-success" style="font-size: 1.1rem;"></i>
                                            <span class="fw-bold text-dark" style="font-size: 14px;"><?= date('H:i', strtotime($p['jam_masuk'])) ?> <small class="text-muted fw-normal">WIB</small></span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-end">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2" style="font-size: 10px; font-weight: 800; text-transform: uppercase;">Hadir</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="mb-3 opacity-20"><i class="ti ti-calendar-x" style="font-size: 3rem;"></i></div>
                                        <h6 class="text-muted fw-bold">Belum Ada Aktivitas</h6>
                                        <p class="text-muted small">Data kehadiran hari ini akan muncul secara otomatis.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const speed = target / 40;

            if (count < target) {
                counter.innerText = Math.ceil(count + speed);
                setTimeout(updateCount, 25);
            } else {
                counter.innerText = target;
            }
        }
        updateCount();
    });
</script>

<?= $this->endSection() ?>