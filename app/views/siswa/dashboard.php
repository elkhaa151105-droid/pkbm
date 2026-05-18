<?php require_once __DIR__.'/../layouts/siswa_header.php';?>

<!-- Welcome Banner -->
<div class="p-4 mb-4 rounded-3" style="background:linear-gradient(135deg,#1e40af,#3b82f6);color:white;position:relative;overflow:hidden;">
    <div style="position:absolute;right:-20px;top:-20px;width:120px;height:120px;background:rgba(255,255,255,.08);border-radius:50%;"></div>
    <div style="position:absolute;right:60px;bottom:-30px;width:80px;height:80px;background:rgba(255,255,255,.05);border-radius:50%;"></div>
    <div style="position:relative;">
        <p style="margin:0;opacity:.8;font-size:.875rem;">Selamat Datang,</p>
        <h4 style="font-weight:800;margin:4px 0;"><?=htmlspecialchars($siswa['nama_lengkap'])?> 👋</h4>
        <p style="margin:0;opacity:.75;font-size:.875rem;"><?=htmlspecialchars($siswa['nama_kelas']??'')?>  &bull; <?=htmlspecialchars($siswa['program']??'')?></p>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff"><i class="fas fa-tasks" style="color:#3b82f6"></i></div>
            <div class="stat-value"><?=count($tugasBelum)?></div>
            <div class="stat-label">Tugas Menunggu</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#ecfdf5"><i class="fas fa-check-circle" style="color:#10b981"></i></div>
            <div class="stat-value"><?=$absensiRekap['hadir']??0?></div>
            <div class="stat-label">Hadir Bulan Ini</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb"><i class="fas fa-chart-bar" style="color:#f59e0b"></i></div>
            <div class="stat-value"><?=count($nilaiTerbaru)?></div>
            <div class="stat-label">Nilai Tersedia</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2"><i class="fas fa-times-circle" style="color:#ef4444"></i></div>
            <div class="stat-value"><?=($absensiRekap['alpha']??0)+($absensiRekap['sakit']??0)+($absensiRekap['izin']??0)?></div>
            <div class="stat-label">Tidak Hadir</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Jadwal Hari Ini -->
    <div class="col-lg-4">
        <div class="card-custom mb-3">
            <div class="card-header-custom">
                <h5><i class="fas fa-calendar-day me-2 text-primary"></i>Jadwal Hari Ini</h5>
                <small class="text-muted"><?=date('l, d M')?></small>
            </div>
            <div class="card-body-custom">
                <?php if(!empty($jadwalHariIni)):?>
                <?php foreach($jadwalHariIni as $j):?>
                <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-3" style="background:#eff6ff;border-left:3px solid #3b82f6;">
                    <div style="text-align:center;min-width:44px;">
                        <div style="font-size:.75rem;font-weight:700;color:#1e40af;"><?=substr($j['jam_mulai'],0,5)?></div>
                        <div style="font-size:.65rem;color:#9ca3af;"><?=substr($j['jam_selesai'],0,5)?></div>
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:.85rem;"><?=htmlspecialchars($j['nama_mapel'])?></div>
                        <div style="font-size:.75rem;color:#6b7280;"><?=htmlspecialchars($j['nama_guru']??'')?></div>
                    </div>
                </div>
                <?php endforeach;?>
                <?php else:?><p class="text-muted text-center py-2 mb-0"><i class="fas fa-coffee me-1"></i>Tidak ada jadwal hari ini</p><?php endif;?>
            </div>
        </div>

        <!-- Absensi Rekap -->
        <div class="card-custom">
            <div class="card-header-custom"><h5><i class="fas fa-clipboard-check me-2 text-success"></i>Absensi Bulan Ini</h5></div>
            <div class="card-body-custom">
                <?php
                $total=($absensiRekap['hadir']??0)+($absensiRekap['sakit']??0)+($absensiRekap['izin']??0)+($absensiRekap['alpha']??0);
                $rekapItems=[['hadir','Hadir','#10b981'],['sakit','Sakit','#f59e0b'],['izin','Izin','#3b82f6'],['alpha','Alpha','#ef4444']];
                foreach($rekapItems as $ri):
                    $val=$absensiRekap[$ri[0]]??0;
                    $persen=$total>0?round($val/$total*100):0;
                ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span style="font-size:.85rem;"><?=$ri[1]?></span>
                    <span style="font-weight:700;color:<?=$ri[2]?>"><?=$val?>x</span>
                </div>
                <div style="height:6px;background:#f0f0f0;border-radius:3px;margin-bottom:10px;overflow:hidden;">
                    <div style="height:100%;width:<?=$persen?>%;background:<?=$ri[2]?>;border-radius:3px;transition:width .6s;"></div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>

    <!-- Tugas Menunggu -->
    <div class="col-lg-8">
        <div class="card-custom mb-3">
            <div class="card-header-custom">
                <h5><i class="fas fa-tasks me-2 text-warning"></i>Tugas Menunggu</h5>
                <a href="<?=APP_URL?>/index.php?page=siswa_tugas" class="btn-primary-custom" style="font-size:.75rem;padding:6px 12px;">Lihat Semua</a>
            </div>
            <div class="card-body-custom p-0">
                <?php if(!empty($tugasBelum)):?>
                <table class="table-custom w-100">
                    <thead><tr><th>Judul Tugas</th><th>Mapel</th><th>Deadline</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach($tugasBelum as $t):
                        $sisa=strtotime($t['deadline'])-time();
                        $sisFmt=$sisa>86400?ceil($sisa/86400).'h':ceil($sisa/3600).'j';
                        $urgent=$sisa<86400;
                    ?>
                    <tr>
                        <td style="font-weight:600;"><?=htmlspecialchars($t['judul'])?></td>
                        <td><?=htmlspecialchars($t['nama_mapel']??'')?></td>
                        <td><span class="badge bg-<?=$urgent?'danger':'warning'?>"><?=$sisFmt?> lagi</span></td>
                        <td><a href="<?=APP_URL?>/index.php?page=siswa_tugas" class="btn-icon" style="background:#eff6ff;color:#3b82f6;"><i class="fas fa-arrow-right"></i></a></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <?php else:?>
                <div class="text-center py-4"><i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i><p class="text-muted mb-0">Semua tugas sudah dikerjakan! 🎉</p></div>
                <?php endif;?>
            </div>
        </div>

        <!-- Nilai Terbaru -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-chart-bar me-2 text-primary"></i>Nilai Terbaru</h5>
                <a href="<?=APP_URL?>/index.php?page=siswa_nilai" class="btn-primary-custom" style="font-size:.75rem;padding:6px 12px;">Lihat Semua</a>
            </div>
            <div class="card-body-custom">
                <?php if(!empty($nilaiTerbaru)):?>
                <div class="row g-2">
                <?php foreach($nilaiTerbaru as $n): if($n['nilai_akhir']===null) continue; $g=getGradeLabel($n['nilai_akhir']);?>
                <div class="col-6 col-md-4">
                    <div class="p-3 rounded-3 text-center" style="background:#f8fafc;border:1px solid #e5e7eb;">
                        <div style="font-size:.75rem;color:#6b7280;margin-bottom:4px;"><?=htmlspecialchars($n['nama_mapel'])?></div>
                        <div style="font-size:1.5rem;font-weight:800;color:#1a2a3a;"><?=$n['nilai_akhir']?></div>
                        <span class="badge bg-<?=$g['class']?>"><?=$g['label']?></span>
                    </div>
                </div>
                <?php endforeach;?>
                </div>
                <?php else:?><p class="text-muted text-center py-3">Belum ada nilai tersedia</p><?php endif;?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../layouts/siswa_footer.php';?>
