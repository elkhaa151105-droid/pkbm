<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? ($settings['nama_pkbm'] ?? 'PKBM Sari Asih') ?></title>
    <meta name="description" content="<?= htmlspecialchars($settings['visi'] ?? 'PKBM Sari Asih - Pusat Kegiatan Belajar Masyarakat') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital,wght@0,600;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a5276;
            --primary-light: #2980b9;
            --accent: #f39c12;
            --font: 'Plus Jakarta Sans', sans-serif;
        }
        * { box-sizing: border-box; }
        body { font-family: var(--font); color: #1a2a3a; }

        /* NAVBAR */
        .navbar-custom {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.08);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .nav-logo {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }
        .nav-brand-text { line-height: 1.2; }
        .nav-brand-text strong { display: block; font-size: 0.9rem; font-weight: 800; color: var(--primary); }
        .nav-brand-text small { font-size: 0.65rem; color: #9ca3af; }
        .nav-link-custom {
            color: #374151 !important;
            font-size: 0.875rem;
            font-weight: 600;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .nav-link-custom:hover, .nav-link-custom.active { color: var(--primary) !important; background: #eff6ff; }
        .btn-login-nav {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white !important;
            padding: 8px 20px !important;
            border-radius: 20px !important;
        }
        .btn-login-nav:hover { opacity: 0.9; color: white !important; }

        /* FOOTER */
        .footer {
            background: #0d2137;
            color: rgba(255,255,255,0.7);
            padding: 48px 0 24px;
            margin-top: 60px;
        }
        .footer h5 { color: white; font-size: 1rem; font-weight: 700; margin-bottom: 16px; }
        .footer a { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.875rem; display: block; margin-bottom: 8px; transition: color 0.2s; }
        .footer a:hover { color: var(--accent); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); margin-top: 32px; padding-top: 20px; text-align: center; font-size: 0.8rem; }

        /* COMMON */
        .section-title { font-size: 1.75rem; font-weight: 800; color: var(--primary); margin-bottom: 8px; }
        .section-subtitle { color: #6b7280; font-size: 1rem; margin-bottom: 32px; }
        .btn-primary-pub { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: 12px 28px; border-radius: 12px; font-family: var(--font); font-weight: 700; font-size: 0.9rem; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-primary-pub:hover { color: white; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,82,118,.4); }
        .card-pub { background: white; border-radius: 16px; border: 1px solid #f0f0f0; overflow: hidden; transition: all 0.2s; }
        .card-pub:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-custom">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <a href="<?= APP_URL ?>" class="navbar-brand-custom">
                <div class="nav-logo">
                    <?php if(!empty($settings['logo'])): ?>
                    <img src="<?= getFileUrl($settings['logo']) ?>" style="width:100%;height:100%;border-radius:10px;object-fit:cover;">
                    <?php else: ?>
                    <i class="fas fa-graduation-cap"></i>
                    <?php endif; ?>
                </div>
                <div class="nav-brand-text">
                    <strong><?= htmlspecialchars($settings['nama_pkbm'] ?? 'PKBM Sari Asih') ?></strong>
                    <small>Pusat Kegiatan Belajar Masyarakat</small>
                </div>
            </a>

            <div class="d-none d-lg-flex align-items-center gap-1">
                <a href="<?= APP_URL ?>" class="nav-link-custom <?= ($activePage??'')==='home'?'active':'' ?>">Beranda</a>
                <a href="<?= APP_URL ?>/index.php?page=profil" class="nav-link-custom <?= ($activePage??'')==='profil'?'active':'' ?>">Profil</a>
                <a href="<?= APP_URL ?>/index.php?page=program" class="nav-link-custom <?= ($activePage??'')==='program'?'active':'' ?>">Program</a>
                <a href="<?= APP_URL ?>/index.php?page=berita" class="nav-link-custom <?= ($activePage??'')==='berita'?'active':'' ?>">Berita</a>
                <a href="<?= APP_URL ?>/index.php?page=galeri" class="nav-link-custom <?= ($activePage??'')==='galeri'?'active':'' ?>">Galeri</a>
                <a href="<?= APP_URL ?>/index.php?page=kontak" class="nav-link-custom <?= ($activePage??'')==='kontak'?'active':'' ?>">Kontak</a>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="<?= APP_URL ?>/index.php?page=daftar" class="btn btn-outline-primary btn-sm d-none d-md-flex" style="border-radius:20px;font-weight:600;">Daftar Sekarang</a>
                
                <button class="btn btn-sm d-lg-none" data-bs-toggle="collapse" data-bs-target="#navMenu" style="border:none;"><i class="fas fa-bars"></i></button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="collapse mt-3" id="navMenu">
            <div class="d-flex flex-column gap-1 pb-2">
                <a href="<?= APP_URL ?>" class="nav-link-custom">Beranda</a>
                <a href="<?= APP_URL ?>/index.php?page=profil" class="nav-link-custom">Profil</a>
                <a href="<?= APP_URL ?>/index.php?page=program" class="nav-link-custom">Program</a>
                <a href="<?= APP_URL ?>/index.php?page=berita" class="nav-link-custom">Berita</a>
                <a href="<?= APP_URL ?>/index.php?page=galeri" class="nav-link-custom">Galeri</a>
                <a href="<?= APP_URL ?>/index.php?page=kontak" class="nav-link-custom">Kontak</a>
            </div>
        </div>
    </div>
</nav>
