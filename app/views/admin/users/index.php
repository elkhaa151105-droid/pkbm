<?php require_once __DIR__.'/../../layouts/admin_header.php';?>
<div class="card-custom">
    <div class="card-header-custom"><h5><i class="fas fa-users-cog me-2"></i>Manajemen User (<?=count($users)?>)</h5></div>
    <div class="card-body-custom p-0">
        <table class="table-custom datatable w-100">
            <thead><tr><th>No</th><th>Username</th><th>Nama</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach($users as $i=>$u):?>
            <tr>
                <td><?=$i+1?></td>
                <td><code><?=htmlspecialchars($u['username'])?></code></td>
                <td><?=htmlspecialchars($u['nama_lengkap']??'-')?></td>
                <td>
                    <?php $rc=['admin'=>'danger','guru'=>'success','siswa'=>'primary'][$u['role']]??'secondary';?>
                    <span class="badge bg-<?=$rc?>"><?=ucfirst($u['role'])?></span>
                </td>
                <td>
                    <span class="badge bg-<?=$u['is_active']?'success':'secondary'?>"><?=$u['is_active']?'Aktif':'Non-Aktif'?></span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <?php if($u['id']!=getCurrentUserId()):?>
                        <a href="<?=APP_URL?>/index.php?page=admin_users&action=toggleStatus&id=<?=$u['id']?>" class="btn-icon" style="background:<?=$u['is_active']?'#fef2f2':'#ecfdf5'?>;color:<?=$u['is_active']?'#ef4444':'#059669'?>;" title="<?=$u['is_active']?'Nonaktifkan':'Aktifkan'?>"><i class="fas fa-<?=$u['is_active']?'ban':'check'?>"></i></a>
                        <?php endif;?>
                        <button class="btn-icon" style="background:#fffbeb;color:#d97706;" data-bs-toggle="modal" data-bs-target="#resetModal<?=$u['id']?>" title="Reset Password"><i class="fas fa-key"></i></button>
                    </div>
                    <!-- Reset Modal -->
                    <div class="modal fade" id="resetModal<?=$u['id']?>" tabindex="-1">
                        <div class="modal-dialog modal-sm"><div class="modal-content" style="border-radius:16px;">
                            <div class="modal-header"><h6 class="modal-title">Reset: <?=htmlspecialchars($u['username'])?></h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                            <form method="POST" action="<?=APP_URL?>/index.php?page=admin_users&action=resetPassword">
                                <input type="hidden" name="id" value="<?=$u['id']?>">
                                <div class="modal-body"><label class="form-label">Password Baru</label><input type="password" name="password" class="form-control" required minlength="6"></div>
                                <div class="modal-footer"><button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-key me-1"></i>Reset</button></div>
                            </form>
                        </div></div>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
