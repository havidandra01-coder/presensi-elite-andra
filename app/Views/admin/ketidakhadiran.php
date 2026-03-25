<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root { --primary-green: #10b981; --dark-emerald: #064e3b; --bg-soft: #f0fdf4; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-soft); }

    /* Card Styling */
    .table-container { 
        background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); 
        border-radius: 24px; padding: 25px; border: 1px solid white;
    }

    /* Modern Table Styling */
    #dataTable { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    #dataTable thead th { border: none; padding: 15px; color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
    #dataTable tbody tr { background: white; transition: 0.3s; }
    #dataTable tbody td { padding: 15px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    #dataTable tbody tr td:first-child { border-left: 1px solid #f1f5f9; border-radius: 15px 0 0 15px; }
    #dataTable tbody tr td:last-child { border-right: 1px solid #f1f5f9; border-radius: 0 15px 15px 0; }
    #dataTable tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(16,185,129,0.1); }

    /* Badge & Button Styling */
    .badge-status { padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 5px; }
    .badge-pending { background: #fee2e2; color: #991b1b; }
    .badge-approved { background: #dcfce7; color: #166534; }
    
    .btn-approve { 
        background: var(--primary-green); color: white; border: none;
        border-radius: 10px; padding: 8px 16px; font-weight: 600; font-size: 0.85rem;
        transition: 0.3s; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-approve:hover { background: #059669; color: white; transform: scale(1.05); }
    
    .btn-file {
        background: white; color: #334155; border: 1px solid #e2e8f0;
        border-radius: 10px; padding: 6px 12px; font-size: 0.8rem; font-weight: 600;
        transition: 0.3s;
    }
    .btn-file:hover { background: #f8fafc; border-color: var(--primary-green); color: var(--primary-green); }

    .header-title h2 { font-weight: 800; color: var(--dark-emerald); margin: 0; }
</style>

<div class="container-fluid py-5 px-4">
    <div class="header-title d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
        <div>
            <h2>Data Ketidakhadiran</h2>
            <p class="text-muted mb-0">Kelola perizinan dan sakit siswa</p>
        </div>
    </div>

    <div class="table-container shadow-sm" data-aos="fade-up">
        <div class="table-responsive">
            <table id="dataTable" class="text-center">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="12%">Keterangan</th>
                        <th class="text-start">Deskripsi</th>
                        <th width="12%">Bukti</th>
                        <th width="12%">Status</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($ketidakhadiran as $row) : ?>
                    <tr>
                        <td style="font-weight: 800; color: var(--primary-green);"><?= $no++ ?></td>
                        <td>
                            <div class="d-flex flex-column align-items-center">
                                <span style="font-weight: 700; color: #1e293b;"><?= date('d M Y', strtotime($row['tanggal'])) ?></span>
                                <small class="text-muted" style="font-size: 10px; text-transform: uppercase;"><?= date('l', strtotime($row['tanggal'])) ?></small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light border text-dark" style="border-radius: 8px;"><?= $row['keterangan'] ?></span>
                        </td>
                        <td class="text-start">
                            <span class="small text-muted" style="font-style: italic;">"<?= esc($row['deskripsi']) ?>"</span>
                        </td>
                        <td>
                            <a href="<?= base_url('file_ketidakhadiran/'.$row['file']) ?>" class="btn-file text-decoration-none" target="_blank">
                                <i data-lucide="image" size="14"></i> Lihat File
                            </a>
                        </td>
                        <td>
                            <?php if($row['status'] == 'Pending') : ?>
                                <span class="badge-status badge-pending"><i data-lucide="clock" size="14"></i> Pending</span>
                            <?php else : ?>
                                <span class="badge-status badge-approved"><i data-lucide="check-circle" size="14"></i> Approved</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['status'] == 'Pending') : ?>
                                <a href="<?= base_url('admin/approve_ketidakhadiran/'.$row['id']) ?>" class="btn-approve btn-confirm-approve">
                                    <i data-lucide="check" size="16"></i> Setujui
                                </a>
                            <?php else : ?>
                                <div class="text-success fw-bold small">
                                    <i data-lucide="user-check" size="16"></i> Selesai
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    lucide.createIcons();
    AOS.init({ duration: 800, once: true });

    // SweetAlert Konfirmasi
    document.querySelectorAll('.btn-confirm-approve').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');

            Swal.fire({
                title: 'Setujui Izin?',
                text: "Siswa akan dianggap sah tidak hadir pada tanggal tersebut.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    });

    // Notifikasi Flashdata
    <?php if (session()->getFlashdata('message')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('message') ?>',
            showConfirmButton: false,
            timer: 2000
        });
    <?php endif; ?>
</script>

<?= $this->endSection() ?>