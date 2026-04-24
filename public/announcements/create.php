<?php

session_start();

$role = $_SESSION['role'] ?? null;
$user_id = $_SESSION['id'];

require_once '../../config/bd.php';

if (!$conn) {
    die("DB connection failed");
}

/* ---------------------------
   FORM VALUES
----------------------------*/
$module_id = $_POST['module_id'] ?? null;
$title = $_POST['title'] ?? '';
$body = $_POST['body'] ?? '';
$errors = $errors ?? [];
$success = $success ?? '';
$error = $error ?? '';

/* ---------------------------
   INSERT ANNOUNCEMENT
----------------------------*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];

    // convert admin "0" into NULL (IMPORTANT FIX)
    if ($module_id == 0) {
        $module_id = null;
    }

    // validation
    if ($module_id === '' || ($role !== 'admin' && $module_id === null)) {
        $errors['module_id'] = "Module required";
    }

    if (empty($title)) {
        $errors['title'] = "Title required";
    }

    if (empty($body)) {
        $errors['body'] = "Message required";
    }

    if (empty($errors)) {

        if ($module_id === null) {

            // GENERAL ANNOUNCEMENT (NO FK)
            $stmt = $conn->prepare("
                INSERT INTO announcements (user_id, module_id, title, content, posted_at)
                VALUES (?, NULL, ?, ?, NOW())
            ");

            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param(
                "iss",
                $user_id,
                $title,
                $body
            );

        } else {

            // MODULE ANNOUNCEMENT
            $stmt = $conn->prepare("
                INSERT INTO announcements (user_id, module_id, title, content, posted_at)
                VALUES (?, ?, ?, ?, NOW())
            ");

            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param(
                "iiss",
                $user_id,
                $module_id,
                $title,
                $body
            );
        }

        if ($stmt->execute()) {
            $success = "Announcement published successfully!";
        } else {
            $error = "Insert failed: " . $stmt->error;
        }
    }
}

/* ---------------------------
   FETCH MODULES
----------------------------*/
$modules_list = [];

if ($role === 'teacher') {

    $stmt = $conn->prepare("SELECT id, code, name FROM modules WHERE teacher_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $modules_list[] = $row;
    }

} elseif ($role === 'admin') {

    $result = $conn->query("SELECT id, code, name FROM modules");

    while ($result && $row = $result->fetch_assoc()) {
        $modules_list[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces</title>
    <link rel="stylesheet" href="../../public/assets/style.css?v=6">
</head>
<body>

<div class="container">

    <h1>Annonces</h1>

    <?php
    $dashboard = match($role) {
        'teacher' => '../../public/dashboard_enseignant.php',
        'admin'   => '../../public/dashboard_admin.php',
        default   => '../../public/accueil.php',
    };
    ?>

    <!-- SUCCESS -->
    <?php if (!empty($success)): ?>
        <div class="card" style="border-left: 4px solid green;">
            <p>✅ <?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>

    <!-- ERROR -->
    <?php if (!empty($error)): ?>
        <div class="card" style="border-left: 4px solid red;">
            <p>❌ <?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <!-- FORM -->
    <div class="card">

        <h2>
            <?= $role === 'admin'
                ? 'Publier une annonce'
                : 'Publier une annonce (mes modules)' ?>
        </h2>

        <form method="POST">

            <!-- MODULE SELECT -->
            <div style="margin-bottom: 1rem;">
                <label><strong>Module :</strong></label><br>

                <select name="module_id" style="width:100%; padding:0.5rem; margin-top:0.3rem;">

                    <?php if ($role === 'admin'): ?>
                        <option value="0">— Annonce générale —</option>
                    <?php else: ?>
                        <option value="">— Choisissez un module —</option>
                    <?php endif; ?>

                    <?php foreach ($modules_list as $m): ?>
                        <option value="<?= $m['id'] ?>"
                            <?= ($module_id == $m['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['code'] . ' — ' . $m['name']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>

                <?php if (!empty($errors['module_id'])): ?>
                    <small style="color:red;"><?= $errors['module_id'] ?></small>
                <?php endif; ?>
            </div>

            <!-- TITLE -->
            <div style="margin-bottom: 1rem;">
                <label><strong>Titre :</strong></label><br>

                <input type="text" name="title"
                       value="<?= htmlspecialchars($title) ?>"
                       style="width:100%; padding:0.5rem;">

                <?php if (!empty($errors['title'])): ?>
                    <small style="color:red;"><?= $errors['title'] ?></small>
                <?php endif; ?>
            </div>

            <!-- BODY -->
            <div style="margin-bottom: 1rem;">
                <label><strong>Message :</strong></label><br>

                <textarea name="body" rows="5"
                          style="width:100%; padding:0.5rem;"><?= htmlspecialchars($body) ?></textarea>

                <?php if (!empty($errors['body'])): ?>
                    <small style="color:red;"><?= $errors['body'] ?></small>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn">Publier</button>

        </form>
    </div>

    <a class="btn" href="<?= $dashboard ?>">⬅ Retour au tableau de bord</a>

</div>

</body>
</html>