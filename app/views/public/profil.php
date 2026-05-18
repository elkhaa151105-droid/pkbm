<?php
$pageTitle = 'Profil - ' . ($settings['nama_pkbm'] ?? 'PKBM Sari Asih');
$activePage = 'profil';
require_once __DIR__ . '/layout_header.php';
$misiList = explode('|', $settings['misi'] ?? '');
?>

<div style="background:linear-gradient(135deg,#1a5276,#2980b9);padding:48px 0 24px;color:white;">
    <div class="container"><h1 style="font-weight:800;font-size:2rem;">Profil PKBM</h1><p style="opacity:.7;">Mengenal lebih dekat <?= htmlspecialchars($settings['nama_pkbm'] ?? '') ?></p></div>
</div>

<div class="container" style="padding:48px 0;">
    <div class="row g-5">
        <div class="col-lg-7">
            <h2 class="section-title">Tentang Kami</h2>
            <p style="color:#6b7280;line-height:1.8;"><?= nl2br(htmlspecialchars($settings['sejarah'] ?? '')) ?></p>

            <h3 style="font-weight:800;color:#1a5276;margin-top:36px;margin-bottom:12px;">Visi</h3>
            <div style="background:#eff6ff;border-left:4px solid #2980b9;padding:16px 20px;border-radius:0 12px 12px 0;">
                <p style="margin:0;font-style:italic;color:#1a5276;font-weight:600;"><?= htmlspecialchars($settings['visi'] ?? '') ?></p>
            </div>

            <h3 style="font-weight:800;color:#1a5276;margin-top:28px;margin-bottom:12px;">Misi</h3>
            <ul style="list-style:none;padding:0;">
                <?php foreach($misiList as $i=>$m): if(empty(trim($m))) continue; ?>
                <li style="display:flex;gap:12px;margin-bottom:10px;">
                    <div style="width:28px;height:28px;background:#2980b9;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:.75rem;font-weight:700;flex-shrink:0;"><?=$i+1?></div>
                    <span style="color:#374151;line-height:1.6;"><?= htmlspecialchars(trim($m)) ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-lg-5">
            <div class="card-pub" style="padding:28px;">
                <h4 style="font-weight:700;color:#1a5276;margin-bottom:20px;"><i class="fas fa-map-marker-alt me-2"></i>Informasi Kontak</h4>
                <?php foreach([['fa-map-marker-alt','Alamat',$settings['alamat']??''],['fa-phone','Telepon',$settings['telepon']??''],['fa-envelope','Email',$settings['email']??''],['fa-globe','Website',$settings['website']??'']] as $c): ?>
                <div style="display:flex;gap:12px;margin-bottom:14px;align-items:flex-start;">
                    <div style="width:36px;height:36px;background:#eff6ff;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas <?=$c[0]?>" style="color:#2980b9;font-size:.875rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:.75rem;color:#9ca3af;"><?=$c[1]?></div>
                        <div style="font-weight:600;color:#1a2a3a;font-size:.875rem;"><?= htmlspecialchars($c[2]) ?: '-' ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
