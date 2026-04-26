<?php
session_start();

require_once "../utils/auth_check.php";

$allowed_role = "student";
require_once "../utils/role_check.php";

// 🔌 DB connection
$db = new PDO("mysql:host=localhost;dbname=university_portal_db", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 👤 Current student (FIXED)
$user_id = $_SESSION['id'];

// 📥 Get attendance (SIMPLIFIED)
$sql = "SELECT a.scaned_at, m.name AS module_name
        FROM attendance a
        JOIN attendance_session s ON a.session_id = s.id
        JOIN modules m ON s.module_id = m.id
        WHERE a.user_id = ?
        ORDER BY a.scaned_at DESC";

$stmt = $db->prepare($sql);
$stmt->execute([$user_id]);
$attendances = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma présence</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

    <h2>📋 Ma présence</h2>

    
    <div class="card">

        <?php if (count($attendances) > 0): ?>

            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <tr>
                    <th>Module</th>
                    <th>Date</th>
                </tr>

                <?php foreach ($attendances as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['module_name'] ?? 'Module non défini') ?></td>
                        <td><?= htmlspecialchars($row['scaned_at']) ?></td>
                    </tr>
                <?php endforeach; ?>

            </table>

        <?php else: ?>
            <p>Aucune présence enregistrée.</p>
        <?php endif; ?>

    </div>

    <br>

    <a class="btn" href="dashboard_etudiant.php">⬅ Retour</a>

</div>

</body>
</html>