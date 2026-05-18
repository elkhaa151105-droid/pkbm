<?php require_once __DIR__.'/../../layouts/siswa_header.php';?>

<div class="card-custom mb-4">
    <div class="card-body-custom">
        <form method="GET" action="<?=APP_URL?>/index.php" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="siswa_absensi">
            <div class="col-md-4"><label class="form-label">Bulan</label><input type="month" name="bulan" class="form-control" value="<?=$bulan?>"></div>
            <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Tampilkan</button></div>
        </form>
    </div>
</div>

<!-- Rekap Cards -->
<div class="row g-3 mb-4">
    <?php
    $rekapData=[
        ['hadir','Hadir','#10b981','#ecfdf5','fa-check-circle'],
        ['sakit','Sakit','#f59e0b','#fffbeb','fa-thermometer-half'],
        ['izin','Izin','#3b82f6','#eff6ff','fa-door-open'],
        ['alpha','Alpha','#ef4444','#fef2f2','fa-times-circle'],
    ];
    foreach($rekapData as $r):?>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:<?=$r[3]?>"><i class="fas <?=$r[4]?>" style="color:<?=$r[2]?>"></i></div>
            <div class="stat-value" style="color:<?=$r[2]?>"><?=$rekap[$r[0]]??0?></div>
            <div class="stat-label"><?=$r[1]?></div>
        </div>
    </div>
    <?php endforeach;?>
</div>

<div class="card-custom">
    <div class="card-header-custom"><h5><i class="fas fa-clipboard-check me-2 text-primary"></i>Detail Absensi - <?=date('F Y',strtotime($bulan.'-01'))?></h5></div>
    <div class="card-body-custom p-0">
        <table class="table-custom datatable w-100">
            <thead><tr><th>Tanggal</th><th>Mata Pelajaran</th><th>Status</th><th>Keterangan</th></tr></thead>
            <tbody>
            <?php if(!empty($absensi)):?>
            <?php foreach($absensi as $a):
                $statusBadge=['hadir'=>'success','sakit'=>'warning','izin'=>'info','alpha'=>'danger'];
                $sc=$statusBadge[$a['status']]??'secondary';
            ?>
            <tr>
                <td><?=date('l, d M Y',strtotime($a['tanggal']))?></td>
                <td><?=htmlspecialchars($a['nama_mapel']??'Umum')?></td>
                <td><span class="badge bg-<?=$sc?>"><?=ucfirst($a['status'])?></span></td>
                <td><?=htmlspecialchars($a['keterangan']??'-')?></td>
            </tr>
            <?php endforeach;?>
            <?php else:?><tr><td colspan="4" class="text-center py-4 text-muted">Tidak ada data absensi pada bulan ini</td></tr><?php endif;?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__.'/../../layouts/siswa_footer.php';?>
