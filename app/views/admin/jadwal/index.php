<?php require_once __DIR__.'/../../layouts/admin_header.php';?>

<div class="modal fade" id="jadwalModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:16px;border:none;">
        <div class="modal-header" style="background:linear-gradient(135deg,#1a5276,#2980b9);border-radius:16px 16px 0 0;">
            <h5 class="modal-title text-white"><i class="fas fa-calendar-plus me-2"></i>Tambah Jadwal</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="<?=APP_URL?>/index.php?page=admin_jadwal&action=store">
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Kelas *</label>
                        <select name="kelas_id" class="form-select" required><option value="">-- Pilih Kelas --</option>
                            <?php foreach($kelass as $k):?><option value="<?=$k['id']?>"><?=htmlspecialchars($k['nama_kelas'])?></option><?php endforeach;?>
                        </select>
                    </div>
                    <div class="col-md-6"><label class="form-label">Mata Pelajaran *</label>
                        <select name="mapel_id" class="form-select" required><option value="">-- Pilih Mapel --</option>
                            <?php foreach($mapels as $m):?><option value="<?=$m['id']?>"><?=htmlspecialchars($m['nama_mapel'])?></option><?php endforeach;?>
                        </select>
                    </div>
                    <div class="col-md-6"><label class="form-label">Guru *</label>
                        <select name="guru_id" class="form-select" required><option value="">-- Pilih Guru --</option>
                            <?php foreach($gurus as $g):?><option value="<?=$g['id']?>"><?=htmlspecialchars($g['nama_lengkap'])?></option><?php endforeach;?>
                        </select>
                    </div>
                    <div class="col-md-4"><label class="form-label">Hari *</label>
                        <select name="hari" class="form-select" required>
                            <?php foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h):?><option value="<?=$h?>"><?=$h?></option><?php endforeach;?>
                        </select>
                    </div>
                    <div class="col-md-4"><label class="form-label">Jam Mulai *</label><input type="time" name="jam_mulai" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Jam Selesai *</label><input type="time" name="jam_selesai" class="form-control" required></div>
                    <div class="col-12"><label class="form-label">Ruangan</label><input type="text" name="ruangan" class="form-control" placeholder="cth: Ruang 1"></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Simpan</button></div>
        </form>
    </div></div>
</div>

<!-- Filter -->
<div class="card-custom mb-3">
    <div class="card-body-custom">
        <form method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="admin_jadwal">
            <div class="col-md-4"><label class="form-label">Filter Kelas</label>
                <select name="kelas" class="form-select"><option value="">Semua Kelas</option>
                    <?php foreach($kelass as $k):?><option value="<?=$k['id']?>" <?=($_GET['kelas']??'')==$k['id']?'selected':''?>><?=htmlspecialchars($k['nama_kelas'])?></option><?php endforeach;?>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-1"><i class="fas fa-filter"></i> Filter</button>
                <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#jadwalModal"><i class="fas fa-plus"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom"><h5><i class="fas fa-calendar-alt me-2"></i>Jadwal Pelajaran (<?=count($jadwals)?>)</h5></div>
    <div class="card-body-custom p-0">
        <table class="table-custom datatable w-100">
            <thead><tr><th>Hari</th><th>Kelas</th><th>Mata Pelajaran</th><th>Guru</th><th>Waktu</th><th>Ruangan</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php if(!empty($jadwals)):?>
            <?php foreach($jadwals as $j):?>
            <tr>
                <td><span class="badge bg-primary"><?=$j['hari']?></span></td>
                <td><?=htmlspecialchars($j['nama_kelas'])?></td>
                <td style="font-weight:600;"><?=htmlspecialchars($j['nama_mapel'])?></td>
                <td><?=htmlspecialchars($j['nama_guru'])?></td>
                <td style="font-size:.85rem;"><?=substr($j['jam_mulai'],0,5)?> - <?=substr($j['jam_selesai'],0,5)?></td>
                <td><?=htmlspecialchars($j['ruangan']??'-')?></td>
                <td><a href="javascript:void(0)" onclick="confirmDelete('<?=APP_URL?>/index.php?page=admin_jadwal&action=delete&id=<?=$j['id']?>','Jadwal ini')" class="btn-icon" style="background:#fef2f2;color:#ef4444;"><i class="fas fa-trash"></i></a></td>
            </tr>
            <?php endforeach;?>
            <?php else:?><tr><td colspan="7" class="text-center py-4 text-muted">Belum ada jadwal</td></tr><?php endif;?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
