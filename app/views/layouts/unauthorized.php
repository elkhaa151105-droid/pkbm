<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - PKBM Sari Asih</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f8; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .box { background: white; border-radius: 24px; padding: 48px; text-align: center; max-width: 440px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.08); }
        .icon { width: 80px; height: 80px; background: #fef2f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; }
        h1 { font-size: 1.5rem; font-weight: 800; color: #1a2a3a; margin-bottom: 8px; }
        p { color: #6b7280; margin-bottom: 28px; line-height: 1.6; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: .875rem; transition: all .2s; }
        .btn-primary { background: linear-gradient(135deg,#1a5276,#2980b9); color: white; }
        .btn-secondary { background: #f0f4f8; color: #374151; margin-left: 8px; }
        .btn:hover { transform: translateY(-1px); }
    </style>
</head>
<body>
    <div class="box">
        <div class="icon">
            <i class="fas fa-lock" style="font-size:2rem;color:#ef4444;"></i>
        </div>
        <h1>Akses Ditolak</h1>
        <p>Anda tidak memiliki izin untuk mengakses halaman ini. Pastikan Anda login dengan akun yang sesuai.</p>
        <div>
            <a href="<?= defined('APP_URL') ? APP_URL : '/pkbm' ?>/index.php?page=login" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a href="<?= defined('APP_URL') ? APP_URL : '/pkbm' ?>" class="btn btn-secondary">
                <i class="fas fa-home"></i> Beranda
            </a>
        </div>
    </div>
</body>
</html>
