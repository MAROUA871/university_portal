<!--P14-->
<!--ABAOUI MELISSA LYNA 
212431859912
GROUPE 2
-->
<!--Bouderraz Maroua    
232335477206
GROUPE 4    
-->
<!--Aitouamar Aya
242431438719
GROUPE 2
-->
<!-- Aissaoui Yousra
 232331413601
 GROUPE 4
-->
<?php
session_start();

// 🔌 DB connection
$db = new PDO("mysql:host=localhost;dbname=university_portal_db", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 👨‍🏫 Teacher ID
$user_id = $_SESSION['id'];

// ➕ QR + model
require_once __DIR__ . '/../utils/phpqrcode/qrlib.php';
require_once __DIR__ . '/../app/models/attendance_session.php';

// ✅ GET MODULES (IMPORTANT)
$stmt = $db->prepare("SELECT id, code, name FROM modules WHERE teacher_id = ?");
$stmt->execute([$user_id]);
$modules_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$qr_path = null;
$token = null;

// ✅ FORM SUBMIT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $module_id = $_POST['module_id'];

    // create session with module
    $token = createSession($db, $user_id, $module_id);

    // create folder if needed
    $folder = __DIR__ . '/qr_codes';
    if (!file_exists($folder)) {
        mkdir($folder, 0755, true);
    }

    // generate QR
    $url = "http://localhost/university_portal/public/scan.php?token=" . $token;
    QRcode::png($url, $folder . "/session_$token.png");

    $qr_path = "qr_codes/session_$token.png";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Session de présence</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
<div class="card">

    <h1>Session de présence</h1>

    <!-- MODULE SELECT -->
    <form method="POST">
        <select name="module_id" required>
            <option value="">-- Choisir un module --</option>

            <?php foreach ($modules_list as $module): ?>
                <option value="<?= $module['id'] ?>">
                    <?= htmlspecialchars($module['code'] . ' - ' . $module['name']) ?>
                </option>
            <?php endforeach; ?>

        </select>

        <br><br>
        <button class="btn" type="submit">Générer QR</button>
    </form>

    <br>

    <!-- QR RESULT -->
    <?php if ($qr_path): ?>
        <img src="<?= $qr_path ?>" style="max-width:250px;">
        <p>Token: <?= htmlspecialchars($token) ?></p>
    <?php endif; ?>

    <br>
    <a class="btn" href="qrview.php">Retour</a>

</div>
</div>

</body>
</html>