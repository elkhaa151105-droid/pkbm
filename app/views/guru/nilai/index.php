<?php require_once __DIR__.'/../../layouts/guru_header.php';?>

<!-- Filter -->
<div class="card-custom mb-4">
    <div class="card-body-custom">
        <form method="GET" action="<?=APP_URL?>/index.php" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="guru_nilai">
            <div class="col-md-3">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach($kelass as $k):?>
                    <option value="<?=$k['id']?>" <?=($_GET['kelas']??'')==$k['id']?'selected':''?>><?=htmlspecialchars($k['nama_kelas'])?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Mata Pelajaran</label>
                <select name="mapel" class="form-select" required>
                    <option value="">-- Pilih Mapel --</option>
                    <?php foreach($mapels as $m):?>
                    <option value="<?=$m['id']?>" <?=($_GET['mapel']??'')==$m['id']?'selected':''?>><?=htmlspecialchars($m['nama_mapel'])?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Semester</label>
                <select name="semester" class="form-select">
                    <option value="1" <?=($semester??'')=='1'?'selected':''?>>Semester 1</option>
                    <option value="2" <?=($semester??'')=='2'?'selected':''?>>Semester 2</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tahun Ajaran</label>
                <input type="text" name="tahun" class="form-control" value="<?=htmlspecialchars($tahun??'')?>" placeholder="2024/2025">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Tampilkan</button>
            </div>
        </form>
    </div>
</div>

<?php if(!empty($siswas)):?>
<div class="card-custom">
    <div class="card-header-custom">
        <h5><i class="fas fa-chart-bar me-2 text-success"></i>Input Nilai Siswa</h5>
        <span class="badge bg-primary"><?=count($siswas)?> siswa</span>
    </div>
    <form method="POST" action="<?=APP_URL?>/index.php?page=guru_nilai&action=store">
        <input type="hidden" name="kelas_id" value="<?=$_GET['kelas']??''?>">
        <input type="hidden" name="mapel_id" value="<?=$_GET['mapel']??''?>">
        <input type="hidden" name="semester" value="<?=$semester??''?>">
        <input type="hidden" name="tahun_ajaran" value="<?=$tahun??''?>">
        <div class="table-responsive">
            <table class="table-custom w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Nilai Harian (30%)</th>
                        <th>Nilai UTS (30%)</th>
                        <th>Nilai UAS (40%)</th>
                        <th>Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($siswas as $i=>$s):
                    $n = $nilaiMap[$s['id']] ?? null;
                ?>
                <tr>
                    <td><?=$i+1?></td>
                    <td>
                        <div style="font-weight:600;"><?=htmlspecialchars($s['nama_lengkap'])?></div>
                        <div style="font-size:.75rem;color:#9ca3af;"><?=$s['nisn']??''?></div>
                    </td>
                    <td><input type="number" name="nilai[<?=$s['id']?>][harian]" class="form-control form-control-sm nilai-input" min="0" max="100" step="0.01" value="<?=$n?htmlspecialchars($n['nilai_harian']):'0'?>" style="width:90px;" data-id="<?=$s['id']?>" data-type="harian"></td>
                    <td><input type="number" name="nilai[<?=$s['id']?>][uts]" class="form-control form-control-sm nilai-input" min="0" max="100" step="0.01" value="<?=$n?htmlspecialchars($n['nilai_uts']):'0'?>" style="width:90px;" data-id="<?=$s['id']?>" data-type="uts"></td>
                    <td><input type="number" name="nilai[<?=$s['id']?>][uas]" class="form-control form-control-sm nilai-input" min="0" max="100" step="0.01" value="<?=$n?htmlspecialchars($n['nilai_uas']):'0'?>" style="width:90px;" data-id="<?=$s['id']?>" data-type="uas"></td>
                    <td>
                        <span id="na_<?=$s['id']?>" class="badge bg-primary fs-6" style="font-size:.9rem!important;">
                            <?php if($n && $n['nilai_akhir']!==null): $g=getGradeLabel($n['nilai_akhir']);?>
                            <span style="background:none"><?=$n['nilai_akhir']?> (<?=$g['label']?>)</span>
                            <?php else:?>-<?php endif;?>
                        </span>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top d-flex justify-content-end gap-2">
            <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Simpan Semua Nilai</button>
        </div>
    </form>
</div>
<?php elseif(isset($_GET['kelas']) && isset($_GET['mapel'])):?>
<div class="card-custom"><div class="card-body-custom text-center py-5"><i class="fas fa-users fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Tidak ada siswa di kelas ini</p></div></div>
<?php else:?>
<div class="card-custom"><div class="card-body-custom text-center py-5"><i class="fas fa-filter fa-3x text-muted mb-3 d-block"></i><p class="text-muted">Pilih kelas dan mata pelajaran untuk menampilkan data siswa</p></div></div>
<?php endif;?>

<?php $extraScript = <<<'JS'
document.querySelectorAll('.nilai-input').forEach(function(el){
    el.addEventListener('input', function(){
        var id = this.dataset.id;
        var h = parseFloat(document.querySelector('[name="nilai['+id+'][harian]"]').value)||0;
        var u = parseFloat(document.querySelector('[name="nilai['+id+'][uts]"]').value)||0;
        var a = parseFloat(document.querySelector('[name="nilai['+id+'][uas]"]').value)||0;
        var na = Math.round((h*0.3+u*0.3+a*0.4)*100)/100;
        var grade='';
        if(na>=90)grade='A';else if(na>=80)grade='B';else if(na>=70)grade='C';else if(na>=60)grade='D';else grade='E';
        document.getElementById('na_'+id).innerHTML = na+' ('+grade+')';
    });
});
JS;
?>

<?php require_once __DIR__.'/../../layouts/guru_footer.php';?>
