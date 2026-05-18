<?php require_once __DIR__.'/../../layouts/guru_header.php';?>

<!-- Modal Buat Tugas -->
<div class="modal fade" id="tugasModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;">
            <div class="modal-header" style="background:linear-gradient(135deg,#065f46,#10b981);border-radius:16px 16px 0 0;">
                <h5 class="modal-title text-white"><i class="fas fa-tasks me-2"></i>Buat Tugas Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?=APP_URL?>/index.php?page=guru_tugas&action=store" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Judul Tugas <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php foreach($kelass as $k):?><option value="<?=$k['id']?>"><?=htmlspecialchars($k['nama_kelas'])?></option><?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="mapel_id" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php foreach($mapels as $m):?><option value="<?=$m['id']?>"><?=htmlspecialchars($m['nama_mapel'])?></option><?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Deadline</label>
                            <input type="datetime-local" name="deadline" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Tugas</label>
                        <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Soal (opsional)</label>
                        <input type="file" name="file_soal" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Buat Tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0"><?=count($tugas)?> tugas dibuat</p>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tugasModal">
        <i class="fas fa-plus"></i> Buat Tugas Baru
    </button>
</div>

<div class="card-custom">
    <div class="card-body-custom p-0">
        <table class="table-custom datatable w-100">
            <thead>
                <tr>
                    <th>Judul Tugas</th>
                    <th>Kelas</th>
                    <th>Mapel</th>
                    <th>Deadline</th>
                    <th>Progress</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($tugas)):?>
            <?php foreach($tugas as $t):
                $isLate = $t['deadline'] && strtotime($t['deadline']) < time();
                $persen = $t['total_siswa']>0 ? round(($t['terkumpul']/$t['total_siswa'])*100) : 0;
            ?>
            <tr>
                <td>
                    <div style="font-weight:600;"><?=htmlspecialchars($t['judul'])?></div>
                    <?php if($t['file_soal']):?>
                    <a href="<?=getFileUrl($t['file_soal'])?>" target="_blank" style="font-size:.75rem;color:#059669;"><i class="fas fa-paperclip"></i> File Soal</a>
                    <?php endif;?>
                </td>
                <td><?=htmlspecialchars($t['nama_kelas']??'-')?></td>
                <td><?=htmlspecialchars($t['nama_mapel']??'-')?></td>
                <td>
                    <?php if($t['deadline']):?>
                    <span class="badge bg-<?=$isLate?'danger':'warning'?>"><?=date('d M Y H:i',strtotime($t['deadline']))?></span>
                    <?php else:?><span class="text-muted">-</span><?php endif;?>
                </td>
                <td>
                    <div style="font-size:.75rem;margin-bottom:4px;"><?=$t['terkumpul']?>/<?=$t['total_siswa']?> siswa</div>
                    <div style="height:6px;background:#e5e7eb;border-radius:3px;overflow:hidden;">
                        <div style="height:100%;width:<?=$persen?>%;background:linear-gradient(90deg,#065f46,#10b981);border-radius:3px;"></div>
                    </div>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?=APP_URL?>/index.php?page=guru_tugas&action=detail&id=<?=$t['id']?>" class="btn-icon" style="background:#ecfdf5;color:#059669;" title="Detail"><i class="fas fa-eye"></i></a>
                        <a href="javascript:void(0)" onclick="confirmDelete('<?=APP_URL?>/index.php?page=guru_tugas&action=delete&id=<?=$t['id']?>','<?=htmlspecialchars($t['judul'],ENT_QUOTES)?>')" class="btn-icon" style="background:#fef2f2;color:#ef4444;" title="Hapus"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
            <?php else:?><tr><td colspan="6" class="text-center py-4 text-muted">Belum ada tugas</td></tr><?php endif;?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__.'/../../layouts/guru_footer.php';?>
