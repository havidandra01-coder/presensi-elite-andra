<?= $this->extend('siswa/layout') ?>

<?= $this->section('content') ?>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

<style>
    body { background-color: #F0FBF8; }
    :root {
        --primary-mint: #00a67e; 
        --secondary-mint: #e6f6f2; 
        --dark-surface: #1a332d;
        --text-muted: #7e9690;
        --accent-yellow: #fff9db;
    }

    .presence-wrapper {
        animation: fadeIn 0.8s ease-out;
        max-width: 1100px;
        margin: 0 auto;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .glass-terminal {
        background: #ffffff;
        border-radius: 40px;
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 30px 60px rgba(0, 166, 126, 0.08);
        overflow: hidden;
        padding: 35px;
    }

    /* FIX AREA KAMERA - MEMASTIKAN FULL KOTAK */
    .camera-viewport {
        position: relative;
        width: 100%;
        max-width: 500px; /* Ukuran maksimal preview */
        margin: 0 auto;
        background: #000;
        border-radius: 25px;
        overflow: hidden;
        aspect-ratio: 1 / 1; 
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    #my_camera {
        width: 100% !important;
        height: 100% !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* TARGET SEMUA ELEMEN DI DALAM my_camera (Video dan Div pembungkus WebcamJS) */
    #my_camera, #my_camera div, #my_camera video {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important; /* KUNCI: Menghilangkan bar hitam */
        border-radius: 25px;
    }

    .hud-overlay {
        position: absolute;
        top: 20px; left: 20px; right: 20px; bottom: 20px;
        pointer-events: none;
        z-index: 10;
        background: 
            linear-gradient(to right, var(--primary-mint) 4px, transparent 4px) 0 0,
            linear-gradient(to bottom, var(--primary-mint) 4px, transparent 4px) 0 0,
            linear-gradient(to left, var(--primary-mint) 4px, transparent 4px) 100% 0,
            linear-gradient(to bottom, var(--primary-mint) 4px, transparent 4px) 100% 0,
            linear-gradient(to right, var(--primary-mint) 4px, transparent 4px) 0 100%,
            linear-gradient(to top, var(--primary-mint) 4px, transparent 4px) 0 100%,
            linear-gradient(to left, var(--primary-mint) 4px, transparent 4px) 100% 100%,
            linear-gradient(to top, var(--primary-mint) 4px, transparent 4px) 100% 100%;
        background-repeat: no-repeat;
        background-size: 50px 50px;
        opacity: 0.8;
    }

    .scanning-line {
        position: absolute;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, transparent, var(--primary-mint), transparent);
        top: 50%;
        z-index: 11;
        box-shadow: 0 0 20px var(--primary-mint);
        animation: scanMove 4s infinite ease-in-out;
        opacity: 0.5;
    }

    @keyframes scanMove {
        0%, 100% { top: 15%; }
        50% { top: 85%; }
    }

    .side-panel {
        background: linear-gradient(180deg, var(--secondary-mint) 0%, var(--accent-yellow) 100%);
        border-radius: 30px;
        padding: 30px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 2px solid white;
    }

/* Jam Digital yang dipercantik */
    .digital-clock {
        font-family: 'JetBrains Mono', monospace;
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(180deg, var(--dark-surface) 0%, #00a67e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -3px;
        line-height: 1;
        text-shadow: 0 10px 20px rgba(0, 166, 126, 0.15);
        margin-top: 5px;
    }

    .date-display {
        font-weight: 700;
        color: var(--text-muted);
        font-size: 0.85rem;
        letter-spacing: 1px;
    }

    .status-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        padding: 18px;
        border-radius: 20px;
        margin-bottom: 12px;
        border: 1px solid white;
    }

    .btn-verify {
        background: linear-gradient(135deg, var(--primary-mint), #008f6d);
        color: white;
        border: none;
        width: 100%;
        padding: 20px;
        border-radius: 22px;
        font-weight: 700;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        box-shadow: 0 15px 30px rgba(0, 166, 126, 0.25);
    }

    .tech-label {
        position: absolute; 
        bottom: 20px; left: 20px; 
        z-index: 12; color: #fff; font-family: 'JetBrains Mono'; 
        font-size: 10px; background: rgba(0, 166, 126, 0.8); 
        padding: 6px 15px; border-radius: 50px;
    }

    /* Jam Digital yang dipercantik */
    .digital-clock {
        font-family: 'JetBrains Mono', monospace;
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(180deg, var(--dark-surface) 0%, #00a67e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -3px;
        line-height: 1;
        text-shadow: 0 10px 20px rgba(0, 166, 126, 0.15);
        margin-top: 5px;
    }

    .date-display {
        font-weight: 700;
        color: var(--text-muted);
        font-size: 0.85rem;
        letter-spacing: 1px;
    }
</style>

<div class="container-fluid py-5 presence-wrapper">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-12">
            <div class="glass-terminal">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="mb-4 d-flex align-items-center gap-3">
                            <div style="background: var(--secondary-mint); padding: 10px; border-radius: 12px;">
                                <i class="ti ti-camera-selfie fs-2" style="color: var(--primary-mint);"></i>
                            </div>
                            <h2 style="font-family: 'JetBrains Mono'; font-weight: 700; color: var(--dark-surface); text-transform: uppercase; margin: 0; font-size: 1.4rem;">Presensi Masuk</h2>
                        </div>
                        
                        <div class="camera-viewport">
                            <div id="my_camera"></div>
                            <div class="hud-overlay"></div>
                            <div class="scanning-line"></div>
                            <div class="tech-label">
                                <span style="color: #00ffbc;">●</span> SYSTEM_READY_V4.0
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="side-panel">
    <div>
        <div class="text-center text-lg-start mb-4">
            <div class="date-display" id="live-date"><?= date('l, d F Y') ?></div>
            <div class="digital-clock" id="live-clock">00.00.00</div>
        </div>

        <div class="status-card">
            <span class="status-label" style="font-size: 10px; color: var(--text-muted); font-weight: 800; text-transform: uppercase; margin-bottom: 8px; display: block;">Identitas Siswa</span>
            <div class="d-flex align-items-center gap-3">
                <div class="status-icon icon-box-blue">
                    <i class="ti ti-user fs-3"></i>
                </div>
                <span class="status-value" style="font-weight: 700; color: var(--dark-surface); font-size: 16px;"><?= session()->get('username') ?></span>
            </div>
        </div>

        <div class="status-card">
            <span class="status-label" style="font-size: 10px; color: var(--text-muted); font-weight: 800; text-transform: uppercase; margin-bottom: 8px; display: block;">Lokasi Jaringan</span>
            <div class="d-flex align-items-center gap-3">
                <div class="status-icon icon-box-green">
                    <i class="ti ti-world-latitude fs-3"></i>
                </div>
                <span class="status-value" style="font-weight: 700; color: var(--dark-surface); font-size: 16px;">IP Sekolah Terotorisasi</span>
            </div>
        </div>

        <div class="status-card">
            <span class="status-label" style="font-size: 10px; color: var(--text-muted); font-weight: 800; text-transform: uppercase; margin-bottom: 8px; display: block;">Keamanan Perangkat</span>
            <div class="d-flex align-items-center gap-3">
                <div class="status-icon icon-box-purple">
                    <i class="ti ti-shield-check fs-3"></i>
                </div>
                <div>
                    <span class="status-value" style="font-weight: 700; color: var(--dark-surface); font-size: 16px;">Terverifikasi</span>
                    <small style="display: block; font-size: 10px; color: #059669; font-weight: 600;">System Secure</small>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <input type="hidden" id="id_siswa" value="<?= $id_siswa ?>">
        <input type="hidden" id="tanggal_masuk" value="<?= $tanggal_masuk ?>">
        <input type="hidden" id="jam_masuk" value="<?= $jam_masuk ?>">

        <button id="ambil-foto" class="btn-verify">
            <i class="ti ti-scan fs-3"></i>
            <span>Verifikasi Kehadiran</span>
        </button>
    </div>
</div>
                    </div>
                </div>
            </div>
            <div id="my_result" class="mt-4" style="display:none; max-width: 250px; margin-inline: auto;"></div>
        </div>
    </div>
</div>

<script>
// KONFIGURASI KAMERA
Webcam.set({
    width: 720,
    height: 720, // Paksa preview menjadi square
    dest_width: 720,
    dest_height: 720,
    crop_width: 720,
    crop_height: 720,
    image_format: 'jpeg',
    jpeg_quality: 100,
    flip_horiz: true, // Fix mirror agar tidak terbalik
    constraints: {
        facingMode: "user"
    }
});

Webcam.attach('#my_camera');

// FIXING BUG BLACK BAR SETELAH KAMERA AKTIF
Webcam.on('live', function() {
    // Menghilangkan gaya inline yang dibuat otomatis oleh WebcamJS
    const videoWrap = document.querySelector('#my_camera div');
    const videoEl = document.querySelector('#my_camera video');
    
    if (videoWrap) {
        videoWrap.style.width = '100%';
        videoWrap.style.height = '100%';
    }
    if (videoEl) {
        videoEl.style.width = '100%';
        videoEl.style.height = '100%';
        videoEl.style.objectFit = 'cover';
    }
});

function updateDateTime() {
    const now = new Date();
    document.getElementById('live-clock').innerText = now.toLocaleTimeString('id-ID', { hour12: false }).replace(/:/g, '.');
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('live-date').innerText = now.toLocaleDateString('id-ID', options).toUpperCase();
}
setInterval(updateDateTime, 1000);
updateDateTime();

document.getElementById('ambil-foto').addEventListener('click', function(){
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> MEMPROSES...';

Webcam.snap(function(data_uri) {
    // Ubah 'block' menjadi 'none' agar foto hasil jepretan tetap tersembunyi
    document.getElementById('my_result').style.display = 'none'; 
    
    document.getElementById('my_result').innerHTML =
    '<img src="'+data_uri+'" style="width:100%; border-radius:20px;">';

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                btn.innerHTML = '<i class="ti ti-circle-check fs-3"></i> BERHASIL!';
                btn.style.background = '#059669';
                setTimeout(() => { window.location.href = '<?= base_url('siswa/home')?>'; }, 1200);
            }
        };
        xhttp.open("POST", "<?= base_url('siswa/presensi_masuk_aksi')?>", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send('foto_masuk=' + encodeURIComponent(data_uri) + 
                   '&id_siswa=' + document.getElementById('id_siswa').value + 
                   '&tanggal_masuk=' + document.getElementById('tanggal_masuk').value + 
                   '&jam_masuk=' + document.getElementById('jam_masuk').value);
    });
});
</script>

<?= $this->endSection() ?>