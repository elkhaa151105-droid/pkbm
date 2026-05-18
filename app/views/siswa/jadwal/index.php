<?php require_once __DIR__.'/../../layouts/siswa_header.php';?>

<?php
$hariList=['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$jadwalByHari=[];
foreach($jadwal as $j) $jadwalByHari[$j['hari']][]=$j;
$hariNow=['1'=>'Senin','2'=>'Selasa','3'=>'Rabu','4'=>'Kamis','5'=>'Jumat','6'=>'Sabtu'];
$hariIni=$hariNow[date('N')]??'';
?>

<div class="row g-3">
<?php foreach($hariList as $hari):
    $items=$jadwalByHari[$hari]??[];
    $isToday=$hari===$hariIni;
?>
<div class="col-md-6 col-xl-4">
    <div class="card-custom h-100" style="<?=$isToday?'border-color:#3b82f6;box-shadow:0 0 0 2px rgba(59,130,246,.2);':''?>">
        <div class="card-header-custom" style="<?=$isToday?'background:#eff6ff;':'background:#f9fafb;'?>">
            <h5 style="color:<?=$isToday?'#1e40af':'#374151'?>">
                <?php if($isToday):?><i class="fas fa-map-pin me-2"></i><?php endif;?>
                <?=$hari?>
                <?php if($isToday):?><small class="ms-1 badge bg-primary" style="font-size:.65rem;">Hari Ini</small><?php endif;?>
            </h5>
            <span class="badge bg-secondary"><?=count($items)?></span>
        </div>
        <div class="card-body-custom">
        <?php if(!empty($items)):?>
        <?php foreach($items as $j):?>
        <div class="d-flex align-items-start gap-3 mb-3 p-3 rounded-3" style="background:<?=$isToday?'#eff6ff':'#f9fafb'?>;border-left:3px solid <?=$isToday?'#3b82f6':'#d1d5db'?>;">
            <div style="text-align:center;min-width:50px;flex-shrink:0;">
                <div style="font-size:.8rem;font-weight:700;color:#1e40af;"><?=substr($j['jam_mulai'],0,5)?></div>
                <div style="font-size:.65rem;color:#9ca3af;">s/d</div>
                <div style="font-size:.8rem;font-weight:600;color:#6b7280;"><?=substr($j['jam_selesai'],0,5)?></div>
            </div>
            <div>
                <div style="font-weight:700;font-size:.9rem;"><?=htmlspecialchars($j['nama_mapel'])?></div>
                <div style="font-size:.8rem;color:#6b7280;"><i class="fas fa-user me-1"></i><?=htmlspecialchars($j['nama_guru']??'')?></div>
                <?php if($j['ruangan']??false):?><div style="font-size:.75rem;color:#9ca3af;"><i class="fas fa-map-marker-alt me-1"></i><?=htmlspecialchars($j['ruangan'])?></div><?php endif;?>
            </div>
        </div>
        <?php endforeach;?>
        <?php else:?>
        <div class="text-center py-3 text-muted"><i class="fas fa-coffee d-block mb-1"></i><small>Tidak ada pelajaran</small></div>
        <?php endif;?>
        </div>
    </div>
</div>
<?php endforeach;?>
</div>

<?php require_once __DIR__.'/../../layouts/siswa_footer.php';?>
