<?php
// Loaded by AnnouncementController.php for student role.
// Has access to: $announcements
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Annonces</title>
    <link rel="stylesheet" href="../../public/assets/style.css">
</head>
<body>
<div class="container">

    <h1>Annonces</h1>

    <!-- ── ANNOUNCEMENT LIST ── -->
    <?php if (empty($announcements)): ?>
        <div class="card">
            <p>Aucune annonce disponible pour le moment.</p>
        </div>
    <?php else: ?>
        <?php foreach ($announcements as $ann): ?>
            <div class="card">

                <!-- Module badge or General tag -->
                <?php if ($ann['module_code']): ?>
                    <small style="
                        background:#e8f0fe;
                        color:#3b5bdb;
                        padding:0.2rem 0.6rem;
                        border-radius:999px;
                        font-size:0.78rem;
                        font-weight:600;
                    ">
                        <?php echo htmlspecialchars($ann['module_code'] . ' — ' . $ann['module_name']); ?>
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

                <h2 style="margin:0.6rem 0 0.3rem;">
                    <?php echo htmlspecialchars($ann['title']); ?>
                </h2>

                <p><?php echo nl2br(htmlspecialchars($ann['content'])); ?></p>

                <small style="color:#aaa;">
                    Publié par <?php echo htmlspecialchars($ann['first_name'] . ' ' . $ann['last_name']); ?>
                    (<?php echo htmlspecialchars($ann['role']); ?>)
                    — <?php echo $ann['posted_at']; ?>
                </small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a class="btn" href="../../public/dashboard_etudiant.php">⬅ Retour au tableau de bord</a>

</div>
</body>
</html>