<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class JadwalController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $kelas_filter = (int)($_GET['kelas']??0);
        $sql = "SELECT j.*, k.nama_kelas, m.nama_mapel, g.nama_lengkap as nama_guru 
                FROM jadwal j JOIN kelas k ON j.kelas_id=k.id JOIN mapel m ON j.mapel_id=m.id JOIN guru g ON j.guru_id=g.id WHERE 1=1";
        $params=[];
        if ($kelas_filter) { $sql.=" AND j.kelas_id=?"; $params[]=$kelas_filter; }
        $sql.=" ORDER BY FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), j.jam_mulai";
        $jadwals=$this->db->fetchAll($sql,$params);
        $kelass=$this->db->fetchAll("SELECT * FROM kelas ORDER BY nama_kelas");
        $mapels=$this->db->fetchAll("SELECT * FROM mapel ORDER BY nama_mapel");
        $gurus=$this->db->fetchAll("SELECT * FROM guru WHERE status='aktif' ORDER BY nama_lengkap");
        $page='admin_jadwal'; $pageTitle='Jadwal Pelajaran'; $breadcrumb='Admin / Jadwal';
        require_once __DIR__ . '/../../views/admin/jadwal/index.php';
    }

    public function store() {
        $data=sanitize($_POST);
        $this->db->insert(
            "INSERT INTO jadwal (kelas_id,mapel_id,guru_id,hari,jam_mulai,jam_selesai,ruangan) VALUES (?,?,?,?,?,?,?)",
            [$data['kelas_id'],$data['mapel_id'],$data['guru_id'],$data['hari'],$data['jam_mulai'],$data['jam_selesai'],$data['ruangan']??null]
        );
        setFlash('success','Jadwal berhasil ditambahkan');
        redirect('/index.php?page=admin_jadwal');
    }

    public function delete() {
        $id=(int)($_GET['id']??0);
        $this->db->update("DELETE FROM jadwal WHERE id=?",[$id]);
        setFlash('success','Jadwal berhasil dihapus');
        redirect('/index.php?page=admin_jadwal');
    }
}
