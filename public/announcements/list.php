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
<?php
session_start();

require_once "../../config/bd.php";

if (!$conn) {
    die("DB connection failed");
}

/* ---------------------------
   FETCH ANNOUNCEMENTS
----------------------------*/
$sql = "
SELECT 
    a.id,
    a.title,
    a.content,
    a.posted_at,
    u.first_name,
    u.last_name,
    u.role,
    m.code AS module_code,
    m.name AS module_name
FROM announcements a
LEFT JOIN users u ON a.user_id = u.id
LEFT JOIN modules m ON a.module_id = m.id
ORDER BY a.posted_at DESC
";

$result = $conn->query($sql);

$announcements = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Annonces</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">

    <h1>📢 Annonces</h1>

    <!-- LIST -->
    <?php if (empty($announcements)): ?>
        <div class="card">
            <p>Aucune annonce disponible pour le moment.</p>
        </div>
    <?php else: ?>
        <?php foreach ($announcements as $ann): ?>
            <div class="card">

                <!-- MODULE / GENERAL BADGE -->
                <?php if (!empty($ann['module_code'])): ?>
                    <small style="
                        background:#e8f0fe;
                        color:#3b5bdb;
                        padding:0.2rem 0.6rem;
                        border-radius:999px;
                        font-size:0.78rem;
                        font-weight:600;
                    ">
                        <?= htmlspecialchars($ann['module_code'] . ' — ' . $ann['module_name']) ?>
                    </small>
                <?php else: ?>
                    <small style="
                        background:#fff3bf;
                        color:#e67700;
                        padding:0.2rem 0.6rem;
                        border-radius:999px;
                        font-size:0.78rem;
                        font-weight:600;
                    ">
                        🌐 Annonce générale
                    </small>
                <?php endif; ?>

                <!-- TITLE -->
                <h2 style="margin:0.6rem 0 0.3rem;">
                    <?= htmlspecialchars($ann['title']) ?>
                </h2>

                <!-- CONTENT -->
                <p>
                    <?= nl2br(htmlspecialchars($ann['content'])) ?>
                </p>

                <!-- FOOTER -->
                <small style="color:#aaa;">
                    Publié par <?= htmlspecialchars($ann['first_name'] . ' ' . $ann['last_name']) ?>
                    (<?= htmlspecialchars($ann['role']) ?>)
                    — <?= $ann['posted_at'] ?>
                </small>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a class="btn" href="../../public/dashboard_etudiant.php">
        ⬅ Retour au tableau de bord
    </a>

</div>

</body>
</html>