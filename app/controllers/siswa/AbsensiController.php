<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('siswa');

class AbsensiController {
    private $db; private $siswaId;
    public function __construct() { $this->db=Database::getInstance(); $this->siswaId=$_SESSION['profile_id']??0; }
    public function index() {
        $bulan=sanitize($_GET['bulan']??date('Y-m'));
        $dari=$bulan.'-01';
        $sampai=date('Y-m-t',strtotime($dari));
        $absensi=$this->db->fetchAll("SELECT a.*,j.jam_mulai,m.nama_mapel FROM absensi_siswa a LEFT JOIN jadwal j ON a.jadwal_id=j.id LEFT JOIN mapel m ON j.mapel_id=m.id WHERE a.siswa_id=? AND a.tanggal BETWEEN ? AND ? ORDER BY a.tanggal DESC",[$this->siswaId,$dari,$sampai]);
        $rekap=$this->db->fetchOne("SELECT SUM(status='hadir') as hadir, SUM(status='sakit') as sakit, SUM(status='izin') as izin, SUM(status='alpha') as alpha FROM absensi_siswa WHERE siswa_id=? AND tanggal BETWEEN ? AND ?",[$this->siswaId,$dari,$sampai]);
        $page='siswa_absensi'; $pageTitle='Absensi Saya'; $breadcrumb='Siswa / Absensi';
        require_once __DIR__ . '/../../views/siswa/absensi/index.php';
    }
}
