<?php require_once __DIR__.'/../../layouts/siswa_header.php';?>

<!-- Filter -->
<div class="card-custom mb-4">
    <div class="card-body-custom">
        <form method="GET" action="<?=APP_URL?>/index.php" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="siswa_nilai">
            <div class="col-md-3"><label class="form-label">Semester</label>
                <select name="semester" class="form-select">
                    <option value="1" <?=($semester??'')==='1'?'selected':''?>>Semester 1</option>
                    <option value="2" <?=($semester??'')==='2'?'selected':''?>>Semester 2</option>
                </select>
            </div>
            <div class="col-md-3"><label class="form-label">Tahun Ajaran</label><input type="text" name="tahun" class="form-control" value="<?=htmlspecialchars($tahun??'')?>"></div>
            <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Tampilkan</button></div>
        </form>
    </div>
</div>

<?php if(!empty($nilais)):?>
<!-- Rata-rata Banner -->
<div class="p-4 rounded-3 mb-4" style="background:linear-gradient(135deg,#1e40af,#3b82f6);color:white;">
    <div class="row align-items-center">
        <div class="col">
            <p style="margin:0;opacity:.8;font-size:.875rem;">Rata-rata Nilai Akhir</p>
            <div style="font-size:2.5rem;font-weight:800;"><?=round($rataRata,1)?></div>
        </div>
        <div class="col-auto">
            <?php $g=getGradeLabel($rataRata); ?>
            <div style="width:64px;height:64px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.75rem;font-weight:800;">
                <?=$g['label']?>
            </div>
        </div>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom"><h5><i class="fas fa-chart-bar me-2 text-primary"></i>Daftar Nilai Semester <?=$semester?> - <?=$tahun?></h5></div>
    <div class="table-responsive">
        <table class="table-custom datatable w-100">
            <thead>
                <tr><th>No</th><th>Mata Pelajaran</th><th>Nilai Harian</th><th>Nilai UTS</th><th>Nilai UAS</th><th>Nilai Akhir</th><th>Predikat</th></tr>
            </thead>
            <tbody>
            <?php foreach($nilais as $i=>$n):
                $g=$n['nilai_akhir']!==null?getGradeLabel($n['nilai_akhir']):['label'=>'-','class'=>'secondary'];
            ?>
            <tr>
                <td><?=$i+1?></td>
                <td style="font-weight:600;"><?=htmlspecialchars($n['nama_mapel'])?></td>
                <td><?=$n['nilai_harian']??'-'?></td>
                <td><?=$n['nilai_uts']??'-'?></td>
                <td><?=$n['nilai_uas']??'-'?></td>
                <td><strong><?=$n['nilai_akhir']??'-'?></strong></td>
                <td><span class="badge bg-<?=$g['class']?> fs-6"><?=$g['label']?></span></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<?php else:?>
<div class="card-custom"><div class="card-body-custom text-center py-5"><i class="fas fa-chart-bar fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Nilai belum tersedia untuk semester ini</p></div></div>
<?php endif;?>

<?php require_once __DIR__.'/../../layouts/siswa_footer.php';?>
