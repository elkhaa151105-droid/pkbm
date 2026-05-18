<?php require_once __DIR__.'/../../layouts/guru_header.php';?>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:16px;border:none;">
            <div class="modal-header" style="background:linear-gradient(135deg,#065f46,#10b981);border-radius:16px 16px 0 0;">
                <h5 class="modal-title text-white"><i class="fas fa-upload me-2"></i>Upload Materi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?=APP_URL?>/index.php?page=guru_materi&action=store" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Judul Materi <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" required placeholder="Judul materi...">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select">
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach($kelass as $k):?>
                                <option value="<?=$k['id']?>"><?=htmlspecialchars($k['nama_kelas'])?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="mapel_id" class="form-select">
                                <option value="">-- Pilih Mapel --</option>
                                <?php foreach($mapels as $m):?>
                                <option value="<?=$m['id']?>"><?=htmlspecialchars($m['nama_mapel'])?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat materi..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Materi</label>
                        <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.zip">
                        <small class="text-muted">PDF, Word, PPT, Video (maks 10MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom"><i class="fas fa-upload"></i> Upload Materi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Total <?=count($materis)?> materi tersedia</p>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#uploadModal">
        <i class="fas fa-upload"></i> Upload Materi
    </button>
</div>

<!-- Materi Grid -->
<?php if(!empty($materis)):?>
<div class="row g-3">
<?php foreach($materis as $m):
    $iconMap=['pdf'=>['fa-file-pdf','#ef4444','#fef2f2'],'doc'=>['fa-file-word','#2563eb','#eff6ff'],'docx'=>['fa-file-word','#2563eb','#eff6ff'],'ppt'=>['fa-file-powerpoint','#d97706','#fffbeb'],'pptx'=>['fa-file-powerpoint','#d97706','#fffbeb'],'mp4'=>['fa-file-video','#7c3aed','#f5f3ff'],'zip'=>['fa-file-archive','#374151','#f9fafb']];
    $ic=$iconMap[$m['tipe_file']??'']??['fa-file','#6b7280','#f9fafb'];
?>
<div class="col-md-6 col-lg-4">
    <div class="card-custom h-100">
        <div class="card-body-custom">
            <div class="d-flex align-items-start gap-3 mb-3">
                <div style="width:48px;height:48px;background:<?=$ic[2]?>;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas <?=$ic[0]?>" style="color:<?=$ic[1]?>;font-size:1.25rem;"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h6 style="font-weight:700;margin:0;font-size:.9rem;line-height:1.3;"><?=htmlspecialchars($m['judul'])?></h6>
                    <div style="font-size:.75rem;color:#9ca3af;margin-top:2px;"><?=htmlspecialchars($m['nama_kelas']??'Semua Kelas')?> &bull; <?=htmlspecialchars($m['nama_mapel']??'-')?></div>
                </div>
            </div>
            <?php if($m['deskripsi']):?>
            <p style="font-size:.8rem;color:#6b7280;margin-bottom:12px;"><?=htmlspecialchars(substr($m['deskripsi'],0,80)).(strlen($m['deskripsi'])>80?'...':'')?></p>
            <?php endif;?>
            <div class="d-flex align-items-center justify-content-between mt-auto">
                <span style="font-size:.75rem;color:#9ca3af;"><?=date('d M Y',strtotime($m['created_at']))?></span>
                <div class="d-flex gap-1">
                    <?php if($m['file_path']):?>
                    <a href="<?=getFileUrl($m['file_path'])?>" target="_blank" class="btn-icon" style="background:#ecfdf5;color:#059669;" title="Download">
                        <i class="fas fa-download"></i>
                    </a>
                    <?php endif;?>
                    <a href="javascript:void(0)" onclick="confirmDelete('<?=APP_URL?>/index.php?page=guru_materi&action=delete&id=<?=$m['id']?>','<?=htmlspecialchars($m['judul'],ENT_QUOTES)?>')" class="btn-icon" style="background:#fef2f2;color:#ef4444;" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
</div>
<?php else:?>
<div class="card-custom">
    <div class="card-body-custom text-center py-5">
        <i class="fas fa-book-open fa-3x text-muted mb-3 d-block"></i>
        <h5 class="text-muted">Belum ada materi</h5>
        <p class="text-muted">Upload materi pertama Anda</p>
        <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="fas fa-upload"></i> Upload Materi
        </button>
    </div>
</div>
<?php endif;?>

<?php require_once __DIR__.'/../../layouts/guru_footer.php';?>
