<?php require_once __DIR__.'/../../layouts/admin_header.php';?>

<div class="card-custom mb-4">
    <div class="card-body-custom">
        <form method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="admin_nilai">
            <div class="col-md-3"><label class="form-label">Kelas</label>
                <select name="kelas" class="form-select"><option value="">Semua Kelas</option>
                    <?php foreach($kelass as $k):?><option value="<?=$k['id']?>" <?=($kelas_filter==$k['id'])?'selected':''?>><?=htmlspecialchars($k['nama_kelas'])?></option><?php endforeach;?>
                </select>
            </div>
            <div class="col-md-3"><label class="form-label">Mata Pelajaran</label>
                <select name="mapel" class="form-select"><option value="">Semua Mapel</option>
                    <?php foreach($mapels as $m):?><option value="<?=$m['id']?>" <?=($mapel_filter==$m['id'])?'selected':''?>><?=htmlspecialchars($m['nama_mapel'])?></option><?php endforeach;?>
                </select>
            </div>
            <div class="col-md-2"><label class="form-label">Semester</label>
                <select name="semester" class="form-select">
                    <option value="">Semua</option>
                    <option value="1" <?=$semester==='1'?'selected':''?>>Semester 1</option>
                    <option value="2" <?=$semester==='2'?'selected':''?>>Semester 2</option>
                </select>
            </div>
            <div class="col-md-2"><label class="form-label">Tahun Ajaran</label><input type="text" name="tahun" class="form-control" value="<?=htmlspecialchars($tahun)?>"></div>
            <div class="col-md-2"><button type="submit" class="btn btn-primary w-100 mt-4"><i class="fas fa-search"></i> Tampilkan</button></div>
        </form>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom">
        <h5><i class="fas fa-chart-bar me-2"></i>Data Nilai (<?=count($nilais)?> record)</h5>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table-custom w-100" id="tabelNilai">
                <thead><tr><th>No</th><th>Siswa</th><th>Kelas</th><th>Mapel</th><th>Harian</th><th>UTS</th><th>UAS</th><th>Akhir</th><th>Predikat</th><th>Guru</th></tr></thead>
                <tbody>
                <?php if(!empty($nilais)):?>
                <?php foreach($nilais as $i=>$n): $g=$n['nilai_akhir']!==null?getGradeLabel($n['nilai_akhir']):['label'=>'-','class'=>'secondary'];?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><div style="font-weight:600;"><?=htmlspecialchars($n['nama_siswa'])?></div><small class="text-muted"><?=$n['nisn']??''?></small></td>
                    <td><?=htmlspecialchars($n['nama_kelas'])?></td>
                    <td><?=htmlspecialchars($n['nama_mapel'])?></td>
                    <td><?=$n['nilai_harian']??'-'?></td>
                    <td><?=$n['nilai_uts']??'-'?></td>
                    <td><?=$n['nilai_uas']??'-'?></td>
                    <td><strong><?=$n['nilai_akhir']??'-'?></strong></td>
                    <td><span class="badge bg-<?=$g['class']?>"><?=$g['label']?></span></td>
                    <td style="font-size:.8rem;"><?=htmlspecialchars($n['nama_guru'])?></td>
                </tr>
                <?php endforeach;?>
                <?php else:?><tr><td colspan="10" class="text-center py-4 text-muted">Belum ada data nilai</td></tr><?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__.'/../../layouts/admin_footer.php';?>
