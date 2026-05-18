# 🎓 PKBM Sari Asih - Sistem Informasi Akademik

Aplikasi web berbasis PHP & MySQL dengan arsitektur MVC untuk mengelola kegiatan akademik PKBM Sari Asih.

---

## 📋 Fitur Lengkap

### 👑 Admin
- Dashboard statistik (siswa, guru, kelas, mapel)
- CRUD: Siswa, Guru, Kelas, Mata Pelajaran, Jadwal
- Manajemen User (aktivasi, reset password)
- Laporan Nilai & Absensi
- Kelola Artikel/Berita & Galeri
- Kelola Pendaftaran Online
- Pengaturan Website (nama, logo, visi-misi)

### 👨‍🏫 Guru
- Dashboard dengan jadwal hari ini
- Upload Materi Pembelajaran (PDF, PPT, Video, dll)
- Buat & Kelola Tugas + Penilaian Tugas
- Input Nilai Siswa (Harian, UTS, UAS → Nilai Akhir otomatis)
- Input Absensi Siswa per Jadwal
- Lihat Jadwal Mengajar

### 👨‍🎓 Siswa
- Dashboard personal dengan info lengkap
- Lihat Jadwal Pelajaran
- Download Materi
- Upload/Kumpulkan Tugas
- Lihat Nilai (per semester)
- Lihat Riwayat Absensi
- Edit Profil & Ganti Password

### 🌐 Publik (Tanpa Login)
- Halaman Beranda
- Profil PKBM (Visi, Misi, Sejarah)
- Informasi Program (Paket A, B, C)
- Berita & Pengumuman
- Galeri Foto & Video (dengan lightbox)
- Form Kontak
- Formulir Pendaftaran Online

---

## ⚙️ Persyaratan Sistem

- PHP >= 7.4 (direkomendasikan PHP 8.0+)
- MySQL >= 5.7 atau MariaDB >= 10.3
- Web Server: Apache (XAMPP/Laragon/WAMP)
- Ekstensi PHP: `mysqli`, `fileinfo`, `mbstring`
- Browser modern (Chrome, Firefox, Edge, Safari)

---

## 🚀 Cara Instalasi

### Langkah 1 — Copy File
Salin folder `pkbm` ke direktori web server Anda:
```
C:\xampp\htdocs\pkbm         (XAMPP Windows)
C:\laragon\www\pkbm          (Laragon)
/var/www/html/pkbm           (Linux Apache)
```

### Langkah 2 — Import Database
1. Buka **phpMyAdmin** → `http://localhost/phpmyadmin`
2. Klik **"New"** → buat database bernama `pkbm_sari_asih`
3. Pilih database tersebut → klik tab **"Import"**
4. Pilih file `database/pkbm_sari_asih.sql` → klik **"Go"**

### Langkah 3 — Konfigurasi
Edit file `config/database.php`:
```php
define('DB_HOST', 'localhost');   // Host database
define('DB_USER', 'root');        // Username MySQL
define('DB_PASS', '');            // Password MySQL (kosong jika XAMPP default)
define('DB_NAME', 'pkbm_sari_asih');
define('APP_URL', 'http://localhost/pkbm');  // Sesuaikan URL
```

### Langkah 4 — Buat Folder Upload
Pastikan folder berikut **ada dan writable**:
```
public/assets/uploads/
public/assets/uploads/foto/
public/assets/uploads/materi/
public/assets/uploads/tugas/
public/assets/uploads/tugas_jawaban/
public/assets/uploads/artikel/
public/assets/uploads/galeri/
public/assets/uploads/pendaftaran/
public/assets/uploads/logo/
```

Atau jalankan di terminal (Linux/Mac):
```bash
mkdir -p public/assets/uploads/{foto,materi,tugas,tugas_jawaban,artikel,galeri,pendaftaran,logo}
chmod -R 755 public/assets/uploads
```

### Langkah 5 — Akses Aplikasi
Buka browser dan akses:
```
http://localhost/pkbm
```

---

## 🔑 Akun Default

| Role  | Username    | Password  |
|-------|-------------|-----------|
| Admin | `admin`     | `admin123`|
| Guru  | `guru.budi` | `guru123` |
| Guru  | `guru.siti` | `guru123` |
| Siswa | `siswa.andi`| `siswa123`|
| Siswa | `siswa.rina`| `siswa123`|

> ⚠️ **Penting:** Ganti password semua akun setelah instalasi!

---

## 🗂️ Struktur Direktori

```
pkbm/
├── index.php                    ← Front Controller / Router
├── .htaccess
├── config/
│   ├── database.php             ← Konfigurasi DB & konstanta
│   └── app.php                  ← Bootstrap, helpers, Database class
├── database/
│   └── pkbm_sari_asih.sql       ← Skema & data awal
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── PublicController.php
│   │   ├── admin/               ← Controller Admin (10 file)
│   │   ├── guru/                ← Controller Guru (6 file)
│   │   └── siswa/               ← Controller Siswa (7 file)
│   └── views/
│       ├── auth/login.php
│       ├── layouts/             ← Header/footer per role
│       ├── admin/               ← View admin (10 folder)
│       ├── guru/                ← View guru (5 folder)
│       ├── siswa/               ← View siswa (6 folder)
│       └── public/              ← View publik (7 file)
└── public/
    └── assets/
        └── uploads/             ← Folder file upload
```

---

## 🎨 Teknologi yang Digunakan

| Teknologi       | Kegunaan                           |
|----------------|------------------------------------|
| PHP 7.4+       | Backend & logika aplikasi          |
| MySQL          | Database                           |
| Bootstrap 5.3  | UI Framework & Responsif           |
| DataTables     | Tabel data interaktif              |
| Chart.js       | Grafik dashboard admin             |
| Font Awesome 6 | Ikon                               |
| Plus Jakarta Sans | Font utama                      |

---

## 🐛 Troubleshooting

**Halaman Error 500:**
- Periksa konfigurasi di `config/database.php`
- Pastikan database sudah diimport

**Upload File Gagal:**
- Periksa permission folder `public/assets/uploads/`
- Pastikan PHP `upload_max_filesize` cukup (lihat `.htaccess`)

**Halaman Tidak Ditemukan:**
- Aktifkan `mod_rewrite` di Apache
- Periksa `APP_URL` di `config/database.php`

**Login Gagal:**
- Pastikan database sudah diimport dengan benar
- Coba reset password via phpMyAdmin

---

## 📞 Dukungan

Untuk pertanyaan dan dukungan teknis:
- Email: pkbm.sariasih@gmail.com

---

*Sistem Informasi PKBM Sari Asih v1.0.0*
