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

    /* Header Styling */
    .page-title {
        font-weight: 800;
        color: var(--text-dark);
        letter-spacing: -0.5px;
    }

    .badge-elite {
        background: var(--secondary-mint);
        color: var(--primary-mint);
        font-weight: 700;
        font-size: 10px;
        padding: 4px 12px;
        border-radius: 8px;
        text-transform: uppercase;
    }

    /* Tombol Tambah Premium */
    .btn-add-new {
        background: linear-gradient(135deg, var(--primary-mint), #008f6d);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 15px;
        font-weight: 700;
        box-shadow: 0 10px 20px rgba(0, 166, 126, 0.2);
        transition: all 0.3s ease;
    }

    .btn-add-new:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(0, 166, 126, 0.3);
        color: white;
    }

    /* TABLE REDESIGN - Floating Row Style */
    .table-container {
        margin-top: 20px;
    }

    .custom-table {
        border-collapse: separate;
        border-spacing: 0 12px; /* Jarak antar baris */
        width: 100%;
    }

    .custom-table thead th {
        background: transparent;
        border: none;
        color: var(--soft-gray);
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding: 10px 25px;
    }

    .custom-table tbody tr {
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .custom-table tbody tr td {
        padding: 20px 25px;
        border: none;
        vertical-align: middle;
    }

    /* Membuat sudut melengkung pada setiap baris */
    .custom-table tbody tr td:first-child {
        border-radius: 20px 0 0 20px;
    }

    .custom-table tbody tr td:last-child {
        border-radius: 0 20px 20px 0;
    }

    .custom-table tbody tr:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
    }

    /* Status Pill - More Refined */
    .status-badge {
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-pending { background: #fff5f5; color: #fa5252; }
    .status-approved { background: #f0fff4; color: #38a169; }

    /* Attachment Link Styling */
    .btn-view-file {
        background: #f8fafb;
        color: var(--text-dark);
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid #edf2f7;
        transition: all 0.2s;
    }

    .btn-view-file:hover {
        background: var(--primary-mint);
        color: white;
        border-color: var(--primary-mint);
    }

    /* Action Buttons */
    .action-group {
        display: flex;
        gap: 8px;
    }

    .btn-action-elite {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
    }

    .btn-edit-elite { background: #fff9db; color: #f08c00; }
    .btn-edit-elite:hover { background: #f08c00; color: white; }

    .btn-delete-elite { background: #fff5f5; color: #fa5252; }
    .btn-delete-elite:hover { background: #fa5252; color: white; }

    /* Animation */
    .animate-up {
        animation: fadeInUp 0.7s ease-out both;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid py-5 px-md-4 animate-up">
    <div class="swal-data" data-swal="<?= session()->getFlashdata('berhasil'); ?>"></div>

    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <div class="icon-header me-3" style="background: var(--primary-mint); width: 50px; height: 50px; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0,166,126,0.2);">
                    <i class="ti ti-notes text-white fs-3"></i>
                </div>
                <div>
                    <h1 class="page-title mb-0">Ketidakhadiran</h1>
                    <div class="d-flex align-items-center mt-1">
                        <span class="text-muted small fw-500">History Log</span>
                        <span class="badge-elite ms-2">Elite Edition</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="<?= base_url('siswa/ketidakhadiran/create') ?>" class="btn btn-add-new">
                <i class="ti ti-plus me-1"></i> Ajukan Izin Baru
            </a>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="80" class="text-center">#</th>
                        <th>WAKTU & TANGGAL</th>
                        <th>KATEGORI</th>
                        <th>DETAIL ALASAN</th>
                        <th class="text-center">LAMPIRAN</th>
                        <th class="text-center">STATUS</th>
                        <th width="150" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ketidakhadiran) : ?>
                        <?php $no = 1; foreach($ketidakhadiran as $row) : ?>
                        <tr>
                            <td class="text-center">
                                <span class="fw-800 text-muted opacity-50" style="font-size: 14px;"><?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?></span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark" style="font-size: 0.95rem;"><?= date('d F Y', strtotime($row['tanggal'])) ?></div>
                                <div class="text-muted small d-flex align-items-center gap-1">
                                    <i class="ti ti-clock"></i> Scheduled Date
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--primary-mint);"></div>
                                    <span class="fw-bold text-dark"><?= $row['keterangan'] ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted" style="font-size: 0.85rem; max-width: 250px; line-height: 1.5;">
                                    "<?= esc($row['deskripsi']) ?>"
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('file_ketidakhadiran/'.$row['file']) ?>" class="btn-view-file" target="_blank">
                                    <i class="ti ti-paperclip me-1"></i> Doc File
                                </a>
                            </td>
                            <td class="text-center">
                                <?php if ($row['status'] == 'Pending') : ?>
                                    <span class="status-badge status-pending">
                                        <i class="ti ti-loader"></i> PENDING
                                    </span>
                                <?php else : ?>
                                    <span class="status-badge status-approved">
                                        <i class="ti ti-circle-check"></i> APPROVED
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="action-group justify-content-center">
                                    <a href="<?= base_url('siswa/ketidakhadiran/edit/'.$row['id']) ?>" class="btn-action-elite btn-edit-elite" title="Edit">
                                        <i class="ti ti-edit-circle fs-5"></i>
                                    </a>
                                    <a href="<?= base_url('siswa/ketidakhadiran/delete/'.$row['id']) ?>" class="btn-action-elite btn-delete-elite tombol-hapus" title="Hapus">
                                        <i class="ti ti-trash-x fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <i class="ti ti-database-x fs-1 text-muted opacity-20 d-block mb-3"></i>
                                    <p class="text-muted fw-500">Belum ada riwayat pengajuan izin.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const swalCustom = Swal.mixin({
        customClass: {
            confirmButton: 'btn-mint mx-2',
            cancelButton: 'btn btn-light mx-2'
        },
        buttonsStyling: false
    });

    const flashData = document.querySelector('.swal-data').dataset.swal;
    if (flashData) {
        swalCustom.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: flashData,
            timer: 2000,
            showConfirmButton: false
        });
    }

    document.querySelectorAll('.tombol-hapus').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;

            swalCustom.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus pengajuan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>