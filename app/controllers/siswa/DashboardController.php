<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('siswa');

class DashboardController {
    private $db;
    private $siswaId;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->siswaId = $_SESSION['profile_id'] ?? 0;
    }

    public function index() {
        $siswaId = $this->siswaId;
        $siswa = $this->db->fetchOne("SELECT s.*,k.nama_kelas,k.program FROM siswa s LEFT JOIN kelas k ON s.kelas_id=k.id WHERE s.id=?",[$siswaId]);
        if (!$siswa) { setFlash('error','Profil tidak ditemukan'); redirect('/index.php?page=logout'); }

        $kelasId = $siswa['kelas_id'];
        $tahun = getPengaturan('tahun_ajaran_aktif');
        $semester = getPengaturan('semester_aktif');

        // Jadwal hari ini
        $hariMap=['1'=>'Senin','2'=>'Selasa','3'=>'Rabu','4'=>'Kamis','5'=>'Jumat','6'=>'Sabtu'];
        $hariIni=$hariMap[date('N')]??'';
        $jadwalHariIni=$this->db->fetchAll(
            "SELECT j.*,m.nama_mapel,g.nama_lengkap as nama_guru FROM jadwal j JOIN mapel m ON j.mapel_id=m.id JOIN guru g ON j.guru_id=g.id WHERE j.kelas_id=? AND j.hari=? ORDER BY j.jam_mulai",
            [$kelasId,$hariIni]
        );

        // Tugas yang belum dikumpulkan
        $tugasBelum=$this->db->fetchAll(
            "SELECT t.*,m.nama_mapel,g.nama_lengkap as nama_guru FROM tugas t JOIN mapel m ON t.mapel_id=m.id JOIN guru g ON t.guru_id=g.id WHERE t.kelas_id=? AND t.deadline>=NOW() AND t.id NOT IN (SELECT tugas_id FROM pengumpulan_tugas WHERE siswa_id=? AND status!='belum') ORDER BY t.deadline LIMIT 5",
            [$kelasId,$siswaId]
        );

        // Nilai terbaru
        $nilaiTerbaru=$this->db->fetchAll(
            "SELECT n.*,m.nama_mapel FROM nilai n JOIN mapel m ON n.mapel_id=m.id WHERE n.siswa_id=? AND n.semester=? AND n.tahun_ajaran=? ORDER BY n.updated_at DESC LIMIT 6",
            [$siswaId,$semester,$tahun]
        );

        // Materi terbaru
        $materiTerbaru=$this->db->fetchAll(
            "SELECT m.*,mp.nama_mapel FROM materi m LEFT JOIN mapel mp ON m.mapel_id=mp.id WHERE m.kelas_id=? ORDER BY m.created_at DESC LIMIT 4",
            [$kelasId]
        );

        // Rekap absensi bulan ini
        $absensiRekap=$this->db->fetchOne(
            "SELECT SUM(CASE WHEN status='hadir' THEN 1 ELSE 0 END) as hadir, SUM(CASE WHEN status='sakit' THEN 1 ELSE 0 END) as sakit, SUM(CASE WHEN status='izin' THEN 1 ELSE 0 END) as izin, SUM(CASE WHEN status='alpha' THEN 1 ELSE 0 END) as alpha FROM absensi_siswa WHERE siswa_id=? AND MONTH(tanggal)=MONTH(NOW())",
            [$siswaId]
        );

        $page='siswa_dashboard'; $pageTitle='Dashboard'; $breadcrumb='Siswa / Dashboard';
        require_once __DIR__ . '/../../views/siswa/dashboard.php';
    }
}
