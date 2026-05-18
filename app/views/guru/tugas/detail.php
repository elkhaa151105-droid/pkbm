<?php require_once __DIR__.'/../../layouts/guru_header.php';?>

<div class="row g-3">
    <!-- Info Tugas -->
    <div class="col-lg-4">
        <div class="card-custom mb-3">
            <div class="card-header-custom"><h5><i class="fas fa-info-circle me-2 text-success"></i>Info Tugas</h5></div>
            <div class="card-body-custom">
                <h6 style="font-weight:700;"><?=htmlspecialchars($tugas['judul'])?></h6>
                <?php if($tugas['deskripsi']):?><p style="font-size:.875rem;color:#6b7280;"><?=nl2br(htmlspecialchars($tugas['deskripsi']))?></p><?php endif;?>
                <div class="d-flex flex-column gap-2 mt-3">
                    <div class="d-flex justify-content-between"><span class="text-muted small">Kelas:</span><span class="fw-600 small"><?=htmlspecialchars($tugas['nama_kelas']??'-')?></span></div>
                    <div class="d-flex justify-content-between"><span class="text-muted small">Mapel:</span><span class="fw-600 small"><?=htmlspecialchars($tugas['nama_mapel']??'-')?></span></div>
                    <div class="d-flex justify-content-between"><span class="text-muted small">Deadline:</span><span class="fw-600 small"><?=$tugas['deadline']?date('d M Y H:i',strtotime($tugas['deadline'])):'-'?></span></div>
                    <div class="d-flex justify-content-between"><span class="text-muted small">Terkumpul:</span><span class="badge bg-success"><?=count($pengumpulan)?> siswa</span></div>
                    <div class="d-flex justify-content-between"><span class="text-muted small">Belum Kumpul:</span><span class="badge bg-danger"><?=count($belumKumpul)?> siswa</span></div>
                </div>
                <?php if($tugas['file_soal']):?>
                <a href="<?=getFileUrl($tugas['file_soal'])?>" target="_blank" class="btn-primary-custom w-100 justify-content-center mt-3"><i class="fas fa-download"></i> Download Soal</a>
                <?php endif;?>
            </div>
        </div>

        <!-- Siswa Belum Kumpul -->
        <?php if(!empty($belumKumpul)):?>
        <div class="card-custom">
            <div class="card-header-custom"><h5><i class="fas fa-clock me-2 text-danger"></i>Belum Kumpul (<?=count($belumKumpul)?>)</h5></div>
            <div class="card-body-custom p-0">
                <?php foreach($belumKumpul as $s):?>
                <div class="d-flex align-items-center gap-2 px-3 py-2" style="border-bottom:1px solid #fef2f2;">
                    <div style="width:28px;height:28px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:#ef4444;"><?=strtoupper(substr($s['nama_lengkap'],0,1))?></div>
                    <span style="font-size:.875rem;"><?=htmlspecialchars($s['nama_lengkap'])?></span>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif;?>
    </div>

    <!-- Pengumpulan -->
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-header-custom"><h5><i class="fas fa-inbox me-2 text-success"></i>Pengumpulan Tugas (<?=count($pengumpulan)?>)</h5></div>
            <div class="card-body-custom p-0">
                <table class="table-custom w-100">
                    <thead><tr><th>Siswa</th><th>Status</th><th>Waktu</th><th>Nilai</th><th>Aksi</th></tr></thead>
                    <tbody>
                    <?php if(!empty($pengumpulan)):?>
                    <?php foreach($pengumpulan as $p):?>
                    <tr>
                        <td>
                            <div style="font-weight:600;"><?=htmlspecialchars($p['nama_lengkap'])?></div>
                            <?php if($p['file_jawaban']):?><a href="<?=getFileUrl($p['file_jawaban'])?>" target="_blank" style="font-size:.75rem;color:#059669;"><i class="fas fa-paperclip"></i> Lihat Jawaban</a><?php endif;?>
                        </td>
                        <td><span class="badge bg-<?=$p['status']==='terkumpul'?'success':($p['status']==='terlambat'?'warning':'secondary')?>"><?=ucfirst($p['status'])?></span></td>
                        <td style="font-size:.8rem;"><?=$p['submitted_at']?date('d/m H:i',strtotime($p['submitted_at'])):'-'?></td>
                        <td>
                            <?php if($p['nilai']!==null):?>
                            <span class="badge bg-<?=getGradeLabel($p['nilai'])['class']?>"><?=$p['nilai']?> (<?=getGradeLabel($p['nilai'])['label']?>)</span>
                            <?php else:?><span class="text-muted small">-</span><?php endif;?>
                        </td>
                        <td>
                            <button class="btn-icon" style="background:#eff6ff;color:#3b82f6;" data-bs-toggle="modal" data-bs-target="#nilaiModal<?=$p['id']?>" title="Beri Nilai">
                                <i class="fas fa-star"></i>
                            </button>
                            <!-- Modal Nilai -->
                            <div class="modal fade" id="nilaiModal<?=$p['id']?>" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content" style="border-radius:16px;">
                                        <div class="modal-header"><h6 class="modal-title">Nilai: <?=htmlspecialchars($p['nama_lengkap'])?></h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                        <form method="POST" action="<?=APP_URL?>/index.php?page=guru_tugas&action=nilaiTugas">
                                            <input type="hidden" name="pengumpulan_id" value="<?=$p['id']?>">
                                            <input type="hidden" name="tugas_id" value="<?=$tugas['id']?>">
                                            <div class="modal-body">
                                                <label class="form-label">Nilai (0-100)</label>
                                                <input type="number" name="nilai" class="form-control" min="0" max="100" value="<?=$p['nilai']??''?>" required>
                                                <label class="form-label mt-2">Feedback</label>
                                                <textarea name="feedback" class="form-control" rows="3"><?=htmlspecialchars($p['feedback']??'')?></textarea>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-success btn-sm">Simpan</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php else:?><tr><td colspan="5" class="text-center py-4 text-muted">Belum ada yang mengumpulkan</td></tr><?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?=APP_URL?>/index.php?page=guru_tugas" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<?php require_once __DIR__.'/../../layouts/guru_footer.php';?>
