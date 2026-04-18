<?php
// start_session.php

// 🔌 Connect to database
$db = new PDO("mysql:host=localhost;dbname=university_portal_db", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 👨‍🏫 Teacher ID (temporary)
$user_id = 1;

// ➕ Include QR library
require_once __DIR__ . '/../utils/phpqrcode/qrlib.php';

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
$url = "http://localhost/university_portal/public/scan.php?token=" . $token;
QRcode::png($url, $folder . "/session_$token.png");

// Path for display
$qr_path = "qr_codes/session_$token.png";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session de présence</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <div class="card">

        <!-- Logos -->
        <div class="top-logos">
            <div class="logo-side">
                <img src="assets/logo_university.png" class="side-logo">
            </div>

            <div class="logo-center">
                <img src="assets/logo_progress.png" class="progress-logo">
            </div>

            <div class="logo-side">
                <img src="assets/logo_faculty.png" class="side-logo">
            </div>
        </div>

        <!-- Title -->
        <h1 class="main-title">Session de présence</h1>

        <!-- Description -->
        <p class="description-fr">
            Les étudiants doivent scanner ce QR code pour enregistrer leur présence.
        </p>

        <p class="description-ar" dir="rtl">
            يجب على الطلبة مسح رمز QR لتسجيل حضورهم
        </p>

        <!-- QR Code Section -->
        <div class="section-block">
            <h2 class="section-title">📱 QR Code</h2>
            <img src="<?php echo $qr_path; ?>" alt="QR Code" style="max-width: 250px; margin-top: 15px;">
        </div>

        <!-- Optional info -->
        <div class="section-block">
            <p class="small-text">
                Token de session : <?php echo htmlspecialchars($token); ?>
            </p>
        </div>

        <!-- Back button -->
        <div class="login-links">
            <a class="small-link" href="index.php">Retour</a>
        </div>

    </div>
</div>

</body>
</html>