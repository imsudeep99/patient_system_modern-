<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in() {
    return isset($_SESSION['user']);
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function require_login($role = null) {
    if (!is_logged_in()) {
        header("Location: /patient_system_modern/login.php");
        exit;
    }
    if ($role && (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== $role)) {
        header("Location: /patient_system_modern/dashboard.php");
        exit;
    }
}

function redirect($path) {
    header("Location: " . $path);
    exit;
}
