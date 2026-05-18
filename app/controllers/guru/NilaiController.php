<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('guru');

class NilaiController {
    private $db;
    private $guruId;
    public function __construct() { $this->db=Database::getInstance(); $this->guruId=$_SESSION['profile_id']??0; }

    public function index() {
        $kelas_id=(int)($_GET['kelas']??0);
        $mapel_id=(int)($_GET['mapel']??0);
        $semester=sanitize($_GET['semester']??getPengaturan('semester_aktif'));
        $tahun=sanitize($_GET['tahun']??getPengaturan('tahun_ajaran_aktif'));

        $kelass=$this->db->fetchAll("SELECT DISTINCT k.* FROM jadwal j JOIN kelas k ON j.kelas_id=k.id WHERE j.guru_id=?",[$this->guruId]);
        $mapels=$this->db->fetchAll("SELECT DISTINCT m.* FROM jadwal j JOIN mapel m ON j.mapel_id=m.id WHERE j.guru_id=?",[$this->guruId]);

        $siswas=[]; $nilaiMap=[];
        if ($kelas_id && $mapel_id) {
            $siswas=$this->db->fetchAll("SELECT * FROM siswa WHERE kelas_id=? AND status='aktif' ORDER BY nama_lengkap",[$kelas_id]);
            $existingNilai=$this->db->fetchAll("SELECT * FROM nilai WHERE kelas_id=? AND mapel_id=? AND guru_id=? AND semester=? AND tahun_ajaran=?",[$kelas_id,$mapel_id,$this->guruId,$semester,$tahun]);
            foreach ($existingNilai as $n) $nilaiMap[$n['siswa_id']]=$n;
        }

        $page='guru_nilai'; $pageTitle='Input Nilai'; $breadcrumb='Guru / Nilai';
        require_once __DIR__ . '/../../views/guru/nilai/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD']!=='POST') redirect('/index.php?page=guru_nilai');
        $kelas_id=(int)($_POST['kelas_id']??0);
        $mapel_id=(int)($_POST['mapel_id']??0);
        $semester=sanitize($_POST['semester']??'');
        $tahun=sanitize($_POST['tahun_ajaran']??'');
        $nilaiData=$_POST['nilai']??[];

        foreach ($nilaiData as $siswa_id=>$n) {
            $siswa_id=(int)$siswa_id;
            $nh=isset($n['harian'])?floatval($n['harian']):null;
            $nuts=isset($n['uts'])?floatval($n['uts']):null;
            $nuas=isset($n['uas'])?floatval($n['uas']):null;
            $na=null;
            if ($nh!==null && $nuts!==null && $nuas!==null) {
                $na=round(($nh*0.3)+($nuts*0.3)+($nuas*0.4),2);
            }
            $grade=$na!==null?getGradeLabel($na)['label']:null;
            $existing=$this->db->fetchOne("SELECT id FROM nilai WHERE siswa_id=? AND mapel_id=? AND kelas_id=? AND guru_id=? AND semester=? AND tahun_ajaran=?",[$siswa_id,$mapel_id,$kelas_id,$this->guruId,$semester,$tahun]);
            if ($existing) {
                $this->db->update("UPDATE nilai SET nilai_harian=?,nilai_uts=?,nilai_uas=?,nilai_akhir=?,predikat=? WHERE id=?",[$nh,$nuts,$nuas,$na,$grade,$existing['id']]);
            } else {
                $this->db->insert("INSERT INTO nilai (siswa_id,mapel_id,kelas_id,guru_id,nilai_harian,nilai_uts,nilai_uas,nilai_akhir,predikat,semester,tahun_ajaran) VALUES (?,?,?,?,?,?,?,?,?,?,?)",[$siswa_id,$mapel_id,$kelas_id,$this->guruId,$nh,$nuts,$nuas,$na,$grade,$semester,$tahun]);
            }
        }
        setFlash('success','Nilai berhasil disimpan');
        redirect("/index.php?page=guru_nilai&kelas=$kelas_id&mapel=$mapel_id&semester=$semester&tahun=$tahun");
    }
}
