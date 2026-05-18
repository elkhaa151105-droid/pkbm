<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class AbsensiController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $tipe = sanitize($_GET['tipe']??'siswa');
        $tanggal_dari = sanitize($_GET['dari']??date('Y-m-01'));
        $tanggal_sampai = sanitize($_GET['sampai']??date('Y-m-d'));
        $kelas_filter = (int)($_GET['kelas']??0);

        if ($tipe === 'guru') {
            $sql = "SELECT a.*, g.nama_lengkap as nama FROM absensi_guru a JOIN guru g ON a.guru_id=g.id WHERE a.tanggal BETWEEN ? AND ?";
            $params = [$tanggal_dari, $tanggal_sampai];
            $absensi = $this->db->fetchAll($sql, $params);
        } else {
            $sql = "SELECT a.*, s.nama_lengkap as nama, k.nama_kelas, m.nama_mapel
                    FROM absensi_siswa a 
                    JOIN siswa s ON a.siswa_id=s.id 
                    LEFT JOIN kelas k ON s.kelas_id=k.id
                    LEFT JOIN jadwal j ON a.jadwal_id=j.id
                    LEFT JOIN mapel m ON j.mapel_id=m.id
                    WHERE a.tanggal BETWEEN ? AND ?";
            $params = [$tanggal_dari, $tanggal_sampai];
            if ($kelas_filter) { $sql .= " AND s.kelas_id=?"; $params[]=$kelas_filter; }
            $sql .= " ORDER BY a.tanggal DESC, s.nama_lengkap";
            $absensi = $this->db->fetchAll($sql, $params);
        }

        // Rekap
        $rekap = ['hadir'=>0,'sakit'=>0,'izin'=>0,'alpha'=>0];
        foreach ($absensi as $a) {
            if (isset($rekap[$a['status']])) $rekap[$a['status']]++;
        }

        $kelass = $this->db->fetchAll("SELECT * FROM kelas ORDER BY nama_kelas");
        $page='admin_absensi'; $pageTitle='Laporan Absensi'; $breadcrumb='Admin / Laporan / Absensi';
        require_once __DIR__ . '/../../views/admin/absensi/index.php';
    }
}
