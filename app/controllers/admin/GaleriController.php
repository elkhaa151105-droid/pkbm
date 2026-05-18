<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class GaleriController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $galeris = $this->db->fetchAll("SELECT * FROM galeri ORDER BY created_at DESC");
        $page='admin_galeri'; $pageTitle='Galeri'; $breadcrumb='Admin / Konten / Galeri';
        require_once __DIR__ . '/../../views/admin/galeri/index.php';
    }

    public function store() {
        $data = sanitize($_POST);
        $file = null;
        if (!empty($_FILES['file']['name'])) {
            $allowed = ($data['tipe']??'foto') === 'video' ? ['mp4','webm'] : ['jpg','jpeg','png','gif','webp'];
            $upload = uploadFile($_FILES['file'], 'galeri', $allowed);
            if ($upload['success']) $file = $upload['filename'];
            else { setFlash('error', $upload['message']); redirect('/index.php?page=admin_galeri'); }
        }
        $this->db->insert(
            "INSERT INTO galeri (judul, deskripsi, file_path, tipe, kategori) VALUES (?,?,?,?,?)",
            [$data['judul'], $data['deskripsi']??null, $file, $data['tipe']??'foto', $data['kategori']??null]
        );
        setFlash('success','Item galeri berhasil ditambahkan');
        redirect('/index.php?page=admin_galeri');
    }

    public function delete() {
        $id=(int)($_GET['id']??0);
        $g = $this->db->fetchOne("SELECT * FROM galeri WHERE id=?",[$id]);
        if ($g && $g['file_path']) deleteFile($g['file_path']);
        $this->db->update("DELETE FROM galeri WHERE id=?",[$id]);
        setFlash('success','Item galeri berhasil dihapus');
        redirect('/index.php?page=admin_galeri');
    }
}
