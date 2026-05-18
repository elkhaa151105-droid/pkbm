-- ============================================
-- DATABASE: PKBM SARI ASIH
-- ============================================

CREATE DATABASE IF NOT EXISTS pkbm_sari_asih CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pkbm_sari_asih;

-- ============================================
-- TABEL USERS
-- ============================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','guru','siswa') NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- TABEL GURU
-- ============================================
CREATE TABLE guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    nip VARCHAR(20) UNIQUE,
    nama_lengkap VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    alamat TEXT,
    no_hp VARCHAR(15),
    email VARCHAR(100),
    foto VARCHAR(255),
    status ENUM('aktif','nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================
-- TABEL KELAS
-- ============================================
CREATE TABLE kelas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(50) NOT NULL,
    program ENUM('Paket A','Paket B','Paket C') NOT NULL,
    tingkat VARCHAR(10) NOT NULL,
    tahun_ajaran VARCHAR(10) NOT NULL,
    wali_kelas INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (wali_kelas) REFERENCES guru(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================
-- TABEL SISWA
-- ============================================
CREATE TABLE siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    nisn VARCHAR(20) UNIQUE,
    nis VARCHAR(20),
    nama_lengkap VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    alamat TEXT,
    no_hp VARCHAR(15),
    email VARCHAR(100),
    foto VARCHAR(255),
    kelas_id INT,
    status ENUM('aktif','nonaktif','lulus','dropout') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================
-- TABEL MATA PELAJARAN
-- ============================================
CREATE TABLE mapel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_mapel VARCHAR(10) UNIQUE NOT NULL,
    nama_mapel VARCHAR(100) NOT NULL,
    program ENUM('Paket A','Paket B','Paket C','Semua') DEFAULT 'Semua',
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- TABEL JADWAL
-- ============================================
CREATE TABLE jadwal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kelas_id INT NOT NULL,
    mapel_id INT NOT NULL,
    guru_id INT NOT NULL,
    hari ENUM('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    ruangan VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE,
    FOREIGN KEY (mapel_id) REFERENCES mapel(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- TABEL MATERI
-- ============================================
CREATE TABLE materi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    file_path VARCHAR(255),
    tipe_file VARCHAR(20),
    kelas_id INT,
    mapel_id INT,
    guru_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE SET NULL,
    FOREIGN KEY (mapel_id) REFERENCES mapel(id) ON DELETE SET NULL,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================
-- TABEL TUGAS
-- ============================================
CREATE TABLE tugas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    file_soal VARCHAR(255),
    kelas_id INT,
    mapel_id INT,
    guru_id INT,
    deadline DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE SET NULL,
    FOREIGN KEY (mapel_id) REFERENCES mapel(id) ON DELETE SET NULL,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================
-- TABEL PENGUMPULAN TUGAS
-- ============================================
CREATE TABLE pengumpulan_tugas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tugas_id INT NOT NULL,
    siswa_id INT NOT NULL,
    file_jawaban VARCHAR(255),
    catatan TEXT,
    status ENUM('belum','terkumpul','terlambat') DEFAULT 'belum',
    nilai DECIMAL(5,2),
    feedback TEXT,
    submitted_at TIMESTAMP,
    FOREIGN KEY (tugas_id) REFERENCES tugas(id) ON DELETE CASCADE,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    UNIQUE KEY unique_pengumpulan (tugas_id, siswa_id)
) ENGINE=InnoDB;

-- ============================================
-- TABEL NILAI
-- ============================================
CREATE TABLE nilai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT NOT NULL,
    mapel_id INT NOT NULL,
    kelas_id INT NOT NULL,
    guru_id INT NOT NULL,
    nilai_harian DECIMAL(5,2),
    nilai_uts DECIMAL(5,2),
    nilai_uas DECIMAL(5,2),
    nilai_akhir DECIMAL(5,2),
    predikat VARCHAR(5),
    semester ENUM('1','2') NOT NULL,
    tahun_ajaran VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (mapel_id) REFERENCES mapel(id) ON DELETE CASCADE,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- TABEL ABSENSI SISWA
-- ============================================
CREATE TABLE absensi_siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT NOT NULL,
    jadwal_id INT,
    tanggal DATE NOT NULL,
    status ENUM('hadir','sakit','izin','alpha') NOT NULL,
    keterangan TEXT,
    guru_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (jadwal_id) REFERENCES jadwal(id) ON DELETE SET NULL,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================
-- TABEL ABSENSI GURU
-- ============================================
CREATE TABLE absensi_guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guru_id INT NOT NULL,
    tanggal DATE NOT NULL,
    jam_masuk TIME,
    jam_keluar TIME,
    status ENUM('hadir','sakit','izin','alpha') NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- TABEL ARTIKEL / BERITA
-- ============================================
CREATE TABLE artikel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    konten LONGTEXT,
    gambar VARCHAR(255),
    kategori ENUM('berita','pengumuman','artikel') DEFAULT 'berita',
    status ENUM('draft','publish') DEFAULT 'draft',
    penulis INT,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (penulis) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================
-- TABEL GALERI
-- ============================================
CREATE TABLE galeri (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    file_path VARCHAR(255) NOT NULL,
    tipe ENUM('foto','video') DEFAULT 'foto',
    kategori VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- TABEL PENDAFTARAN
-- ============================================
CREATE TABLE pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    alamat TEXT,
    no_hp VARCHAR(15),
    email VARCHAR(100),
    program ENUM('Paket A','Paket B','Paket C') NOT NULL,
    pendidikan_terakhir VARCHAR(100),
    alasan TEXT,
    dokumen VARCHAR(255),
    status ENUM('pending','diterima','ditolak') DEFAULT 'pending',
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- TABEL KONTAK
-- ============================================
CREATE TABLE kontak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subjek VARCHAR(200),
    pesan TEXT NOT NULL,
    status ENUM('belum_dibaca','sudah_dibaca') DEFAULT 'belum_dibaca',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- TABEL PENGATURAN
-- ============================================
CREATE TABLE pengaturan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_key VARCHAR(100) UNIQUE NOT NULL,
    nilai_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- DATA AWAL
-- ============================================

-- Insert pengaturan default
INSERT INTO pengaturan (nama_key, nilai_value) VALUES
('nama_pkbm', 'PKBM Sari Asih'),
('alamat', 'Jl. Pendidikan No. 1, Adiwerna, Tegal, Jawa Tengah'),
('telepon', '(0283) 123456'),
('email', 'pkbm.sariasih@gmail.com'),
('website', 'www.pkbmsariasih.sch.id'),
('visi', 'Menjadi pusat kegiatan belajar masyarakat yang unggul, berkarakter, dan berdaya saing tinggi'),
('misi', 'Menyelenggarakan pendidikan berkualitas|Memberdayakan masyarakat melalui keterampilan|Membangun karakter peserta didik'),
('sejarah', 'PKBM Sari Asih didirikan pada tahun 2005 dengan tujuan memberikan layanan pendidikan non-formal kepada masyarakat yang membutuhkan.'),
('logo', 'logo.png'),
('tahun_ajaran_aktif', '2024/2025'),
('semester_aktif', '2');

-- Insert admin default (password: admin123)
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert guru demo (password: guru123)
INSERT INTO users (username, password, role) VALUES
('guru.budi', '$2y$10$TKh8H1.PfuA2iofHeaven.XFbGZ.H3X1R1/wXTGUQFKw8xFAf9y6', 'guru'),
('guru.siti', '$2y$10$TKh8H1.PfuA2iofHeaven.XFbGZ.H3X1R1/wXTGUQFKw8xFAf9y6', 'guru');

-- Insert siswa demo (password: siswa123)
INSERT INTO users (username, password, role) VALUES
('siswa.andi', '$2y$10$TKh8H1.PfuA2iofHeaven.XFbGZ.H3X1R1/wXTGUQFKw8xFAf9y6', 'siswa'),
('siswa.rina', '$2y$10$TKh8H1.PfuA2iofHeaven.XFbGZ.H3X1R1/wXTGUQFKw8xFAf9y6', 'siswa');

-- Insert data guru
INSERT INTO guru (user_id, nip, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, no_hp, email, status) VALUES
(2, '198501012010011001', 'Budi Santoso, S.Pd', 'L', 'Tegal', '1985-01-01', 'Jl. Merdeka No.5 Tegal', '081234567890', 'budi@pkbm.com', 'aktif'),
(3, '199001012015012002', 'Siti Rahayu, S.Pd', 'P', 'Brebes', '1990-01-01', 'Jl. Pahlawan No.10 Brebes', '082345678901', 'siti@pkbm.com', 'aktif');

-- Insert data kelas
INSERT INTO kelas (nama_kelas, program, tingkat, tahun_ajaran, wali_kelas) VALUES
('Paket C Tingkat I', 'Paket C', 'I', '2024/2025', 1),
('Paket C Tingkat II', 'Paket C', 'II', '2024/2025', 2),
('Paket B Tingkat I', 'Paket B', 'I', '2024/2025', 1);

-- Insert data siswa
INSERT INTO siswa (user_id, nisn, nis, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, no_hp, kelas_id, status) VALUES
(4, '0012345678', '24001', 'Andi Prasetyo', 'L', 'Tegal', '2000-03-15', 'Jl. Raya Adiwerna No.12', '085678901234', 1, 'aktif'),
(5, '0087654321', '24002', 'Rina Wulandari', 'P', 'Tegal', '2001-07-22', 'Jl. Gatot Subroto No.8', '086789012345', 1, 'aktif');

-- Insert mata pelajaran
INSERT INTO mapel (kode_mapel, nama_mapel, program, deskripsi) VALUES
('MTK', 'Matematika', 'Semua', 'Mata pelajaran matematika'),
('BIN', 'Bahasa Indonesia', 'Semua', 'Mata pelajaran bahasa indonesia'),
('IPA', 'Ilmu Pengetahuan Alam', 'Semua', 'Mata pelajaran IPA'),
('IPS', 'Ilmu Pengetahuan Sosial', 'Semua', 'Mata pelajaran IPS'),
('BIG', 'Bahasa Inggris', 'Paket B', 'Mata pelajaran bahasa inggris'),
('PKN', 'PKn', 'Semua', 'Pendidikan Kewarganegaraan');

-- Insert jadwal
INSERT INTO jadwal (kelas_id, mapel_id, guru_id, hari, jam_mulai, jam_selesai, ruangan) VALUES
(1, 1, 1, 'Senin', '08:00:00', '10:00:00', 'Ruang 1'),
(1, 2, 2, 'Senin', '10:00:00', '12:00:00', 'Ruang 1'),
(1, 3, 1, 'Selasa', '08:00:00', '10:00:00', 'Ruang 1'),
(1, 4, 2, 'Rabu', '08:00:00', '10:00:00', 'Ruang 2');

-- Insert artikel
INSERT INTO artikel (judul, slug, konten, kategori, status, penulis) VALUES
('Selamat Datang di PKBM Sari Asih', 'selamat-datang-pkbm-sari-asih', '<p>PKBM Sari Asih hadir untuk memberikan layanan pendidikan non-formal yang berkualitas bagi masyarakat. Kami berkomitmen untuk membantu setiap warga belajar meraih cita-citanya.</p><p>Dengan program Paket A, B, dan C, kami siap memfasilitasi kebutuhan pendidikan Anda.</p>', 'berita', 'publish', 1),
('Penerimaan Peserta Didik Baru 2024/2025', 'ppdb-2024-2025', '<p>PKBM Sari Asih membuka pendaftaran peserta didik baru tahun ajaran 2024/2025. Pendaftaran dibuka mulai 1 Juli 2024 hingga 31 Agustus 2024.</p><p>Segera daftarkan diri Anda dan raih masa depan yang lebih cerah bersama kami!</p>', 'pengumuman', 'publish', 1);
