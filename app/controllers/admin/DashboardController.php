<?php
// app/controllers/admin/DashboardController.php

require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class DashboardController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function index() {
        // Stats
        $stats = [
            'total_siswa' => $this->db->fetchOne("SELECT COUNT(*) as c FROM siswa WHERE status='aktif'")['c'] ?? 0,
            'total_guru' => $this->db->fetchOne("SELECT COUNT(*) as c FROM guru WHERE status='aktif'")['c'] ?? 0,
            'total_kelas' => $this->db->fetchOne("SELECT COUNT(*) as c FROM kelas")['c'] ?? 0,
            'total_mapel' => $this->db->fetchOne("SELECT COUNT(*) as c FROM mapel")['c'] ?? 0,
            'pendaftaran_pending' => $this->db->fetchOne("SELECT COUNT(*) as c FROM pendaftaran WHERE status='pending'")['c'] ?? 0,
            'pesan_baru' => $this->db->fetchOne("SELECT COUNT(*) as c FROM kontak WHERE status='belum_dibaca'")['c'] ?? 0,
        ];

        // Recent siswa
        $recentSiswa = $this->db->fetchAll(
            "SELECT s.*, k.nama_kelas FROM siswa s LEFT JOIN kelas k ON s.kelas_id=k.id ORDER BY s.created_at DESC LIMIT 5"
        );

        // Recent pendaftaran
        $recentPendaftaran = $this->db->fetchAll(
            "SELECT * FROM pendaftaran ORDER BY created_at DESC LIMIT 5"
        );

        // Siswa per kelas
        $siswaPerKelas = $this->db->fetchAll(
            "SELECT k.nama_kelas, COUNT(s.id) as total FROM kelas k LEFT JOIN siswa s ON k.id=s.kelas_id AND s.status='aktif' GROUP BY k.id ORDER BY total DESC"
        );

        // Artikel terbaru
        $recentArtikel = $this->db->fetchAll(
            "SELECT * FROM artikel WHERE status='publish' ORDER BY created_at DESC LIMIT 3"
        );

        $page = 'admin_dashboard';
        $pageTitle = 'Dashboard';
        $breadcrumb = 'Admin / Dashboard';

        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }
}
