<?php
$pageTitle = 'Pendaftaran Online - ' . ($settings['nama_pkbm'] ?? 'PKBM Sari Asih');
$activePage = 'daftar';
require_once __DIR__ . '/layout_header.php';
?>

<div style="background:linear-gradient(135deg,#1a5276,#2980b9);padding:48px 0 24px;color:white;">
    <div class="container">
        <h1 style="font-weight:800;font-size:2rem;">Pendaftaran Peserta Didik Baru</h1>
        <p style="opacity:.7;">Isi formulir berikut untuk mendaftar menjadi peserta didik</p>
    </div>
</div>

<div class="container" style="padding:48px 0;">
    <?php if($success): ?>
    <div style="background:#ecfdf5;border:1px solid #a7f3d0;border-radius:16px;padding:32px;text-align:center;max-width:600px;margin:0 auto;">
        <div style="width:80px;height:80px;background:linear-gradient(135deg,#10b981,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <i class="fas fa-check" style="font-size:2rem;color:white;"></i>
        </div>
        <h3 style="font-weight:800;color:#059669;">Pendaftaran Berhasil Dikirim!</h3>
        <p style="color:#065f46;margin:12px 0;">Terima kasih telah mendaftar. Tim kami akan segera menghubungi Anda untuk proses selanjutnya.</p>
        <a href="<?= APP_URL ?>" class="btn-primary-pub" style="margin-top:8px;display:inline-flex;">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>
    <?php else: ?>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <!-- Steps -->
            <div class="d-flex justify-content-center gap-0 mb-5">
                <?php foreach(['Isi Formulir','Verifikasi','Pengumuman'] as $i=>$step): ?>
                <div style="flex:1;text-align:center;position:relative;">
                    <div style="width:36px;height:36px;border-radius:50%;background:<?= $i===0?'#1a5276':'#e5e7eb' ?>;color:<?= $i===0?'white':'#9ca3af' ?>;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;font-weight:700;font-size:.875rem;position:relative;z-index:1;"><?= $i+1 ?></div>
                    <div style="font-size:.75rem;font-weight:600;color:<?= $i===0?'#1a5276':'#9ca3af' ?>;"><?= $step ?></div>
                    <?php if($i < 2): ?><div style="position:absolute;top:18px;left:calc(50% + 18px);right:calc(-50% + 18px);height:2px;background:#e5e7eb;"></div><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="card-pub" style="padding:36px;">
                <form method="POST" action="<?= APP_URL ?>/index.php?page=daftar" enctype="multipart/form-data">

                    <!-- Data Pribadi -->
                    <h4 style="font-weight:800;color:#1a5276;margin-bottom:20px;padding-bottom:12px;border-bottom:2px solid #eff6ff;">
                        <i class="fas fa-user me-2"></i>Data Pribadi
                    </h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" required placeholder="Sesuai KTP/Akta Lahir"
                                   value="<?= htmlspecialchars($_POST['nama_lengkap'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="L" <?= ($_POST['jenis_kelamin']??'') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= ($_POST['jenis_kelamin']??'') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="<?= htmlspecialchars($_POST['tempat_lahir'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="<?= $_POST['tanggal_lahir'] ?? '' ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota"><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" class="form-control" required placeholder="08xxxxxxxxxx"
                                   value="<?= htmlspecialchars($_POST['no_hp'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="opsional@email.com"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Program -->
                    <h4 style="font-weight:800;color:#1a5276;margin-bottom:20px;padding-bottom:12px;border-bottom:2px solid #eff6ff;">
                        <i class="fas fa-graduation-cap me-2"></i>Program yang Dipilih
                    </h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Program <span class="text-danger">*</span></label>
                            <select name="program" class="form-select" required>
                                <option value="">-- Pilih Program --</option>
                                <?php foreach(['Paket A'=>'Paket A (Setara SD)','Paket B'=>'Paket B (Setara SMP)','Paket C'=>'Paket C (Setara SMA)'] as $v=>$l): ?>
                                <option value="<?= $v ?>" <?= ($_POST['program']??'')===$v?'selected':'' ?>><?= $l ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php foreach(['Tidak Sekolah','SD / Sederajat (tidak lulus)','SD / Sederajat (lulus)','SMP / Sederajat (tidak lulus)','SMP / Sederajat (lulus)','SMA / Sederajat (tidak lulus)'] as $p): ?>
                                <option value="<?=$p?>" <?=($_POST['pendidikan_terakhir']??'')===$p?'selected':''?>><?=$p?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alasan / Motivasi Mendaftar</label>
                            <textarea name="alasan" class="form-control" rows="4" placeholder="Ceritakan alasan Anda bergabung..."><?= htmlspecialchars($_POST['alasan'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Upload Dokumen</label>
                            <input type="file" name="dokumen" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted">Opsional: KTP, KK, atau ijazah terakhir (PDF/JPG, maks 10MB)</small>
                        </div>
                    </div>

                    <!-- Syarat -->
                    <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:16px;margin-bottom:24px;">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="fas fa-info-circle" style="color:#d97706;margin-top:2px;"></i>
                            <div style="font-size:.875rem;color:#92400e;">
                                <strong>Informasi:</strong> Setelah pendaftaran, tim kami akan menghubungi Anda dalam 2-3 hari kerja melalui nomor HP yang tercantum untuk konfirmasi dan jadwal wawancara.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <input type="checkbox" id="setuju" required class="form-check-input" style="width:18px;height:18px;">
                        <label for="setuju" style="font-size:.875rem;color:#374151;cursor:pointer;">
                            Saya menyatakan bahwa data yang saya isi adalah benar dan bersedia mengikuti proses seleksi.
                        </label>
                    </div>

                    <button type="submit" class="btn-primary-pub w-100 justify-content-center" style="font-size:1rem;padding:14px;">
                        <i class="fas fa-paper-plane"></i> Kirim Formulir Pendaftaran
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
