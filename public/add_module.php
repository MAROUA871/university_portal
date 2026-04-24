<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

$message = "";

$teachers_sql = "SELECT id, first_name, last_name FROM users WHERE role = 'teacher' ORDER BY last_name ASC";
$teachers_result = mysqli_query($conn, $teachers_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST["code"]);
    $name = trim($_POST["name"]);
    $teacher_id = intval($_POST["teacher_id"]);
    $coefficient = intval($_POST["coefficient"]);

    if (!empty($code) && !empty($name) && $teacher_id > 0 && $coefficient > 0) {
        $sql = "INSERT INTO modules (code, name, teacher_id, coefficient) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ssii", $code, $name, $teacher_id, $coefficient);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: modules_list.php?success=1");
            exit();
        } else {
            $message = "Erreur lors de l'ajout du module.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un module</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Ajouter un module</h1>

    <div class="card">

        <?php if (!empty($message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Code du module</label>
            <input type="text" name="code" placeholder="Exemple : MATH1" required>

            <label>Nom du module</label>
            <input type="text" name="name" placeholder="Exemple : Maths 1" required>

            <label>Enseignant</label>
            <select name="teacher_id" required>
                <option value="">-- Choisir un enseignant --</option>

                <?php while ($teacher = mysqli_fetch_assoc($teachers_result)): ?>
                    <option value="<?php echo $teacher["id"]; ?>">
                        <?php echo htmlspecialchars($teacher["first_name"] . " " . $teacher["last_name"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Coefficient</label>
            <input type="number" name="coefficient" min="1" max="10" required>

            <button class="btn" type="submit">Ajouter</button>
        </form>
    </div>

    <a class="btn" href="modules_list.php">Retour</a>
</div>

</body>
</html>