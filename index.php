<?php
// index.php - Front Controller / Router

require_once __DIR__ . '/config/app.php';

// Get page param
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// ============================================
// ROUTING
// ============================================

// Auth routes
if ($page === 'login') {
    require_once __DIR__ . '/app/controllers/AuthController.php';
    $ctrl = new AuthController();
    $ctrl->login();
    exit();
}

if ($page === 'logout') {
    require_once __DIR__ . '/app/controllers/AuthController.php';
    $ctrl = new AuthController();
    $ctrl->logout();
    exit();
}

// Unauthorized
if ($page === 'unauthorized') {
    require_once __DIR__ . '/app/views/layouts/unauthorized.php';
    exit();
}

// Public routes
$publicPages = ['home', 'profil', 'program', 'berita', 'galeri', 'kontak', 'daftar', 'berita_detail'];
if (in_array($page, $publicPages)) {
    require_once __DIR__ . '/app/controllers/PublicController.php';
    $ctrl = new PublicController();
    if (method_exists($ctrl, $page)) {
        $ctrl->$page();
    } else {
        $ctrl->home();
    }
    exit();
}

// Protected routes - require login
if (!isLoggedIn()) {
    setFlash('warning', 'Silakan login terlebih dahulu');
    redirect('/index.php?page=login');
}

$role = getRole();

// Admin routes
if ($role === 'admin' && str_starts_with($page, 'admin_')) {
    $controllerName = str_replace('admin_', '', $page);
    $controllerFile = __DIR__ . "/app/controllers/admin/" . ucfirst($controllerName) . "Controller.php";
    
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $className = ucfirst($controllerName) . "Controller";
        $ctrl = new $className();
        if (method_exists($ctrl, $action)) {
            $ctrl->$action();
        } else {
            $ctrl->index();
        }
    } else {
        // Default admin dashboard
        require_once __DIR__ . '/app/controllers/admin/DashboardController.php';
        $ctrl = new DashboardController();
        $ctrl->index();
    }
    exit();
}

// Guru routes
if ($role === 'guru' && str_starts_with($page, 'guru_')) {
    $controllerName = str_replace('guru_', '', $page);
    $controllerFile = __DIR__ . "/app/controllers/guru/" . ucfirst($controllerName) . "Controller.php";
    
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $className = ucfirst($controllerName) . "Controller";
        $ctrl = new $className();
        if (method_exists($ctrl, $action)) {
            $ctrl->$action();
        } else {
            $ctrl->index();
        }
    } else {
        require_once __DIR__ . '/app/controllers/guru/DashboardController.php';
        $ctrl = new DashboardController();
        $ctrl->index();
    }
    exit();
}

// Siswa routes
if ($role === 'siswa' && str_starts_with($page, 'siswa_')) {
    $controllerName = str_replace('siswa_', '', $page);
    $controllerFile = __DIR__ . "/app/controllers/siswa/" . ucfirst($controllerName) . "Controller.php";
    
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $className = ucfirst($controllerName) . "Controller";
        $ctrl = new $className();
        if (method_exists($ctrl, $action)) {
            $ctrl->$action();
        } else {
            $ctrl->index();
        }
    } else {
        require_once __DIR__ . '/app/controllers/siswa/DashboardController.php';
        $ctrl = new DashboardController();
        $ctrl->index();
    }
    exit();
}

// Redirect to role dashboard if no valid page
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
