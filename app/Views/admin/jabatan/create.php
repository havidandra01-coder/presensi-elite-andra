<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root {
        --primary-green: #10b981;
        --dark-emerald: #064e3b;
        --bg-soft: #f0fdf4;
        --white: #ffffff;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-soft);
    }

    .header-section {
        margin-bottom: 2rem;
        animation: fadeInDown 0.6s ease;
    }

    .badge-elite {
        background: #dcfce7;
        color: #15803d;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .main-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        padding: 40px;
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        animation: fadeInUp 0.8s ease;
        max-width: 550px;
        margin: 0 auto;
    }

    .form-label {
        font-weight: 600;
        color: var(--dark-emerald);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control {
        border-radius: 12px;
        padding: 14px 18px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .btn-submit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        width: 100%;
        margin-top: 15px;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px rgba(16, 185, 129, 0.3);
        color: white;
    }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container py-5">
    <div class="header-section text-center">
        <div class="badge-elite mb-2">Setup Master Data</div>
        <h2 style="font-weight: 800; color: var(--dark-emerald);">Tambah Jabatan</h2>
    </div>

    <div class="main-card">
        <?php $validation = \Config\Services::validation(); ?>
        <form method="post" action="<?= base_url('admin/jabatan/store') ?>">
            <?= csrf_field(); ?>

            <div class="mb-4">
                <label class="form-label">
                    <i data-lucide="briefcase" size="18"></i> Nama Jabatan
                </label>
                <input type="text" 
                       name="jabatan" 
                       value="<?= old('jabatan'); ?>" 
                       placeholder="Contoh: Manager Operasional" 
                       class="form-control <?= ($validation->hasError('jabatan')) ? 'is-invalid' : ''; ?>">
                
                <?php if ($validation->hasError('jabatan')) : ?>
                    <div class="invalid-feedback mt-2">
                        <?= $validation->getError('jabatan'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-submit">
                <i data-lucide="check-circle" size="18" class="me-2"></i> Simpan Data Jabatan
            </button>
            
            <a href="<?= base_url('admin/jabatan') ?>" class="btn btn-link w-100 text-muted mt-3 text-decoration-none small">
                Kembali ke daftar
            </a>
        </form>
    </div>
</div>

<script>lucide.createIcons();</script>
<?= $this->endSection() ?>