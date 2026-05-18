<?php
$pageTitle = htmlspecialchars($artikel['judul']) . ' - ' . ($settings['nama_pkbm'] ?? 'PKBM Sari Asih');
$activePage = 'berita';
require_once __DIR__ . '/layout_header.php';
?>

<div style="background:linear-gradient(135deg,#1a5276,#2980b9);padding:48px 0 24px;color:white;">
    <div class="container">
        <div class="mb-2">
            <a href="<?= APP_URL ?>/index.php?page=berita" style="color:rgba(255,255,255,.6);text-decoration:none;font-size:.85rem;"><i class="fas fa-arrow-left me-1"></i>Kembali ke Berita</a>
        </div>
        <span class="badge bg-<?= $artikel['kategori']==='berita'?'primary':($artikel['kategori']==='pengumuman'?'warning':'secondary') ?> mb-3"><?= ucfirst($artikel['kategori']) ?></span>
        <h1 style="font-weight:800;font-size:clamp(1.5rem,4vw,2.2rem);line-height:1.3;max-width:800px;"><?= htmlspecialchars($artikel['judul']) ?></h1>
        <div style="color:rgba(255,255,255,.6);font-size:.875rem;margin-top:12px;">
            <i class="fas fa-calendar me-1"></i><?= date('d F Y', strtotime($artikel['created_at'])) ?>
            &bull;
            <i class="fas fa-eye me-1 ms-1"></i><?= number_format($artikel['views']) ?> kali dibaca
        </div>
    </div>
</div>

<div class="container" style="padding:48px 0;">
    <div class="row g-5">
        <!-- Konten Utama -->
        <div class="col-lg-8">
            <?php if($artikel['gambar']): ?>
            <img src="<?= getFileUrl($artikel['gambar']) ?>" alt="<?= htmlspecialchars($artikel['judul']) ?>"
                 style="width:100%;border-radius:16px;margin-bottom:28px;max-height:400px;object-fit:cover;">
            <?php endif; ?>

            <div style="font-size:1rem;line-height:1.9;color:#374151;">
                <?= $artikel['konten'] ?>
            </div>

            <!-- Share -->
            <div style="margin-top:36px;padding-top:24px;border-top:1px solid #f0f0f0;">
                <p style="font-size:.875rem;font-weight:700;color:#6b7280;margin-bottom:12px;">BAGIKAN ARTIKEL:</p>
                <div class="d-flex gap-2">
                    <a href="https://wa.me/?text=<?= urlencode($artikel['judul'].' - '.APP_URL.'/index.php?page=berita_detail&slug='.$artikel['slug']) ?>"
                       target="_blank" style="background:#25d366;color:white;padding:8px 16px;border-radius:8px;font-size:.8rem;font-weight:700;text-decoration:none;">
                        <i class="fab fa-whatsapp me-1"></i>WhatsApp
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(APP_URL.'/index.php?page=berita_detail&slug='.$artikel['slug']) ?>"
                       target="_blank" style="background:#1877f2;color:white;padding:8px 16px;border-radius:8px;font-size:.8rem;font-weight:700;text-decoration:none;">
                        <i class="fab fa-facebook me-1"></i>Facebook
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card-pub" style="padding:20px;margin-bottom:20px;">
                <h5 style="font-weight:700;color:#1a5276;margin-bottom:16px;font-size:.95rem;"><i class="fas fa-newspaper me-2"></i>Artikel Terkait</h5>
                <?php if(!empty($related)): foreach($related as $r): ?>
                <div style="padding:12px 0;border-bottom:1px solid #f5f5f5;">
                    <a href="<?= APP_URL ?>/index.php?page=berita_detail&slug=<?= urlencode($r['slug']) ?>"
                       style="color:#1a2a3a;text-decoration:none;font-size:.875rem;font-weight:600;line-height:1.4;display:block;margin-bottom:4px;">
                        <?= htmlspecialchars(substr($r['judul'],0,60)).(strlen($r['judul'])>60?'...':'') ?>
                    </a>
                    <span style="font-size:.75rem;color:#9ca3af;"><?= date('d M Y',strtotime($r['created_at'])) ?></span>
                </div>
                <?php endforeach; else: ?>
                <p class="text-muted small">Tidak ada artikel terkait</p>
                <?php endif; ?>
            </div>

            <div class="card-pub" style="padding:20px;background:linear-gradient(135deg,#1a5276,#2980b9);color:white;">
                <h5 style="font-weight:700;margin-bottom:12px;font-size:.95rem;"><i class="fas fa-user-plus me-2"></i>Tertarik Bergabung?</h5>
                <p style="font-size:.85rem;opacity:.8;margin-bottom:16px;">Daftarkan diri Anda ke program pendidikan kami sekarang!</p>
                <a href="<?= APP_URL ?>/index.php?page=daftar" style="background:#f39c12;color:white;padding:10px 20px;border-radius:10px;font-weight:700;font-size:.85rem;text-decoration:none;display:block;text-align:center;">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
