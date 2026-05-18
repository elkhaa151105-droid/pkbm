<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div style="width:40px;height:40px;background:linear-gradient(135deg,#2980b9,#f39c12);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-graduation-cap" style="color:white;"></i>
                    </div>
                    <div>
                        <div style="color:white;font-weight:700;font-size:.95rem;"><?= htmlspecialchars($settings['nama_pkbm'] ?? 'PKBM Sari Asih') ?></div>
                        <div style="font-size:.7rem;opacity:.5;">Pusat Kegiatan Belajar Masyarakat</div>
                    </div>
                </div>
                <p style="font-size:.875rem;line-height:1.6;"><?= htmlspecialchars($settings['alamat'] ?? '') ?></p>
                <div class="d-flex gap-2 mt-3">
                    <a href="tel:<?= htmlspecialchars($settings['telepon'] ?? '') ?>" style="width:34px;height:34px;background:rgba(255,255,255,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;text-decoration:none;"><i class="fas fa-phone" style="font-size:.8rem;"></i></a>
                    <a href="mailto:<?= htmlspecialchars($settings['email'] ?? '') ?>" style="width:34px;height:34px;background:rgba(255,255,255,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;text-decoration:none;"><i class="fas fa-envelope" style="font-size:.8rem;"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h5>Navigasi</h5>
                <a href="<?= APP_URL ?>">Beranda</a>
                <a href="<?= APP_URL ?>/index.php?page=profil">Profil PKBM</a>
                <a href="<?= APP_URL ?>/index.php?page=program">Program</a>
                <a href="<?= APP_URL ?>/index.php?page=berita">Berita</a>
                <a href="<?= APP_URL ?>/index.php?page=galeri">Galeri</a>
            </div>
            <div class="col-6 col-lg-2">
                <h5>Layanan</h5>
                <a href="<?= APP_URL ?>/index.php?page=daftar">Pendaftaran</a>
                <a href="<?= APP_URL ?>/index.php?page=kontak">Kontak</a>
                <a href="<?= APP_URL ?>/index.php?page=login">Portal Akademik</a>
            </div>
            <div class="col-lg-4">
                <h5>Kontak Kami</h5>
                <div style="font-size:.875rem;line-height:2;">
                    <?php if($settings['telepon'] ?? ''): ?>
                    <div><i class="fas fa-phone me-2" style="color:var(--accent);width:16px;"></i><?= htmlspecialchars($settings['telepon']) ?></div>
                    <?php endif; ?>
                    <?php if($settings['email'] ?? ''): ?>
                    <div><i class="fas fa-envelope me-2" style="color:var(--accent);width:16px;"></i><?= htmlspecialchars($settings['email']) ?></div>
                    <?php endif; ?>
                    <?php if($settings['website'] ?? ''): ?>
                    <div><i class="fas fa-globe me-2" style="color:var(--accent);width:16px;"></i><?= htmlspecialchars($settings['website']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="mt-3">
                    <a href="<?= APP_URL ?>/index.php?page=daftar" style="background:var(--accent);color:white;padding:10px 20px;border-radius:10px;text-decoration:none;font-weight:700;font-size:.875rem;display:inline-block;">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p style="margin:0;">© <?= date('Y') ?> <?= htmlspecialchars($settings['nama_pkbm'] ?? 'PKBM Sari Asih') ?>. Hak cipta dilindungi. Dibuat dengan ❤️ untuk pendidikan.</p>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
