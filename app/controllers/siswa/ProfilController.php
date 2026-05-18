<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('siswa');

class ProfilController {
    private $db; private $siswaId;
    public function __construct() { $this->db=Database::getInstance(); $this->siswaId=$_SESSION['profile_id']??0; }

    public function index() {
        $siswa=$this->db->fetchOne("SELECT s.*,u.username,k.nama_kelas FROM siswa s LEFT JOIN users u ON s.user_id=u.id LEFT JOIN kelas k ON s.kelas_id=k.id WHERE s.id=?",[$this->siswaId]);
        $page='siswa_profil'; $pageTitle='Profil Saya'; $breadcrumb='Siswa / Profil';
        require_once __DIR__ . '/../../views/siswa/profil/index.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD']!=='POST') redirect('/index.php?page=siswa_profil');
        $data=sanitize($_POST);
        $siswa=$this->db->fetchOne("SELECT * FROM siswa WHERE id=?",[$this->siswaId]);

        $foto=$siswa['foto'];
        if (!empty($_FILES['foto']['name'])) {
            $upload=uploadFile($_FILES['foto'],'foto',['jpg','jpeg','png']);
            if ($upload['success']) { if ($foto) deleteFile($foto); $foto=$upload['filename']; $_SESSION['foto']=$foto; }
        }

        $this->db->update("UPDATE siswa SET tempat_lahir=?,tanggal_lahir=?,alamat=?,no_hp=?,email=?,foto=? WHERE id=?",[$data['tempat_lahir']??null,$data['tanggal_lahir']??null,$data['alamat']??null,$data['no_hp']??null,$data['email']??null,$foto,$this->siswaId]);

        if (!empty($_POST['password_lama']) && !empty($_POST['password_baru'])) {
            $user=$this->db->fetchOne("SELECT * FROM users WHERE id=?",[$siswa['user_id']]);
            if (verifyPassword($_POST['password_lama'],$user['password'])) {
                if (strlen($_POST['password_baru'])>=6) {
                    $this->db->update("UPDATE users SET password=? WHERE id=?", [hashPassword($_POST['password_baru']),$siswa['user_id']]);
                    setFlash('success','Profil dan password berhasil diperbarui');
                } else { setFlash('error','Password baru minimal 6 karakter'); }
            } else { setFlash('error','Password lama tidak sesuai'); }
        } else {
            setFlash('success','Profil berhasil diperbarui');
        }
        redirect('/index.php?page=siswa_profil');
    }
}
