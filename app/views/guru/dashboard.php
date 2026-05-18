<?php require_once __DIR__.'/../layouts/guru_header.php'; ?>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <?php
    $cards=[
        ['icon'=>'school','color'=>'#10b981','bg'=>'#ecfdf5','value'=>$stats['kelas'],'label'=>'Kelas Diajar'],
        ['icon'=>'calendar-alt','color'=>'#3b82f6','bg'=>'#eff6ff','value'=>$stats['jadwal_minggu'],'label'=>'Jadwal/Minggu'],
        ['icon'=>'tasks','color'=>'#f59e0b','bg'=>'#fffbeb','value'=>$stats['tugas_aktif'],'label'=>'Tugas Aktif'],
        ['icon'=>'book-open','color'=>'#8b5cf6','bg'=>'#f5f3ff','value'=>$stats['materi'],'label'=>'Total Materi'],
    ];
    foreach($cards as $c):?>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:<?=$c['bg']?>"><i class="fas fa-<?=$c['icon']?>" style="color:<?=$c['color']?>"></i></div>
            <div class="stat-value"><?=$c['value']?></div>
            <div class="stat-label"><?=$c['label']?></div>
        </div>
    </div>
    <?php endforeach;?>
</div>

<div class="row g-3">
    <!-- Jadwal Hari Ini -->
    <div class="col-lg-5">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h5><i class="fas fa-calendar-day me-2 text-success"></i>Jadwal Hari Ini (<?=date('l, d M Y')?>)</h5>
            </div>
            <div class="card-body-custom">
                <?php if(!empty($jadwalHariIni)):?>
                <?php foreach($jadwalHariIni as $j):?>
                <div class="d-flex align-items-center gap-3 mb-3 p-3 rounded-3" style="background:#f0fdf4;border:1px solid #d1fae5;">
                    <div style="width:48px;height:48px;background:linear-gradient(135deg,#065f46,#10b981);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;flex-shrink:0;">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="flex-1">
                        <div style="font-weight:700;font-size:.9rem;"><?=htmlspecialchars($j['nama_mapel'])?></div>
                        <div style="font-size:.8rem;color:#6b7280;"><?=htmlspecialchars($j['nama_kelas'])?></div>
                    </div>
                    <div class="text-end">
                        <div style="font-size:.8rem;font-weight:700;color:#065f46;"><?=substr($j['jam_mulai'],0,5)?></div>
                        <div style="font-size:.75rem;color:#9ca3af;"><?=substr($j['jam_selesai'],0,5)?></div>
                    </div>
                </div>
                <?php endforeach;?>
                <?php else:?>
                <div class="text-center py-4">
                    <i class="fas fa-coffee fa-2x text-muted mb-2 d-block"></i>
                    <p class="text-muted mb-0">Tidak ada jadwal hari ini</p>
                </div>
                <?php endif;?>
                <a href="<?=APP_URL?>/index.php?page=guru_jadwal" class="btn-primary-custom w-100 justify-content-center mt-3">
                    <i class="fas fa-calendar"></i> Lihat Semua Jadwal
                </a>
            </div>
        </div>
    </div>

    <!-- Tugas Aktif -->
    <div class="col-lg-7">
        <div class="card-custom mb-3">
            <div class="card-header-custom">
                <h5><i class="fas fa-tasks me-2 text-warning"></i>Tugas Aktif</h5>
                <a href="<?=APP_URL?>/index.php?page=guru_tugas&action=create_form" class="btn-primary-custom" style="font-size:.75rem;padding:6px 12px;"><i class="fas fa-plus"></i> Buat Tugas</a>
            </div>
            <div class="card-body-custom p-0">
                <table class="table-custom w-100">
                    <thead><tr><th>Tugas</th><th>Kelas</th><th>Deadline</th><th>Terkumpul</th></tr></thead>
                    <tbody>
                    <?php if(!empty($tugasAktif)):?>
                    <?php foreach($tugasAktif as $t):?>
                    <tr>
                        <td><a href="<?=APP_URL?>/index.php?page=guru_tugas&action=detail&id=<?=$t['id']?>" style="font-weight:600;color:#065f46;text-decoration:none;"><?=htmlspecialchars($t['judul'])?></a><div style="font-size:.75rem;color:#9ca3af;"><?=htmlspecialchars($t['nama_mapel']??'')?></div></td>
                        <td><?=htmlspecialchars($t['nama_kelas']??'')?></td>
                        <td><span style="font-size:.8rem;"><?=date('d M',strtotime($t['deadline']))?></span></td>
                        <td><span class="badge bg-<?=$t['terkumpul']>0?'success':'secondary'?>"><?=$t['terkumpul']?> siswa</span></td>
                    </tr>
                    <?php endforeach;?>
                    <?php else:?><tr><td colspan="4" class="text-center text-muted py-3">Belum ada tugas aktif</td></tr><?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Materi Terbaru -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-book-open me-2 text-primary"></i>Materi Terbaru</h5>
                <a href="<?=APP_URL?>/index.php?page=guru_materi" class="btn-primary-custom" style="font-size:.75rem;padding:6px 12px;">Kelola Materi</a>
            </div>
            <div class="card-body-custom p-0">
                <table class="table-custom w-100">
                    <thead><tr><th>Judul</th><th>Kelas</th><th>Tanggal</th><th>Tipe</th></tr></thead>
                    <tbody>
                    <?php if(!empty($materiTerbaru)):?>
                    <?php foreach($materiTerbaru as $m):
                        $icons=['pdf'=>'fa-file-pdf text-danger','doc'=>'fa-file-word text-primary','docx'=>'fa-file-word text-primary','mp4'=>'fa-file-video text-warning','ppt'=>'fa-file-powerpoint text-orange','pptx'=>'fa-file-powerpoint text-orange'];
                        $icon=$icons[$m['tipe_file']??'']??'fa-file text-secondary';
                    ?>
                    <tr>
                        <td><i class="fas <?=$icon?> me-1"></i><?=htmlspecialchars(substr($m['judul'],0,30)).(strlen($m['judul'])>30?'...':'')?></td>
                        <td><?=htmlspecialchars($m['nama_kelas']??'')?></td>
                        <td style="font-size:.8rem;"><?=date('d/m/Y',strtotime($m['created_at']))?></td>
                        <td><span class="badge bg-secondary"><?=strtoupper($m['tipe_file']??'-')?></span></td>
                    </tr>
                    <?php endforeach;?>
                    <?php else:?><tr><td colspan="4" class="text-center text-muted py-3">Belum ada materi</td></tr><?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../layouts/guru_footer.php';?>
