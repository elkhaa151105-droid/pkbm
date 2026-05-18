<?php require_once __DIR__.'/../../layouts/siswa_header.php';?>

<!-- Filter -->
<div class="card-custom mb-3">
    <div class="card-body-custom">
        <form method="GET" action="<?=APP_URL?>/index.php" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="siswa_materi">
            <div class="col-md-5">
                <label class="form-label">Filter Mata Pelajaran</label>
                <select name="mapel" class="form-select">
                    <option value="">Semua Mapel</option>
                    <?php foreach($mapels as $m):?>
                    <option value="<?=$m['id']?>" <?=($_GET['mapel']??'')==$m['id']?'selected':''?>><?=htmlspecialchars($m['nama_mapel'])?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filter</button></div>
        </form>
    </div>
</div>

<div class="row g-3">
<?php if(!empty($materis)):?>
<?php foreach($materis as $m):
    $iconMap=['pdf'=>['fa-file-pdf','#ef4444','#fef2f2'],'doc'=>['fa-file-word','#2563eb','#eff6ff'],'docx'=>['fa-file-word','#2563eb','#eff6ff'],'ppt'=>['fa-file-powerpoint','#d97706','#fffbeb'],'pptx'=>['fa-file-powerpoint','#d97706','#fffbeb'],'mp4'=>['fa-file-video','#7c3aed','#f5f3ff'],'zip'=>['fa-file-archive','#374151','#f9fafb']];
    $ic=$iconMap[$m['tipe_file']??'']??['fa-file','#6b7280','#f9fafb'];
?>
<div class="col-md-6 col-lg-4">
    <div class="card-custom h-100">
        <div class="card-body-custom">
            <div class="d-flex gap-3 mb-3">
                <div style="width:48px;height:48px;background:<?=$ic[2]?>;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas <?=$ic[0]?>" style="color:<?=$ic[1]?>;font-size:1.25rem;"></i>
                </div>
                <div>
                    <h6 style="font-weight:700;margin:0;"><?=htmlspecialchars($m['judul'])?></h6>
                    <div style="font-size:.75rem;color:#9ca3af;"><?=htmlspecialchars($m['nama_mapel']??'-')?></div>
                </div>
            </div>
            <?php if($m['deskripsi']):?><p style="font-size:.8rem;color:#6b7280;"><?=htmlspecialchars(substr($m['deskripsi'],0,100)).(strlen($m['deskripsi'])>100?'...':'')?></p><?php endif;?>
            <div class="d-flex justify-content-between align-items-center mt-auto">
                <span style="font-size:.75rem;color:#9ca3af;"><i class="fas fa-user me-1"></i><?=htmlspecialchars($m['nama_guru']??'')?></span>
                <?php if($m['file_path']):?>
                <a href="<?=getFileUrl($m['file_path'])?>" target="_blank" class="btn-primary-custom" style="font-size:.75rem;padding:6px 12px;">
                    <i class="fas fa-download"></i> Download
                </a>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php else:?>
<div class="col-12"><div class="card-custom"><div class="card-body-custom text-center py-5"><i class="fas fa-book-open fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Belum ada materi tersedia</p></div></div></div>
<?php endif;?>
</div>

<?php require_once __DIR__.'/../../layouts/siswa_footer.php';?>
