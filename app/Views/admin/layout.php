<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/x-icon" />
    <title><?= $title ?> | Presence System Elite</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css')?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/lineicons.css')?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css')?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.35.0/tabler-icons.min.css" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png') ?>">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        :root {
            --primary-dark: #0f1d0e; 
            --accent-green: #4ade80;
            --sidebar-bg: #142612;
            --sidebar-width: 280px;
            --transition-smooth: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        /* --- SIDEBAR BASE --- */
        .sidebar-nav-wrapper {
            width: var(--sidebar-width) !important;
            background: var(--sidebar-bg) !important;
            position: fixed !important;
            top: 0; left: 0; height: 100vh;
            z-index: 1100 !important;
            border-right: 1px solid rgba(74, 222, 128, 0.1) !important;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 10px 0 30px rgba(0,0,0,0.5);
            transform: translateX(0);
        }

        .sidebar-nav-wrapper.active {
            transform: translateX(calc(-1 * var(--sidebar-width))) !important;
        }

        #sidebar-canvas {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 0;
            pointer-events: none;
            opacity: 0.4;
        }

        .sidebar-nav { position: relative; z-index: 10; padding-top: 20px; }

        .navbar-logo {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            padding: 50px 20px 30px !important;
        }

        .navbar-logo img {
            width: 90px !important;
            height: 90px !important;
            border-radius: 50%;
            margin-bottom: 20px !important;
            border: 3px solid var(--accent-green);
            padding: 5px;
            background: rgba(255,255,255,0.05);
            filter: drop-shadow(0 0 15px rgba(74, 222, 128, 0.4));
            transition: var(--transition-smooth);
        }

        .brand-text .app-name {
            font-size: 1.6rem !important;
            font-weight: 800 !important;
            color: #ffffff !important;
            letter-spacing: 1px;
            margin: 0;
        }

        .brand-text .system-status {
            font-size: 0.75rem !important;
            color: var(--accent-green) !important;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 700;
            margin-top: -5px;
        }

        .sidebar-nav ul { list-style: none; padding: 0; margin: 0; }

        /* Animation for list items */
        .sidebar-nav ul li {
            opacity: 0; 
            transform: translateX(-20px);
            animation: fadeInRight 0.5s forwards;
        }

        @keyframes fadeInRight {
            to { opacity: 1; transform: translateX(0); }
        }

        .sidebar-nav ul li a {
            position: relative;
            color: rgba(255, 255, 255, 0.5) !important;
            padding: 14px 28px !important;
            margin: 4px 15px !important;
            border-radius: 12px !important;
            transition: var(--transition-smooth) !important;
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
            font-weight: 500;
            overflow: hidden;
        }

        .sidebar-nav ul li a i {
            font-size: 1.3rem;
            margin-right: 15px;
            transition: var(--transition-smooth);
        }

        .sidebar-nav ul li a:hover {
            color: #fff !important;
            background: rgba(74, 222, 128, 0.05) !important;
            padding-left: 35px !important;
        }

        .sidebar-nav ul li a.active {
            color: var(--accent-green) !important;
            background: rgba(74, 222, 128, 0.12) !important;
            font-weight: 700;
        }

        .sidebar-nav ul li a.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 4px;
            background: var(--accent-green);
            border-radius: 0 10px 10px 0;
            box-shadow: 0 0 15px var(--accent-green);
        }

        /* Submenu Styling */
        .dropdown-nav {
            background: rgba(0,0,0,0.2);
            margin: 5px 15px !important;
            border-radius: 12px;
            padding: 5px 0 !important;
        }

        .dropdown-nav li a {
            padding: 10px 20px 10px 45px !important;
            margin: 2px 5px !important;
            font-size: 0.85rem;
        }

        .main-wrapper {
            margin-left: var(--sidebar-width) !important;
            width: 100% !important;
            max-width: calc(100% - var(--sidebar-width));
            transition: var(--transition-smooth) !important;
            min-height: 100vh;
        }

        .main-wrapper.active {
            margin-left: 0 !important;
            max-width: 100% !important;
        }

        /* --- HEADER --- */
        .header {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(0,0,0,0.05) !important;
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        #menu-toggle {
            width: 45px; height: 45px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px;
            background: var(--sidebar-bg);
            color: var(--accent-green);
            border: none;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

/* --- UPDATED PROFILE SECTION --- */
.profile-box {
    background: #effaf3; /* Background transparan tipis */
    padding: 6px 20px 6px 8px;
    border-radius: 50px;
    border: 1px solid rgba(16, 185, 129, 0.1); /* Border hijau sangat halus */
    transition: var(--transition-smooth);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
}

.profile-box:hover {
    background: #effaf3;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.1);
    border-color: var(--accent-green);
}

.profile-container .image {
    position: relative;
    line-height: 0;
}

.profile-container .image img {
    width: 42px !important;
    height: 42px !important;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Titik online yang lebih 'glow' */
.online-dot {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    background: #10b981;
    border-radius: 50%;
    border: 2.5px solid #fff;
    box-shadow: 0 0 8px rgba(16, 185, 129, 0.5);
}

.name-info {
    margin-left: 12px;
}

.name-info .user-name {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1e293b; /* Warna gelap charcoal untuk kontras yang bagus */
    display: block;
    line-height: 1.2;
}

.name-info .user-role {
    font-size: 0.75rem;
    color: #64748b; /* Abu-abu medium */
    font-weight: 500;
    display: block;
}

/* Dropdown yang lebih smooth */
.custom-dropdown-menu {
    border: none;
    margin-top: 15px;
    background: rgba(218, 255, 187, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

        .online-dot {
            position: absolute;
            bottom: 2px; right: 2px;
            width: 10px; height: 10px;
            background: #2ed573;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .custom-dropdown-menu {
            display: none;
            position: absolute;
            right: 0; top: 65px;
            background: #ffffff;
            min-width: 220px;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
            border: 1px solid rgba(0,0,0,0.05);
            padding: 12px;
            z-index: 1200;
        }

        .custom-dropdown-menu.show { display: block; animation: dropFade 0.3s ease forwards; }

        @keyframes dropFade {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .custom-dropdown-item {
            display: flex; align-items: center;
            padding: 12px 15px;
            color: #475569;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .custom-dropdown-item:hover { background: #f8fafc; color: var(--sidebar-bg); }

        @media (max-width: 991px) {
            .sidebar-nav-wrapper { transform: translateX(-100%); }
            .sidebar-nav-wrapper.active { transform: translateX(0) !important; }
            .main-wrapper { margin-left: 0 !important; max-width: 100% !important; }
        }

        #preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: var(--primary-dark);
            display: flex; justify-content: center; align-items: center;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <div id="preloader">
        <div class="spinner-border text-success" role="status"></div>
    </div>

    <aside class="sidebar-nav-wrapper">
        <canvas id="sidebar-canvas"></canvas>
        <div class="navbar-logo">
            <a href="<?= base_url('admin/home') ?>" style="text-decoration: none; text-align: center;">
                <img src="<?= base_url('assets/images/logo/1.png') ?>" alt="logo" />
                <div class="brand-text">
                    <h1 class="app-name">Presence</h1>
                    <p class="system-status">ADMIN ELITE</p>
                </div>
            </a>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li style="animation-delay: 0.1s">
                    <a href="<?= base_url('admin/home') ?>" class="<?= (uri_string() == 'admin/home') ? 'active' : '' ?>">
                        <i class="ti ti-layout-dashboard"></i> <span class="text">Dashboard</span>
                    </a>
                </li>
                <li style="animation-delay: 0.15s">
                    <a href="<?= base_url('admin/data_siswa') ?>" class="<?= (uri_string() == 'admin/data_siswa') ? 'active' : '' ?>">
                        <i class="ti ti-users"></i> <span class="text">Data Siswa</span>
                    </a>
                </li>
                
                <li style="animation-delay: 0.2s">
                    <a href="#masterData" data-bs-toggle="collapse" class="<?= (strpos(uri_string(), 'admin/jabatan') !== false || strpos(uri_string(), 'admin/lokasi') !== false) ? '' : 'collapsed' ?>">
                        <i class="ti ti-database"></i> <span class="text">Master Data</span>
                    </a>
                    <ul id="masterData" class="collapse dropdown-nav <?= (strpos(uri_string(), 'admin/jabatan') !== false || strpos(uri_string(), 'admin/lokasi') !== false) ? 'show' : '' ?>">
                        <li><a href="<?= base_url('admin/jabatan') ?>" class="<?= (uri_string() == 'admin/jabatan') ? 'active' : '' ?>">Data Jabatan</a></li>
                        <li><a href="<?= base_url('admin/lokasi_presensi') ?>" class="<?= (uri_string() == 'admin/lokasi_presensi') ? 'active' : '' ?>">Lokasi Presensi</a></li>
                    </ul>
                </li>

                <li style="animation-delay: 0.25s">
                    <a href="#rekapData" data-bs-toggle="collapse" class="<?= (strpos(uri_string(), 'rekap') !== false) ? '' : 'collapsed' ?>">
                        <i class="ti ti-report-analytics"></i> <span class="text">Rekap Presensi</span>
                    </a>
                    <ul id="rekapData" class="collapse dropdown-nav <?= (strpos(uri_string(), 'rekap') !== false) ? 'show' : '' ?>">
                        <li><a href="<?= base_url('admin/rekap_harian') ?>" class="<?= (uri_string() == 'admin/rekap_harian') ? 'active' : '' ?>">Rekap Harian</a></li>
                        <li><a href="<?= base_url('admin/rekap_bulanan') ?>" class="<?= (uri_string() == 'admin/rekap_bulanan') ? 'active' : '' ?>">Rekap Bulanan</a></li>
                    </ul>
                </li>

                <li style="animation-delay: 0.3s">
                    <a href="<?= base_url('admin/ketidakhadiran') ?>" class="<?= (uri_string() == 'admin/ketidakhadiran') ? 'active' : '' ?>">
                        <i class="ti ti-user-off"></i> <span class="text">Ketidakhadiran</span>
                    </a>
                </li>

                <div style="border-top: 1px solid rgba(74,222,128,0.1); margin: 25px 30px;"></div>
                <li style="animation-delay: 0.4s">
                    <a href="<?= base_url('logout') ?>" class="text-danger">
                        <i class="ti ti-logout" style="color: #ff6b6b"></i> <span class="text">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="main-wrapper">
        <header class="header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-6">
                        <button id="menu-toggle">
                            <i class="ti ti-menu-2 fs-4"></i>
                        </button>
                    </div>
                    
                    <div class="col-6 d-flex justify-content-end align-items-center">
                        <div class="profile-container">
                                <div id="profile-trigger" class="profile-box d-flex align-items-center" style="cursor: pointer; user-select: none;">
                                    <div class="image me-3">
                                        <?php 
                                            // Logika: Jika session foto ada, pakai itu. Jika tidak, pakai logo default.
                                            $foto_profil = session()->get('foto') ? base_url('profile/' . session()->get('foto')) : base_url('assets/images/logo/1.png');
                                        ?>
                                        <img src="<?= $foto_profil ?>" 
                                            style="width:38px; height:38px; border-radius:50%; object-fit: cover; border: 2px solid #fff;" 
                                            alt="User Profile" 
                                            onerror="this.src='<?= base_url('assets/images/logo/1.png') ?>';">
                                        <span class="online-dot"></span>
                                    </div>
                                    <div class="name-info">
                                        <span class="d-block fw-bold" style="font-size: 0.9rem; color: #10b981; line-height: 1;">
                                            <?= session()->get('nama') ?? 'Admin' ?>
                                        </span>
                                        <small class="text-muted" style="font-size: 0.75rem;">Administrator</small>
                                    </div>
                                </div>
                            </div>
                            <ul id="profile-menu" class="custom-dropdown-menu">
                                <li>
                                    <a href="<?= base_url('admin/profil') ?>" class="custom-dropdown-item">
                                        <i class="ti ti-user-circle me-2"></i> Profil Saya
                                    </a>
                                </li>
                                <li style="border-top: 1px solid #f1f1f1; margin: 8px 0;"></li>
                                <li>
                                    <a href="<?= base_url('logout') ?>" class="custom-dropdown-item text-danger">
                                        <i class="ti ti-logout me-2"></i> Log Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="section">
            <div class="container-fluid">
                <div class="title-wrapper pt-30">
                    <div class="title mb-4">
                        <h2 class="fw-800" style="color: var(--primary-dark);"><?= $title ?></h2>
                    </div>
                </div>
                <?= $this->renderSection('content') ?>
            </div>
        </section>
    </main>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js')?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const menuToggle = document.querySelector("#menu-toggle");
            const sidebar = document.querySelector(".sidebar-nav-wrapper");
            const mainWrapper = document.querySelector(".main-wrapper");

            menuToggle.addEventListener("click", () => {
                sidebar.classList.toggle("active");
                mainWrapper.classList.toggle("active");
                setTimeout(() => {
                    window.dispatchEvent(new Event('resize'));
                    initCanvas();
                }, 400);
            });

            const profileTrigger = document.querySelector("#profile-trigger");
            const profileMenu = document.querySelector("#profile-menu");

            if (profileTrigger) {
                profileTrigger.addEventListener("click", (e) => {
                    e.stopPropagation();
                    profileMenu.classList.toggle("show");
                });
            }

            document.addEventListener("click", (e) => {
                if (profileMenu && !profileTrigger.contains(e.target)) {
                    profileMenu.classList.remove("show");
                }
            });

            window.addEventListener('load', () => {
                const preloader = document.getElementById('preloader');
                preloader.style.opacity = '0';
                setTimeout(() => { preloader.style.display = 'none'; }, 500);
            });
        });

        // CANVAS PARTICLES ANIMATION
        const canvas = document.getElementById('sidebar-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];

        function initCanvas() {
            if(!canvas) return;
            canvas.width = canvas.parentElement.offsetWidth;
            canvas.height = canvas.parentElement.offsetHeight;
            particles = [];
            for (let i = 0; i < 40; i++) {
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    size: Math.random() * 2 + 1,
                    speedX: (Math.random() - 0.5) * 0.5,
                    speedY: (Math.random() - 0.5) * 0.5
                });
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.x += p.speedX; p.y += p.speedY;
                if (p.x < 0 || p.x > canvas.width) p.speedX *= -1;
                if (p.y < 0 || p.y > canvas.height) p.speedY *= -1;
                ctx.fillStyle = 'rgba(74, 222, 128, 0.3)';
                ctx.beginPath(); ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2); ctx.fill();
            });
            for (let i = 0; i < particles.length; i++) {
                for (let j = i; j < particles.length; j++) {
                    let dx = particles[i].x - particles[j].x;
                    let dy = particles[i].y - particles[j].y;
                    let dist = Math.sqrt(dx*dx + dy*dy);
                    if (dist < 100) {
                        ctx.strokeStyle = `rgba(74, 222, 128, ${1 - dist/100})`;
                        ctx.lineWidth = 0.5;
                        ctx.beginPath(); ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y); ctx.stroke();
                    }
                }
            }
            requestAnimationFrame(animate);
        }

        initCanvas(); animate();
        window.addEventListener('resize', initCanvas);
    </script>
</body>
</html>