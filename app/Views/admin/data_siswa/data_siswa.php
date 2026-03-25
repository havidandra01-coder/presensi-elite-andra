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

    /* Table Styling */
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

    #datatables tbody tr td:first-child { border-left: 1px solid #f1f5f9; border-radius: 16px 0 0 16px; }
    #datatables tbody tr td:last-child { border-right: 1px solid #f1f5f9; border-radius: 0 16px 16px 0; }

    #datatables tbody tr:hover {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08);
    }

    .action-btn {
        width: 40px; height: 40px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 12px; transition: 0.3s;
        border: none; margin: 0 4px; text-decoration: none;
    }

    .btn-detail { background: #f0f9ff; color: #0ea5e9; }
    .btn-edit { background: #fffbeb; color: #f59e0b; }
    .btn-delete { background: #fef2f2; color: #ef4444; cursor: pointer; }

    .action-btn:hover { transform: scale(1.15) rotate(5deg); }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container-fluid py-5 px-4">
    <div class="header-section">
        <div class="d-flex align-items-center gap-3">
            <div style="background: var(--primary-green); padding: 10px; border-radius: 14px; color: white;">
                <i data-lucide="users" size="28"></i>
            </div>
            <div>
                <h2>Data Siswa</h2>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Presence System</span>
                    <span class="badge-elite">Elite Edition</span>
                </div>
            </div>
        </div>
    </div>

    <div class="main-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="<?= base_url('admin/data_siswa/create') ?>" class="btn-custom-add">
                <i data-lucide="plus-circle" size="20"></i> Tambah Data Siswa
            </a>
        </div>

        <div class="table-responsive table-container">
            <table id="datatables">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Identitas Siswa</th>
                        <th>Jabatan</th>
                        <th>Lokasi Kerja</th>
                        <th>Alamat Domisili</th>
                        <th class="text-center">Manajemen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($siswa as $sis) : ?>
                    <tr>
                        <td class="text-center" style="font-weight: 700; color: var(--primary-green);"><?= $no++ ?></td>
                        <td>
                            <div class="d-flex flex-column">
                                <span style="font-weight: 700; font-size: 1.05rem;"><?= $sis['nama'] ?></span>
                                <span class="text-muted small">NIS: <?= $sis['nis'] ?></span>
                            </div>
                        </td>
                        <td>
                            <span style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 6px 14px; border-radius: 10px; font-size: 0.85rem; font-weight: 600;">
                                <?= $sis['jabatan'] ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2" style="color: #ef4444; font-weight: 500;">
                                <i data-lucide="map-pin" size="16"></i>
                                <span>Area <?= $sis['lokasi_presensi'] ?></span>
                            </div>
                        </td>
                        <td class="text-muted"><?= $sis['alamat'] ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/data_siswa/detail/' . $sis['id']) ?>" class="action-btn btn-detail" title="Lihat Detail">
                                <i data-lucide="eye" size="18"></i>
                            </a>
                            <a href="<?= base_url('admin/data_siswa/edit/' . $sis['id']) ?>" class="action-btn btn-edit" title="Ubah Data">
                                <i data-lucide="edit-3" size="18"></i>
                            </a>
                            <a href="<?= base_url('admin/data_siswa/delete/' . $sis['id']) ?>" class="action-btn btn-delete tombol-hapus" title="Hapus Data">
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
    lucide.createIcons();

    // Logika SweetAlert untuk tombol hapus
    const hapusButtons = document.querySelectorAll('.tombol-hapus');
    hapusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah link langsung terbuka
            const href = this.getAttribute('href');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data siswa ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981', // Hijau tema kita
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '20px',
                background: '#ffffff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    });

    // Opsional: Notifikasi sukses setelah delete (jika ada session flashdata)
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