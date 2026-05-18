<?php
// config/app.php - Bootstrap & Autoloader

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load config
require_once __DIR__ . '/database.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// ============================================
// DATABASE CONNECTION (Singleton)
// ============================================
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->connection->connect_error) {
            die(json_encode(['error' => 'Database connection failed: ' . $this->connection->connect_error]));
        }
        $this->connection->set_charset(DB_CHARSET);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql, $params = [], $types = '') {
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new Exception("Query error: " . $this->connection->error . " | SQL: " . $sql);
        }
        if (!empty($params)) {
            if (empty($types)) {
                $types = str_repeat('s', count($params));
            }
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    }

    public function fetchAll($sql, $params = [], $types = '') {
        $stmt = $this->query($sql, $params, $types);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchOne($sql, $params = [], $types = '') {
        $stmt = $this->query($sql, $params, $types);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function insert($sql, $params = [], $types = '') {
        $stmt = $this->query($sql, $params, $types);
        return $this->connection->insert_id;
    }

    public function update($sql, $params = [], $types = '') {
        $stmt = $this->query($sql, $params, $types);
        return $stmt->affected_rows;
    }

    public function escape($value) {
        return $this->connection->real_escape_string($value);
    }

    public function lastInsertId() {
        return $this->connection->insert_id;
    }
}

// ============================================
// HELPER FUNCTIONS
// ============================================

function redirect($url) {
    header("Location: " . APP_URL . $url);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function getRole() {
    return $_SESSION['role'] ?? null;
}

function requireLogin($role = null) {
    if (!isLoggedIn()) {
        redirect('/index.php?page=login');
    }
    if ($role !== null && getRole() !== $role) {
        redirect('/index.php?page=unauthorized');
    }
}

function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function formatDate($date, $format = 'd F Y') {
    if (empty($date) || $date == '0000-00-00') return '-';
    $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $d = date('d', strtotime($date));
    $m = $months[(int)date('m', strtotime($date))];
    $y = date('Y', strtotime($date));
    return "$d $m $y";
}

function formatRupiah($amount) {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function uploadFile($file, $folder = 'uploads', $allowed = null) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload gagal'];
    }
    
    $allowedExt = $allowed ?? ALLOWED_EXTENSIONS;
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($ext, $allowedExt)) {
        return ['success' => false, 'message' => 'Tipe file tidak diizinkan'];
    }
    
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'Ukuran file terlalu besar (maks 10MB)'];
    }
    
    $targetDir = UPLOAD_PATH . $folder . '/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    
    $newName = uniqid() . '_' . time() . '.' . $ext;
    $targetPath = $targetDir . $newName;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'filename' => $folder . '/' . $newName];
    }
    
    return ['success' => false, 'message' => 'Gagal menyimpan file'];
}

function deleteFile($filename) {
    $path = UPLOAD_PATH . $filename;
    if (file_exists($path)) {
        return unlink($path);
    }
    return false;
}

function getFileUrl($filename) {
    if (empty($filename)) return '';
    return UPLOAD_URL . $filename;
}

function getPengaturan($key) {
    try {
        $db = Database::getInstance();
        $row = $db->fetchOne("SELECT nilai_value FROM pengaturan WHERE nama_key = ?", [$key]);
        return $row ? $row['nilai_value'] : '';
    } catch (Exception $e) {
        return '';
    }
}

function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function displayFlash() {
    $flash = getFlash();
    if ($flash) {
        $type = $flash['type'];
        $message = $flash['message'];
        $alertClass = match($type) {
            'success' => 'alert-success',
            'error', 'danger' => 'alert-danger',
            'warning' => 'alert-warning',
            default => 'alert-info'
        };
        echo "<div class='alert $alertClass alert-dismissible fade show' role='alert'>
                <i class='fas fa-" . ($type == 'success' ? 'check-circle' : 'exclamation-circle') . " me-2'></i>
                {$message}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
}

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

function getGradeLabel($nilai) {
    if ($nilai >= 90) return ['label' => 'A', 'class' => 'success'];
    if ($nilai >= 80) return ['label' => 'B', 'class' => 'primary'];
    if ($nilai >= 70) return ['label' => 'C', 'class' => 'warning'];
    if ($nilai >= 60) return ['label' => 'D', 'class' => 'secondary'];
    return ['label' => 'E', 'class' => 'danger'];
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getCurrentUserData() {
    return $_SESSION['user_data'] ?? null;
}
