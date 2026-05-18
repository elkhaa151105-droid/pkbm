<?php require_once __DIR__.'/../../layouts/siswa_header.php';?>

<div class="row g-3">
<?php if(!empty($tugas)):?>
<?php foreach($tugas as $t):
    $isLate = $t['deadline'] && strtotime($t['deadline'])<time();
    $submitted = in_array($t['status_kumpul'],['terkumpul','terlambat']);
    $sisa = $t['deadline'] ? strtotime($t['deadline'])-time() : null;
    $urgent = $sisa!==null && $sisa<86400 && !$submitted;
?>
<div class="col-md-6 col-lg-4">
    <div class="card-custom h-100" style="<?=$urgent?'border-color:#ef4444;':''?>">
        <div class="card-body-custom">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-primary"><?=htmlspecialchars($t['nama_mapel']??'')?></span>
                <?php if($submitted):?>
                <span class="badge bg-<?=$t['status_kumpul']==='terkumpul'?'success':'warning'?>"><?=$t['status_kumpul']==='terkumpul'?'✓ Terkumpul':'⚠ Terlambat'?></span>
                <?php elseif($isLate):?>
                <span class="badge bg-danger">Terlambat</span>
                <?php else:?>
                <span class="badge bg-secondary">Belum Kumpul</span>
                <?php endif;?>
            </div>
            <h6 style="font-weight:700;margin-bottom:8px;"><?=htmlspecialchars($t['judul'])?></h6>
            <?php if($t['deskripsi']):?><p style="font-size:.8rem;color:#6b7280;margin-bottom:12px;"><?=htmlspecialchars(substr($t['deskripsi'],0,80)).'...'?></p><?php endif;?>

            <div class="d-flex flex-column gap-1 mb-3">
                <div style="font-size:.8rem;"><i class="fas fa-user me-1 text-muted"></i><?=htmlspecialchars($t['nama_guru']??'')?></div>
                <?php if($t['deadline']):?>
                <div style="font-size:.8rem;color:<?=$urgent?'#ef4444':'#6b7280'?>;"><i class="fas fa-clock me-1"></i>Deadline: <?=date('d M Y H:i',strtotime($t['deadline']))?><?=$urgent?' ⚠':''?></div>
                <?php endif;?>
                <?php if($submitted && $t['nilai']!==null): $g=getGradeLabel($t['nilai']);?>
                <div style="font-size:.8rem;font-weight:700;color:#059669;"><i class="fas fa-star me-1"></i>Nilai: <?=$t['nilai']?> (<?=$g['label']?>)</div>
                <?php endif;?>
            </div>

            <div class="d-flex gap-2">
                <?php if($t['file_soal'] ?? false):?>
                <a href="<?=getFileUrl($t['file_soal'])?>" target="_blank" class="btn btn-sm btn-outline-primary flex-1"><i class="fas fa-download me-1"></i>Soal</a>
                <?php endif;?>
                <?php if(!$isLate || !$submitted):?>
                <button class="btn btn-sm btn-<?=$submitted?'outline-success':'success'?> flex-1" data-bs-toggle="modal" data-bs-target="#kumpulModal<?=$t['id']?>">
                    <i class="fas fa-upload me-1"></i><?=$submitted?'Update':'Kumpul'?>
                </button>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kumpul -->
<div class="modal fade" id="kumpulModal<?=$t['id']?>" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:16px;border:none;">
        <div class="modal-header" style="background:linear-gradient(135deg,#1e40af,#3b82f6);border-radius:16px 16px 0 0;">
            <h6 class="modal-title text-white"><i class="fas fa-upload me-2"></i>Kumpulkan Tugas</h6>
            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="<?=APP_URL?>/index.php?page=siswa_tugas&action=kumpulkan" enctype="multipart/form-data">
            <input type="hidden" name="tugas_id" value="<?=$t['id']?>">
            <div class="modal-body">
                <p style="font-size:.875rem;font-weight:600;"><?=htmlspecialchars($t['judul'])?></p>
                <div class="mb-3">
                    <label class="form-label">Upload Jawaban</label>
                    <input type="file" name="file_jawaban" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip">
                    <small class="text-muted">PDF, Word, Gambar, ZIP (maks 10MB)</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan (opsional)</label>
                    <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan untuk guru..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i>Kumpulkan</button>
            </div>
        </form>
    </div></div>
</div>
<?php endforeach;?>
<?php else:?>
<div class="col-12"><div class="card-custom"><div class="card-body-custom text-center py-5"><i class="fas fa-tasks fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Belum ada tugas yang diberikan</p></div></div></div>
<?php endif;?>
</div>

<?php require_once __DIR__.'/../../layouts/siswa_footer.php';?>
