<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class PendaftaranController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $status_filter = sanitize($_GET['status']??'');
        $sql = "SELECT * FROM pendaftaran WHERE 1=1";
        $params = [];
        if ($status_filter) { $sql.=" AND status=?"; $params[]=$status_filter; }
        $sql .= " ORDER BY created_at DESC";
        $pendaftarans = $this->db->fetchAll($sql,$params);
        $page='admin_pendaftaran'; $pageTitle='Pendaftaran Siswa Baru'; $breadcrumb='Admin / Pendaftaran';
        require_once __DIR__ . '/../../views/admin/pendaftaran/index.php';
    }

    public function detail() {
        $id=(int)($_GET['id']??0);
        $pendaftaran = $this->db->fetchOne("SELECT * FROM pendaftaran WHERE id=?",[$id]);
        if (!$pendaftaran) { setFlash('error','Data tidak ditemukan'); redirect('/index.php?page=admin_pendaftaran'); }
        $page='admin_pendaftaran'; $pageTitle='Detail Pendaftaran'; $breadcrumb='Admin / Pendaftaran / Detail';
        require_once __DIR__ . '/../../views/admin/pendaftaran/detail.php';
    }

    public function updateStatus() {
        $id=(int)($_POST['id']??0);
        $status = sanitize($_POST['status']??'');
        $catatan = sanitize($_POST['catatan']??'');
        $this->db->update("UPDATE pendaftaran SET status=?, catatan=? WHERE id=?",[$status,$catatan,$id]);
        setFlash('success','Status pendaftaran berhasil diperbarui');
        redirect('/index.php?page=admin_pendaftaran');
    }

    public function delete() {
        $id=(int)($_GET['id']??0);
        $p = $this->db->fetchOne("SELECT * FROM pendaftaran WHERE id=?",[$id]);
        if ($p && $p['dokumen']) deleteFile($p['dokumen']);
        $this->db->update("DELETE FROM pendaftaran WHERE id=?",[$id]);
        setFlash('success','Data pendaftaran berhasil dihapus');
        redirect('/index.php?page=admin_pendaftaran');
    }
}
