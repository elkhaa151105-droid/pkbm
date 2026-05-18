<?php require_once __DIR__.'/../../layouts/admin_header.php';
$isEdit = isset($guru);
?>
<div class="row justify-content-center">
    <div class="col-xl-8">
        <form method="POST" action="<?=APP_URL?>/index.php?page=admin_guru&action=<?=$isEdit?'update':'store'?>" enctype="multipart/form-data">
            <?php if($isEdit):?><input type="hidden" name="id" value="<?=$guru['id']?>"><?php endif;?>
            <div class="form-section">
                <h5><i class="fas fa-chalkboard-teacher me-2"></i>Data Guru</h5>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?=htmlspecialchars($guru['nama_lengkap']??'')?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="L" <?=($guru['jenis_kelamin']??'')==='L'?'selected':''?>>Laki-laki</option>
                            <option value="P" <?=($guru['jenis_kelamin']??'')==='P'?'selected':''?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control" value="<?=htmlspecialchars($guru['nip']??'')?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="<?=htmlspecialchars($guru['tempat_lahir']??'')?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?=$guru['tanggal_lahir']??''?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="<?=htmlspecialchars($guru['no_hp']??'')?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?=htmlspecialchars($guru['email']??'')?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif" <?=($guru['status']??'aktif')==='aktif'?'selected':''?>>Aktif</option>
                            <option value="nonaktif" <?=($guru['status']??'')==='nonaktif'?'selected':''?>>Non-Aktif</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3"><?=htmlspecialchars($guru['alamat']??'')?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Foto</label>
                        <?php if($isEdit && $guru['foto']):?><div class="mb-2"><img src="<?=getFileUrl($guru['foto'])?>" height="80" class="rounded"></div><?php endif;?>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="form-section mt-3">
                <h5><i class="fas fa-key me-2"></i><?=$isEdit?'Reset Password':'Akun Login'?></h5>
                <?php if(!$isEdit):?><p class="text-muted small">Username dibuat otomatis. Default password: <code>guru123</code></p><?php endif;?>
                <div class="col-md-6">
                    <label class="form-label">Password <?=$isEdit?'Baru (opsional)':''?></label>
                    <input type="password" name="<?=$isEdit?'password_baru':'password'?>" class="form-control" placeholder="<?=$isEdit?'Kosongkan jika tidak diubah':'Default: guru123'?>">
                </div>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> <?=$isEdit?'Simpan':'Tambah Guru'?></button>
                <a href="<?=APP_URL?>/index.php?page=admin_guru" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
