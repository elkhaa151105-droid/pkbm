<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('siswa');

class NilaiController {
    private $db; private $siswaId;
    public function __construct() { $this->db=Database::getInstance(); $this->siswaId=$_SESSION['profile_id']??0; }
    public function index() {
        $semester=sanitize($_GET['semester']??getPengaturan('semester_aktif'));
        $tahun=sanitize($_GET['tahun']??getPengaturan('tahun_ajaran_aktif'));
        $nilais=$this->db->fetchAll("SELECT n.*,m.nama_mapel FROM nilai n JOIN mapel m ON n.mapel_id=m.id WHERE n.siswa_id=? AND n.semester=? AND n.tahun_ajaran=? ORDER BY m.nama_mapel",[$this->siswaId,$semester,$tahun]);
        $rataRata=count($nilais)>0?array_sum(array_column($nilais,'nilai_akhir'))/count($nilais):0;
        $page='siswa_nilai'; $pageTitle='Nilai Saya'; $breadcrumb='Siswa / Nilai';
        require_once __DIR__ . '/../../views/siswa/nilai/index.php';
    }
}
