<?php
require_once __DIR__ . '/../../config/app.php';

class PublicController {
    private $db;
    public function __construct() { $this->db = Database::getInstance(); }

    public function home() {
        $artikels=$this->db->fetchAll("SELECT * FROM artikel WHERE status='publish' ORDER BY created_at DESC LIMIT 3");
        $galeris=$this->db->fetchAll("SELECT * FROM galeri ORDER BY created_at DESC LIMIT 8");
        $settings=$this->getSettings();
        require_once __DIR__ . '/../views/public/home.php';
    }

    public function profil() {
        $settings=$this->getSettings();
        require_once __DIR__ . '/../views/public/profil.php';
    }

    public function program() {
        $settings=$this->getSettings();
        require_once __DIR__ . '/../views/public/program.php';
    }

    public function berita() {
        $kategori=sanitize($_GET['kategori']??'');
        $sql="SELECT * FROM artikel WHERE status='publish'";
        $params=[];
        if ($kategori) { $sql.=" AND kategori=?"; $params[]=$kategori; }
        $sql.=" ORDER BY created_at DESC";
        $artikels=$this->db->fetchAll($sql,$params);
        $settings=$this->getSettings();
        require_once __DIR__ . '/../views/public/berita.php';
    }

    public function berita_detail() {
        $slug=sanitize($_GET['slug']??'');
        $artikel=$this->db->fetchOne("SELECT * FROM artikel WHERE slug=? AND status='publish'",[$slug]);
        if (!$artikel) { header('Location: '.APP_URL.'/index.php?page=berita'); exit; }
        $this->db->update("UPDATE artikel SET views=views+1 WHERE id=?",[$artikel['id']]);
        $related=$this->db->fetchAll("SELECT * FROM artikel WHERE status='publish' AND id!=? ORDER BY created_at DESC LIMIT 3",[$artikel['id']]);
        $settings=$this->getSettings();
        require_once __DIR__ . '/../views/public/berita_detail.php';
    }

    public function galeri() {
        $galeris=$this->db->fetchAll("SELECT * FROM galeri ORDER BY created_at DESC");
        $settings=$this->getSettings();
        require_once __DIR__ . '/../views/public/galeri.php';
    }

    public function kontak() {
        $success=false;
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $data=sanitize($_POST);
            if (!empty($data['nama']) && !empty($data['email']) && !empty($data['pesan'])) {
                $this->db->insert("INSERT INTO kontak (nama,email,subjek,pesan) VALUES (?,?,?,?)",[$data['nama'],$data['email'],$data['subjek']??null,$data['pesan']]);
                $success=true;
            }
        }
        $settings=$this->getSettings();
        require_once __DIR__ . '/../views/public/kontak.php';
    }

    public function daftar() {
        $success=false;
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $data=sanitize($_POST);
            $dokumen=null;
            if (!empty($_FILES['dokumen']['name'])) {
                $upload=uploadFile($_FILES['dokumen'],'pendaftaran',['pdf','jpg','jpeg','png']);
                if ($upload['success']) $dokumen=$upload['filename'];
            }
            if (!empty($data['nama_lengkap']) && !empty($data['program'])) {
                $this->db->insert(
                    "INSERT INTO pendaftaran (nama_lengkap,jenis_kelamin,tempat_lahir,tanggal_lahir,alamat,no_hp,email,program,pendidikan_terakhir,alasan,dokumen) VALUES (?,?,?,?,?,?,?,?,?,?,?)",
                    [$data['nama_lengkap'],$data['jenis_kelamin'],$data['tempat_lahir']??null,$data['tanggal_lahir']??null,$data['alamat']??null,$data['no_hp']??null,$data['email']??null,$data['program'],$data['pendidikan_terakhir']??null,$data['alasan']??null,$dokumen]
                );
                $success=true;
            }
        }
        $settings=$this->getSettings();
        require_once __DIR__ . '/../views/public/daftar.php';
    }

    private function getSettings() {
        $rows=$this->db->fetchAll("SELECT * FROM pengaturan");
        $s=[];
        foreach ($rows as $r) $s[$r['nama_key']]=$r['nilai_value'];
        return $s;
    }
}
