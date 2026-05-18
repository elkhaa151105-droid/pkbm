<?php require_once __DIR__.'/../../layouts/admin_header.php';
$isEdit = isset($artikel);
?>
<div class="row justify-content-center">
    <div class="col-xl-10">
        <form method="POST" action="<?=APP_URL?>/index.php?page=admin_artikel&action=<?=$isEdit?'update':'store'?>" enctype="multipart/form-data">
            <?php if($isEdit):?><input type="hidden" name="id" value="<?=$artikel['id']?>"><?php endif;?>
            <div class="form-section">
                <h5><i class="fas fa-newspaper me-2"></i><?=$isEdit?'Edit':'Tulis'?> Artikel</h5>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Judul Artikel *</label>
                        <input type="text" name="judul" class="form-control" value="<?=htmlspecialchars($artikel['judul']??'')?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select">
                            <?php foreach(['berita'=>'Berita','pengumuman'=>'Pengumuman','artikel'=>'Artikel'] as $v=>$l):?>
                            <option value="<?=$v?>" <?=($artikel['kategori']??'')===$v?'selected':''?>><?=$l?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft" <?=($artikel['status']??'')==='draft'?'selected':''?>>Draft</option>
                            <option value="publish" <?=($artikel['status']??'')==='publish'?'selected':''?>>Publish</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Konten Artikel *</label>
                        <textarea name="konten" id="kontenEditor" class="form-control" rows="12" style="font-family:monospace;"><?=htmlspecialchars($artikel['konten']??'')?></textarea>
                        <small class="text-muted">Mendukung HTML dasar: &lt;p&gt;, &lt;b&gt;, &lt;i&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;h3&gt;, &lt;img&gt;</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Gambar Cover</label>
                        <?php if($isEdit && $artikel['gambar']):?><div class="mb-2"><img src="<?=getFileUrl($artikel['gambar'])?>" height="100" class="rounded"></div><?php endif;?>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> <?=$isEdit?'Simpan':'Publish'?></button>
                <a href="<?=APP_URL?>/index.php?page=admin_artikel" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
