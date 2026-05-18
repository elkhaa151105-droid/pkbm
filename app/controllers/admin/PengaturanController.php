<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class PengaturanController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $settings = $this->db->fetchAll("SELECT * FROM pengaturan ORDER BY nama_key");
        $settingMap = [];
        foreach ($settings as $s) $settingMap[$s['nama_key']] = $s['nilai_value'];
        $page='admin_pengaturan'; $pageTitle='Pengaturan Website'; $breadcrumb='Admin / Sistem / Pengaturan';
        require_once __DIR__ . '/../../views/admin/pengaturan/index.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/index.php?page=admin_pengaturan');
        
        $fields = ['nama_pkbm','alamat','telepon','email','website','visi','misi','sejarah','tahun_ajaran_aktif','semester_aktif'];
        foreach ($fields as $field) {
            $value = sanitize($_POST[$field] ?? '');
            $this->db->update(
                "INSERT INTO pengaturan (nama_key, nilai_value) VALUES (?,?) ON DUPLICATE KEY UPDATE nilai_value=?",
                [$field, $value, $value]
            );
        }

        // Handle logo upload
        if (!empty($_FILES['logo']['name'])) {
            $upload = uploadFile($_FILES['logo'], 'logo', ['jpg','jpeg','png','gif','svg','webp']);
            if ($upload['success']) {
                $this->db->update(
                    "INSERT INTO pengaturan (nama_key,nilai_value) VALUES ('logo',?) ON DUPLICATE KEY UPDATE nilai_value=?",
                    [$upload['filename'], $upload['filename']]
                );
            }
        }

        setFlash('success','Pengaturan berhasil disimpan');
        redirect('/index.php?page=admin_pengaturan');
    }
}
