<?php
// program.php
$pageTitle = 'Program Pendidikan - ' . ($settings['nama_pkbm'] ?? 'PKBM Sari Asih');
$activePage = 'program';
require_once __DIR__ . '/layout_header.php';
?>
<div style="background:linear-gradient(135deg,#1a5276,#2980b9);padding:48px 0 24px;color:white;">
    <div class="container"><h1 style="font-weight:800;font-size:2rem;">Program Pendidikan</h1><p style="opacity:.7;">Pilih program yang sesuai dengan kebutuhan Anda</p></div>
</div>
<div class="container" style="padding:48px 0;">
    <?php foreach([
        ['Paket A','Setara SD (Sekolah Dasar)','fa-child','#10b981','Kelas I - VI (6 Tahun)','Program Paket A merupakan program pendidikan kesetaraan SD yang diperuntukkan bagi warga masyarakat yang karena kondisi sosial, budaya, ekonomi, geografi, maupun waktu tidak dapat mengikuti pendidikan dasar formal.','<li>Membaca, Menulis, Berhitung</li><li>IPA dan IPS Dasar</li><li>Bahasa Indonesia</li><li>Matematika Dasar</li><li>PKn</li>','Dewasa usia 15+ atau anak yang tidak bisa sekolah formal'],
        ['Paket B','Setara SMP (Sekolah Menengah Pertama)','fa-user-graduate','#3b82f6','Kelas VII - IX (3 Tahun)','Program Paket B merupakan program pendidikan kesetaraan SMP yang memberikan kesempatan kepada masyarakat yang tidak/belum menyelesaikan pendidikan setara SMP untuk mendapatkan ijazah yang setara.','<li>Matematika</li><li>Bahasa Indonesia & Inggris</li><li>IPA & IPS</li><li>PKn</li><li>Pendidikan Jasmani</li>','Lulusan SD/Paket A atau setara'],
        ['Paket C','Setara SMA (Sekolah Menengah Atas)','fa-university','#8b5cf6','Kelas X - XII (3 Tahun)','Program Paket C merupakan program pendidikan kesetaraan SMA yang memberi peluang kepada masyarakat untuk mendapatkan ijazah setara SMA guna melanjutkan pendidikan ke perguruan tinggi.','<li>Matematika & IPA/IPS</li><li>Bahasa Indonesia & Inggris</li><li>Sejarah & Geografi</li><li>Ekonomi & Sosiologi</li><li>PKn & Seni Budaya</li>','Lulusan SMP/Paket B atau setara'],
    ] as $p): ?>
    <div class="row g-4 align-items-start mb-5 pb-5" style="border-bottom:1px solid #f0f0f0;">
        <div class="col-md-4 text-center">
            <div style="background:linear-gradient(135deg,<?=$p[3]?>,<?=$p[3]?>dd);border-radius:24px;padding:40px;display:inline-block;">
                <i class="fas <?=$p[2]?>" style="font-size:3rem;color:white;"></i>
            </div>
            <h2 style="font-weight:800;margin-top:16px;color:#1a2a3a;"><?=$p[0]?></h2>
            <p style="color:<?=$p[3]?>;font-weight:700;"><?=$p[1]?></p>
            <div style="background:#f8fafc;border-radius:10px;padding:8px 16px;display:inline-block;font-size:.85rem;"><i class="fas fa-clock me-1 text-muted"></i><?=$p[4]?></div>
        </div>
        <div class="col-md-8">
            <h3 style="font-weight:700;color:#1a5276;margin-bottom:12px;">Deskripsi Program</h3>
            <p style="color:#6b7280;line-height:1.7;"><?=$p[5]?></p>
            <h4 style="font-weight:700;margin-top:20px;margin-bottom:10px;">Mata Pelajaran</h4>
            <ul style="color:#374151;line-height:2;"><?=$p[6]?></ul>
            <p><strong>Persyaratan:</strong> <?=$p[7]?></p>
            <a href="<?=APP_URL?>/index.php?page=daftar" class="btn-primary-pub"><i class="fas fa-user-plus"></i> Daftar <?=$p[0]?></a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/layout_footer.php'; ?>
