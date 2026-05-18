<?php require_once __DIR__.'/../../layouts/admin_header.php';?>
<div class="d-flex justify-content-between mb-4">
    <p class="text-muted mb-0"><?=count($artikels)?> artikel</p>
    <a href="<?=APP_URL?>/index.php?page=admin_artikel&action=create" class="btn-primary-custom"><i class="fas fa-plus"></i> Tulis Artikel</a>
</div>
<div class="card-custom">
    <div class="card-body-custom p-0">
        <table class="table-custom datatable w-100">
            <thead><tr><th>No</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Penulis</th><th>Tanggal</th><th>Views</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php if(!empty($artikels)):?>
            <?php foreach($artikels as $i=>$a):?>
            <tr>
                <td><?=$i+1?></td>
                <td style="font-weight:600;max-width:200px;"><?=htmlspecialchars(substr($a['judul'],0,60)).(strlen($a['judul'])>60?'...':'')?></td>
                <td><span class="badge bg-<?=$a['kategori']==='berita'?'info':($a['kategori']==='pengumuman'?'warning':'secondary')?>"><?=ucfirst($a['kategori'])?></span></td>
                <td><span class="badge bg-<?=$a['status']==='publish'?'success':'secondary'?>"><?=ucfirst($a['status'])?></span></td>
                <td style="font-size:.85rem;"><?=htmlspecialchars($a['penulis_name']??'-')?></td>
                <td style="font-size:.85rem;"><?=date('d/m/Y',strtotime($a['created_at']))?></td>
                <td><?=$a['views']?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?=APP_URL?>/index.php?page=admin_artikel&action=edit&id=<?=$a['id']?>" class="btn-icon" style="background:#eff6ff;color:#3b82f6;"><i class="fas fa-edit"></i></a>
                        <a href="javascript:void(0)" onclick="confirmDelete('<?=APP_URL?>/index.php?page=admin_artikel&action=delete&id=<?=$a['id']?>','<?=htmlspecialchars($a['judul'],ENT_QUOTES)?>')" class="btn-icon" style="background:#fef2f2;color:#ef4444;"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
            <?php else:?><tr><td colspan="8" class="text-center py-4 text-muted">Belum ada artikel</td></tr><?php endif;?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
