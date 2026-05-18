<?php require_once __DIR__.'/../../layouts/admin_header.php';?>

<div class="modal fade" id="galeriModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:16px;border:none;">
        <div class="modal-header" style="background:linear-gradient(135deg,#1a5276,#2980b9);border-radius:16px 16px 0 0;">
            <h5 class="modal-title text-white"><i class="fas fa-images me-2"></i>Tambah Galeri</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="<?=APP_URL?>/index.php?page=admin_galeri&action=store" enctype="multipart/form-data">
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Judul *</label><input type="text" name="judul" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Tipe</label>
                        <select name="tipe" class="form-select" id="tipeSelect"><option value="foto">Foto</option><option value="video">Video</option></select>
                    </div>
                    <div class="col-md-6"><label class="form-label">Kategori</label><input type="text" name="kategori" class="form-control" placeholder="cth: Kegiatan, Prestasi"></div>
                    <div class="col-12"><label class="form-label">File</label><input type="file" name="file" id="fileInput" class="form-control" accept="image/*"><small class="text-muted" id="fileHint">JPG, PNG, GIF (maks 10MB)</small></div>
                    <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="2"></textarea></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-primary-custom"><i class="fas fa-upload"></i> Upload</button></div>
        </form>
    </div></div>
</div>

<div class="d-flex justify-content-between mb-4">
    <p class="text-muted mb-0"><?=count($galeris)?> item galeri</p>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#galeriModal"><i class="fas fa-plus"></i> Tambah</button>
</div>

<div class="row g-3">
<?php if(!empty($galeris)):?>
<?php foreach($galeris as $g):?>
<div class="col-6 col-md-4 col-xl-3">
    <div class="card-custom h-100">
        <div style="height:160px;overflow:hidden;background:#f0f4f8;">
            <?php if($g['tipe']==='foto' && $g['file_path']):?>
            <img src="<?=getFileUrl($g['file_path'])?>" style="width:100%;height:100%;object-fit:cover;" alt="<?=htmlspecialchars($g['judul'])?>">
            <?php elseif($g['tipe']==='video'):?>
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#0f2033;"><i class="fas fa-play-circle fa-3x" style="color:#3b82f6;"></i></div>
            <?php else:?>
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image fa-3x text-muted"></i></div>
            <?php endif;?>
        </div>
        <div class="card-body-custom" style="padding:12px;">
            <h6 style="font-weight:600;font-size:.875rem;margin-bottom:4px;"><?=htmlspecialchars(substr($g['judul'],0,40)).(strlen($g['judul'])>40?'...':'')?></h6>
            <?php if($g['kategori']):?><span class="badge bg-secondary" style="font-size:.7rem;"><?=htmlspecialchars($g['kategori'])?></span><?php endif;?>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <small class="text-muted"><?=date('d/m/Y',strtotime($g['created_at']))?></small>
                <a href="javascript:void(0)" onclick="confirmDelete('<?=APP_URL?>/index.php?page=admin_galeri&action=delete&id=<?=$g['id']?>','<?=htmlspecialchars($g['judul'],ENT_QUOTES)?>')" class="btn-icon" style="background:#fef2f2;color:#ef4444;width:24px;height:24px;"><i class="fas fa-trash" style="font-size:.7rem;"></i></a>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php else:?><div class="col-12"><div class="card-custom"><div class="card-body-custom text-center py-5"><i class="fas fa-images fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Belum ada item galeri</p></div></div></div><?php endif;?>
</div>

<?php $extraScript=<<<'JS'
document.getElementById('tipeSelect').addEventListener('change',function(){
    var hint=document.getElementById('fileHint');
    var fi=document.getElementById('fileInput');
    if(this.value==='video'){fi.accept='.mp4,.webm';hint.textContent='MP4, WebM (maks 10MB)';}
    else{fi.accept='image/*';hint.textContent='JPG, PNG, GIF (maks 10MB)';}
});
JS;?>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
