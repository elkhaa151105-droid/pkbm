<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('admin');

class UsersController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function index() {
        $users = $this->db->fetchAll(
            "SELECT u.*, 
             COALESCE(g.nama_lengkap, s.nama_lengkap, 'Administrator') as nama_lengkap
             FROM users u 
             LEFT JOIN guru g ON u.id=g.user_id AND u.role='guru'
             LEFT JOIN siswa s ON u.id=s.user_id AND u.role='siswa'
             ORDER BY u.role, u.username"
        );
        $page='admin_users'; $pageTitle='Manajemen User'; $breadcrumb='Admin / Sistem / Users';
        require_once __DIR__ . '/../../views/admin/users/index.php';
    }

    public function toggleStatus() {
        $id = (int)($_GET['id']??0);
        $user = $this->db->fetchOne("SELECT * FROM users WHERE id=?",[$id]);
        if ($user && $user['id'] != getCurrentUserId()) {
            $newStatus = $user['is_active'] ? 0 : 1;
            $this->db->update("UPDATE users SET is_active=? WHERE id=?",[$newStatus,$id]);
            setFlash('success','Status user berhasil diubah');
        }
        redirect('/index.php?page=admin_users');
    }

    public function resetPassword() {
        $id = (int)($_POST['id']??0);
        $password = $_POST['password']??'';
        if (strlen($password) < 6) { setFlash('error','Password minimal 6 karakter'); redirect('/index.php?page=admin_users'); }
        $this->db->update("UPDATE users SET password=? WHERE id=?", [hashPassword($password), $id]);
        setFlash('success','Password berhasil direset');
        redirect('/index.php?page=admin_users');
    }
}
