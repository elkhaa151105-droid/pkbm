<?php require_once __DIR__.'/../../layouts/admin_header.php';?>
<div class="row justify-content-center">
    <div class="col-xl-9">
        <form method="POST" action="<?=APP_URL?>/index.php?page=admin_pengaturan&action=update" enctype="multipart/form-data">
            <div class="form-section mb-4">
                <h5><i class="fas fa-info-circle me-2"></i>Identitas PKBM</h5>
                <div class="row g-3">
                    <div class="col-md-8"><label class="form-label">Nama PKBM</label><input type="text" name="nama_pkbm" class="form-control" value="<?=htmlspecialchars($settingMap['nama_pkbm']??'')?>"></div>
                    <div class="col-md-4">
                        <label class="form-label">Logo PKBM</label>
                        <?php if(!empty($settingMap['logo'])):?><div class="mb-2"><img src="<?=getFileUrl($settingMap['logo'])?>" height="50" class="rounded"></div><?php endif;?>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="2"><?=htmlspecialchars($settingMap['alamat']??'')?></textarea></div>
                    <div class="col-md-4"><label class="form-label">Telepon</label><input type="text" name="telepon" class="form-control" value="<?=htmlspecialchars($settingMap['telepon']??'')?>"></div>
                    <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?=htmlspecialchars($settingMap['email']??'')?>"></div>
                    <div class="col-md-4"><label class="form-label">Website</label><input type="text" name="website" class="form-control" value="<?=htmlspecialchars($settingMap['website']??'')?>"></div>
                </div>
            </div>
            <div class="form-section mb-4">
                <h5><i class="fas fa-calendar me-2"></i>Tahun Ajaran</h5>
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label">Tahun Ajaran Aktif</label><input type="text" name="tahun_ajaran_aktif" class="form-control" value="<?=htmlspecialchars($settingMap['tahun_ajaran_aktif']??'')?>" placeholder="2024/2025"></div>
                    <div class="col-md-4"><label class="form-label">Semester Aktif</label>
                        <select name="semester_aktif" class="form-select">
                            <option value="1" <?=($settingMap['semester_aktif']??'')==='1'?'selected':''?>>Semester 1</option>
                            <option value="2" <?=($settingMap['semester_aktif']??'')==='2'?'selected':''?>>Semester 2</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-section mb-4">
                <h5><i class="fas fa-eye me-2"></i>Visi, Misi & Sejarah</h5>
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Visi</label><textarea name="visi" class="form-control" rows="3"><?=htmlspecialchars($settingMap['visi']??'')?></textarea></div>
                    <div class="col-12"><label class="form-label">Misi (pisahkan dengan | )</label><textarea name="misi" class="form-control" rows="3"><?=htmlspecialchars($settingMap['misi']??'')?></textarea><small class="text-muted">Contoh: Misi 1|Misi 2|Misi 3</small></div>
                    <div class="col-12"><label class="form-label">Sejarah</label><textarea name="sejarah" class="form-control" rows="5"><?=htmlspecialchars($settingMap['sejarah']??'')?></textarea></div>
                </div>
            </div>
            <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Simpan Pengaturan</button>
        </form>
    </div>
</div>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
