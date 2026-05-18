<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class NilaiController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $kelas_filter = (int)($_GET['kelas']??0);
        $mapel_filter = (int)($_GET['mapel']??0);
        $semester = sanitize($_GET['semester']??'');
        $tahun = sanitize($_GET['tahun']??getPengaturan('tahun_ajaran_aktif'));

        $sql = "SELECT n.*, s.nama_lengkap as nama_siswa, s.nisn, m.nama_mapel, k.nama_kelas, g.nama_lengkap as nama_guru
                FROM nilai n 
                JOIN siswa s ON n.siswa_id=s.id
                JOIN mapel m ON n.mapel_id=m.id
                JOIN kelas k ON n.kelas_id=k.id
                JOIN guru g ON n.guru_id=g.id
                WHERE n.tahun_ajaran=?";
        $params = [$tahun];

        if ($kelas_filter) { $sql.=" AND n.kelas_id=?"; $params[]=$kelas_filter; }
        if ($mapel_filter) { $sql.=" AND n.mapel_id=?"; $params[]=$mapel_filter; }
        if ($semester) { $sql.=" AND n.semester=?"; $params[]=$semester; }
        $sql .= " ORDER BY k.nama_kelas, s.nama_lengkap, m.nama_mapel";

        $nilais = $this->db->fetchAll($sql, $params);
        $kelass = $this->db->fetchAll("SELECT * FROM kelas ORDER BY nama_kelas");
        $mapels = $this->db->fetchAll("SELECT * FROM mapel ORDER BY nama_mapel");

        $page='admin_nilai'; $pageTitle='Nilai Siswa'; $breadcrumb='Admin / Laporan / Nilai';
        require_once __DIR__ . '/../../views/admin/nilai/index.php';
    }
}
