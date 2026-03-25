<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        margin-bottom: 0.5rem;
    }

    .badge-elite {
        background: #dcfce7;
        color: #15803d;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Main Container Card */
    .main-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        padding: 32px;
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Modern Green Button */
    .btn-custom-add {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
    }

    .btn-custom-add:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.3);
        color: white;
        filter: brightness(1.1);
    }

    /* Table "Floating Row" Styling */
    .table-container { margin-top: 1.5rem; }

    #datatables {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0 12px; 
    }

    #datatables thead th {
        background: transparent;
        color: var(--text-slate);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 700;
        border: none;
        padding: 0 20px 10px 20px;
    }

    #datatables tbody tr {
        background: var(--white);
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    #datatables tbody tr td {
        padding: 20px;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    #datatables tbody tr td:first-child {
        border-left: 1px solid #f1f5f9;
        border-radius: 16px 0 0 16px;
    }

    #datatables tbody tr td:last-child {
        border-right: 1px solid #f1f5f9;
        border-radius: 0 16px 16px 0;
    }

    #datatables tbody tr:hover {
        transform: translateY(-4px) scale(1.005);
        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08);
        z-index: 10;
        position: relative;
    }

    /* Action Buttons Styles */
    .action-btn {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        margin: 0 4px;
        text-decoration: none;
    }

    .btn-edit { background: #fffbeb; color: #f59e0b; }
    .btn-delete { background: #fef2f2; color: #ef4444; cursor: pointer; }

    .action-btn:hover {
        transform: scale(1.15) rotate(5deg);
    }

    /* Animations */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container-fluid py-5 px-4">
    <div class="header-section">
        <div class="d-flex align-items-center gap-3">
            <div style="background: var(--primary-green); padding: 10px; border-radius: 14px; color: white;">
                <i data-lucide="briefcase" size="28"></i>
            </div>
            <div>
                <h2>Data Jabatan</h2>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Presence System</span>
                    <span class="badge-elite">Elite Edition</span>
                </div>
            </div>
        </div>
    </div>

    <div class="main-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="<?= base_url('admin/jabatan/create') ?>" class="btn-custom-add">
                <i data-lucide="plus-circle" size="20"></i> Tambah Jabatan Baru
            </a>
        </div>

        <div class="table-responsive table-container">
            <table id="datatables">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">No</th>
                        <th>Nama Jabatan</th>
                        <th class="text-center" style="width: 200px;">Manajemen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($jabatan as $jab) : ?>
                    <tr>
                        <td class="text-center">
                            <span style="font-weight: 700; color: var(--primary-green); background: var(--bg-soft); padding: 5px 12px; border-radius: 8px;">
                                <?= $no++ ?>
                            </span>
                        </td>
                        <td>
                            <span style="font-weight: 600; font-size: 1rem; color: var(--dark-emerald);">
                                <?= $jab['jabatan'] ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/jabatan/edit/' . $jab['id']) ?>" class="action-btn btn-edit" title="Ubah Jabatan">
                                <i data-lucide="edit-3" size="18"></i>
                            </a>
                            <a href="<?= base_url('admin/jabatan/delete/' . $jab['id']) ?>" class="action-btn btn-delete tombol-hapus" title="Hapus Jabatan">
                                <i data-lucide="trash-2" size="18"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Aktifkan ikon Lucide
    lucide.createIcons();

    // SweetAlert Konfirmasi Hapus
    const hapusButtons = document.querySelectorAll('.tombol-hapus');
    hapusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');

            Swal.fire({
                title: 'Hapus Jabatan?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '20px'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    });

    // Notifikasi Sukses (Opsional jika pakai flashdata)
    <?php if (session()->getFlashdata('berhasil')) : ?>
        Swal.fire({
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('berhasil') ?>',
            icon: 'success',
            confirmButtonColor: '#10b981'
        });
    <?php endif; ?>
</script>

<?= $this->endSection() ?>