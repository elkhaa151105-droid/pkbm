<?php require_once __DIR__.'/../../layouts/guru_header.php';?>

<div class="card-custom mb-4">
    <div class="card-body-custom">
        <form method="GET" action="<?=APP_URL?>/index.php" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="guru_absensi">
            <div class="col-md-3">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-select">
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach($kelass as $k):?>
                    <option value="<?=$k['id']?>" <?=($_GET['kelas']??'')==$k['id']?'selected':''?>><?=htmlspecialchars($k['nama_kelas'])?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?=$tanggal?>">
            </div>
            <?php if(!empty($jadwalList)):?>
            <div class="col-md-4">
                <label class="form-label">Jadwal / Mata Pelajaran</label>
                <select name="jadwal" class="form-select">
                    <option value="">-- Pilih Jadwal --</option>
                    <?php foreach($jadwalList as $j):?>
                    <option value="<?=$j['id']?>" <?=($_GET['jadwal']??'')==$j['id']?'selected':''?>><?=htmlspecialchars($j['nama_mapel'])?> (<?=substr($j['jam_mulai'],0,5)?>-<?=substr($j['jam_selesai'],0,5)?>)</option>
                    <?php endforeach;?>
                </select>
            </div>
            <?php endif;?>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Tampilkan</button>
            </div>
        </form>
    </div>
</div>

<?php if(!empty($siswas) && !empty($_GET['jadwal'])):?>
<div class="card-custom">
    <div class="card-header-custom">
        <h5><i class="fas fa-clipboard-check me-2 text-success"></i>Absensi - <?=date('l, d M Y',strtotime($tanggal))?></h5>
        <span class="badge bg-success"><?=count($siswas)?> siswa</span>
    </div>
    <form method="POST" action="<?=APP_URL?>/index.php?page=guru_absensi&action=store">
        <input type="hidden" name="kelas_id" value="<?=$_GET['kelas']??''?>">
        <input type="hidden" name="jadwal_id" value="<?=$_GET['jadwal']??''?>">
        <input type="hidden" name="tanggal" value="<?=$tanggal?>">
        <div class="table-responsive">
            <table class="table-custom w-100">
                <thead>
                    <tr>
                        <th>No</th><th>Nama Siswa</th>
                        <th>Hadir</th><th>Sakit</th><th>Izin</th><th>Alpha</th><th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($siswas as $i=>$s):
                    $existing=$absensiMap[$s['id']]??null;
                    $curStatus=$existing?$existing['status']:'hadir';
                ?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><div style="font-weight:600;"><?=htmlspecialchars($s['nama_lengkap'])?></div></td>
                    <?php foreach(['hadir'=>'success','sakit'=>'warning','izin'=>'info','alpha'=>'danger'] as $status=>$color):?>
                    <td class="text-center">
                        <input type="radio" name="absensi[<?=$s['id']?>]" value="<?=$status?>" class="form-check-input" style="width:18px;height:18px;" <?=$curStatus===$status?'checked':''?>>
                    </td>
                    <?php endforeach;?>
                    <td><input type="text" name="keterangan[<?=$s['id']?>]" class="form-control form-control-sm" value="<?=htmlspecialchars($existing?$existing['keterangan']:'')?>" placeholder="Opsional..."></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top d-flex justify-content-between align-items-center">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-success" onclick="setAll('hadir')"><i class="fas fa-check me-1"></i>Semua Hadir</button>
            </div>
            <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Simpan Absensi</button>
        </div>
    </form>
</div>
<?php elseif(isset($_GET['kelas'])):?>
<div class="card-custom"><div class="card-body-custom text-center py-5"><i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Tidak ada jadwal pada hari ini untuk kelas ini, atau pilih jadwal yang tersedia</p></div></div>
<?php else:?>
<div class="card-custom"><div class="card-body-custom text-center py-5"><i class="fas fa-filter fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Pilih kelas dan tanggal untuk mulai input absensi</p></div></div>
<?php endif;?>

<?php $extraScript = <<<'JS'
function setAll(status){
    document.querySelectorAll('[value="'+status+'"]').forEach(function(el){ el.checked=true; });
}
JS;?>
<?php require_once __DIR__.'/../../layouts/guru_footer.php';?>
