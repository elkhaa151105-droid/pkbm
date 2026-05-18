<?php require_once __DIR__ . '/../layouts/admin_header.php'; ?>

<!-- STAT CARDS -->
<div class="row g-3 mb-4">
    <?php
    $cards = [
        ['icon' => 'user-graduate', 'color' => '#3b82f6', 'bg' => '#eff6ff', 'value' => $stats['total_siswa'], 'label' => 'Total Siswa Aktif', 'link' => 'admin_siswa'],
        ['icon' => 'chalkboard-teacher', 'color' => '#10b981', 'bg' => '#ecfdf5', 'value' => $stats['total_guru'], 'label' => 'Total Guru Aktif', 'link' => 'admin_guru'],
        ['icon' => 'school', 'color' => '#f59e0b', 'bg' => '#fffbeb', 'value' => $stats['total_kelas'], 'label' => 'Total Kelas', 'link' => 'admin_kelas'],
        ['icon' => 'book-open', 'color' => '#8b5cf6', 'bg' => '#f5f3ff', 'value' => $stats['total_mapel'], 'label' => 'Mata Pelajaran', 'link' => 'admin_mapel'],
        ['icon' => 'file-alt', 'color' => '#ef4444', 'bg' => '#fef2f2', 'value' => $stats['pendaftaran_pending'], 'label' => 'Pendaftaran Baru', 'link' => 'admin_pendaftaran'],
        ['icon' => 'envelope', 'color' => '#06b6d4', 'bg' => '#ecfeff', 'value' => $stats['pesan_baru'], 'label' => 'Pesan Masuk', 'link' => 'admin_kontak'],
    ];
    foreach ($cards as $card): ?>
    <div class="col-6 col-md-4 col-xl-2">
        <a href="<?= APP_URL ?>/index.php?page=<?= $card['link'] ?>" style="text-decoration:none;">
            <div class="stat-card">
                <div class="stat-icon" style="background:<?= $card['bg'] ?>;">
                    <i class="fas fa-<?= $card['icon'] ?>" style="color:<?= $card['color'] ?>;"></i>
                </div>
                <div class="stat-value"><?= number_format($card['value']) ?></div>
                <div class="stat-label"><?= $card['label'] ?></div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<!-- CHARTS + CONTENT ROW -->
<div class="row g-3 mb-4">
    <!-- Siswa per Kelas -->
    <div class="col-lg-5">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h5><i class="fas fa-chart-pie me-2 text-primary"></i>Siswa per Kelas</h5>
            </div>
            <div class="card-body-custom">
                <canvas id="classChart" height="220"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Pendaftaran -->
    <div class="col-lg-7">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h5><i class="fas fa-file-alt me-2 text-warning"></i>Pendaftaran Terbaru</h5>
                <a href="<?= APP_URL ?>/index.php?page=admin_pendaftaran" class="btn-primary-custom" style="font-size:0.75rem;padding:6px 12px;">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body-custom p-0">
                <table class="table-custom w-100">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Program</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentPendaftaran)): ?>
                        <?php foreach ($recentPendaftaran as $p): ?>
                        <tr>
                            <td class="fw-600"><?= htmlspecialchars($p['nama_lengkap']) ?></td>
                            <td><span class="badge bg-primary"><?= $p['program'] ?></span></td>
                            <td><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                            <td>
                                <?php
                                $badges = ['pending' => 'warning', 'diterima' => 'success', 'ditolak' => 'danger'];
                                $labels = ['pending' => 'Pending', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'];
                                $b = $badges[$p['status']] ?? 'secondary';
                                $l = $labels[$p['status']] ?? $p['status'];
                                ?>
                                <span class="badge bg-<?= $b ?>"><?= $l ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr><td colspan="4" class="text-center text-muted py-3">Belum ada pendaftaran</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SISWA TERBARU + ARTIKEL -->
<div class="row g-3">
    <!-- Siswa Terbaru -->
    <div class="col-lg-7">
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-user-graduate me-2 text-primary"></i>Siswa Terbaru</h5>
                <a href="<?= APP_URL ?>/index.php?page=admin_siswa" class="btn-primary-custom" style="font-size:0.75rem;padding:6px 12px;">
                    Kelola Siswa
                </a>
            </div>
            <div class="card-body-custom p-0">
                <table class="table-custom w-100">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>NISN</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentSiswa)): ?>
                        <?php foreach ($recentSiswa as $s): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:32px;height:32px;background:linear-gradient(135deg,#3b82f6,#6366f1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:0.75rem;font-weight:700;flex-shrink:0;">
                                        <?= strtoupper(substr($s['nama_lengkap'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-600" style="font-size:0.875rem;"><?= htmlspecialchars($s['nama_lengkap']) ?></div>
                                        <div style="font-size:0.75rem;color:#9ca3af;"><?= $s['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><code style="font-size:0.8rem;"><?= $s['nisn'] ?? '-' ?></code></td>
                            <td><?= htmlspecialchars($s['nama_kelas'] ?? '-') ?></td>
                            <td><span class="badge bg-<?= $s['status']=='aktif'?'success':'secondary' ?>"><?= ucfirst($s['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data siswa</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Artikel -->
    <div class="col-lg-5">
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-newspaper me-2 text-success"></i>Artikel Terbaru</h5>
                <a href="<?= APP_URL ?>/index.php?page=admin_artikel" class="btn-primary-custom" style="font-size:0.75rem;padding:6px 12px;">
                    Kelola
                </a>
            </div>
            <div class="card-body-custom">
                <?php if (!empty($recentArtikel)): ?>
                <?php foreach ($recentArtikel as $a): ?>
                <div class="d-flex gap-3 mb-3 pb-3" style="border-bottom:1px solid #f5f5f5;">
                    <div style="width:44px;height:44px;background:linear-gradient(135deg,#10b981,#059669);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-newspaper" style="color:white;font-size:1rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:0.875rem;font-weight:600;color:#1a2a3a;line-height:1.3;">
                            <?= htmlspecialchars(substr($a['judul'], 0, 50)) ?><?= strlen($a['judul']) > 50 ? '...' : '' ?>
                        </div>
                        <div style="font-size:0.75rem;color:#9ca3af;margin-top:2px;">
                            <?= date('d M Y', strtotime($a['created_at'])) ?>
                            &bull; <span class="badge bg-<?= $a['kategori']=='berita'?'info':($a['kategori']=='pengumuman'?'warning':'secondary') ?> badge-sm"><?= ucfirst($a['kategori']) ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted text-center py-3">Belum ada artikel</p>
                <?php endif; ?>
                <a href="<?= APP_URL ?>/index.php?page=admin_artikel&action=create" class="btn-primary-custom w-100 justify-content-center" style="margin-top:4px;">
                    <i class="fas fa-plus"></i> Tulis Artikel Baru
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('classChart');
const classData = <?= json_encode($siswaPerKelas) ?>;

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: classData.map(d => d.nama_kelas),
        datasets: [{
            data: classData.map(d => d.total),
            backgroundColor: ['#3b82f6','#10b981','#f59e0b','#8b5cf6','#ef4444','#06b6d4'],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: { family: 'Plus Jakarta Sans', size: 11 },
                    padding: 12,
                    usePointStyle: true
                }
            }
        }
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/admin_footer.php'; ?>
