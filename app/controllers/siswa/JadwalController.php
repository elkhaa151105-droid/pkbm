<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('siswa');

class JadwalController {
    private $db; private $siswaId; private $kelasId;
    public function __construct() { $this->db=Database::getInstance(); $this->siswaId=$_SESSION['profile_id']??0; $this->kelasId=$_SESSION['kelas_id']??0; }
    public function index() {
        $jadwal=$this->db->fetchAll("SELECT j.*,m.nama_mapel,g.nama_lengkap as nama_guru FROM jadwal j JOIN mapel m ON j.mapel_id=m.id JOIN guru g ON j.guru_id=g.id WHERE j.kelas_id=? ORDER BY FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'),j.jam_mulai",[$this->kelasId]);
        $page='siswa_jadwal'; $pageTitle='Jadwal Pelajaran'; $breadcrumb='Siswa / Jadwal';
        require_once __DIR__ . '/../../views/siswa/jadwal/index.php';
    }
}
