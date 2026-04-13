<?php
// Loaded by AnnouncementController.php for teacher and admin roles.
// Has access to: $role, $modules, $announcements,
//                $success, $error, $errors,
//                $module_id, $title, $body
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces</title>
    <link rel="stylesheet" href="../../public/assets/style.css">
</head>
<body>
<div class="container">

    <h1>Annonces</h1>

    <!-- Back to dashboard -->
    <?php
        $dashboard = match($role) {
            'teacher' => '../../public/dashboard_enseignant.php',
            'admin'   => '../../public/dashboard_admin.php',
            default   => '../../public/accueil.php',
        };
    ?>

    <!-- ── FEEDBACK MESSAGES ── -->
    <?php if ($success): ?>
        <div class="card" style="border-left: 4px solid green;">
            <p>✅ <?php echo htmlspecialchars($success); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="card" style="border-left: 4px solid red;">
            <p>❌ <?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <!-- ── POST FORM ── -->
    <div class="card">
        <h2>
            <?php echo $role === 'admin' ? 'Publier une annonce' : 'Publier une annonce dans mon module'; ?>
        </h2>

        <form method="POST">

            <!-- Module selector -->
            <div style="margin-bottom: 1rem;">
                <label for="module_id"><strong>Module :</strong></label><br>
                <select name="module_id" id="module_id" style="width:100%; padding:0.5rem; margin-top:0.3rem;">

                    <?php if ($role === 'admin'): ?>
                        <!-- Admin: first option = general announcement -->
                        <option value="">— Annonce générale (tous les étudiants) —</option>
                    <?php else: ?>
                        <option value="">— Choisissez un module —</option>
                    <?php endif; ?>

                    <?php foreach ($modules as $m): ?>
                        <option value="<?php echo $m['id']; ?>"
                            <?php echo ($module_id == $m['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($m['code'] . ' — ' . $m['name']); ?>
                        </option>
                    <?php endforeach; ?>

                </select>
                <?php if (!empty($errors['module_id'])): ?>
                    <small style="color:red;"><?php echo htmlspecialchars($errors['module_id']); ?></small>
                <?php endif; ?>
            </div>

            <!-- Title -->
            <div style="margin-bottom: 1rem;">
                <label for="title"><strong>Titre :</strong></label><br>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="<?php echo htmlspecialchars($title ?? ''); ?>"
                    style="width:100%; padding:0.5rem; margin-top:0.3rem;"
                    placeholder="Titre de l'annonce"
                >
                <?php if (!empty($errors['title'])): ?>
                    <small style="color:red;"><?php echo htmlspecialchars($errors['title']); ?></small>
                <?php endif; ?>
            </div>

            <!-- Body -->
            <div style="margin-bottom: 1rem;">
                <label for="body"><strong>Message :</strong></label><br>
                <textarea
                    name="body"
                    id="body"
                    rows="5"
                    style="width:100%; padding:0.5rem; margin-top:0.3rem;"
                    placeholder="Contenu de l'annonce..."
                ><?php echo htmlspecialchars($body ?? ''); ?></textarea>
                <?php if (!empty($errors['body'])): ?>
                    <small style="color:red;"><?php echo htmlspecialchars($errors['body']); ?></small>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn">Publier</button>
        </form>
    </div>

    <!-- ── PAST ANNOUNCEMENTS ── -->
    <div class="card">
        <h2>
            <?php echo $role === 'admin' ? 'Toutes les annonces' : 'Mes annonces publiées'; ?>
        </h2>

        <?php if (empty($announcements)): ?>
            <p>Aucune annonce pour le moment.</p>
        <?php else: ?>
            <?php foreach ($announcements as $ann): ?>
                <div style="border-bottom: 1px solid #ddd; padding: 0.75rem 0;">
                    <strong><?php echo htmlspecialchars($ann['title']); ?></strong>
                    <span style="font-size:0.8rem; color:#888; margin-left:1rem;">
                        <?php echo $ann['module_code']
                            ? htmlspecialchars($ann['module_code'] . ' — ' . $ann['module_name'])
                            : '🌐 Annonce générale'; ?>
                    </span>
                    <p style="margin:0.4rem 0;"><?php echo nl2br(htmlspecialchars($ann['content'])); ?></p>
                    <small style="color:#aaa;"><?php echo $ann['posted_at']; ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <a class="btn" href="<?php echo $dashboard; ?>">⬅ Retour au tableau de bord</a>

</div>
</body>
</html>