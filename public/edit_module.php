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
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

if (!isset($_GET["id"])) {
    header("Location: modules_list.php");
    exit();
}

$id = intval($_GET["id"]);
$message = "";

$module_sql = "SELECT * FROM modules WHERE id = ?";
$module_stmt = mysqli_prepare($conn, $module_sql);
mysqli_stmt_bind_param($module_stmt, "i", $id);
mysqli_stmt_execute($module_stmt);
$module_result = mysqli_stmt_get_result($module_stmt);
$module = mysqli_fetch_assoc($module_result);

if (!$module) {
    header("Location: modules_list.php");
    exit();
}

$teachers_sql = "SELECT id, first_name, last_name FROM users WHERE role = 'teacher' ORDER BY last_name ASC";
$teachers_result = mysqli_query($conn, $teachers_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST["code"]);
    $name = trim($_POST["name"]);
    $teacher_id = intval($_POST["teacher_id"]);
    $coefficient = intval($_POST["coefficient"]);

    if (!empty($code) && !empty($name) && $teacher_id > 0 && $coefficient > 0) {
        $sql = "UPDATE modules SET code = ?, name = ?, teacher_id = ?, coefficient = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ssiii", $code, $name, $teacher_id, $coefficient, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: modules_list.php?updated=1");
            exit();
        } else {
            $message = "Erreur lors de la modification.";
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
    <title>Modifier un module</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Modifier un module</h1>

    <div class="card">

        <?php if (!empty($message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Code du module</label>
            <input type="text" name="code" value="<?php echo htmlspecialchars($module["code"]); ?>" required>

            <label>Nom du module</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($module["name"]); ?>" required>

            <label>Enseignant</label>
            <select name="teacher_id" required>
                <option value="">-- Choisir un enseignant --</option>

                <?php while ($teacher = mysqli_fetch_assoc($teachers_result)): ?>
                    <option value="<?php echo $teacher["id"]; ?>"
                        <?php echo ($module["teacher_id"] == $teacher["id"]) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($teacher["first_name"] . " " . $teacher["last_name"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Coefficient</label>
            <input type="number" name="coefficient" min="1" max="10"
                   value="<?php echo htmlspecialchars($module["coefficient"]); ?>" required>

            <button class="btn" type="submit">Modifier</button>
        </form>
    </div>

    <a class="btn" href="modules_list.php">Retour</a>
</div>

</body>
</html>