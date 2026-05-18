<?php require_once __DIR__.'/../../layouts/siswa_header.php';?>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <form method="POST" action="<?=APP_URL?>/index.php?page=siswa_profil&action=update" enctype="multipart/form-data">
            <!-- Profile Header -->
            <div class="p-4 rounded-3 mb-4 d-flex align-items-center gap-4" style="background:linear-gradient(135deg,#1e40af,#3b82f6);color:white;">
                <div style="position:relative;">
                    <?php if($siswa['foto']):?>
                    <img src="<?=getFileUrl($siswa['foto'])?>" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid rgba(255,255,255,.5);">
                    <?php else:?>
                    <div style="width:80px;height:80px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;border:3px solid rgba(255,255,255,.3);">
                        <?=strtoupper(substr($siswa['nama_lengkap'],0,1))?>
                    </div>
                    <?php endif;?>
                </div>
                <div>
                    <h4 style="font-weight:800;margin:0;"><?=htmlspecialchars($siswa['nama_lengkap'])?></h4>
                    <p style="margin:2px 0;opacity:.8;font-size:.875rem;"><?=htmlspecialchars($siswa['nama_kelas']??'')?></p>
                    <p style="margin:0;opacity:.6;font-size:.8rem;">NISN: <?=$siswa['nisn']??'-'?> | NIS: <?=$siswa['nis']??'-'?></p>
                </div>
            </div>

            <div class="form-section mb-4">
                <h5><i class="fas fa-user-edit me-2"></i>Edit Profil</h5>
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Foto Profil</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">JPG, PNG (maks 2MB)</small>
                    </div>
                    <div class="col-md-6"><label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="<?=htmlspecialchars($siswa['tempat_lahir']??'')?>">
                    </div>
                    <div class="col-md-6"><label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?=$siswa['tanggal_lahir']??''?>">
                    </div>
                    <div class="col-12"><label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3"><?=htmlspecialchars($siswa['alamat']??'')?></textarea>
                    </div>
                    <div class="col-md-6"><label class="form-label">No HP / WA</label>
                        <input type="text" name="no_hp" class="form-control" value="<?=htmlspecialchars($siswa['no_hp']??'')?>">
                    </div>
                    <div class="col-md-6"><label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?=htmlspecialchars($siswa['email']??'')?>">
                    </div>
                </div>
            </div>

            <div class="form-section mb-4">
                <h5><i class="fas fa-lock me-2"></i>Ganti Password</h5>
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label">Password Lama</label><input type="password" name="password_lama" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Password Baru</label><input type="password" name="password_baru" class="form-control" placeholder="min. 6 karakter"></div>
                    <div class="col-md-4"><label class="form-label">Konfirmasi Password</label><input type="password" name="password_konfirm" class="form-control"></div>
                </div>
                <p class="text-muted small mt-2">Kosongkan field password jika tidak ingin mengubah password.</p>
            </div>

            <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php require_once __DIR__.'/../../layouts/siswa_footer.php';?>
