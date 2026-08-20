<?php
declare(strict_types=1);
$host = 'localhost';
$db   = 'gps_tracker';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try { $pdo = new PDO($dsn, $user, $pass, $options); }
catch (PDOException $e) { http_response_code(500); die('Database connection failed: '.htmlspecialchars($e->getMessage())); }
session_start();
function require_login(): void { if (empty($_SESSION['user'])) { header('Location: /gps_tracker/login.php'); exit; } }
function require_role(string $role): void { require_login(); if (($_SESSION['user']['role'] ?? '') !== $role) { http_response_code(403); exit('Forbidden'); } }
