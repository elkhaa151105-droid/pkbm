<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PKBM Sari Asih</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a5276;
            --primary-light: #2980b9;
            --accent: #f39c12;
            --accent-light: #f7dc6f;
            --success: #27ae60;
            --bg-dark: #0d2137;
            --bg-card: #ffffff;
            --text-muted-custom: #6c7a8d;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(ellipse at 20% 50%, rgba(26,82,118,0.6) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(41,128,185,0.4) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(243,156,18,0.15) 0%, transparent 50%);
        }

        body::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border: 1px solid rgba(255,255,255,0.04);
            border-radius: 50%;
            top: -150px;
            right: -150px;
        }

        .geo-circle {
            position: absolute;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .page-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 400px;
            padding: 12px;
            animation: slideUp 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(48px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-card {
            background: rgba(255,255,255,0.98);
            border-radius: 28px;
            overflow: hidden;
            box-shadow:
                0 40px 100px rgba(0,0,0,0.45),
                0 0 0 1px rgba(255,255,255,0.18),
                inset 0 1px 0 rgba(255,255,255,0.9);
                max-height: 90vh;   /* biar tidak melebihi layar */
            display: flex;
            flex-direction: column;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 28px 28px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
            top: -90px;
            right: -60px;
            animation: floatOrb 6s ease-in-out infinite;
        }

        .login-header::after {
            content: '';
            position: absolute;
            width: 130px;
            height: 130px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
            bottom: -45px;
            left: -35px;
            animation: floatOrb 8s ease-in-out infinite reverse;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(8px, -10px) scale(1.05); }
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.15);
            border: 2.5px solid rgba(255,255,255,0.35);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            position: relative;
            z-index: 1;
            animation: pulseLogo 3s ease-in-out infinite;
        }

        @keyframes pulseLogo {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.2); }
            50% { box-shadow: 0 0 0 10px rgba(255,255,255,0); }
        }

        .logo-circle i { font-size: 32px; color: white; }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 4px;
            position: relative;
            z-index: 1;
        }

        .login-header p {
            color: rgba(255,255,255,0.75);
            font-size: 0.875rem;
            position: relative;
            z-index: 1;
        }

        .login-body { 
            padding: 24px 28px 28px;
            overflow-y: auto;
        }

        .login-body h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a2a3a;
            margin-bottom: 6px;
        }

        .login-body p.subtitle {
            color: var(--text-muted-custom);
            font-size: 0.875rem;
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: #374151;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 14px;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.875rem;
            z-index: 2;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-group-custom:focus-within .input-icon { color: var(--primary-light); }

        .form-control-custom {
            width: 100%;
            padding: 13px 16px 13px 44px;
            border: 2px solid #e8ecf0;
            border-radius: 14px;
            font-size: 0.9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.25s ease;
            background: #f8fafc;
            color: #1a2a3a;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: var(--primary-light);
            background: white;
            box-shadow: 0 0 0 5px rgba(41,128,185,0.12);
            transform: translateY(-1px);
        }

        .form-control-custom.error {
            border-color: #ef4444;
            background: #fff5f5;
            box-shadow: 0 0 0 4px rgba(239,68,68,0.1);
            animation: shake 0.4s cubic-bezier(0.36,0.07,0.19,0.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translateX(-2px); }
            20%, 80% { transform: translateX(3px); }
            30%, 50%, 70% { transform: translateX(-4px); }
            40%, 60% { transform: translateX(4px); }
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 0;
            font-size: 0.875rem;
            z-index: 2;
        }

        .password-toggle:hover { color: var(--primary); }

        /* ===================== CAPTCHA ===================== */
        .captcha-wrapper {
            margin-bottom: 14px;
        }

        .captcha-box {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f0f7ff;
            border: 2px solid #dbeafe;
            border-radius: 14px;
            padding: 12px 16px;
            transition: border-color 0.2s;
        }

        .captcha-box:focus-within {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 5px rgba(41,128,185,0.10);
        }

        .captcha-equation {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .captcha-num {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary);
            font-family: 'Lora', serif;
            letter-spacing: -0.02em;
            min-width: 28px;
            text-align: center;
            position: relative;
        }

        /* Slight random tilt on numbers for visual interest */
        .captcha-num:first-child { transform: rotate(-2deg); display: inline-block; }
        .captcha-num:last-child  { transform: rotate(1.5deg); display: inline-block; }

        .captcha-op {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--accent);
        }

        .captcha-equals {
            font-size: 1.1rem;
            font-weight: 700;
            color: #6b7280;
        }

        .captcha-sep {
            width: 1px;
            height: 36px;
            background: #c7d9f0;
            flex-shrink: 0;
        }

        .captcha-input {
            flex: 1;
            border: none;
            background: transparent;
            font-size: 1.1rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1a2a3a;
            outline: none;
            min-width: 0;
            padding: 4px 0;
        }

        .captcha-input::placeholder { color: #bfcdd9; font-weight: 400; font-size: 0.9rem; }

        .captcha-refresh {
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            font-size: 0.9rem;
            padding: 6px;
            border-radius: 8px;
            transition: all 0.2s;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .captcha-refresh:hover {
            color: var(--primary-light);
            background: rgba(41,128,185,0.1);
        }

        .captcha-refresh.spin i {
            animation: spinOnce 0.4s ease-out;
        }

        @keyframes spinOnce {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .captcha-hint {
            font-size: 0.72rem;
            color: #9ca3af;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .captcha-hint i { font-size: 0.65rem; }

        /* captcha error state */
        .captcha-box.error {
            border-color: #ef4444;
            background: #fff5f5;
            animation: shake 0.4s cubic-bezier(0.36,0.07,0.19,0.97) both;
        }

        /* captcha success state */
        .captcha-box.success {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .captcha-check {
            color: #22c55e;
            font-size: 1rem;
            display: none;
            flex-shrink: 0;
        }

        .captcha-box.success .captcha-check { display: block; }
        .captcha-box.success .captcha-refresh { display: none; }
        /* ================================================== */

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 6px 20px rgba(26,82,118,0.45);
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 10px 28px rgba(26,82,118,0.55);
        }

        .btn-login:active { transform: translateY(0) scale(0.99); }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .alert-custom {
            padding: 12px 16px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            color: #dc2626;
            font-size: 0.875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-link { text-align: center; margin-top: 20px; }
        .back-link a {
            color: var(--primary-light);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .back-link a:hover { text-decoration: underline; }

        @media (max-height: 700px) {
            body {
                align-items: flex-start;
                padding-top: 20px;
                padding-bottom: 20px;
            }

            .login-card {
                border-radius: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="geo-circle" style="width:400px;height:400px;bottom:-100px;left:-100px;"></div>
    <div class="geo-circle" style="width:250px;height:250px;top:50px;right:80px;"></div>

    <div class="page-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-circle">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>PKBM Sari Asih</h1>
                <p>Pusat Kegiatan Belajar Masyarakat</p>
            </div>

            <div class="login-body">
                <h2>Selamat Datang 👋</h2>
                <p class="subtitle">Masuk ke akun Anda untuk melanjutkan</p>

                <?php if (!empty($error)): ?>
                <div class="alert-custom">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
                <?php endif; ?>

                <?php if ($flash = getFlash()): ?>
                <div class="alert-custom" style="background:#f0fdf4;border-color:#bbf7d0;color:#16a34a;">
                    <i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars($flash['message']) ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="<?= APP_URL ?>/index.php?page=login" id="loginForm">
                    <!-- Hidden captcha answer for server-side validation -->
                    <input type="hidden" name="captcha_answer" id="captchaAnswer">

                    <div>
                        <label class="form-label">Username</label>
                        <div class="input-group-custom">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="username" class="form-control-custom"
                                   placeholder="Masukkan username"
                                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                                   required autocomplete="username">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Password</label>
                        <div class="input-group-custom">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="passwordInput"
                                   class="form-control-custom"
                                   placeholder="Masukkan password"
                                   required autocomplete="current-password">
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- CAPTCHA -->
                    <div class="captcha-wrapper">
                        <label class="form-label">Verifikasi</label>
                        <div class="captcha-box" id="captchaBox">
                            <div class="captcha-equation">
                                <span class="captcha-num" id="capNum1"></span>
                                <span class="captcha-op" id="capOp"></span>
                                <span class="captcha-num" id="capNum2"></span>
                                <span class="captcha-equals">=</span>
                            </div>
                            <div class="captcha-sep"></div>
                            <input type="number" class="captcha-input" id="captchaInput"
                                   placeholder="Jawaban?" autocomplete="off" inputmode="numeric">
                            <i class="fas fa-check-circle captcha-check" id="captchaCheck"></i>
                            <button type="button" class="captcha-refresh" id="refreshBtn" onclick="refreshCaptcha()" title="Ganti soal">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <div class="captcha-hint">
                            <i class="fas fa-shield-alt"></i>
                            Selesaikan soal di atas untuk membuktikan Anda bukan robot
                        </div>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </button>
                </form>

                

                <div class="back-link">
                    <a href="<?= APP_URL ?>"><i class="fas fa-home me-1"></i>Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ============================================================
        // CAPTCHA — Math-based, client-side generation + validation
        // Server-side: cek $_POST['captcha_answer'] == $_SESSION['captcha']
        // ============================================================
        let captchaResult = 0;

        function generateCaptcha() {
            const ops = ['+', '-', '+', '+', '-']; // weighted: lebih banyak + agar hasil selalu positif
            const op  = ops[Math.floor(Math.random() * ops.length)];

            let a, b;
            if (op === '+') {
                a = Math.floor(Math.random() * 15) + 1;   // 1–15
                b = Math.floor(Math.random() * 15) + 1;   // 1–15
            } else {
                a = Math.floor(Math.random() * 10) + 6;   // 6–15
                b = Math.floor(Math.random() * 5)  + 1;   // 1–5 (selalu a > b)
            }

            captchaResult = op === '+' ? a + b : a - b;

            document.getElementById('capNum1').textContent = a;
            document.getElementById('capOp').textContent   = op;
            document.getElementById('capNum2').textContent = b;

            // Kirim jawaban benar ke hidden field agar bisa divalidasi server
            document.getElementById('captchaAnswer').value = captchaResult;

            // Reset state
            const box   = document.getElementById('captchaBox');
            const input = document.getElementById('captchaInput');
            box.classList.remove('error', 'success');
            input.value = '';
            input.disabled = false;
        }

        function refreshCaptcha() {
            const btn = document.getElementById('refreshBtn');
            btn.classList.add('spin');
            setTimeout(() => btn.classList.remove('spin'), 400);
            generateCaptcha();
            document.getElementById('captchaInput').focus();
        }

        // Real-time check saat user mengetik
        document.addEventListener('DOMContentLoaded', function () {
            generateCaptcha();

            const input = document.getElementById('captchaInput');
            const box   = document.getElementById('captchaBox');

            input.addEventListener('input', function () {
                const val = parseInt(this.value, 10);
                if (this.value === '') {
                    box.classList.remove('error', 'success');
                    return;
                }
                if (val === captchaResult) {
                    box.classList.remove('error');
                    box.classList.add('success');
                    input.disabled = true; // kunci setelah benar
                } else {
                    box.classList.remove('success');
                    // Tampilkan error hanya setelah user pause mengetik
                    clearTimeout(input._errorTimer);
                    input._errorTimer = setTimeout(() => {
                        if (parseInt(input.value, 10) !== captchaResult) {
                            box.classList.add('error');
                        }
                    }, 600);
                }
            });
        });

        // Validasi sebelum submit
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            const input = document.getElementById('captchaInput');
            const box   = document.getElementById('captchaBox');
            const val   = parseInt(input.value, 10);

            if (isNaN(val) || val !== captchaResult) {
                e.preventDefault();
                box.classList.remove('success');
                box.classList.add('error');
                input.focus();

                // Ganti soal setelah gagal submit
                setTimeout(refreshCaptcha, 800);
                return;
            }

            // Simpan jawaban benar ke hidden field
            document.getElementById('captchaAnswer').value = captchaResult;
        });

        // ============================================================
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        function fillDemo(username, password) {
            document.querySelector('input[name="username"]').value = username;
            document.querySelector('input[name="password"]').value  = password;
        }
    </script>
</body>
</html>