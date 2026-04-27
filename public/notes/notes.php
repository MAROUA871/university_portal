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

require_once "../../config/bd.php";
require_once "../../utils/auth_check.php";

$allowed_role = "teacher";
require_once "../../utils/role_check.php";

if (!isset($_SESSION["id"])) {
    die("Erreur : id introuvable dans la session.");
}

$teacher_id = intval($_SESSION["id"]);
$message = "";

/* =========================
   MODULE FILTER
========================= */
$selected_module_id = isset($_GET["filter_module"]) ? intval($_GET["filter_module"]) : 0;

/* =========================
   ENREGISTRER MODIFICATION
========================= */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["save_notes"])) {
    $student_id = intval($_POST["student_id"]);
    $module_id  = intval($_POST["module_id"]);
    $td_value   = ($_POST["td_value"] !== "") ? round(floatval($_POST["td_value"]), 2) : null;
    $exam_value = ($_POST["exam_value"] !== "") ? round(floatval($_POST["exam_value"]), 2) : null;

    $check_sql = "SELECT id FROM modules WHERE id = ? AND teacher_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);

    if ($check_stmt) {
        mysqli_stmt_bind_param($check_stmt, "ii", $module_id, $teacher_id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {

            /* TD */
            if ($td_value !== null && $td_value >= 0 && $td_value <= 20) {
                $sql_td = "SELECT id FROM notes WHERE student_id = ? AND module_id = ? AND type = 'td'";
                $stmt_td = mysqli_prepare($conn, $sql_td);
                mysqli_stmt_bind_param($stmt_td, "ii", $student_id, $module_id);
                mysqli_stmt_execute($stmt_td);
                $res_td = mysqli_stmt_get_result($stmt_td);

                if ($row_td = mysqli_fetch_assoc($res_td)) {
                    $update_td = "UPDATE notes SET value = ? WHERE id = ?";
                    $stmt_update_td = mysqli_prepare($conn, $update_td);
                    mysqli_stmt_bind_param($stmt_update_td, "di", $td_value, $row_td["id"]);
                    mysqli_stmt_execute($stmt_update_td);
                    mysqli_stmt_close($stmt_update_td);
                } else {
                    $insert_td = "INSERT INTO notes (student_id, module_id, value, type, created_at) VALUES (?, ?, ?, 'td', NOW())";
                    $stmt_insert_td = mysqli_prepare($conn, $insert_td);
                    mysqli_stmt_bind_param($stmt_insert_td, "iid", $student_id, $module_id, $td_value);
                    mysqli_stmt_execute($stmt_insert_td);
                    mysqli_stmt_close($stmt_insert_td);
                }

                mysqli_stmt_close($stmt_td);
            }

            /* EXAM */
            if ($exam_value !== null && $exam_value >= 0 && $exam_value <= 20) {
                $sql_exam = "SELECT id FROM notes WHERE student_id = ? AND module_id = ? AND type = 'exam'";
                $stmt_exam = mysqli_prepare($conn, $sql_exam);
                mysqli_stmt_bind_param($stmt_exam, "ii", $student_id, $module_id);
                mysqli_stmt_execute($stmt_exam);
                $res_exam = mysqli_stmt_get_result($stmt_exam);

                if ($row_exam = mysqli_fetch_assoc($res_exam)) {
                    $update_exam = "UPDATE notes SET value = ? WHERE id = ?";
                    $stmt_update_exam = mysqli_prepare($conn, $update_exam);
                    mysqli_stmt_bind_param($stmt_update_exam, "di", $exam_value, $row_exam["id"]);
                    mysqli_stmt_execute($stmt_update_exam);
                    mysqli_stmt_close($stmt_update_exam);
                } else {
                    $insert_exam = "INSERT INTO notes (student_id, module_id, value, type, created_at) VALUES (?, ?, ?, 'exam', NOW())";
                    $stmt_insert_exam = mysqli_prepare($conn, $insert_exam);
                    mysqli_stmt_bind_param($stmt_insert_exam, "iid", $student_id, $module_id, $exam_value);
                    mysqli_stmt_execute($stmt_insert_exam);
                    mysqli_stmt_close($stmt_insert_exam);
                }

                mysqli_stmt_close($stmt_exam);
            }

            if ($selected_module_id > 0) {
                header("Location: notes.php?filter_module=" . $selected_module_id);
            } else {
                header("Location: notes.php");
            }
            exit();
        }

        mysqli_stmt_close($check_stmt);
    }
}

/* =========================
   LIGNE EN MODE EDIT
========================= */
$edit_student_id = isset($_GET["student_id"]) ? intval($_GET["student_id"]) : 0;
$edit_module_id  = isset($_GET["module_id"]) ? intval($_GET["module_id"]) : 0;

/* =========================
   MODULES DE L'ENSEIGNANT
========================= */
$modules = [];
$sql_modules = "SELECT id, code, name FROM modules WHERE teacher_id = ? ORDER BY name ASC";
$stmt_modules = mysqli_prepare($conn, $sql_modules);

if ($stmt_modules) {
    mysqli_stmt_bind_param($stmt_modules, "i", $teacher_id);
    mysqli_stmt_execute($stmt_modules);
    $result_modules = mysqli_stmt_get_result($stmt_modules);

    while ($row_module = mysqli_fetch_assoc($result_modules)) {
        $modules[] = $row_module;
    }

    mysqli_stmt_close($stmt_modules);
}

/* =========================
   AFFICHAGE TABLEAU
========================= */
$rows = [];

$sql = "
    SELECT 
        users.id AS student_id,
        users.last_name,
        users.first_name,
        users.identifier,
        modules.id AS module_id,
        modules.code,
        modules.name,
        ROUND(MAX(CASE WHEN notes.type = 'td' THEN notes.value END), 2) AS td_note,
        ROUND(MAX(CASE WHEN notes.type = 'exam' THEN notes.value END), 2) AS exam_note
    FROM users
    CROSS JOIN modules
    LEFT JOIN notes 
        ON notes.student_id = users.id 
        AND notes.module_id = modules.id
    WHERE users.role = 'student'
      AND modules.teacher_id = ?
";

if ($selected_module_id > 0) {
    $sql .= " AND modules.id = ? ";
}

$sql .= "
    GROUP BY users.id, users.last_name, users.first_name, users.identifier, modules.id, modules.code, modules.name
    ORDER BY users.last_name ASC, users.first_name ASC
";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    if ($selected_module_id > 0) {
        mysqli_stmt_bind_param($stmt, "ii", $teacher_id, $selected_module_id);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $teacher_id);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des notes</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h1>Gestion des notes</h1>
        <p>Modifier simplement les notes TD et Examen.</p>

        <?php if (!empty($message)) : ?>
            <p class="top-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="GET" class="filter-form">
            <label for="filter_module">Filtrer par module</label>
            <select name="filter_module" id="filter_module" onchange="this.form.submit()">
                <option value="0">-- Tous les modules --</option>

                <?php foreach ($modules as $module) : ?>
                    <option value="<?php echo $module["id"]; ?>" <?php echo ($selected_module_id == $module["id"]) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($module["code"] . " - " . $module["name"]); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Matricule</th>
                <th>Module</th>
                <th>Note TD</th>
                <th>Note Examen</th>
                <th>Moyenne</th>
                <th>Action</th>
            </tr>

            <?php foreach ($rows as $row) : ?>
                <?php
                $td = $row["td_note"];
                $exam = $row["exam_note"];

                if ($td !== null && $exam !== null) {
                    $moyenne = round(($td * 0.4) + ($exam * 0.6), 2);
                } else {
                    $moyenne = null;
                }
                ?>

                <?php if ($edit_student_id == $row["student_id"] && $edit_module_id == $row["module_id"]) : ?>
                    <tr>
                        <form method="POST">
                            <td><?php echo htmlspecialchars($row["last_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["first_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["identifier"]); ?></td>
                            <td><?php echo htmlspecialchars($row["code"] . " - " . $row["name"]); ?></td>

                            <td>
                                <input type="number" step="0.01" min="0" max="20" name="td_value"
                                       class="note-input"
                                       value="<?php echo ($td !== null) ? htmlspecialchars($td) : ""; ?>">
                            </td>

                            <td>
                                <input type="number" step="0.01" min="0" max="20" name="exam_value"
                                       class="note-input"
                                       value="<?php echo ($exam !== null) ? htmlspecialchars($exam) : ""; ?>">
                            </td>

                            <td>
                                <?php echo ($moyenne !== null) ? number_format($moyenne, 2) : "-"; ?>
                            </td>

                            <td>
                                <input type="hidden" name="student_id" value="<?php echo $row["student_id"]; ?>">
                                <input type="hidden" name="module_id" value="<?php echo $row["module_id"]; ?>">
                                <input type="hidden" name="save_notes" value="1">

                                <button type="submit" class="action-btn">Save</button>
                                <a class="action-btn cancel-btn" href="notes.php<?php echo ($selected_module_id > 0) ? '?filter_module=' . $selected_module_id : ''; ?>">Cancel</a>
                            </td>
                        </form>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["last_name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["first_name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["identifier"]); ?></td>
                        <td><?php echo htmlspecialchars($row["code"] . " - " . $row["name"]); ?></td>

                        <td class="<?php echo ($td !== null && $td >= 10) ? 'good' : 'bad'; ?>">
                            <?php echo ($td !== null) ? number_format($td, 2) : "-"; ?>
                        </td>

                        <td class="<?php echo ($exam !== null && $exam >= 10) ? 'good' : 'bad'; ?>">
                            <?php echo ($exam !== null) ? number_format($exam, 2) : "-"; ?>
                        </td>

                        <td class="<?php echo ($moyenne !== null && $moyenne >= 10) ? 'good' : 'bad'; ?>">
                            <?php echo ($moyenne !== null) ? number_format($moyenne, 2) : "-"; ?>
                        </td>

                        <td>
                            <a class="action-btn" href="notes.php?student_id=<?php echo $row["student_id"]; ?>&module_id=<?php echo $row["module_id"]; ?><?php echo ($selected_module_id > 0) ? '&filter_module=' . $selected_module_id : ''; ?>">
                                Edit
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>

        <div style="margin-top: 20px;">
            <a class="btn" href="../dashboard_enseignant.php">Retour au dashboard</a>
        </div>
    </div>
</div>

</body>
</html>