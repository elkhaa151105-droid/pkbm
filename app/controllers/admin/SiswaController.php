<?php
// app/controllers/admin/SiswaController.php

require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class SiswaController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function index() {
        $search = sanitize($_GET['search'] ?? '');
        $kelas_filter = (int)($_GET['kelas'] ?? 0);

        $sql = "SELECT s.*, k.nama_kelas, u.username FROM siswa s 
                LEFT JOIN kelas k ON s.kelas_id=k.id 
                LEFT JOIN users u ON s.user_id=u.id
                WHERE 1=1";
        $params = [];

        if ($search) {
            $sql .= " AND (s.nama_lengkap LIKE ? OR s.nisn LIKE ? OR s.nis LIKE ?)";
            $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
        }
        if ($kelas_filter) {
            $sql .= " AND s.kelas_id = ?";
            $params[] = $kelas_filter;
        }

        $sql .= " ORDER BY s.nama_lengkap ASC";
        $siswas = $this->db->fetchAll($sql, $params);
        $kelass = $this->db->fetchAll("SELECT * FROM kelas ORDER BY nama_kelas");

        $page = 'admin_siswa';
        $pageTitle = 'Data Siswa';
        $breadcrumb = 'Admin / Akademik / Siswa';
        require_once __DIR__ . '/../../views/admin/siswa/index.php';
    }

    public function create() {
        $kelass = $this->db->fetchAll("SELECT * FROM kelas ORDER BY nama_kelas");
        $page = 'admin_siswa';
        $pageTitle = 'Tambah Siswa';
        $breadcrumb = 'Admin / Siswa / Tambah';
        require_once __DIR__ . '/../../views/admin/siswa/form.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/index.php?page=admin_siswa');
        }

        $data = sanitize($_POST);
        $errors = $this->validate($data);

        if (!empty($errors)) {
            setFlash('error', implode(', ', $errors));
            redirect('/index.php?page=admin_siswa&action=create');
        }

        // Handle foto upload
        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            $upload = uploadFile($_FILES['foto'], 'foto', ['jpg', 'jpeg', 'png', 'gif']);
            if ($upload['success']) {
                $foto = $upload['filename'];
            }
        }

        // Create user account
        $username = strtolower(str_replace(' ', '.', $data['nama_lengkap'])) . '.' . ($data['nis'] ?? rand(100, 999));
        $password = hashPassword($data['password'] ?? 'siswa123');

        $userId = $this->db->insert(
            "INSERT INTO users (username, password, role) VALUES (?, ?, 'siswa')",
            [$username, $password]
        );

        // Insert siswa
        $this->db->insert(
            "INSERT INTO siswa (user_id, nisn, nis, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, no_hp, email, foto, kelas_id, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $userId,
                $data['nisn'] ?? null,
                $data['nis'] ?? null,
                $data['nama_lengkap'],
                $data['jenis_kelamin'],
                $data['tempat_lahir'] ?? null,
                $data['tanggal_lahir'] ?? null,
                $data['alamat'] ?? null,
                $data['no_hp'] ?? null,
                $data['email'] ?? null,
                $foto,
                $data['kelas_id'] ?: null,
                $data['status'] ?? 'aktif'
            ]
        );

        setFlash('success', "Siswa {$data['nama_lengkap']} berhasil ditambahkan. Username: $username");
        redirect('/index.php?page=admin_siswa');
    }

    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $siswa = $this->db->fetchOne(
            "SELECT s.*, u.username FROM siswa s LEFT JOIN users u ON s.user_id=u.id WHERE s.id=?",
            [$id]
        );
        if (!$siswa) {
            setFlash('error', 'Data siswa tidak ditemukan');
            redirect('/index.php?page=admin_siswa');
        }
        $kelass = $this->db->fetchAll("SELECT * FROM kelas ORDER BY nama_kelas");
        $page = 'admin_siswa';
        $pageTitle = 'Edit Siswa';
        $breadcrumb = 'Admin / Siswa / Edit';
        require_once __DIR__ . '/../../views/admin/siswa/form.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/index.php?page=admin_siswa');

        $id = (int)($_POST['id'] ?? 0);
        $data = sanitize($_POST);

        $siswa = $this->db->fetchOne("SELECT * FROM siswa WHERE id=?", [$id]);
        if (!$siswa) {
            setFlash('error', 'Data tidak ditemukan');
            redirect('/index.php?page=admin_siswa');
        }

        $foto = $siswa['foto'];
        if (!empty($_FILES['foto']['name'])) {
            $upload = uploadFile($_FILES['foto'], 'foto', ['jpg', 'jpeg', 'png', 'gif']);
            if ($upload['success']) {
                if ($foto) deleteFile($foto);
                $foto = $upload['filename'];
            }
        }

        $this->db->update(
            "UPDATE siswa SET nisn=?, nis=?, nama_lengkap=?, jenis_kelamin=?, tempat_lahir=?, tanggal_lahir=?, alamat=?, no_hp=?, email=?, foto=?, kelas_id=?, status=? WHERE id=?",
            [
                $data['nisn'] ?? null,
                $data['nis'] ?? null,
                $data['nama_lengkap'],
                $data['jenis_kelamin'],
                $data['tempat_lahir'] ?? null,
                $data['tanggal_lahir'] ?? null,
                $data['alamat'] ?? null,
                $data['no_hp'] ?? null,
                $data['email'] ?? null,
                $foto,
                $data['kelas_id'] ?: null,
                $data['status'] ?? 'aktif',
                $id
            ]
        );

        // Update password jika diisi
        if (!empty($_POST['password_baru'])) {
            $this->db->update(
                "UPDATE users SET password=? WHERE id=?",
                [hashPassword($_POST['password_baru']), $siswa['user_id']]
            );
        }

        setFlash('success', "Data siswa berhasil diperbarui");
        redirect('/index.php?page=admin_siswa');
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        $siswa = $this->db->fetchOne("SELECT * FROM siswa WHERE id=?", [$id]);
        if (!$siswa) {
            setFlash('error', 'Data tidak ditemukan');
        } else {
            if ($siswa['foto']) deleteFile($siswa['foto']);
            if ($siswa['user_id']) {
                $this->db->update("DELETE FROM users WHERE id=?", [$siswa['user_id']]);
            }
            $this->db->update("DELETE FROM siswa WHERE id=?", [$id]);
            setFlash('success', 'Data siswa berhasil dihapus');
        }
        redirect('/index.php?page=admin_siswa');
    }

    private function validate($data) {
        $errors = [];
        if (empty($data['nama_lengkap'])) $errors[] = 'Nama lengkap wajib diisi';
        if (empty($data['jenis_kelamin'])) $errors[] = 'Jenis kelamin wajib dipilih';
        return $errors;
    }
}
