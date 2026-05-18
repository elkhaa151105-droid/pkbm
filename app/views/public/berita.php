<?php
$pageTitle = 'Berita - ' . ($settings['nama_pkbm'] ?? 'PKBM Sari Asih');
$activePage = 'berita';
require_once __DIR__ . '/layout_header.php';
?>
<div style="background:linear-gradient(135deg,#1a5276,#2980b9);padding:48px 0 24px;color:white;">
    <div class="container"><h1 style="font-weight:800;font-size:2rem;">Berita & Pengumuman</h1></div>
</div>
<div class="container" style="padding:48px 0;">
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <?php foreach([''=>'Semua','berita'=>'Berita','pengumuman'=>'Pengumuman','artikel'=>'Artikel'] as $v=>$l): ?>
        <a href="<?=APP_URL?>/index.php?page=berita<?=$v?"&kategori=$v":''?>" style="padding:8px 18px;border-radius:20px;font-size:.85rem;font-weight:600;text-decoration:none;background:<?=($kategori??'')===$v?'#1a5276':'#f0f4f8'?>;color:<?=($kategori??'')===$v?'white':'#374151'?>;"><?=$l?></a>
        <?php endforeach; ?>
    </div>
    <div class="row g-4">
        <?php if(!empty($artikels)): foreach($artikels as $a): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card-pub h-100">
                <?php if($a['gambar']): ?><img src="<?=getFileUrl($a['gambar'])?>" style="width:100%;height:180px;object-fit:cover;" alt="">
                <?php else: ?><div style="width:100%;height:180px;background:linear-gradient(135deg,#1a5276,#2980b9);display:flex;align-items:center;justify-content:center;"><i class="fas fa-newspaper fa-2x" style="color:rgba(255,255,255,.3);"></i></div><?php endif; ?>
                <div style="padding:20px;">
                    <span class="badge bg-<?=$a['kategori']==='berita'?'primary':($a['kategori']==='pengumuman'?'warning':'secondary')?> mb-2"><?=ucfirst($a['kategori'])?></span>
                    <h5 style="font-weight:700;font-size:1rem;line-height:1.4;"><a href="<?=APP_URL?>/index.php?page=berita_detail&slug=<?=urlencode($a['slug'])?>" style="color:#1a2a3a;text-decoration:none;"><?=htmlspecialchars(substr($a['judul'],0,70)).(strlen($a['judul'])>70?'...':'')?></a></h5>
                    <p style="color:#6b7280;font-size:.85rem;"><?=htmlspecialchars(strip_tags(substr($a['konten']??'',0,100))).'...'?></p>
                    <div style="font-size:.75rem;color:#9ca3af;"><?=date('d F Y',strtotime($a['created_at']))?></div>
                </div>
            </div>
        </div>
        <?php endforeach; else: ?>
        <div class="col-12 text-center py-5"><i class="fas fa-newspaper fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Belum ada berita</p></div>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/layout_footer.php'; ?>
