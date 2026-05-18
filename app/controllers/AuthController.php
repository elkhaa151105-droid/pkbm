<?php
// app/controllers/AuthController.php

require_once __DIR__ . '/../../config/app.php';

class AuthController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function login() {
        // If already logged in, redirect to dashboard
        if (isLoggedIn()) {
            $this->redirectToDashboard(getRole());
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = sanitize($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = 'Username dan password harus diisi';
            } else {
                $user = $this->db->fetchOne(
                    "SELECT * FROM users WHERE username = ? AND is_active = 1",
                    [$username]
                );

                if ($user && verifyPassword($password, $user['password'])) {
                    // Set session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // Load role-specific data
                    $this->loadUserProfile($user);

                    setFlash('success', 'Login berhasil! Selamat datang, ' . $user['username']);
                    $this->redirectToDashboard($user['role']);
                } else {
                    $error = 'Username atau password salah, atau akun tidak aktif';
                }
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        redirect('/index.php?page=login');
    }

    private function loadUserProfile($user) {
        switch ($user['role']) {
            case 'guru':
                $profile = $this->db->fetchOne(
                    "SELECT * FROM guru WHERE user_id = ?",
                    [$user['id']]
                );
                if ($profile) {
                    $_SESSION['profile_id'] = $profile['id'];
                    $_SESSION['nama_lengkap'] = $profile['nama_lengkap'];
                    $_SESSION['foto'] = $profile['foto'];
                }
                break;
            case 'siswa':
                $profile = $this->db->fetchOne(
                    "SELECT s.*, k.nama_kelas FROM siswa s LEFT JOIN kelas k ON s.kelas_id = k.id WHERE s.user_id = ?",
                    [$user['id']]
                );
                if ($profile) {
                    $_SESSION['profile_id'] = $profile['id'];
                    $_SESSION['nama_lengkap'] = $profile['nama_lengkap'];
                    $_SESSION['foto'] = $profile['foto'];
                    $_SESSION['kelas_id'] = $profile['kelas_id'];
                    $_SESSION['nama_kelas'] = $profile['nama_kelas'];
                }
                break;
            case 'admin':
                $_SESSION['nama_lengkap'] = 'Administrator';
                $_SESSION['foto'] = null;
                break;
        }
    }

    private function redirectToDashboard($role) {
        switch ($role) {
            case 'admin':
                redirect('/index.php?page=admin_dashboard');
                break;
            case 'guru':
                redirect('/index.php?page=guru_dashboard');
                break;
            case 'siswa':
                redirect('/index.php?page=siswa_dashboard');
                break;
            default:
                redirect('/index.php?page=login');
        }
    }
}
