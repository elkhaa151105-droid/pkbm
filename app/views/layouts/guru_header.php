<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Dashboard' ?> - PKBM Sari Asih Guru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --sidebar-w: 260px;
            --primary: #065f46;
            --primary-light: #10b981;
            --accent: #f59e0b;
            --sidebar-bg: #022c22;
            --font: 'Plus Jakarta Sans', sans-serif;
        }
        * { box-sizing: border-box; }
        body { font-family: var(--font); background: #f0fdf4; margin: 0; }
        .sidebar { width:var(--sidebar-w); height:100vh; background:var(--sidebar-bg); position:fixed; top:0; left:0; z-index:1000; display:flex; flex-direction:column; transition:transform .3s; overflow:hidden; }
        .sidebar-brand { padding:20px 20px 16px; border-bottom:1px solid rgba(255,255,255,0.07); display:flex; align-items:center; gap:12px; }
        .brand-icon { width:42px; height:42px; background:linear-gradient(135deg,var(--primary-light),var(--accent)); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .brand-icon i { color:white; font-size:18px; }
        .brand-text h4 { color:white; font-size:.875rem; font-weight:700; margin:0; }
        .brand-text span { color:rgba(255,255,255,.45); font-size:.7rem; }
        .sidebar-nav { flex:1; overflow-y:auto; padding:16px 0; scrollbar-width:thin; scrollbar-color:rgba(255,255,255,.1) transparent; }
        .nav-section-title { padding:8px 20px 4px; font-size:.65rem; font-weight:700; color:rgba(255,255,255,.3); text-transform:uppercase; letter-spacing:.08em; margin-top:8px; }
        .nav-item a { display:flex; align-items:center; gap:12px; padding:10px 20px; color:rgba(255,255,255,.65); text-decoration:none; font-size:.85rem; font-weight:500; transition:all .2s; border-left:3px solid transparent; }
        .nav-item a:hover { background:rgba(16,185,129,.15); color:rgba(255,255,255,.9); }
        .nav-item a.active { background:rgba(16,185,129,.25); color:white; border-left-color:var(--accent); }
        .nav-item a i { width:18px; text-align:center; font-size:.875rem; opacity:.8; }
        .sidebar-footer { padding:16px 20px; border-top:1px solid rgba(255,255,255,.07); }
        .user-info { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
        .user-avatar { width:36px; height:36px; background:linear-gradient(135deg,var(--primary-light),var(--accent)); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:.875rem; font-weight:700; flex-shrink:0; }
        .user-details h5 { color:white; font-size:.8rem; font-weight:600; margin:0; }
        .user-details span { color:rgba(255,255,255,.4); font-size:.7rem; }
        .btn-logout { display:flex; align-items:center; gap:8px; width:100%; padding:8px 12px; background:rgba(220,38,38,.15); border:1px solid rgba(220,38,38,.2); border-radius:8px; color:#fca5a5; font-size:.8rem; font-weight:600; cursor:pointer; text-decoration:none; transition:all .2s; }
        .btn-logout:hover { background:rgba(220,38,38,.25); color:#fca5a5; }
        .main-wrapper { margin-left:var(--sidebar-w); min-height:100vh; display:flex; flex-direction:column; }
        .topbar { height:60px; background:white; border-bottom:1px solid #d1fae5; display:flex; align-items:center; justify-content:space-between; padding:0 24px; position:sticky; top:0; z-index:100; }
        .page-title { font-size:1rem; font-weight:700; color:#1a2a3a; margin:0; }
        .breadcrumb-custom { font-size:.75rem; color:#9ca3af; margin:0; }
        .topbar-right { display:flex; align-items:center; gap:12px; }
        .topbar-btn { width:38px; height:38px; background:#f0fdf4; border:1px solid #d1fae5; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#6b7280; cursor:pointer; text-decoration:none; transition:all .2s; }
        .topbar-btn:hover { background:#dcfce7; color:var(--primary); }
        .hamburger { display:none; background:none; border:none; font-size:1.25rem; color:#374151; cursor:pointer; }
        .content-area { flex:1; padding:24px; }
        .stat-card { background:white; border-radius:16px; padding:22px; border:1px solid #d1fae5; transition:all .2s; height:100%; }
        .stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(0,0,0,.08); }
        .stat-icon { width:48px; height:48px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.25rem; margin-bottom:14px; }
        .stat-value { font-size:1.75rem; font-weight:800; color:#1a2a3a; line-height:1; margin-bottom:4px; }
        .stat-label { font-size:.8rem; color:#9ca3af; font-weight:500; }
        .card-custom { background:white; border-radius:16px; border:1px solid #d1fae5; overflow:hidden; }
        .card-header-custom { padding:18px 22px; border-bottom:1px solid #f0fdf4; display:flex; align-items:center; justify-content:space-between; }
        .card-header-custom h5 { font-size:.95rem; font-weight:700; color:#1a2a3a; margin:0; }
        .card-body-custom { padding:22px; }
        .table-custom { width:100%; border-collapse:separate; border-spacing:0; }
        .table-custom thead th { background:#f0fdf4; padding:12px 16px; font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:#6b7280; border-bottom:1px solid #d1fae5; }
        .table-custom tbody td { padding:12px 16px; font-size:.875rem; color:#374151; border-bottom:1px solid #f9f9f9; vertical-align:middle; }
        .table-custom tbody tr:hover { background:#f0fdf4; }
        .btn-primary-custom { background:linear-gradient(135deg,var(--primary),var(--primary-light)); color:white; border:none; padding:8px 18px; border-radius:10px; font-size:.85rem; font-weight:600; font-family:var(--font); cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .2s; }
        .btn-primary-custom:hover { transform:translateY(-1px); box-shadow:0 4px 15px rgba(6,95,70,.35); color:white; }
        .btn-icon { width:32px; height:32px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; border:none; cursor:pointer; font-size:.8rem; transition:all .15s; text-decoration:none; }
        .form-section { background:white; border-radius:16px; padding:28px; border:1px solid #d1fae5; }
        .form-section h5 { font-size:1rem; font-weight:700; color:#1a2a3a; margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #f0fdf4; }
        .form-label { font-size:.8rem; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:.03em; }
        .form-control,.form-select { font-family:var(--font); font-size:.875rem; border-radius:10px; border-color:#d1fae5; }
        .form-control:focus,.form-select:focus { border-color:var(--primary-light); box-shadow:0 0 0 3px rgba(16,185,129,.1); }
        .sidebar-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:999; }
        @media(max-width:991px) { .sidebar{transform:translateX(-100%);} .sidebar.open{transform:translateX(0);} .sidebar-overlay.active{display:block;} .main-wrapper{margin-left:0;} .hamburger{display:block;} }
        @media(max-width:768px) { .content-area{padding:16px;} }
    </style>
</head>
<body>
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="brand-text"><h4>PKBM Sari Asih</h4><span>Panel Guru</span></div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-title">Utama</div>
        <div class="nav-item"><a href="<?= APP_URL ?>/index.php?page=guru_dashboard" class="<?= strpos($page??'','dashboard')!==false?'active':'' ?>"><i class="fas fa-th-large"></i> Dashboard</a></div>
        <div class="nav-section-title">Pembelajaran</div>
        <div class="nav-item"><a href="<?= APP_URL ?>/index.php?page=guru_jadwal" class="<?= ($page??'')==='guru_jadwal'?'active':'' ?>"><i class="fas fa-calendar-alt"></i> Jadwal Mengajar</a></div>
        <div class="nav-item"><a href="<?= APP_URL ?>/index.php?page=guru_materi" class="<?= ($page??'')==='guru_materi'?'active':'' ?>"><i class="fas fa-book-open"></i> Materi</a></div>
        <div class="nav-item"><a href="<?= APP_URL ?>/index.php?page=guru_tugas" class="<?= ($page??'')==='guru_tugas'?'active':'' ?>"><i class="fas fa-tasks"></i> Tugas</a></div>
        <div class="nav-section-title">Evaluasi</div>
        <div class="nav-item"><a href="<?= APP_URL ?>/index.php?page=guru_nilai" class="<?= ($page??'')==='guru_nilai'?'active':'' ?>"><i class="fas fa-chart-bar"></i> Input Nilai</a></div>
        <div class="nav-item"><a href="<?= APP_URL ?>/index.php?page=guru_absensi" class="<?= ($page??'')==='guru_absensi'?'active':'' ?>"><i class="fas fa-clipboard-check"></i> Absensi Siswa</a></div>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar"><?= strtoupper(substr($_SESSION['nama_lengkap']??'G',0,1)) ?></div>
            <div class="user-details"><h5><?= htmlspecialchars($_SESSION['nama_lengkap']??'Guru') ?></h5><span>Guru</span></div>
        </div>
        <a href="<?= APP_URL ?>/index.php?page=logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
</aside>
<div class="main-wrapper">
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="hamburger" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <div>
                <h1 class="page-title"><?= $pageTitle??'Dashboard' ?></h1>
                <?php if(!empty($breadcrumb)): ?><div class="breadcrumb-custom"><?= $breadcrumb ?></div><?php endif; ?>
            </div>
        </div>
        <div class="topbar-right">
            <a href="<?= APP_URL ?>" target="_blank" class="topbar-btn" title="Lihat Website"><i class="fas fa-external-link-alt"></i></a>
        </div>
    </header>
    <main class="content-area">
        <?php displayFlash(); ?>
