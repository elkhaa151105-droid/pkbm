<?php
require_once __DIR__ . '/../../../config/app.php';
requireLogin('guru');

class AbsensiController {
    private $db;
    private $guruId;
    public function __construct() { $this->db=Database::getInstance(); $this->guruId=$_SESSION['profile_id']??0; }

    public function index() {
        $kelas_id=(int)($_GET['kelas']??0);
        $tanggal=sanitize($_GET['tanggal']??date('Y-m-d'));
        $jadwal_id=(int)($_GET['jadwal']??0);

        $kelass=$this->db->fetchAll("SELECT DISTINCT k.* FROM jadwal j JOIN kelas k ON j.kelas_id=k.id WHERE j.guru_id=?",[$this->guruId]);
        $jadwalList=[]; $siswas=[]; $absensiMap=[];

        if ($kelas_id) {
            $hariMap=['1'=>'Senin','2'=>'Selasa','3'=>'Rabu','4'=>'Kamis','5'=>'Jumat','6'=>'Sabtu','7'=>'Minggu'];
            $hari=$hariMap[date('N',strtotime($tanggal))]??'';
            $jadwalList=$this->db->fetchAll("SELECT j.*,m.nama_mapel FROM jadwal j JOIN mapel m ON j.mapel_id=m.id WHERE j.guru_id=? AND j.kelas_id=? AND j.hari=? ORDER BY j.jam_mulai",[$this->guruId,$kelas_id,$hari]);
            $siswas=$this->db->fetchAll("SELECT * FROM siswa WHERE kelas_id=? AND status='aktif' ORDER BY nama_lengkap",[$kelas_id]);
            if ($jadwal_id) {
                $existing=$this->db->fetchAll("SELECT * FROM absensi_siswa WHERE jadwal_id=? AND tanggal=?",[$jadwal_id,$tanggal]);
                foreach ($existing as $a) $absensiMap[$a['siswa_id']]=$a;
            }
        }

        $page='guru_absensi'; $pageTitle='Input Absensi'; $breadcrumb='Guru / Absensi';
        require_once __DIR__ . '/../../views/guru/absensi/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD']!=='POST') redirect('/index.php?page=guru_absensi');
        $kelas_id=(int)($_POST['kelas_id']??0);
        $jadwal_id=(int)($_POST['jadwal_id']??0);
        $tanggal=sanitize($_POST['tanggal']??date('Y-m-d'));
        $absensi=$_POST['absensi']??[];
        $keterangan=$_POST['keterangan']??[];

        foreach ($absensi as $siswa_id=>$status) {
            $siswa_id=(int)$siswa_id;
            $ket=sanitize($keterangan[$siswa_id]??'');
            $existing=$this->db->fetchOne("SELECT id FROM absensi_siswa WHERE siswa_id=? AND jadwal_id=? AND tanggal=?",[$siswa_id,$jadwal_id,$tanggal]);
            if ($existing) {
                $this->db->update("UPDATE absensi_siswa SET status=?,keterangan=? WHERE id=?",[$status,$ket,$existing['id']]);
            } else {
                $this->db->insert("INSERT INTO absensi_siswa (siswa_id,jadwal_id,tanggal,status,keterangan,guru_id) VALUES (?,?,?,?,?,?)",[$siswa_id,$jadwal_id,$tanggal,$status,$ket,$this->guruId]);
            }
        }
        setFlash('success','Absensi berhasil disimpan');
        redirect("/index.php?page=guru_absensi&kelas=$kelas_id&tanggal=$tanggal&jadwal=$jadwal_id");
    }
}
