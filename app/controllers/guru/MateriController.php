<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('guru');

class MateriController {
    private $db;
    private $guruId;
    public function __construct() { $this->db = Database::getInstance(); $this->guruId = $_SESSION['profile_id']??0; }

    public function index() {
        $materis = $this->db->fetchAll(
            "SELECT m.*, k.nama_kelas, mp.nama_mapel FROM materi m LEFT JOIN kelas k ON m.kelas_id=k.id LEFT JOIN mapel mp ON m.mapel_id=mp.id WHERE m.guru_id=? ORDER BY m.created_at DESC",
            [$this->guruId]
        );
        $kelass = $this->db->fetchAll("SELECT DISTINCT k.* FROM jadwal j JOIN kelas k ON j.kelas_id=k.id WHERE j.guru_id=?",[$this->guruId]);
        $mapels = $this->db->fetchAll("SELECT DISTINCT m.* FROM jadwal j JOIN mapel m ON j.mapel_id=m.id WHERE j.guru_id=?",[$this->guruId]);
        $page='guru_materi'; $pageTitle='Materi Pembelajaran'; $breadcrumb='Guru / Materi';
        require_once __DIR__ . '/../../views/guru/materi/index.php';
    }

    public function store() {
        $data = sanitize($_POST);
        $filePath = null; $tipeFile = null;
        if (!empty($_FILES['file']['name'])) {
            $upload = uploadFile($_FILES['file'], 'materi');
            if ($upload['success']) {
                $filePath = $upload['filename'];
                $tipeFile = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            } else { setFlash('error',$upload['message']); redirect('/index.php?page=guru_materi'); }
        }
        $this->db->insert(
            "INSERT INTO materi (judul,deskripsi,file_path,tipe_file,kelas_id,mapel_id,guru_id) VALUES (?,?,?,?,?,?,?)",
            [$data['judul'],$data['deskripsi']??null,$filePath,$tipeFile,$data['kelas_id']?:null,$data['mapel_id']?:null,$this->guruId]
        );
        setFlash('success','Materi berhasil diupload');
        redirect('/index.php?page=guru_materi');
    }

    public function delete() {
        $id=(int)($_GET['id']??0);
        $m=$this->db->fetchOne("SELECT * FROM materi WHERE id=? AND guru_id=?",[$id,$this->guruId]);
        if ($m) {
            if ($m['file_path']) deleteFile($m['file_path']);
            $this->db->update("DELETE FROM materi WHERE id=?",[$id]);
            setFlash('success','Materi berhasil dihapus');
        }
        redirect('/index.php?page=guru_materi');
    }
}
