<?php require_once __DIR__.'/../../layouts/admin_header.php';?>
<div class="card-custom mb-3">
    <div class="card-body-custom">
        <form method="GET" class="row g-2">
            <input type="hidden" name="page" value="admin_pendaftaran">
            <div class="col-md-4"><label class="form-label">Filter Status</label>
                <select name="status" class="form-select"><option value="">Semua Status</option>
                    <?php foreach(['pending'=>'Pending','diterima'=>'Diterima','ditolak'=>'Ditolak'] as $v=>$l):?><option value="<?=$v?>" <?=($status_filter==$v)?'selected':''?>><?=$l?></option><?php endforeach;?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filter</button></div>
        </form>
    </div>
</div>
<div class="card-custom">
    <div class="card-header-custom"><h5><i class="fas fa-file-alt me-2"></i>Data Pendaftaran (<?=count($pendaftarans)?>)</h5></div>
    <div class="card-body-custom p-0">
        <table class="table-custom datatable w-100">
            <thead><tr><th>No</th><th>Nama</th><th>Program</th><th>Tgl Daftar</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php if(!empty($pendaftarans)):?>
            <?php foreach($pendaftarans as $i=>$p):
                $sc=['pending'=>'warning','diterima'=>'success','ditolak'=>'danger'][$p['status']]??'secondary';
            ?>
            <tr>
                <td><?=$i+1?></td>
                <td>
                    <div style="font-weight:600;"><?=htmlspecialchars($p['nama_lengkap'])?></div>
                    <small class="text-muted"><?=htmlspecialchars($p['no_hp']??'')?></small>
                </td>
                <td><span class="badge bg-primary"><?=$p['program']?></span></td>
                <td style="font-size:.85rem;"><?=date('d M Y',strtotime($p['created_at']))?></td>
                <td><span class="badge bg-<?=$sc?>"><?=ucfirst($p['status'])?></span></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?=APP_URL?>/index.php?page=admin_pendaftaran&action=detail&id=<?=$p['id']?>" class="btn-icon" style="background:#eff6ff;color:#3b82f6;" title="Detail"><i class="fas fa-eye"></i></a>
                        <a href="javascript:void(0)" onclick="confirmDelete('<?=APP_URL?>/index.php?page=admin_pendaftaran&action=delete&id=<?=$p['id']?>','pendaftaran ini')" class="btn-icon" style="background:#fef2f2;color:#ef4444;" title="Hapus"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
            <?php else:?><tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada data pendaftaran</td></tr><?php endif;?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
