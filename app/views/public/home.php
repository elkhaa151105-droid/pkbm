<?php
$pageTitle = ($settings['nama_pkbm'] ?? 'PKBM Sari Asih') . ' - Beranda';
$activePage = 'home';
require_once __DIR__ . '/layout_header.php';
?>

<!-- HERO -->
<section style="background:linear-gradient(135deg,#0d2137 0%,#1a5276 50%,#2980b9 100%);padding:80px 0;position:relative;overflow:hidden;">
    <div style="position:absolute;right:-50px;top:-50px;width:400px;height:400px;background:rgba(255,255,255,.04);border-radius:50%;"></div>
    <div style="position:absolute;left:30%;bottom:-80px;width:250px;height:250px;background:rgba(243,156,18,.08);border-radius:50%;"></div>
    <div class="container" style="position:relative;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span style="background:rgba(243,156,18,.2);color:#f39c12;padding:6px 16px;border-radius:20px;font-size:.8rem;font-weight:700;display:inline-block;margin-bottom:20px;">
                    🎓 Pusat Kegiatan Belajar Masyarakat
                </span>
                <h1 style="font-size:clamp(2rem,5vw,3rem);font-weight:800;color:white;line-height:1.2;margin-bottom:16px;">
                    <?= htmlspecialchars($settings['nama_pkbm'] ?? 'PKBM Sari Asih') ?>
                </h1>
                <p style="color:rgba(255,255,255,.7);font-size:1.05rem;line-height:1.7;margin-bottom:32px;">
                    <?= htmlspecialchars(substr($settings['visi'] ?? 'Kami berkomitmen memberikan pendidikan berkualitas untuk semua.', 0, 160)) ?>
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= APP_URL ?>/index.php?page=daftar" class="btn-primary-pub">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </a>
                    <a href="<?= APP_URL ?>/index.php?page=program" style="background:rgba(255,255,255,.1);color:white;border:1px solid rgba(255,255,255,.3);padding:12px 28px;border-radius:12px;font-weight:700;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
                        <i class="fas fa-book"></i> Lihat Program
                    </a>
                </div>
                <div class="d-flex gap-4 mt-4">
                    <?php
                    try {
                        $db = Database::getInstance();
                        $totalSiswa = $db->fetchOne("SELECT COUNT(*) as c FROM siswa WHERE status='aktif'")['c'] ?? 0;
                        $totalGuru  = $db->fetchOne("SELECT COUNT(*) as c FROM guru WHERE status='aktif'")['c'] ?? 0;
                        $totalLulus = $db->fetchOne("SELECT COUNT(*) as c FROM siswa WHERE status='lulus'")['c'] ?? 0;
                    } catch(Exception $e) { $totalSiswa=$totalGuru=$totalLulus=0; }
                    ?>
                    <?php foreach([[$totalSiswa,'Siswa Aktif'],[$totalGuru,'Guru'],[$totalLulus,'Alumni']] as $s): ?>
                    <div style="text-align:center;">
                        <div style="font-size:1.5rem;font-weight:800;color:white;"><?= $s[0] ?>+</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.5);"><?= $s[1] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div style="background:rgba(255,255,255,.08);backdrop-filter:blur(10px);border-radius:24px;padding:32px;border:1px solid rgba(255,255,255,.1);">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <?php foreach([['fa-graduation-cap','#f39c12','Program Paket A, B & C'],['fa-chalkboard-teacher','#10b981','Guru Berpengalaman'],['fa-book-open','#3b82f6','Materi Digital'],['fa-certificate','#8b5cf6','Setara Ijazah Formal']] as $f): ?>
                        <div style="background:rgba(255,255,255,.08);border-radius:16px;padding:20px;text-align:center;">
                            <i class="fas <?=$f[0]?>" style="font-size:1.75rem;color:<?=$f[1]?>;margin-bottom:10px;display:block;"></i>
                            <div style="color:white;font-size:.8rem;font-weight:600;"><?=$f[2]?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROGRAM -->
<section style="padding:60px 0;background:#f8fafc;">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Program Pendidikan</h2>
            <p class="section-subtitle">Kami menyediakan tiga jalur pendidikan kesetaraan bagi semua kalangan</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach([
                ['Paket A','Setara SD','fa-child','#10b981','#ecfdf5','Program kesetaraan Sekolah Dasar (SD). Cocok bagi yang belum menyelesaikan pendidikan dasar.','6 Tahun'],
                ['Paket B','Setara SMP','fa-user-graduate','#3b82f6','#eff6ff','Program kesetaraan Sekolah Menengah Pertama (SMP). Lanjutkan pendidikan Anda ke jenjang lebih tinggi.','3 Tahun'],
                ['Paket C','Setara SMA','fa-university','#8b5cf6','#f5f3ff','Program kesetaraan Sekolah Menengah Atas (SMA). Raih ijazah setara SMA untuk masa depan cerah.','3 Tahun'],
            ] as $p): ?>
            <div class="col-md-4">
                <div class="card-pub h-100">
                    <div style="padding:28px 24px 0;text-align:center;">
                        <div style="width:64px;height:64px;background:<?=$p[4]?>;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                            <i class="fas <?=$p[2]?>" style="font-size:1.5rem;color:<?=$p[3]?>;"></i>
                        </div>
                        <span style="background:<?=$p[3]?>;color:white;padding:4px 14px;border-radius:20px;font-size:.75rem;font-weight:700;"><?=$p[1]?></span>
                        <h3 style="font-size:1.35rem;font-weight:800;margin-top:12px;color:#1a2a3a;"><?=$p[0]?></h3>
                        <p style="color:#6b7280;font-size:.875rem;line-height:1.6;"><?=$p[5]?></p>
                    </div>
                    <div style="padding:0 24px 24px;">
                        <div style="background:#f8fafc;border-radius:10px;padding:10px 16px;text-align:center;margin-bottom:16px;">
                            <span style="font-size:.8rem;color:#9ca3af;">Durasi Belajar</span>
                            <div style="font-weight:700;color:#1a2a3a;"><?=$p[6]?></div>
                        </div>
                        <a href="<?= APP_URL ?>/index.php?page=program" class="btn-primary-pub w-100 justify-content-center">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- BERITA TERBARU -->
<?php if(!empty($artikels)): ?>
<section style="padding:60px 0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title mb-1">Berita & Pengumuman</h2>
                <p class="section-subtitle mb-0">Informasi terkini dari PKBM Sari Asih</p>
            </div>
            <a href="<?= APP_URL ?>/index.php?page=berita" class="btn-primary-pub">Lihat Semua</a>
        </div>
        <div class="row g-4">
            <?php foreach($artikels as $a): ?>
            <div class="col-md-4">
                <div class="card-pub h-100">
                    <?php if($a['gambar']): ?>
                    <img src="<?= getFileUrl($a['gambar']) ?>" alt="<?=htmlspecialchars($a['judul'])?>" style="width:100%;height:180px;object-fit:cover;">
                    <?php else: ?>
                    <div style="width:100%;height:180px;background:linear-gradient(135deg,#1a5276,#2980b9);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-newspaper fa-3x" style="color:rgba(255,255,255,.3);"></i>
                    </div>
                    <?php endif; ?>
                    <div style="padding:20px;">
                        <span class="badge bg-<?=$a['kategori']==='berita'?'primary':($a['kategori']==='pengumuman'?'warning':'secondary')?> mb-2"><?=ucfirst($a['kategori'])?></span>
                        <h5 style="font-weight:700;font-size:1rem;margin-bottom:8px;line-height:1.4;">
                            <a href="<?= APP_URL ?>/index.php?page=berita_detail&slug=<?= urlencode($a['slug']) ?>" style="color:#1a2a3a;text-decoration:none;"><?= htmlspecialchars(substr($a['judul'],0,60)).(strlen($a['judul'])>60?'...':'') ?></a>
                        </h5>
                        <p style="color:#6b7280;font-size:.85rem;margin-bottom:12px;"><?= htmlspecialchars(strip_tags(substr($a['konten']??'',0,100))).'...' ?></p>
                        <div style="font-size:.75rem;color:#9ca3af;"><?= date('d F Y',strtotime($a['created_at'])) ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- GALERI -->
<?php if(!empty($galeris)): ?>
<section style="padding:60px 0;background:#f8fafc;">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Galeri Kegiatan</h2>
            <p class="section-subtitle">Dokumentasi kegiatan belajar mengajar di PKBM Sari Asih</p>
        </div>
        <div class="row g-3">
            <?php foreach(array_slice($galeris, 0, 8) as $g): ?>
            <div class="col-6 col-md-3">
                <div style="border-radius:12px;overflow:hidden;height:160px;background:#e5e7eb;">
                    <?php if($g['file_path'] && $g['tipe']==='foto'): ?>
                    <img src="<?= getFileUrl($g['file_path']) ?>" alt="<?=htmlspecialchars($g['judul'])?>" style="width:100%;height:100%;object-fit:cover;transition:transform .3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <?php else: ?>
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#0f2033;">
                        <i class="fas fa-play-circle fa-2x" style="color:#3b82f6;"></i>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= APP_URL ?>/index.php?page=galeri" class="btn-primary-pub"><i class="fas fa-images"></i> Lihat Semua Galeri</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section style="padding:60px 0;background:linear-gradient(135deg,#1a5276,#2980b9);">
    <div class="container text-center">
        <h2 style="font-size:2rem;font-weight:800;color:white;margin-bottom:12px;">Siap Melanjutkan Pendidikan?</h2>
        <p style="color:rgba(255,255,255,.7);font-size:1rem;margin-bottom:28px;">Daftarkan diri Anda sekarang dan mulai perjalanan pendidikan bersama kami</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?= APP_URL ?>/index.php?page=daftar" style="background:var(--accent);color:white;padding:14px 32px;border-radius:12px;font-weight:700;font-size:.95rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
            <a href="<?= APP_URL ?>/index.php?page=kontak" style="background:rgba(255,255,255,.1);color:white;border:1px solid rgba(255,255,255,.3);padding:14px 32px;border-radius:12px;font-weight:700;font-size:.95rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-phone"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
