<?php require_once __DIR__.'/../../layouts/guru_header.php';?>

<?php
$hariList=['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$jadwalByHari=[];
foreach($jadwal as $j) $jadwalByHari[$j['hari']][]=$j;
$hariColors=['Senin'=>['#3b82f6','#eff6ff'],'Selasa'=>['#10b981','#ecfdf5'],'Rabu'=>['#f59e0b','#fffbeb'],'Kamis'=>['#8b5cf6','#f5f3ff'],'Jumat'=>['#ef4444','#fef2f2'],'Sabtu'=>['#06b6d4','#ecfeff']];
?>

<div class="row g-3">
<?php foreach($hariList as $hari):
    $items=$jadwalByHari[$hari]??[];
    $col=$hariColors[$hari]??['#6b7280','#f9fafb'];
?>
<div class="col-md-6 col-xl-4">
    <div class="card-custom h-100">
        <div class="card-header-custom" style="background:<?=$col[1]?>;border-bottom-color:<?=$col[0]?>22;">
            <h5 style="color:<?=$col[0]?>;"><i class="fas fa-calendar-day me-2"></i><?=$hari?></h5>
            <span class="badge" style="background:<?=$col[0]?>"><?=count($items)?> jadwal</span>
        </div>
        <div class="card-body-custom">
            <?php if(!empty($items)):?>
            <?php foreach($items as $j):?>
            <div class="d-flex gap-3 mb-3 p-3 rounded-3" style="background:<?=$col[1]?>;border-left:3px solid <?=$col[0]?>;">
                <div style="text-align:center;min-width:50px;">
                    <div style="font-size:.8rem;font-weight:700;color:<?=$col[0]?>"><?=substr($j['jam_mulai'],0,5)?></div>
                    <div style="font-size:.7rem;color:#9ca3af;">s/d</div>
                    <div style="font-size:.8rem;font-weight:700;color:<?=$col[0]?>"><?=substr($j['jam_selesai'],0,5)?></div>
                </div>
                <div>
                    <div style="font-weight:700;font-size:.9rem;"><?=htmlspecialchars($j['nama_mapel'])?></div>
                    <div style="font-size:.8rem;color:#6b7280;"><?=htmlspecialchars($j['nama_kelas'])?></div>
                    <?php if($j['ruangan']):?><div style="font-size:.75rem;color:#9ca3af;"><i class="fas fa-map-marker-alt me-1"></i><?=htmlspecialchars($j['ruangan'])?></div><?php endif;?>
                </div>
            </div>
            <?php endforeach;?>
            <?php else:?>
            <div class="text-center py-3 text-muted"><i class="fas fa-coffee d-block mb-2"></i><small>Tidak ada jadwal</small></div>
            <?php endif;?>
        </div>
    </div>
</div>
<?php endforeach;?>
</div>

<?php require_once __DIR__.'/../../layouts/guru_footer.php';?>
