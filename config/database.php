<?php
// config/database.php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pkbm_sari_asih');
define('DB_CHARSET', 'utf8mb4');

// App Config
define('APP_NAME', 'PKBM Sari Asih');
define('APP_VERSION', '1.0.0');

// Dynamic APP_URL — otomatis menyesuaikan host & path server
if (!defined('APP_URL')) {
    $__protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $__host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
    // Ambil direktori dari SCRIPT_NAME, hapus "/public" di akhir jika ada
    $__dir      = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
    $__dir      = rtrim(str_replace('/public', '', $__dir), '/');
    define('APP_URL', $__protocol . '://' . $__host . $__dir);
}

// Upload Config
define('UPLOAD_PATH', __DIR__ . '/../public/assets/uploads/');
define('UPLOAD_URL', APP_URL . '/public/assets/uploads/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_EXTENSIONS', ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif', 'mp4', 'zip']);

// Session Config
define('SESSION_NAME', 'pkbm_session');
define('SESSION_LIFETIME', 3600 * 8); // 8 hours

// Timezone
date_default_timezone_set('Asia/Jakarta');
