<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('guru');

class DashboardController {
    private $db;
    private $guruId;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->guruId = $_SESSION['profile_id'] ?? 0;
    }

    public function index() {
        $guruId = $this->guruId;

        $guru = $this->db->fetchOne("SELECT * FROM guru WHERE id=?", [$guruId]);
        if (!$guru) { setFlash('error','Profil guru tidak ditemukan'); redirect('/index.php?page=logout'); }

        // Jadwal hari ini
        $hariIni = date('l');
        $hariMap = ['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu','Sunday'=>'Minggu'];
        $hariIndo = $hariMap[$hariIni] ?? '';

        $jadwalHariIni = $this->db->fetchAll(
            "SELECT j.*, k.nama_kelas, m.nama_mapel FROM jadwal j JOIN kelas k ON j.kelas_id=k.id JOIN mapel m ON j.mapel_id=m.id WHERE j.guru_id=? AND j.hari=? ORDER BY j.jam_mulai",
            [$guruId, $hariIndo]
        );

        // Kelas yang diajar
        $kelasDiajar = $this->db->fetchAll(
            "SELECT DISTINCT k.*, COUNT(s.id) as jumlah_siswa FROM jadwal j JOIN kelas k ON j.kelas_id=k.id LEFT JOIN siswa s ON k.id=s.kelas_id AND s.status='aktif' WHERE j.guru_id=? GROUP BY k.id",
            [$guruId]
        );

        // Tugas aktif
        $tugasAktif = $this->db->fetchAll(
            "SELECT t.*, k.nama_kelas, m.nama_mapel, COUNT(pt.id) as terkumpul FROM tugas t LEFT JOIN kelas k ON t.kelas_id=k.id LEFT JOIN mapel m ON t.mapel_id=m.id LEFT JOIN pengumpulan_tugas pt ON t.id=pt.tugas_id AND pt.status!='belum' WHERE t.guru_id=? AND t.deadline >= NOW() GROUP BY t.id ORDER BY t.deadline LIMIT 5",
            [$guruId]
        );

        // Materi terbaru
        $materiTerbaru = $this->db->fetchAll(
            "SELECT m.*, k.nama_kelas, mp.nama_mapel FROM materi m LEFT JOIN kelas k ON m.kelas_id=k.id LEFT JOIN mapel mp ON m.mapel_id=mp.id WHERE m.guru_id=? ORDER BY m.created_at DESC LIMIT 5",
            [$guruId]
        );

        $stats = [
            'kelas' => count($kelasDiajar),
            'tugas_aktif' => count($tugasAktif),
            'materi' => $this->db->fetchOne("SELECT COUNT(*) as c FROM materi WHERE guru_id=?",[$guruId])['c'] ?? 0,
            'jadwal_minggu' => $this->db->fetchOne("SELECT COUNT(*) as c FROM jadwal WHERE guru_id=?",[$guruId])['c'] ?? 0,
        ];

        $page='guru_dashboard'; $pageTitle='Dashboard'; $breadcrumb='Guru / Dashboard';
        require_once __DIR__ . '/../../views/guru/dashboard.php';
    }
}
