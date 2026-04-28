<?php
session_start();

require_once __DIR__ . '/../app/models/attendance_session.php';

// DB connection
$db = new PDO("mysql:host=localhost;dbname=university_portal_db", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. CHECK LOGIN
if (!isset($_SESSION['id'])) {
    die("You must be logged in");
}

$user_id = $_SESSION['id'];

// Get token
$token = $_GET['token'] ?? null;
if (!$token) {
    die("Invalid QR code");
}

// Get session from token
$session = getSessionByToken($db, $token);
if (!$session) {
    die("Session not found or expired");
}

$session_id = $session['id'];

// 2. PREVENT DUPLICATE SCAN
$checkSql = "SELECT id FROM attendance WHERE user_id = ? AND session_id = ?";
$checkStmt = $db->prepare($checkSql);
$checkStmt->execute([$user_id, $session_id]);

if ($checkStmt->fetch()) {
    die("⚠️ You already scanned this session");
}

// 3. INSERT ATTENDANCE (CORRIGÉ)
$sql = "INSERT INTO attendance (user_id, session_id, status, scaned_at)
        VALUES (?, ?, 'present', NOW())";

$stmt = $db->prepare($sql);
$stmt->execute([$user_id, $session_id]);

echo "<h2>✅ Attendance recorded</h2>";
?>