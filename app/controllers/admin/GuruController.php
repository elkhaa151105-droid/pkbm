<?php
// app/controllers/admin/GuruController.php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class GuruController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $search = sanitize($_GET['search'] ?? '');
        $sql = "SELECT g.*, u.username FROM guru g LEFT JOIN users u ON g.user_id=u.id WHERE 1=1";
        $params = [];
        if ($search) {
            $sql .= " AND (g.nama_lengkap LIKE ? OR g.nip LIKE ?)";
            $params = ["%$search%", "%$search%"];
        }
        $sql .= " ORDER BY g.nama_lengkap";
        $gurus = $this->db->fetchAll($sql, $params);
        $page = 'admin_guru'; $pageTitle = 'Data Guru'; $breadcrumb = 'Admin / Guru';
        require_once __DIR__ . '/../../views/admin/guru/index.php';
    }

    public function create() {
        $page = 'admin_guru'; $pageTitle = 'Tambah Guru'; $breadcrumb = 'Admin / Guru / Tambah';
        require_once __DIR__ . '/../../views/admin/guru/form.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/index.php?page=admin_guru');
        $data = sanitize($_POST);
        if (empty($data['nama_lengkap'])) { setFlash('error','Nama wajib diisi'); redirect('/index.php?page=admin_guru&action=create'); }

        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            $upload = uploadFile($_FILES['foto'], 'foto', ['jpg','jpeg','png']);
            if ($upload['success']) $foto = $upload['filename'];
        }

        $username = strtolower(str_replace(' ', '.', explode(',', $data['nama_lengkap'])[0]));
        $username = 'guru.' . preg_replace('/[^a-z0-9.]/', '', $username);
        $password = hashPassword($data['password'] ?? 'guru123');

        $userId = $this->db->insert("INSERT INTO users (username, password, role) VALUES (?, ?, 'guru')", [$username, $password]);

        $this->db->insert(
            "INSERT INTO guru (user_id, nip, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, no_hp, email, foto, status) VALUES (?,?,?,?,?,?,?,?,?,?,?)",
            [$userId, $data['nip']??null, $data['nama_lengkap'], $data['jenis_kelamin'], $data['tempat_lahir']??null, $data['tanggal_lahir']??null, $data['alamat']??null, $data['no_hp']??null, $data['email']??null, $foto, $data['status']??'aktif']
        );
        setFlash('success', "Guru {$data['nama_lengkap']} berhasil ditambahkan. Username: $username");
        redirect('/index.php?page=admin_guru');
    }

    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $guru = $this->db->fetchOne("SELECT g.*, u.username FROM guru g LEFT JOIN users u ON g.user_id=u.id WHERE g.id=?", [$id]);
        if (!$guru) { setFlash('error','Data tidak ditemukan'); redirect('/index.php?page=admin_guru'); }
        $page = 'admin_guru'; $pageTitle = 'Edit Guru'; $breadcrumb = 'Admin / Guru / Edit';
        require_once __DIR__ . '/../../views/admin/guru/form.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/index.php?page=admin_guru');
        $id = (int)($_POST['id'] ?? 0);
        $data = sanitize($_POST);
        $guru = $this->db->fetchOne("SELECT * FROM guru WHERE id=?", [$id]);
        if (!$guru) { setFlash('error','Data tidak ditemukan'); redirect('/index.php?page=admin_guru'); }

        $foto = $guru['foto'];
        if (!empty($_FILES['foto']['name'])) {
            $upload = uploadFile($_FILES['foto'], 'foto', ['jpg','jpeg','png']);
            if ($upload['success']) { if ($foto) deleteFile($foto); $foto = $upload['filename']; }
        }

        $this->db->update(
            "UPDATE guru SET nip=?,nama_lengkap=?,jenis_kelamin=?,tempat_lahir=?,tanggal_lahir=?,alamat=?,no_hp=?,email=?,foto=?,status=? WHERE id=?",
            [$data['nip']??null,$data['nama_lengkap'],$data['jenis_kelamin'],$data['tempat_lahir']??null,$data['tanggal_lahir']??null,$data['alamat']??null,$data['no_hp']??null,$data['email']??null,$foto,$data['status']??'aktif',$id]
        );
        if (!empty($_POST['password_baru'])) {
            $this->db->update("UPDATE users SET password=? WHERE id=?", [hashPassword($_POST['password_baru']), $guru['user_id']]);
        }
        setFlash('success','Data guru berhasil diperbarui');
        redirect('/index.php?page=admin_guru');
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        $guru = $this->db->fetchOne("SELECT * FROM guru WHERE id=?", [$id]);
        if ($guru) {
            if ($guru['foto']) deleteFile($guru['foto']);
            if ($guru['user_id']) $this->db->update("DELETE FROM users WHERE id=?", [$guru['user_id']]);
            $this->db->update("DELETE FROM guru WHERE id=?", [$id]);
            setFlash('success','Data guru berhasil dihapus');
        }
        redirect('/index.php?page=admin_guru');
    }
}
