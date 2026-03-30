<?php
require_once __DIR__ . '/../app/models/attendance_session.php';

// 🔌 DB connection
$db = new PDO("mysql:host=localhost;dbname=university_portal_db", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 📥 Get token from URL
$token = $_GET['token'] ?? null;
if (!$token) die("Invalid QR code");

// 🔍 Get session
$session = getSessionByToken($db, $token);
if (!$session) die("Session not found or expired");

// ✅ session_id after fetching session
$session_id = $session['id'];

// 👨‍🎓 TEMP: student ID (later from login)
$user_id = 2;

// ✅ Insert attendance
$sql = "INSERT INTO attendance (user_id, session_id, scaned_at) VALUES (?, ?, NOW())";
$stmt = $db->prepare($sql);
$stmt->execute([$user_id, $session_id]);

// ✅ Set current student status to present
$updateStatus = $db->prepare("
    UPDATE attendance
    SET status = 'present'
    WHERE user_id = ? AND session_id = ?
");
$updateStatus->execute([$user_id, $session_id]);

// ✅ Mark all other users who didn't scan as absent
$markAbsent = $db->prepare("
    UPDATE attendance a
    JOIN users u ON u.id = a.user_id
    SET a.status = 'absent'
    WHERE a.session_id = ? AND a.status IS NULL
");
$markAbsent->execute([$session_id]);

echo "<h2>Attendance recorded successfully ✅</h2>";
?>