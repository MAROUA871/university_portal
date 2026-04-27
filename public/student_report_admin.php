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

$student_id = isset($_GET["student_id"]) ? intval($_GET["student_id"]) : 0;

/* =========================
   LISTE DES ETUDIANTS
========================= */
$students_sql = "
    SELECT id, identifier, first_name, last_name
    FROM users
    WHERE role = 'student'
    ORDER BY last_name ASC, first_name ASC
";
$students_result = mysqli_query($conn, $students_sql);

/* =========================
   INFOS ETUDIANT
========================= */
$student = null;
$notes = [];
$moyenne_generale = null;

if ($student_id > 0) {
    $student_sql = "
        SELECT id, identifier, first_name, last_name, email
        FROM users
        WHERE id = ? AND role = 'student'
    ";
    $student_stmt = mysqli_prepare($conn, $student_sql);
    mysqli_stmt_bind_param($student_stmt, "i", $student_id);
    mysqli_stmt_execute($student_stmt);
    $student_result = mysqli_stmt_get_result($student_stmt);
    $student = mysqli_fetch_assoc($student_result);
    mysqli_stmt_close($student_stmt);

    if ($student) {
        $notes_sql = "
            SELECT 
                m.name AS module_name,
                m.code AS module_code,
                m.coefficient,
                ROUND(MAX(CASE WHEN n.type = 'td' THEN n.value END), 2) AS td,
                ROUND(MAX(CASE WHEN n.type = 'exam' THEN n.value END), 2) AS exam
            FROM modules m
            LEFT JOIN notes n 
                ON n.module_id = m.id 
                AND n.student_id = ?
            GROUP BY m.id, m.name, m.code, m.coefficient
            ORDER BY m.name ASC
        ";

        $notes_stmt = mysqli_prepare($conn, $notes_sql);
        mysqli_stmt_bind_param($notes_stmt, "i", $student_id);
        mysqli_stmt_execute($notes_stmt);
        $notes_result = mysqli_stmt_get_result($notes_stmt);

        $somme_moyenne_coeff = 0;
        $somme_coefficients = 0;

        while ($row = mysqli_fetch_assoc($notes_result)) {
            $td = $row["td"];
            $exam = $row["exam"];
            $coefficient = intval($row["coefficient"]);

            if ($td !== null && $exam !== null) {
                $moyenne = round(($td * 0.4) + ($exam * 0.6), 2);

                if ($coefficient > 0) {
                    $somme_moyenne_coeff += $moyenne * $coefficient;
                    $somme_coefficients += $coefficient;
                }
            } else {
                $moyenne = null;
            }

            $row["moyenne"] = $moyenne;
            $notes[] = $row;
        }

        mysqli_stmt_close($notes_stmt);

        if ($somme_coefficients > 0) {
            $moyenne_generale = round($somme_moyenne_coeff / $somme_coefficients, 2);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé de notes étudiant</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Relevé de notes étudiant</h1>

    <div class="card">

        <form method="GET">
            <label for="student_id">Choisir un étudiant</label>
            <select name="student_id" id="student_id" onchange="this.form.submit()" required>
                <option value="">-- Sélectionner un étudiant --</option>

                <?php while ($s = mysqli_fetch_assoc($students_result)): ?>
                    <option value="<?php echo $s["id"]; ?>" <?php echo ($student_id == $s["id"]) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($s["last_name"] . " " . $s["first_name"] . " (" . $s["identifier"] . ")"); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>

        <?php if ($student): ?>

            <button class="btn export-btn" onclick="exportPDF()">Exporter PDF</button>

            <div id="pdf-content">

                <h2>Relevé de notes</h2>

                <div class="stats-box">
                    <div class="stat-item">
                        Étudiant :
                        <?php echo htmlspecialchars($student["first_name"] . " " . $student["last_name"]); ?>
                    </div>

                    <div class="stat-item">
                        Matricule :
                        <?php echo htmlspecialchars($student["identifier"]); ?>
                    </div>

                    <div class="stat-item">
                        Moyenne générale :
                        <?php echo ($moyenne_generale !== null) ? number_format($moyenne_generale, 2) : "-"; ?>
                    </div>

                    <div class="stat-item">
                        Statut :
                        <?php if ($moyenne_generale === null): ?>
                            -
                        <?php elseif ($moyenne_generale >= 10): ?>
                            <span class="status-pass">Admis</span>
                        <?php else: ?>
                            <span class="status-fail">Ajourné</span>
                        <?php endif; ?>
                    </div>
                </div>

                <table>
                    <tr>
                        <th>Code</th>
                        <th>Module</th>
                        <th>Coef</th>
                        <th>TD</th>
                        <th>Examen</th>
                        <th>Moyenne</th>
                    </tr>

                    <?php foreach ($notes as $note): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($note["module_code"]); ?></td>
                            <td><?php echo htmlspecialchars($note["module_name"]); ?></td>
                            <td><?php echo htmlspecialchars($note["coefficient"]); ?></td>

                            <td class="<?php echo ($note["td"] !== null && $note["td"] >= 10) ? 'good' : 'bad'; ?>">
                                <?php echo ($note["td"] !== null) ? number_format($note["td"], 2) : "-"; ?>
                            </td>

                            <td class="<?php echo ($note["exam"] !== null && $note["exam"] >= 10) ? 'good' : 'bad'; ?>">
                                <?php echo ($note["exam"] !== null) ? number_format($note["exam"], 2) : "-"; ?>
                            </td>

                            <td class="<?php echo ($note["moyenne"] !== null && $note["moyenne"] >= 10) ? 'good' : 'bad'; ?>">
                                <?php echo ($note["moyenne"] !== null) ? number_format($note["moyenne"], 2) : "-"; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            </div>

        <?php elseif ($student_id > 0): ?>
            <p class="error-message">Étudiant introuvable.</p>
        <?php endif; ?>

    </div>

    <a class="btn" href="dashboard_admin.php">Retour au dashboard</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
function exportPDF() {
    const element = document.getElementById("pdf-content");

    const options = {
        margin: 0.5,
        filename: "releve_notes_etudiant.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
    };

    html2pdf().set(options).from(element).save();
}
</script>

</body>
</html>