<?php
$pageTitle = 'Kontak - ' . ($settings['nama_pkbm'] ?? 'PKBM Sari Asih');
$activePage = 'kontak';
require_once __DIR__ . '/layout_header.php';
?>

<div style="background:linear-gradient(135deg,#1a5276,#2980b9);padding:48px 0 24px;color:white;">
    <div class="container">
        <h1 style="font-weight:800;font-size:2rem;">Hubungi Kami</h1>
        <p style="opacity:.7;">Kami siap membantu menjawab pertanyaan Anda</p>
    </div>
</div>

<div class="container" style="padding:48px 0;">
    <div class="row g-5">
        <!-- Form Kontak -->
        <div class="col-lg-7">
            <?php if($success): ?>
            <div style="background:#ecfdf5;border:1px solid #a7f3d0;border-radius:14px;padding:20px;margin-bottom:24px;display:flex;gap:12px;align-items:flex-start;">
                <i class="fas fa-check-circle" style="color:#059669;font-size:1.25rem;margin-top:2px;"></i>
                <div>
                    <div style="font-weight:700;color:#059669;">Pesan Terkirim!</div>
                    <div style="color:#065f46;font-size:.875rem;">Terima kasih telah menghubungi kami. Kami akan segera membalas pesan Anda.</div>
                </div>
            </div>
            <?php endif; ?>

            <div class="card-pub" style="padding:32px;">
                <h3 style="font-weight:700;color:#1a5276;margin-bottom:24px;"><i class="fas fa-paper-plane me-2"></i>Kirim Pesan</h3>
                <form method="POST" action="<?= APP_URL ?>/index.php?page=kontak">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.03em;margin-bottom:6px;">Nama Lengkap *</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama Anda"
                                   value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.03em;margin-bottom:6px;">Email *</label>
                            <input type="email" name="email" class="form-control" required placeholder="email@contoh.com"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.03em;margin-bottom:6px;">Subjek</label>
                            <input type="text" name="subjek" class="form-control" placeholder="Topik pesan Anda"
                                   value="<?= htmlspecialchars($_POST['subjek'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.03em;margin-bottom:6px;">Pesan *</label>
                            <textarea name="pesan" class="form-control" rows="6" required placeholder="Tuliskan pesan Anda..."><?= htmlspecialchars($_POST['pesan'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-primary-pub w-100 justify-content-center">
                                <i class="fas fa-paper-plane"></i> Kirim Pesan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Kontak -->
        <div class="col-lg-5">
            <h3 style="font-weight:700;color:#1a5276;margin-bottom:20px;">Informasi Kontak</h3>

            <?php foreach([
                ['fa-map-marker-alt','Alamat',$settings['alamat']??'-','#10b981'],
                ['fa-phone','Telepon',$settings['telepon']??'-','#3b82f6'],
                ['fa-envelope','Email',$settings['email']??'-','#8b5cf6'],
                ['fa-globe','Website',$settings['website']??'-','#f59e0b'],
            ] as $c): ?>
            <div style="display:flex;gap:16px;margin-bottom:20px;padding:16px;background:#f8fafc;border-radius:14px;border:1px solid #f0f0f0;">
                <div style="width:44px;height:44px;background:<?= $c[3] ?>20;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas <?= $c[0] ?>" style="color:<?= $c[3] ?>;font-size:1rem;"></i>
                </div>
                <div>
                    <div style="font-size:.75rem;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.04em;"><?= $c[1] ?></div>
                    <div style="font-weight:600;color:#1a2a3a;margin-top:2px;"><?= htmlspecialchars($c[2]) ?></div>
                </div>
            </div>
            <?php endforeach; ?>

            <div style="background:linear-gradient(135deg,#1a5276,#2980b9);border-radius:16px;padding:24px;color:white;margin-top:24px;">
                <h5 style="font-weight:700;margin-bottom:8px;"><i class="fas fa-clock me-2"></i>Jam Operasional</h5>
                <div style="font-size:.875rem;opacity:.85;line-height:2;">
                    <div>Senin - Jumat: <strong>08.00 - 17.00 WIB</strong></div>
                    <div>Sabtu: <strong>08.00 - 14.00 WIB</strong></div>
                    <div>Minggu: <strong>Libur</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
