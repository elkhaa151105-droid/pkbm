<?php
$pageTitle = 'Galeri - ' . ($settings['nama_pkbm'] ?? 'PKBM Sari Asih');
$activePage = 'galeri';
require_once __DIR__ . '/layout_header.php';

$kategoris = array_unique(array_filter(array_column($galeris, 'kategori')));
$filterKategori = $_GET['kategori'] ?? '';
$filtered = $filterKategori ? array_filter($galeris, fn($g) => $g['kategori'] === $filterKategori) : $galeris;
?>

<div style="background:linear-gradient(135deg,#1a5276,#2980b9);padding:48px 0 24px;color:white;">
    <div class="container">
        <h1 style="font-weight:800;font-size:2rem;">Galeri Kegiatan</h1>
        <p style="opacity:.7;">Dokumentasi kegiatan pembelajaran dan kegiatan PKBM</p>
    </div>
</div>

<div class="container" style="padding:48px 0;">
    <!-- Filter Kategori -->
    <?php if(!empty($kategoris)): ?>
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <a href="<?= APP_URL ?>/index.php?page=galeri" style="padding:8px 18px;border-radius:20px;font-size:.85rem;font-weight:600;text-decoration:none;background:<?= !$filterKategori?'#1a5276':'#f0f4f8' ?>;color:<?= !$filterKategori?'white':'#374151' ?>;">Semua</a>
        <?php foreach($kategoris as $k): ?>
        <a href="<?= APP_URL ?>/index.php?page=galeri&kategori=<?= urlencode($k) ?>" style="padding:8px 18px;border-radius:20px;font-size:.85rem;font-weight:600;text-decoration:none;background:<?= $filterKategori===$k?'#1a5276':'#f0f4f8' ?>;color:<?= $filterKategori===$k?'white':'#374151' ?>;">
            <?= htmlspecialchars($k) ?>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if(!empty($filtered)): ?>
    <!-- Foto Grid -->
    <?php $fotos = array_filter($filtered, fn($g) => $g['tipe'] === 'foto'); ?>
    <?php if(!empty($fotos)): ?>
    <h3 style="font-weight:700;color:#1a5276;margin-bottom:16px;"><i class="fas fa-images me-2"></i>Foto</h3>
    <div style="columns:2 200px;column-gap:12px;margin-bottom:36px;" id="fotoGrid">
        <?php foreach($fotos as $g): ?>
        <div style="break-inside:avoid;margin-bottom:12px;border-radius:12px;overflow:hidden;cursor:pointer;"
             onclick="openLightbox('<?= getFileUrl($g['file_path']) ?>','<?= htmlspecialchars($g['judul'],ENT_QUOTES) ?>')">
            <div style="position:relative;overflow:hidden;">
                <img src="<?= getFileUrl($g['file_path']) ?>" alt="<?= htmlspecialchars($g['judul']) ?>"
                     style="width:100%;display:block;transition:transform .3s;"
                     onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="position:absolute;inset:0;background:rgba(0,0,0,0);transition:background .3s;display:flex;align-items:flex-end;"
                     onmouseover="this.style.background='rgba(0,0,0,.4)'" onmouseout="this.style.background='rgba(0,0,0,0)'">
                    <div style="padding:12px;color:white;transform:translateY(100%);transition:transform .3s;" class="photo-caption">
                        <div style="font-weight:600;font-size:.85rem;"><?= htmlspecialchars($g['judul']) ?></div>
                        <?php if($g['kategori']): ?><div style="font-size:.7rem;opacity:.7;"><?= htmlspecialchars($g['kategori']) ?></div><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Video Grid -->
    <?php $videos = array_filter($filtered, fn($g) => $g['tipe'] === 'video'); ?>
    <?php if(!empty($videos)): ?>
    <h3 style="font-weight:700;color:#1a5276;margin-bottom:16px;"><i class="fas fa-video me-2"></i>Video</h3>
    <div class="row g-3">
        <?php foreach($videos as $g): ?>
        <div class="col-md-4">
            <div class="card-pub">
                <div style="background:#0f1e3d;height:200px;display:flex;align-items:center;justify-content:center;position:relative;">
                    <?php if($g['file_path']): ?>
                    <video style="width:100%;height:100%;object-fit:cover;" preload="metadata">
                        <source src="<?= getFileUrl($g['file_path']) ?>">
                    </video>
                    <?php endif; ?>
                    <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-play-circle" style="font-size:3rem;color:rgba(255,255,255,.8);"></i>
                    </div>
                </div>
                <div style="padding:14px;">
                    <h6 style="font-weight:700;margin:0;"><?= htmlspecialchars($g['judul']) ?></h6>
                    <div style="font-size:.75rem;color:#9ca3af;"><?= date('d M Y',strtotime($g['created_at'])) ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="text-center py-5">
        <i class="fas fa-images fa-3x text-muted mb-3 d-block"></i>
        <p class="text-muted">Belum ada foto/video dalam galeri</p>
    </div>
    <?php endif; ?>
</div>

<!-- Lightbox -->
<div id="lightbox" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.9);z-index:9999;display:none;align-items:center;justify-content:center;flex-direction:column;" onclick="closeLightbox()">
    <button onclick="closeLightbox()" style="position:absolute;top:20px;right:20px;background:none;border:none;color:white;font-size:1.5rem;cursor:pointer;"><i class="fas fa-times"></i></button>
    <img id="lightboxImg" src="" style="max-width:90vw;max-height:80vh;border-radius:12px;object-fit:contain;">
    <div id="lightboxCaption" style="color:white;margin-top:12px;font-weight:600;font-size:.9rem;"></div>
</div>

<script>
function openLightbox(src, caption){
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxCaption').textContent = caption;
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeLightbox(){
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeLightbox(); });
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
