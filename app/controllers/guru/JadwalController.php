<?php
require_once __DIR__.'/../../../config/app.php';
requireLogin('guru');

class JadwalController {
    private $db; private $guruId;
    public function __construct() { $this->db=Database::getInstance(); $this->guruId=$_SESSION['profile_id']??0; }
    public function index() {
        $jadwal=$this->db->fetchAll("SELECT j.*,k.nama_kelas,m.nama_mapel FROM jadwal j JOIN kelas k ON j.kelas_id=k.id JOIN mapel m ON j.mapel_id=m.id WHERE j.guru_id=? ORDER BY FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'),j.jam_mulai",[$this->guruId]);
        $page='guru_jadwal'; $pageTitle='Jadwal Mengajar'; $breadcrumb='Guru / Jadwal';
        require_once __DIR__.'/../../views/guru/jadwal/index.php';
    }
}
