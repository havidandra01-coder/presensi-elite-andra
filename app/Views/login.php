<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png') ?>">
    <title>Sign In | Presence Class</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>?v=1">
    
    <style>
        :root {
            --primary-dark: #2d4a22;
            --accent-green: #4ade80;
            --bg-clean: #ffffff;
            --text-main: #1a1a1a;
            --input-border: #cbd5e1;
        }

        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: var(--text-main);
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            overflow: hidden;
        }

        .auth-row {
            background: var(--bg-clean);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
            max-width: 1050px;
            width: 100%;
            border: 1px solid rgba(0,0,0,0.05);
            display: flex;
            position: relative;
            z-index: 10;
        }

        /* --- Sisi Kiri: Green Animated Zone --- */
        .auth-side-info {
            background: var(--primary-dark);
            padding: 60px;
            color: white;
            position: relative;
            overflow: hidden;
            flex: 0 0 45%;
            max-width: 45%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .shapes-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        /* 1. Lingkaran Besar Neon */
        .shape-circle {
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(74, 222, 128, 0.18) 0%, rgba(74, 222, 128, 0) 70%);
            border-radius: 50%;
            animation: moveRandom1 20s infinite alternate ease-in-out;
        }

        /* 2. Hexagon (SVG) */
        .shape-hexagon {
            position: absolute;
            top: 40%;
            right: -30px;
            width: 120px;
            height: 120px;
            fill: rgba(74, 222, 128, 0.1);
            animation: moveRandom2 15s infinite linear;
        }

        /* 3. Floating Plus Symbols */
        .shape-plus {
            position: absolute;
            font-size: 40px;
            color: var(--accent-green);
            opacity: 0.2;
            font-weight: 300;
        }
        .p1 { top: 10%; right: 20%; animation: moveRandom3 10s infinite alternate; }
        .p2 { bottom: 20%; left: 40%; animation: moveRandom1 12s infinite reverse; }

        /* 4. Segitiga Gede */
        .shape-triangle {
            position: absolute;
            top: 5%;
            left: -20px;
            width: 100px;
            height: 100px;
            opacity: 0.12;
            fill: var(--accent-green);
            animation: moveRandom3 18s infinite alternate ease-in-out;
        }

        /* 5. Kotak Outline */
        .shape-square {
            position: absolute;
            bottom: 5%;
            right: 10%;
            width: 80px;
            height: 80px;
            border: 2px solid rgba(74, 222, 128, 0.15);
            border-radius: 12px;
            animation: rotateSmooth 10s infinite linear;
        }

        /* 6. Grid Dots */
        .shape-dots {
            position: absolute;
            top: 20%;
            left: 30%;
            width: 150px;
            height: 150px;
            background-image: radial-gradient(rgba(74, 222, 128, 0.3) 2px, transparent 2px);
            background-size: 25px 25px;
            opacity: 0.2;
            animation: pulseSoft 5s infinite alternate;
        }

        /* --- KEYFRAMES --- */
        @keyframes moveRandom1 {
            0% { transform: translate(0, 0) scale(1) rotate(0deg); }
            50% { transform: translate(-50px, 80px) scale(1.15) rotate(20deg); }
            100% { transform: translate(40px, -40px) scale(0.9) rotate(-15deg); }
        }

        @keyframes moveRandom2 {
            from { transform: rotate(0deg) translate(20px, -20px) rotate(0deg); }
            to { transform: rotate(360deg) translate(20px, -20px) rotate(-360deg); }
        }

        @keyframes moveRandom3 {
            0% { transform: translate(0,0) rotate(0deg); opacity: 0.1; }
            50% { transform: translate(70px, 50px) rotate(90deg); opacity: 0.3; }
            100% { transform: translate(-30px, 100px) rotate(180deg); opacity: 0.15; }
        }

        @keyframes rotateSmooth { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes pulseSoft { from { opacity: 0.1; transform: scale(0.95); } to { opacity: 0.3; transform: scale(1.05); } }

        /* Konten */
        .auth-content { position: relative; z-index: 10; }
        .logo-wrapper img { max-width: 140px; margin-bottom: 40px; filter: drop-shadow(0 15px 20px rgba(0,0,0,0.5)); }
        .auth-side-info h2 { font-size: 46px; font-weight: 800; color: var(--accent-green); line-height: 1; margin-bottom: 20px; }
        .auth-side-info p { font-size: 17px; opacity: 0.85; line-height: 1.6; }

        /* Sisi Kanan */
        .signin-wrapper { flex: 0 0 55%; max-width: 55%; padding: 80px 60px !important; }
        .form-wrapper h6 { font-size: 32px; font-weight: 800; margin-bottom: 5px; color: var(--text-main); }
        .input-style-1 input { border: 2px solid var(--input-border); border-radius: 16px; padding: 16px; transition: 0.3s; font-family: 'Montserrat'; }
        .input-style-1 input:focus { border-color: var(--primary-dark); box-shadow: 0 0 0 5px rgba(45, 74, 34, 0.1); outline: none; }
        
        .primary-btn { 
            background: var(--primary-dark) !important; padding: 18px; border-radius: 16px; font-weight: 800; 
            text-transform: uppercase; letter-spacing: 2px; border: none; color: white; width: 100%;
            transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); cursor: pointer;
        }
        .primary-btn:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); }

        @media (max-width: 991px) {
            .auth-row { flex-direction: column; margin: 20px; }
            .auth-side-info, .signin-wrapper { flex: 0 0 100%; max-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="auth-row animate__animated animate__fadeInUp">
        <div class="auth-side-info">
            <div class="shapes-container">
                <div class="shape-circle"></div>
                <svg class="shape-hexagon" viewBox="0 0 100 100">
                    <path d="M50 5 L90 27.5 L90 72.5 L50 95 L10 72.5 L10 27.5 Z" />
                </svg>
                <svg class="shape-triangle" viewBox="0 0 100 100">
                    <path d="M50 15 L15 85 L85 85 Z"/>
                </svg>
                <div class="shape-plus p1">+</div>
                <div class="shape-plus p2">+</div>
                <div class="shape-square"></div>
                <div class="shape-dots"></div>
            </div>
            
            <div class="auth-content animate__animated animate__fadeInLeft">
                <div class="logo-wrapper">
                    <img src="<?= base_url('assets/images/logo/1.png') ?>" alt="Logo">
                </div>
                <h2>Presence<br>System.</h2>
                <p>Ubah kedisiplinan menjadi kebiasaan dengan sistem presensi yang presisi dan transparan.</p>
                <div style="width: 60px; height: 8px; background: var(--accent-green); margin-top: 30px; border-radius: 10px;"></div>
            </div>
        </div>

        <div class="signin-wrapper">
            <div class="form-wrapper">
                <h6>Sign In</h6>
                <p class="mb-40 text-muted">Akses dashboard Anda sekarang.</p>
                
                <form method="POST" action="<?= base_url('login') ?>" id="loginForm">
                    <div class="input-style-1 mb-25">
                        <label class="fw-bold mb-2 d-block text-start">Username</label>
                        <input type="text" name="username" class="w-100" placeholder="Username Anda" required />
                    </div>
                    <div class="input-style-1 mb-35">
                        <label class="fw-bold mb-2 d-block text-start">Password</label>
                        <input type="password" name="password" class="w-100" placeholder="••••••••" required />
                    </div>
                    <button type="submit" id="btnSubmit" class="primary-btn">Masuk Sekarang</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('btnSubmit');
        form.onsubmit = function() {
            btn.innerHTML = '<span class="spinner-border spinner-border-sm mr-2"></span> PROCESSING...';
            btn.style.letterSpacing = '5px';
        };
    </script>
</body>
</html>