<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root { --primary-green: #10b981; --dark-emerald: #064e3b; --bg-soft: #f0fdf4; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-soft); overflow-x: hidden; }
    
    .header-section { margin-bottom: 2.5rem; }
    
    .main-card { 
        background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); 
        border-radius: 24px; padding: 30px; border: 1px solid rgba(255,255,255,0.8);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }

    /* Modern Table Styling */
    #datatables { width: 100% !important; border-collapse: separate; border-spacing: 0 12px; }
    #datatables thead th { border: none; padding: 10px 20px; color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; }
    #datatables tbody tr { background: white; transition: 0.3s; }
    #datatables tbody td { padding: 18px 20px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    #datatables tbody tr td:first-child { border-left: 1px solid #f1f5f9; border-radius: 16px 0 0 16px; }
    #datatables tbody tr td:last-child { border-right: 1px solid #f1f5f9; border-radius: 0 16px 16px 0; }
    #datatables tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -5px rgba(16,185,129,0.1); }

    .btn-custom-add {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;
        padding: 12px 24px; border-radius: 12px; font-weight: 600; text-decoration: none;
        display: inline-flex; align-items: center; gap: 10px; transition: 0.3s;
    }
    .btn-custom-add:hover { transform: translateY(-2px); color: white; filter: brightness(1.1); box-shadow: 0 8px 15px rgba(16,185,129,0.2); }

    /* Action Buttons */
    .action-btn { width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: 0.3s; margin: 0 2px; text-decoration: none; }
    .btn-detail { background: #eff6ff; color: #3b82f6; }
    .btn-edit { background: #fffbeb; color: #f59e0b; }
    .btn-delete { background: #fef2f2; color: #ef4444; border: none; cursor: pointer; }
    .action-btn:hover { transform: scale(1.1); filter: contrast(1.1); }

    .badge-tipe { background: #f1f5f9; color: #475569; font-weight: 600; padding: 6px 12px; border-radius: 8px; font-size: 0.7rem; }
</style>

<div class="container-fluid py-5 px-4">
    <div class="header-section d-flex justify-content-between align-items-center" data-aos="fade-down">
        <div>
            <h2 style="font-weight: 800; color: var(--dark-emerald); margin:0;">Lokasi Presensi</h2>
            <p class="text-muted mb-0">Manajemen titik koordinat kehadiran</p>
        </div>
        <a href="<?= base_url('admin/lokasi_presensi/create') ?>" class="btn-custom-add">
            <i data-lucide="map-pin" size="18"></i> Tambah Lokasi
        </a>
    </div>

    <div class="main-card" data-aos="fade-up" data-aos-delay="200">
        <div class="table-responsive">
            <table id="datatables">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama Lokasi</th>
                        <th>Alamat</th>
                        <th>Tipe</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($lokasi_presensi as $lok) : ?>
                    <tr>
                        <td class="text-center" style="font-weight: 700; color: var(--primary-green);"><?= $no++ ?></td>
                        <td>
                            <div style="font-weight: 700; color: #1e293b;"><?= $lok['nama_lokasi'] ?></div>
                        </td>
                        <td class="text-muted small"><?= $lok['alamat_lokasi'] ?></td>
                        <td><span class="badge-tipe"><?= $lok['tipe_lokasi'] ?></span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="<?= base_url('admin/lokasi_presensi/detail/' . $lok['id']) ?>" class="action-btn btn-detail" title="Detail"><i data-lucide="eye" size="18"></i></a>
                                <a href="<?= base_url('admin/lokasi_presensi/edit/' . $lok['id']) ?>" class="action-btn btn-edit" title="Edit"><i data-lucide="edit-3" size="18"></i></a>
                                <button type="button" 
                                        onclick="confirmDelete('<?= base_url('admin/lokasi_presensi/delete/' . $lok['id']) ?>')" 
                                        class="action-btn btn-delete" 
                                        title="Hapus">
                                    <i data-lucide="trash-2" size="18"></i>
                                </button>
                            </div>
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
    // Inisialisasi Lucide Icons
    lucide.createIcons();

    // Inisialisasi AOS Animation
    AOS.init({
        duration: 800,
        once: true,
        easing: 'ease-in-out'
    });

    // Fungsi SweetAlert untuk Konfirmasi Hapus
    function confirmDelete(url) {
        Swal.fire({
            title: 'Hapus Lokasi?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#10b981', // Emerald Green
            cancelButtonColor: '#ef4444', // Red
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            background: '#ffffff',
            borderRadius: '20px',
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Beri efek loading sebelum redirect
                Swal.fire({
                    title: 'Dihapus!',
                    text: 'Sedang memproses permintaan Anda.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000
                });
                setTimeout(() => {
                    window.location.href = url;
                }, 1000);
            }
        });
    }
</script>

<?php if (session()->getFlashdata('pesan')) : ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?= session()->getFlashdata('pesan') ?>',
        showConfirmButton: false,
        timer: 2000,
        borderRadius: '20px'
    });
</script>
<?php endif; ?>

<?= $this->endSection() ?>