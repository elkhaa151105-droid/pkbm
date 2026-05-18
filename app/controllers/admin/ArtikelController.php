<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class ArtikelController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $artikels = $this->db->fetchAll(
            "SELECT a.*, u.username as penulis_name FROM artikel a LEFT JOIN users u ON a.penulis=u.id ORDER BY a.created_at DESC"
        );
        $page='admin_artikel'; $pageTitle='Artikel & Berita'; $breadcrumb='Admin / Konten / Artikel';
        require_once __DIR__ . '/../../views/admin/artikel/index.php';
    }

    public function create() {
        $page='admin_artikel'; $pageTitle='Tulis Artikel'; $breadcrumb='Admin / Artikel / Tambah';
        require_once __DIR__ . '/../../views/admin/artikel/form.php';
    }

    public function store() {
        $data = sanitize($_POST);
        $gambar = null;
        if (!empty($_FILES['gambar']['name'])) {
            $upload = uploadFile($_FILES['gambar'], 'artikel', ['jpg','jpeg','png','webp']);
            if ($upload['success']) $gambar = $upload['filename'];
        }
        $slug = slugify($data['judul']);
        // Ensure unique slug
        $existing = $this->db->fetchOne("SELECT id FROM artikel WHERE slug=?", [$slug]);
        if ($existing) $slug .= '-' . time();

        $this->db->insert(
            "INSERT INTO artikel (judul, slug, konten, gambar, kategori, status, penulis) VALUES (?,?,?,?,?,?,?)",
            [$data['judul'], $slug, $_POST['konten'], $gambar, $data['kategori']??'berita', $data['status']??'draft', getCurrentUserId()]
        );
        setFlash('success','Artikel berhasil disimpan');
        redirect('/index.php?page=admin_artikel');
    }

    public function edit() {
        $id = (int)($_GET['id']??0);
        $artikel = $this->db->fetchOne("SELECT * FROM artikel WHERE id=?",[$id]);
        if (!$artikel) { setFlash('error','Artikel tidak ditemukan'); redirect('/index.php?page=admin_artikel'); }
        $page='admin_artikel'; $pageTitle='Edit Artikel'; $breadcrumb='Admin / Artikel / Edit';
        require_once __DIR__ . '/../../views/admin/artikel/form.php';
    }

    public function update() {
        $id = (int)($_POST['id']??0);
        $data = sanitize($_POST);
        $art = $this->db->fetchOne("SELECT * FROM artikel WHERE id=?",[$id]);
        $gambar = $art['gambar'] ?? null;
        if (!empty($_FILES['gambar']['name'])) {
            $upload = uploadFile($_FILES['gambar'], 'artikel', ['jpg','jpeg','png','webp']);
            if ($upload['success']) { if ($gambar) deleteFile($gambar); $gambar = $upload['filename']; }
        }
        $this->db->update(
            "UPDATE artikel SET judul=?,konten=?,gambar=?,kategori=?,status=? WHERE id=?",
            [$data['judul'], $_POST['konten'], $gambar, $data['kategori']??'berita', $data['status']??'draft', $id]
        );
        setFlash('success','Artikel berhasil diperbarui');
        redirect('/index.php?page=admin_artikel');
    }

    public function delete() {
        $id=(int)($_GET['id']??0);
        $art = $this->db->fetchOne("SELECT * FROM artikel WHERE id=?",[$id]);
        if ($art && $art['gambar']) deleteFile($art['gambar']);
        $this->db->update("DELETE FROM artikel WHERE id=?",[$id]);
        setFlash('success','Artikel berhasil dihapus');
        redirect('/index.php?page=admin_artikel');
    }
}
