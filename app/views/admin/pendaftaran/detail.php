<?php require_once __DIR__.'/../../layouts/admin_header.php';?>
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card-custom">
            <div class="card-header-custom"><h5><i class="fas fa-user me-2"></i>Data Pendaftar</h5></div>
            <div class="card-body-custom">
                <?php $fields=[['Nama Lengkap','nama_lengkap'],['Jenis Kelamin','jenis_kelamin'],['Tempat Lahir','tempat_lahir'],['Tanggal Lahir','tanggal_lahir'],['Alamat','alamat'],['No HP','no_hp'],['Email','email'],['Program','program'],['Pendidikan Terakhir','pendidikan_terakhir']]; ?>
                <?php foreach($fields as $f):?>
                <div class="row mb-2">
                    <div class="col-5 text-muted small"><?=$f[0]?></div>
                    <div class="col-7 fw-600 small"><?=htmlspecialchars($pendaftaran[$f[1]]??'-')?></div>
                </div>
                <?php endforeach;?>
                <?php if($pendaftaran['alasan']):?>
                <div class="mt-3 pt-3 border-top">
                    <p class="text-muted small mb-1">Alasan / Motivasi:</p>
                    <p style="font-size:.875rem;"><?=nl2br(htmlspecialchars($pendaftaran['alasan']))?></p>
                </div>
                <?php endif;?>
                <?php if($pendaftaran['dokumen']):?>
                <a href="<?=getFileUrl($pendaftaran['dokumen'])?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2"><i class="fas fa-file me-1"></i>Lihat Dokumen</a>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-custom">
            <div class="card-header-custom"><h5><i class="fas fa-cog me-2"></i>Update Status</h5></div>
            <div class="card-body-custom">
                <div class="mb-3 p-3 rounded-3" style="background:#f8fafc;">
                    <p class="text-muted small mb-1">Status Saat Ini:</p>
                    <?php $sc=['pending'=>'warning','diterima'=>'success','ditolak'=>'danger'][$pendaftaran['status']]??'secondary';?>
                    <span class="badge bg-<?=$sc?> fs-6"><?=ucfirst($pendaftaran['status'])?></span>
                    <?php if($pendaftaran['catatan']):?><p class="mt-2 mb-0 small text-muted"><?=htmlspecialchars($pendaftaran['catatan'])?></p><?php endif;?>
                </div>
                <form method="POST" action="<?=APP_URL?>/index.php?page=admin_pendaftaran&action=updateStatus">
                    <input type="hidden" name="id" value="<?=$pendaftaran['id']?>">
                    <div class="mb-3">
                        <label class="form-label">Ubah Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" <?=$pendaftaran['status']==='pending'?'selected':''?>>Pending</option>
                            <option value="diterima" <?=$pendaftaran['status']==='diterima'?'selected':''?>>Diterima</option>
                            <option value="ditolak" <?=$pendaftaran['status']==='ditolak'?'selected':''?>>Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3"><?=htmlspecialchars($pendaftaran['catatan']??'')?></textarea>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100 justify-content-center"><i class="fas fa-save"></i> Simpan Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="mt-3"><a href="<?=APP_URL?>/index.php?page=admin_pendaftaran" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a></div>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
