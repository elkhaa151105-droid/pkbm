<?php
// app/controllers/admin/KelasController.php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class KelasController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $kelass = $this->db->fetchAll(
            "SELECT k.*, g.nama_lengkap as wali_kelas_nama, COUNT(s.id) as jumlah_siswa 
             FROM kelas k LEFT JOIN guru g ON k.wali_kelas=g.id LEFT JOIN siswa s ON k.id=s.kelas_id AND s.status='aktif'
             GROUP BY k.id ORDER BY k.nama_kelas"
        );
        $gurus = $this->db->fetchAll("SELECT * FROM guru WHERE status='aktif' ORDER BY nama_lengkap");
        $page='admin_kelas'; $pageTitle='Data Kelas'; $breadcrumb='Admin / Kelas';
        require_once __DIR__ . '/../../views/admin/kelas/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/index.php?page=admin_kelas');
        $data = sanitize($_POST);
        if (empty($data['nama_kelas'])) { setFlash('error','Nama kelas wajib diisi'); redirect('/index.php?page=admin_kelas'); }
        $this->db->insert(
            "INSERT INTO kelas (nama_kelas, program, tingkat, tahun_ajaran, wali_kelas) VALUES (?,?,?,?,?)",
            [$data['nama_kelas'],$data['program'],$data['tingkat'],$data['tahun_ajaran'],$data['wali_kelas']?:null]
        );
        setFlash('success','Kelas berhasil ditambahkan');
        redirect('/index.php?page=admin_kelas');
    }

    public function update() {
        $id=(int)($_POST['id']??0);
        $data=sanitize($_POST);
        $this->db->update(
            "UPDATE kelas SET nama_kelas=?,program=?,tingkat=?,tahun_ajaran=?,wali_kelas=? WHERE id=?",
            [$data['nama_kelas'],$data['program'],$data['tingkat'],$data['tahun_ajaran'],$data['wali_kelas']?:null,$id]
        );
        setFlash('success','Kelas berhasil diperbarui');
        redirect('/index.php?page=admin_kelas');
    }

    public function delete() {
        $id=(int)($_GET['id']??0);
        $this->db->update("DELETE FROM kelas WHERE id=?",[$id]);
        setFlash('success','Kelas berhasil dihapus');
        redirect('/index.php?page=admin_kelas');
    }
}
