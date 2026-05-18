<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <div class="d-flex gap-2">
        <a href="<?= APP_URL ?>/index.php?page=admin_siswa&action=create" class="btn-primary-custom">
            <i class="fas fa-plus"></i> Tambah Siswa
        </a>
    </div>
</div>

<!-- Filter -->
<div class="card-custom mb-3">
    <div class="card-body-custom">
        <form method="GET" action="<?= APP_URL ?>/index.php" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="admin_siswa">
            <div class="col-md-6">
                <label class="form-label">Cari Siswa</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Nama, NISN, NIS..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Filter Kelas</label>
                <select name="kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelass as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= ($_GET['kelas'] ?? '') == $k['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($k['nama_kelas']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card-custom">
    <div class="card-header-custom">
        <h5><i class="fas fa-user-graduate me-2"></i>Daftar Siswa (<?= count($siswas) ?> data)</h5>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table-custom datatable w-100">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Siswa</th>
                        <th>NISN / NIS</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($siswas)): ?>
                    <?php foreach ($siswas as $i => $s): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <?php if ($s['foto']): ?>
                                <img src="<?= getFileUrl($s['foto']) ?>" class="rounded-circle" width="32" height="32" style="object-fit:cover;">
                                <?php else: ?>
                                <div style="width:32px;height:32px;background:linear-gradient(135deg,#3b82f6,#6366f1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:0.75rem;font-weight:700;">
                                    <?= strtoupper(substr($s['nama_lengkap'], 0, 1)) ?>
                                </div>
                                <?php endif; ?>
                                <div>
                                    <div style="font-weight:600;"><?= htmlspecialchars($s['nama_lengkap']) ?></div>
                                    <div style="font-size:0.75rem;color:#9ca3af;"><?= htmlspecialchars($s['username'] ?? '-') ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:0.8rem;"><?= $s['nisn'] ?? '-' ?></div>
                            <div style="font-size:0.75rem;color:#9ca3af;"><?= $s['nis'] ?? '-' ?></div>
                        </td>
                        <td><?= htmlspecialchars($s['nama_kelas'] ?? '-') ?></td>
                        <td><?= $s['jenis_kelamin'] == 'L' ? '<span class="badge bg-primary">L</span>' : '<span class="badge bg-danger">P</span>' ?></td>
                        <td><?= htmlspecialchars($s['no_hp'] ?? '-') ?></td>
                        <td>
                            <?php
                            $statusColors = ['aktif'=>'success','nonaktif'=>'secondary','lulus'=>'primary','dropout'=>'danger'];
                            $sc = $statusColors[$s['status']] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?= $sc ?>"><?= ucfirst($s['status']) ?></span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= APP_URL ?>/index.php?page=admin_siswa&action=edit&id=<?= $s['id'] ?>"
                                   class="btn-icon" style="background:#eff6ff;color:#3b82f6;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)"
                                   onclick="confirmDelete('<?= APP_URL ?>/index.php?page=admin_siswa&action=delete&id=<?= $s['id'] ?>', '<?= htmlspecialchars($s['nama_lengkap'], ENT_QUOTES) ?>')"
                                   class="btn-icon" style="background:#fef2f2;color:#ef4444;" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-user-graduate fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted">Belum ada data siswa</p>
                            <a href="<?= APP_URL ?>/index.php?page=admin_siswa&action=create" class="btn-primary-custom">
                                <i class="fas fa-plus"></i> Tambah Siswa Pertama
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/admin_footer.php'; ?>
