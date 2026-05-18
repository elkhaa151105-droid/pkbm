<?php require_once __DIR__ . '/../../layouts/admin_header.php'; 
$isEdit = isset($siswa);
?>

<div class="row justify-content-center">
    <div class="col-xl-9">
        <form method="POST" action="<?= APP_URL ?>/index.php?page=admin_siswa&action=<?= $isEdit ? 'update' : 'store' ?>" enctype="multipart/form-data">
            <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $siswa['id'] ?>">
            <?php endif; ?>

            <div class="form-section">
                <h5><i class="fas fa-user me-2"></i>Data Pribadi Siswa</h5>

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control"
                               value="<?= htmlspecialchars($siswa['nama_lengkap'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="L" <?= ($siswa['jenis_kelamin'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= ($siswa['jenis_kelamin'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control"
                               value="<?= htmlspecialchars($siswa['nisn'] ?? '') ?>" placeholder="10 digit">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" class="form-control"
                               value="<?= htmlspecialchars($siswa['nis'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                               value="<?= htmlspecialchars($siswa['tempat_lahir'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                               value="<?= $siswa['tanggal_lahir'] ?? '' ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3"><?= htmlspecialchars($siswa['alamat'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No HP / WA</label>
                        <input type="text" name="no_hp" class="form-control"
                               value="<?= htmlspecialchars($siswa['no_hp'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?= htmlspecialchars($siswa['email'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Foto</label>
                        <?php if ($isEdit && $siswa['foto']): ?>
                        <div class="mb-2">
                            <img src="<?= getFileUrl($siswa['foto']) ?>" height="80" class="rounded">
                        </div>
                        <?php endif; ?>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="form-section mt-3">
                <h5><i class="fas fa-school me-2"></i>Data Akademik</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-select">
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($kelass as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= ($siswa['kelas_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($k['nama_kelas']) ?> (<?= $k['program'] ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif" <?= ($siswa['status'] ?? 'aktif') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= ($siswa['status'] ?? '') == 'nonaktif' ? 'selected' : '' ?>>Non-Aktif</option>
                            <option value="lulus" <?= ($siswa['status'] ?? '') == 'lulus' ? 'selected' : '' ?>>Lulus</option>
                            <option value="dropout" <?= ($siswa['status'] ?? '') == 'dropout' ? 'selected' : '' ?>>Dropout</option>
                        </select>
                    </div>
                </div>
            </div>

            <?php if (!$isEdit): ?>
            <div class="form-section mt-3">
                <h5><i class="fas fa-key me-2"></i>Akun Login</h5>
                <p class="text-muted small mb-3">Username akan dibuat otomatis berdasarkan nama. Password default: <code>siswa123</code></p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Kosongkan untuk default (siswa123)">
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="form-section mt-3">
                <h5><i class="fas fa-key me-2"></i>Reset Password</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Password Baru (opsional)</label>
                        <input type="password" name="password_baru" class="form-control"
                               placeholder="Kosongkan jika tidak diubah">
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-save"></i> <?= $isEdit ? 'Simpan Perubahan' : 'Tambah Siswa' ?>
                </button>
                <a href="<?= APP_URL ?>/index.php?page=admin_siswa" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/admin_footer.php'; ?>
