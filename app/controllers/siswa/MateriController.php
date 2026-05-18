<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('siswa');

class MateriController {
    private $db; private $siswaId; private $kelasId;
    public function __construct() { $this->db=Database::getInstance(); $this->siswaId=$_SESSION['profile_id']??0; $this->kelasId=$_SESSION['kelas_id']??0; }

    public function index() {
        $mapel_filter=(int)($_GET['mapel']??0);
        $sql="SELECT m.*,mp.nama_mapel,g.nama_lengkap as nama_guru FROM materi m LEFT JOIN mapel mp ON m.mapel_id=mp.id LEFT JOIN guru g ON m.guru_id=g.id WHERE m.kelas_id=?";
        $params=[$this->kelasId];
        if ($mapel_filter) { $sql.=" AND m.mapel_id=?"; $params[]=$mapel_filter; }
        $sql.=" ORDER BY m.created_at DESC";
        $materis=$this->db->fetchAll($sql,$params);
        $mapels=$this->db->fetchAll("SELECT DISTINCT mp.* FROM materi m JOIN mapel mp ON m.mapel_id=mp.id WHERE m.kelas_id=?",[$this->kelasId]);
        $page='siswa_materi'; $pageTitle='Materi Pembelajaran'; $breadcrumb='Siswa / Materi';
        require_once __DIR__ . '/../../views/siswa/materi/index.php';
    }
}
