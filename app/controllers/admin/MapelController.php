<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class MapelController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $mapels = $this->db->fetchAll("SELECT * FROM mapel ORDER BY nama_mapel");
        $page='admin_mapel'; $pageTitle='Mata Pelajaran'; $breadcrumb='Admin / Mapel';
        require_once __DIR__ . '/../../views/admin/mapel/index.php';
    }

    public function store() {
        $data = sanitize($_POST);
        $this->db->insert(
            "INSERT INTO mapel (kode_mapel, nama_mapel, program, deskripsi) VALUES (?,?,?,?)",
            [$data['kode_mapel'],$data['nama_mapel'],$data['program']??'Semua',$data['deskripsi']??null]
        );
        setFlash('success','Mata pelajaran berhasil ditambahkan');
        redirect('/index.php?page=admin_mapel');
    }

    public function update() {
        $id=(int)($_POST['id']??0);
        $data=sanitize($_POST);
        $this->db->update(
            "UPDATE mapel SET kode_mapel=?,nama_mapel=?,program=?,deskripsi=? WHERE id=?",
            [$data['kode_mapel'],$data['nama_mapel'],$data['program']??'Semua',$data['deskripsi']??null,$id]
        );
        setFlash('success','Mata pelajaran berhasil diperbarui');
        redirect('/index.php?page=admin_mapel');
    }

    public function delete() {
        $id=(int)($_GET['id']??0);
        $this->db->update("DELETE FROM mapel WHERE id=?",[$id]);
        setFlash('success','Mata pelajaran berhasil dihapus');
        redirect('/index.php?page=admin_mapel');
    }
}
