<?php
// start_session.php

// 🔌 Connect to database
$db = new PDO("mysql:host=localhost;dbname=university_portal_db", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 👨‍🏫 Teacher ID (temporary)
$user_id = 1;

// ➕ Include QR library
require_once __DIR__ . '/../utils/phpqrcode/qrlib.php'; // this points to utils/qrcode.php

// ➕ Include attendance session model
require_once __DIR__ . '/../app/models/attendance_session.php';

// ➕ Create session
$token = createSession($db, $user_id);

// 📁 Create folder if not exists
$folder = __DIR__ . '/qr_codes';
if (!file_exists($folder)) {
    mkdir($folder, 0755, true);
}

// 🖼️ Generate QR code
// The QR library in utils/qrcode.php should define QRcode class and method png()
$url = "http://localhost/university_portal/public/scan.php?token=" . $token;

QRcode::png($url, $folder . "/session_$token.png");
// 🌐 Display QR
echo "<h2>Scan this QR code:</h2>";
echo "<img src='qr_codes/session_$token.png'>";
?>