<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('guru');

class TugasController {
    private $db;
    private $guruId;
    public function __construct() { $this->db = Database::getInstance(); $this->guruId = $_SESSION['profile_id']??0; }

    public function index() {
        $tugas = $this->db->fetchAll(
            "SELECT t.*, k.nama_kelas, m.nama_mapel, COUNT(pt.id) as terkumpul, (SELECT COUNT(*) FROM siswa WHERE kelas_id=t.kelas_id AND status='aktif') as total_siswa
             FROM tugas t LEFT JOIN kelas k ON t.kelas_id=k.id LEFT JOIN mapel m ON t.mapel_id=m.id
             LEFT JOIN pengumpulan_tugas pt ON t.id=pt.tugas_id AND pt.status!='belum'
             WHERE t.guru_id=? GROUP BY t.id ORDER BY t.created_at DESC",
            [$this->guruId]
        );
        $kelass = $this->db->fetchAll("SELECT DISTINCT k.* FROM jadwal j JOIN kelas k ON j.kelas_id=k.id WHERE j.guru_id=?",[$this->guruId]);
        $mapels = $this->db->fetchAll("SELECT DISTINCT m.* FROM jadwal j JOIN mapel m ON j.mapel_id=m.id WHERE j.guru_id=?",[$this->guruId]);
        $page='guru_tugas'; $pageTitle='Kelola Tugas'; $breadcrumb='Guru / Tugas';
        require_once __DIR__ . '/../../views/guru/tugas/index.php';
    }

    public function detail() {
        $id=(int)($_GET['id']??0);
        $tugas = $this->db->fetchOne("SELECT t.*,k.nama_kelas,m.nama_mapel FROM tugas t LEFT JOIN kelas k ON t.kelas_id=k.id LEFT JOIN mapel m ON t.mapel_id=m.id WHERE t.id=? AND t.guru_id=?",[$id,$this->guruId]);
        if (!$tugas) { setFlash('error','Tugas tidak ditemukan'); redirect('/index.php?page=guru_tugas'); }

        $pengumpulan = $this->db->fetchAll(
            "SELECT pt.*,s.nama_lengkap,s.nisn FROM pengumpulan_tugas pt JOIN siswa s ON pt.siswa_id=s.id WHERE pt.tugas_id=? ORDER BY pt.submitted_at",
            [$id]
        );
        $belumKumpul = $this->db->fetchAll(
            "SELECT s.* FROM siswa s WHERE s.kelas_id=? AND s.status='aktif' AND s.id NOT IN (SELECT siswa_id FROM pengumpulan_tugas WHERE tugas_id=?)",
            [$tugas['kelas_id'],$id]
        );

        $page='guru_tugas'; $pageTitle='Detail Tugas'; $breadcrumb='Guru / Tugas / Detail';
        require_once __DIR__ . '/../../views/guru/tugas/detail.php';
    }

    public function store() {
        $data = sanitize($_POST);
        $file = null;
        if (!empty($_FILES['file_soal']['name'])) {
            $upload = uploadFile($_FILES['file_soal'],'tugas');
            if ($upload['success']) $file = $upload['filename'];
        }
        $this->db->insert(
            "INSERT INTO tugas (judul,deskripsi,file_soal,kelas_id,mapel_id,guru_id,deadline) VALUES (?,?,?,?,?,?,?)",
            [$data['judul'],$data['deskripsi']??null,$file,$data['kelas_id']?:null,$data['mapel_id']?:null,$this->guruId,$data['deadline']??null]
        );
        setFlash('success','Tugas berhasil dibuat');
        redirect('/index.php?page=guru_tugas');
    }

    public function nilaiTugas() {
        if ($_SERVER['REQUEST_METHOD']!=='POST') redirect('/index.php?page=guru_tugas');
        $id=(int)($_POST['pengumpulan_id']??0);
        $nilai=sanitize($_POST['nilai']??'');
        $feedback=sanitize($_POST['feedback']??'');
        $this->db->update("UPDATE pengumpulan_tugas SET nilai=?,feedback=? WHERE id=?",[$nilai,$feedback,$id]);
        setFlash('success','Nilai berhasil disimpan');
        $tugas_id=(int)($_POST['tugas_id']??0);
        redirect("/index.php?page=guru_tugas&action=detail&id=$tugas_id");
    }

    public function delete() {
        $id=(int)($_GET['id']??0);
        $t=$this->db->fetchOne("SELECT * FROM tugas WHERE id=? AND guru_id=?",[$id,$this->guruId]);
        if ($t) {
            if ($t['file_soal']) deleteFile($t['file_soal']);
            $this->db->update("DELETE FROM tugas WHERE id=?",[$id]);
            setFlash('success','Tugas berhasil dihapus');
        }
        redirect('/index.php?page=guru_tugas');
    }
}
