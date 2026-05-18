<?php require_once __DIR__.'/../../layouts/admin_header.php';?>

<div class="modal fade" id="mapelModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:16px;border:none;">
        <div class="modal-header" style="background:linear-gradient(135deg,#1a5276,#2980b9);border-radius:16px 16px 0 0;">
            <h5 class="modal-title text-white" id="mapelModalTitle"><i class="fas fa-book me-2"></i>Tambah Mata Pelajaran</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" id="mapelForm" action="<?=APP_URL?>/index.php?page=admin_mapel&action=store">
            <input type="hidden" name="id" id="mapel_id">
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label">Kode Mapel *</label><input type="text" name="kode_mapel" id="mapel_kode" class="form-control" required placeholder="MTK"></div>
                    <div class="col-md-8"><label class="form-label">Nama Mata Pelajaran *</label><input type="text" name="nama_mapel" id="mapel_nama" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Program</label>
                        <select name="program" id="mapel_program" class="form-select">
                            <option value="Semua">Semua Program</option>
                            <option value="Paket A">Paket A</option>
                            <option value="Paket B">Paket B</option>
                            <option value="Paket C">Paket C</option>
                        </select>
                    </div>
                    <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="deskripsi" id="mapel_desk" class="form-control" rows="3"></textarea></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Simpan</button></div>
        </form>
    </div></div>
</div>

<div class="d-flex justify-content-between mb-4">
    <p class="text-muted mb-0"><?=count($mapels)?> mata pelajaran</p>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#mapelModal"><i class="fas fa-plus"></i> Tambah Mapel</button>
</div>

<div class="card-custom">
    <div class="card-body-custom p-0">
        <table class="table-custom datatable w-100">
            <thead><tr><th>No</th><th>Kode</th><th>Nama Mapel</th><th>Program</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach($mapels as $i=>$m):?>
            <tr>
                <td><?=$i+1?></td>
                <td><span class="badge bg-secondary" style="font-family:monospace;"><?=htmlspecialchars($m['kode_mapel'])?></span></td>
                <td style="font-weight:600;"><?=htmlspecialchars($m['nama_mapel'])?></td>
                <td><span class="badge bg-<?=$m['program']=='Semua'?'secondary':($m['program']=='Paket A'?'success':($m['program']=='Paket B'?'primary':'warning'))?>"><?=$m['program']?></span></td>
                <td style="color:#6b7280;font-size:.875rem;"><?=htmlspecialchars(substr($m['deskripsi']??'',0,50)).(strlen($m['deskripsi']??'')>50?'...':'')?></td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn-icon" style="background:#eff6ff;color:#3b82f6;" onclick="editMapel(<?=htmlspecialchars(json_encode($m),ENT_QUOTES)?>)" title="Edit"><i class="fas fa-edit"></i></button>
                        <a href="javascript:void(0)" onclick="confirmDelete('<?=APP_URL?>/index.php?page=admin_mapel&action=delete&id=<?=$m['id']?>','<?=htmlspecialchars($m['nama_mapel'],ENT_QUOTES)?>')" class="btn-icon" style="background:#fef2f2;color:#ef4444;" title="Hapus"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<?php $extraScript = <<<'JS'
function editMapel(m){
    document.getElementById('mapelModalTitle').innerHTML='<i class="fas fa-edit me-2"></i>Edit Mata Pelajaran';
    document.getElementById('mapelForm').action=document.getElementById('mapelForm').action.replace('store','update');
    document.getElementById('mapel_id').value=m.id;
    document.getElementById('mapel_kode').value=m.kode_mapel;
    document.getElementById('mapel_nama').value=m.nama_mapel;
    document.getElementById('mapel_program').value=m.program;
    document.getElementById('mapel_desk').value=m.deskripsi||'';
    new bootstrap.Modal(document.getElementById('mapelModal')).show();
}
JS;?>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
