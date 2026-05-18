<?php require_once __DIR__.'/../../layouts/admin_header.php';?>

<div class="card-custom mb-4">
    <div class="card-body-custom">
        <form method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="admin_absensi">
            <div class="col-md-2"><label class="form-label">Tipe</label>
                <select name="tipe" class="form-select"><option value="siswa" <?=$tipe==='siswa'?'selected':''?>>Siswa</option><option value="guru" <?=$tipe==='guru'?'selected':''?>>Guru</option></select>
            </div>
            <div class="col-md-2"><label class="form-label">Dari Tanggal</label><input type="date" name="dari" class="form-control" value="<?=$tanggal_dari?>"></div>
            <div class="col-md-2"><label class="form-label">Sampai</label><input type="date" name="sampai" class="form-control" value="<?=$tanggal_sampai?>"></div>
            <?php if($tipe==='siswa'):?>
            <div class="col-md-3"><label class="form-label">Kelas</label>
                <select name="kelas" class="form-select"><option value="">Semua Kelas</option>
                    <?php foreach($kelass as $k):?><option value="<?=$k['id']?>" <?=($kelas_filter==$k['id'])?'selected':''?>><?=htmlspecialchars($k['nama_kelas'])?></option><?php endforeach;?>
                </select>
            </div>
            <?php endif;?>
            <div class="col-md-2"><button type="submit" class="btn btn-primary w-100 mt-4"><i class="fas fa-search"></i> Tampilkan</button></div>
        </form>
    </div>
</div>

<!-- Rekap Cards -->
<div class="row g-3 mb-4">
    <?php foreach([['hadir','Hadir','#10b981','#ecfdf5','check-circle'],['sakit','Sakit','#f59e0b','#fffbeb','thermometer-half'],['izin','Izin','#3b82f6','#eff6ff','door-open'],['alpha','Alpha','#ef4444','#fef2f2','times-circle']] as $r):?>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:<?=$r[3]?>"><i class="fas fa-<?=$r[4]?>" style="color:<?=$r[2]?>"></i></div>
            <div class="stat-value" style="color:<?=$r[2]?>"><?=$rekap[$r[0]]??0?></div>
            <div class="stat-label"><?=$r[1]?></div>
        </div>
    </div>
    <?php endforeach;?>
</div>

<div class="card-custom">
    <div class="card-header-custom"><h5><i class="fas fa-clipboard-check me-2"></i>Laporan Absensi <?=ucfirst($tipe)?> (<?=count($absensi)?>)</h5></div>
    <div class="card-body-custom p-0">
        <table class="table-custom w-100" id="tabelAbsensi">
            <thead>
                <tr><th>No</th><th>Nama</th><?php if($tipe==='siswa'):?><th>Kelas</th><th>Mapel</th><?php endif;?><th>Tanggal</th><th>Status</th><th>Keterangan</th></tr>
            </thead>
            <tbody>
            <?php if(!empty($absensi)):?>
            <?php foreach($absensi as $i=>$a): $sc=['hadir'=>'success','sakit'=>'warning','izin'=>'info','alpha'=>'danger'][$a['status']]??'secondary';?>
            <tr>
                <td><?=$i+1?></td>
                <td style="font-weight:600;"><?=htmlspecialchars($a['nama'])?></td>
                <?php if($tipe==='siswa'):?><td><?=htmlspecialchars($a['nama_kelas']??'-')?></td><td><?=htmlspecialchars($a['nama_mapel']??'-')?></td><?php endif;?>
                <td><?=date('d M Y',strtotime($a['tanggal']))?></td>
                <td><span class="badge bg-<?=$sc?>"><?=ucfirst($a['status'])?></span></td>
                <td style="font-size:.875rem;"><?=htmlspecialchars($a['keterangan']??'-')?></td>
            </tr>
            <?php endforeach;?>
            <?php else:?><tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data absensi</td></tr><?php endif;?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
