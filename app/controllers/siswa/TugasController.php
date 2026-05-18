<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('siswa');

class TugasController {
    private $db; private $siswaId; private $kelasId;
    public function __construct() { $this->db=Database::getInstance(); $this->siswaId=$_SESSION['profile_id']??0; $this->kelasId=$_SESSION['kelas_id']??0; }

    public function index() {
        $tugas=$this->db->fetchAll(
            "SELECT t.*,m.nama_mapel,g.nama_lengkap as nama_guru,pt.status as status_kumpul,pt.nilai,pt.submitted_at FROM tugas t JOIN mapel m ON t.mapel_id=m.id JOIN guru g ON t.guru_id=g.id LEFT JOIN pengumpulan_tugas pt ON t.id=pt.tugas_id AND pt.siswa_id=? WHERE t.kelas_id=? ORDER BY t.deadline",
            [$this->siswaId,$this->kelasId]
        );
        $page='siswa_tugas'; $pageTitle='Tugas'; $breadcrumb='Siswa / Tugas';
        require_once __DIR__ . '/../../views/siswa/tugas/index.php';
    }

    public function kumpulkan() {
        if ($_SERVER['REQUEST_METHOD']!=='POST') redirect('/index.php?page=siswa_tugas');
        $tugas_id=(int)($_POST['tugas_id']??0);
        $catatan=sanitize($_POST['catatan']??'');
        $tugas=$this->db->fetchOne("SELECT * FROM tugas WHERE id=? AND kelas_id=?",[$tugas_id,$this->kelasId]);
        if (!$tugas) { setFlash('error','Tugas tidak ditemukan'); redirect('/index.php?page=siswa_tugas'); }

        $file=null;
        if (!empty($_FILES['file_jawaban']['name'])) {
            $upload=uploadFile($_FILES['file_jawaban'],'tugas_jawaban');
            if ($upload['success']) $file=$upload['filename'];
            else { setFlash('error',$upload['message']); redirect('/index.php?page=siswa_tugas'); }
        }

        $status=$tugas['deadline'] && strtotime($tugas['deadline'])<time() ? 'terlambat' : 'terkumpul';
        $existing=$this->db->fetchOne("SELECT id,file_jawaban FROM pengumpulan_tugas WHERE tugas_id=? AND siswa_id=?",[$tugas_id,$this->siswaId]);
        if ($existing) {
            if ($file && $existing['file_jawaban']) deleteFile($existing['file_jawaban']);
            $this->db->update("UPDATE pengumpulan_tugas SET file_jawaban=?,catatan=?,status=?,submitted_at=NOW() WHERE id=?",[$file??$existing['file_jawaban'],$catatan,$status,$existing['id']]);
        } else {
            $this->db->insert("INSERT INTO pengumpulan_tugas (tugas_id,siswa_id,file_jawaban,catatan,status,submitted_at) VALUES (?,?,?,?,?,NOW())",[$tugas_id,$this->siswaId,$file,$catatan,$status]);
        }
        setFlash('success','Tugas berhasil dikumpulkan');
        redirect('/index.php?page=siswa_tugas');
    }
}
