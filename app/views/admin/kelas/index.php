<?php require_once __DIR__.'/../../layouts/admin_header.php';?>

<!-- Modal Tambah/Edit Kelas -->
<div class="modal fade" id="kelasModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:16px;border:none;">
        <div class="modal-header" style="background:linear-gradient(135deg,#1a5276,#2980b9);border-radius:16px 16px 0 0;">
            <h5 class="modal-title text-white"><i class="fas fa-school me-2"></i>Tambah Kelas</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="<?=APP_URL?>/index.php?page=admin_kelas&action=store">
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Nama Kelas *</label><input type="text" name="nama_kelas" class="form-control" required placeholder="cth: Paket C Tingkat I"></div>
                    <div class="col-md-6"><label class="form-label">Program</label>
                        <select name="program" class="form-select"><option value="Paket A">Paket A</option><option value="Paket B">Paket B</option><option value="Paket C" selected>Paket C</option></select>
                    </div>
                    <div class="col-md-6"><label class="form-label">Tingkat</label><input type="text" name="tingkat" class="form-control" placeholder="I, II, III"></div>
                    <div class="col-md-6"><label class="form-label">Tahun Ajaran</label><input type="text" name="tahun_ajaran" class="form-control" value="<?=getPengaturan('tahun_ajaran_aktif')?>"></div>
                    <div class="col-md-6"><label class="form-label">Wali Kelas</label>
                        <select name="wali_kelas" class="form-select"><option value="">-- Pilih Guru --</option>
                            <?php foreach($gurus as $g):?><option value="<?=$g['id']?>"><?=htmlspecialchars($g['nama_lengkap'])?></option><?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Simpan</button></div>
        </form>
    </div></div>
</div>

<div class="d-flex justify-content-between mb-4">
    <p class="text-muted mb-0"><?=count($kelass)?> kelas terdaftar</p>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#kelasModal"><i class="fas fa-plus"></i> Tambah Kelas</button>
</div>

<div class="row g-3">
<?php foreach($kelass as $k):?>
<div class="col-md-6 col-xl-4">
    <div class="card-custom">
        <div class="card-body-custom">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="badge bg-primary mb-1"><?=$k['program']?></span>
                    <h6 style="font-weight:700;margin:0;"><?=htmlspecialchars($k['nama_kelas'])?></h6>
                    <small class="text-muted">TA <?=htmlspecialchars($k['tahun_ajaran'])?></small>
                </div>
                <div style="width:48px;height:48px;background:linear-gradient(135deg,#1a5276,#2980b9);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-school" style="color:white;font-size:1.1rem;"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between text-muted small mb-3">
                <span><i class="fas fa-users me-1"></i><?=$k['jumlah_siswa']?> Siswa</span>
                <span><i class="fas fa-user-tie me-1"></i><?=htmlspecialchars($k['wali_kelas_nama']??'Belum ada')?></span>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary flex-1" onclick="editKelas(<?=htmlspecialchars(json_encode($k),ENT_QUOTES)?>)"><i class="fas fa-edit me-1"></i>Edit</button>
                <a href="javascript:void(0)" onclick="confirmDelete('<?=APP_URL?>/index.php?page=admin_kelas&action=delete&id=<?=$k['id']?>','<?=htmlspecialchars($k['nama_kelas'],ENT_QUOTES)?>')" class="btn btn-sm btn-outline-danger flex-1"><i class="fas fa-trash me-1"></i>Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php if(empty($kelass)):?>
<div class="col-12"><div class="card-custom"><div class="card-body-custom text-center py-5"><i class="fas fa-school fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Belum ada kelas</p><button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#kelasModal"><i class="fas fa-plus"></i> Tambah Kelas</button></div></div></div>
<?php endif;?>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editKelasModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:16px;border:none;">
        <div class="modal-header" style="background:linear-gradient(135deg,#1a5276,#2980b9);border-radius:16px 16px 0 0;">
            <h5 class="modal-title text-white">Edit Kelas</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="<?=APP_URL?>/index.php?page=admin_kelas&action=update">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Nama Kelas</label><input type="text" name="nama_kelas" id="edit_nama" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Program</label>
                        <select name="program" id="edit_program" class="form-select"><option value="Paket A">Paket A</option><option value="Paket B">Paket B</option><option value="Paket C">Paket C</option></select>
                    </div>
                    <div class="col-md-6"><label class="form-label">Tingkat</label><input type="text" name="tingkat" id="edit_tingkat" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Tahun Ajaran</label><input type="text" name="tahun_ajaran" id="edit_tahun" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Wali Kelas</label>
                        <select name="wali_kelas" id="edit_wali" class="form-select"><option value="">-- Pilih --</option>
                            <?php foreach($gurus as $g):?><option value="<?=$g['id']?>"><?=htmlspecialchars($g['nama_lengkap'])?></option><?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-primary-custom">Simpan</button></div>
        </form>
    </div></div>
</div>

<?php $extraScript = <<<'JS'
function editKelas(k){
    document.getElementById('edit_id').value=k.id;
    document.getElementById('edit_nama').value=k.nama_kelas;
    document.getElementById('edit_program').value=k.program;
    document.getElementById('edit_tingkat').value=k.tingkat;
    document.getElementById('edit_tahun').value=k.tahun_ajaran;
    document.getElementById('edit_wali').value=k.wali_kelas||'';
    new bootstrap.Modal(document.getElementById('editKelasModal')).show();
}
JS;?>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
