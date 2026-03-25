<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/x-icon" />
    <title>Dashboard | Presence System Elite</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css')?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/lineicons.css')?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css')?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.35.0/tabler-icons.min.css" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png') ?>">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-dark: #2d4a22;
            --accent-green: #4ade80;
            --bg-body: #f8fafc;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-body);
        }

        .header {
            overflow: visible !important;
        }

        /* CUSTOM SIDEBAR THEME */
        .sidebar-nav-wrapper {
            background: var(--primary-dark) !important;
            border-right: none;
            position: relative;
            overflow: hidden;
        }

        /* Canvas Particle Background */
        #sidebar-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            opacity: 0.4;
        }

        .sidebar-nav {
            position: relative;
            z-index: 10;
        }

        .sidebar-nav ul li a {
            color: rgba(255,255,255,0.7) !important;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 12px;
            margin: 5px 15px;
            transition: all 0.3s ease;
        }

        .sidebar-nav ul li a svg {
            color: var(--accent-green);
            margin-right: 12px;
        }

        .sidebar-nav ul li a:hover, .sidebar-nav ul li a.active {
            background: rgba(74, 222, 128, 0.1) !important;
            color: var(--accent-green) !important;
        }

        .navbar-logo {
            background: transparent !important;
            padding: 30px 20px !important;
        }

        /* HEADER CUSTOM */
        .header {
            background: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03) !important;
        }

        .main-btn.primary-btn {
            background: var(--primary-dark) !important;
            border-radius: 10px;
            font-weight: 600;
        }

        .profile-info .info .image img {
            border: 2px solid var(--accent-green);
        }

        /* TITLE SECTION */
        .title h2 {
            font-weight: 800;
            color: var(--primary-dark);
            letter-spacing: -1px;
        }

        .footer {
            background: #fff;
            border-top: 1px solid #eee;
        }
    </style>
  </head>
  <body>
    <div id="preloader">
      <div class="spinner"></div>
    </div>

    <aside class="sidebar-nav-wrapper">
      <canvas id="sidebar-canvas"></canvas>

      <div class="navbar-logo">
        <a href="<?= base_url('dashboard') ?>">
          <img style="width:100%" src="<?= base_url('assets/images/logo/logo kelas.png') ?>" alt="logo" />
        </a>
      </div>
      <nav class="sidebar-nav">
        <ul>
          <li class="nav-item mb-2">
            <a href="<?= base_url('dashboard') ?>">
              <i class="ti ti-smart-home fs-4"></i>
              <span class="text">Dashboard</span>
            </a>
          </li>

          <li class="nav-item mb-2">
            <a href="<?= base_url('siswa') ?>">
              <i class="ti ti-users fs-4"></i>
              <span class="text">Data Siswa</span>
            </a>
          </li>

          <li class="nav-item nav-item-has-children mb-2">
            <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_1" aria-controls="ddmenu_1" aria-expanded="false">
              <i class="ti ti-report-analytics fs-4"></i>
              <span class="text">Rekap Presensi</span>
            </a>
            <ul id="ddmenu_1" class="collapse dropdown-nav">
              <li><a href="#">Rekap Harian</a></li>
              <li><a href="#">Rekap Bulanan</a></li>
            </ul>
          </li>

          <li class="nav-item mb-2">
            <a href="<?= base_url('ketidakhadiran') ?>">
              <i class="ti ti-user-off fs-4"></i>
              <span class="text">Ketidakhadiran</span>
            </a>
          </li>

          <li class="nav-item mb-2">
            <a href="<?= base_url('logout') ?>" class="text-danger btn-logout">
              <i class="ti ti-logout fs-4" style="color: #ff6b6b"></i>
              <span class="text">Logout</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <div class="overlay"></div>

    <main class="main-wrapper">
      <header class="header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
              <div class="header-left d-flex align-items-center">
                <div class="menu-toggle-btn mr-15">
                  <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                    <i class="lni lni-menu me-2"></i> Menu
                  </button>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
              <div class="header-right">
                <div class="profile-box ml-15">
                  <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-info">
                      <div class="info">
                        <div class="image">
                          <img src="<?= base_url('assets/images/profile/profile-image.png') ?>" alt="" />
                        </div>
                        <div>
                          <h6 class="fw-600">Admin Utama</h6>
                          <p>Administrator</p>
                        </div>
                      </div>
                    </div>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                    <li><a href="#"><i class="lni lni-user"></i> Profile</a></li>
                    <li><a href="#"><i class="lni lni-cog"></i> Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="<?= base_url('logout') ?>" class="btn-logout"><i class="lni lni-exit"></i> Sign Out</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title">
                  <h2>Dashboard</h2>
                </div>
              </div>
            </div>
          </div>

          <?= $this->renderSection('content') ?>
          
        </div>
      </section>

      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 order-last order-md-first">
              <div class="copyright text-center text-md-start">
                <p class="text-sm">© 2026 Presence System High Contrast</p>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </main>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js')?>"></script>
    <script src="<?= base_url('assets/js/main.js')?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        // --- 1. SCRIPT UNTUK ANIMASI CANVAS ---
        const canvas = document.getElementById('sidebar-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];

        function initCanvas() {
            canvas.width = canvas.parentElement.offsetWidth;
            canvas.height = canvas.parentElement.offsetHeight;
        }

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 1;
                this.speedX = Math.random() * 0.5 - 0.25;
                this.speedY = Math.random() * 0.5 - 0.25;
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                if (this.x > canvas.width) this.x = 0;
                if (this.x < 0) this.x = canvas.width;
                if (this.y > canvas.height) this.y = 0;
                if (this.y < 0) this.y = canvas.height;
            }
            draw() {
                ctx.fillStyle = '#4ade80';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function createParticles() {
            for (let i = 0; i < 40; i++) {
                particles.push(new Particle());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(animate);
        }

        window.addEventListener('resize', initCanvas);
        initCanvas();
        createParticles();
        animate();

        // --- 2. SCRIPT UNTUK SWEETALERT LOGOUT ---
        $(document).ready(function() {
            // Menggunakan event delegation agar link logout di dropdown juga terdeteksi
            $(document).on('click', '.btn-logout', function(e) {
                e.preventDefault();
                const href = $(this).attr('href');

                Swal.fire({
                    title: 'Konfirmasi Keluar',
                    text: "Apakah anda yakin ingin mengakhiri sesi ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2d4a22',
                    cancelButtonColor: '#ff6b6b',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>
  </body>
</html>