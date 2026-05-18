<?php require_once __DIR__.'/../../layouts/admin_header.php';?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0"><?=count($gurus)?> guru terdaftar</p>
    <a href="<?=APP_URL?>/index.php?page=admin_guru&action=create" class="btn-primary-custom">
        <i class="fas fa-plus"></i> Tambah Guru
    </a>
</div>

<!-- Search -->
<div class="card-custom mb-3">
    <div class="card-body-custom">
        <form method="GET" action="<?=APP_URL?>/index.php" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="admin_guru">
            <div class="col-md-6">
                <label class="form-label">Cari Guru</label>
                <input type="text" name="search" class="form-control" placeholder="Nama atau NIP..." value="<?=htmlspecialchars($_GET['search']??'')?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Cari</button>
            </div>
        </form>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom">
        <h5><i class="fas fa-chalkboard-teacher me-2"></i>Daftar Guru</h5>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table-custom datatable w-100">
                <thead>
                    <tr><th>No</th><th>Nama Guru</th><th>NIP</th><th>Jenis Kelamin</th><th>No HP</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php if(!empty($gurus)):?>
                <?php foreach($gurus as $i=>$g):?>
                <tr>
                    <td><?=$i+1?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <?php if($g['foto']):?>
                            <img src="<?=getFileUrl($g['foto'])?>" class="rounded-circle" width="32" height="32" style="object-fit:cover;">
                            <?php else:?>
                            <div style="width:32px;height:32px;background:linear-gradient(135deg,#10b981,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:.75rem;font-weight:700;">
                                <?=strtoupper(substr($g['nama_lengkap'],0,1))?>
                            </div>
                            <?php endif;?>
                            <div>
                                <div style="font-weight:600;"><?=htmlspecialchars($g['nama_lengkap'])?></div>
                                <div style="font-size:.75rem;color:#9ca3af;"><?=htmlspecialchars($g['username']??'-')?></div>
                            </div>
                        </div>
                    </td>
                    <td><code style="font-size:.8rem;"><?=$g['nip']??'-'?></code></td>
                    <td><?=$g['jenis_kelamin']=='L'?'<span class="badge bg-primary">L</span>':'<span class="badge bg-danger">P</span>'?></td>
                    <td><?=htmlspecialchars($g['no_hp']??'-')?></td>
                    <td><span class="badge bg-<?=$g['status']=='aktif'?'success':'secondary'?>"><?=ucfirst($g['status'])?></span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="<?=APP_URL?>/index.php?page=admin_guru&action=edit&id=<?=$g['id']?>" class="btn-icon" style="background:#eff6ff;color:#3b82f6;" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="javascript:void(0)" onclick="confirmDelete('<?=APP_URL?>/index.php?page=admin_guru&action=delete&id=<?=$g['id']?>','<?=htmlspecialchars($g['nama_lengkap'],ENT_QUOTES)?>')" class="btn-icon" style="background:#fef2f2;color:#ef4444;" title="Hapus"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr><td colspan="7" class="text-center py-5"><i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Belum ada data guru</p><a href="<?=APP_URL?>/index.php?page=admin_guru&action=create" class="btn-primary-custom"><i class="fas fa-plus"></i> Tambah Guru</a></td></tr>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
