<?php 
session_start();

require_once "../../config/bd.php";

if (!isset($_SESSION["id"]) || $_SESSION["role"] != "student") {
    header("Location: ../login.php");
    exit();
}

$student_id = intval($_SESSION["id"]);

$sql = "
SELECT 
    m.name AS module_name,
    m.coefficient,
    ROUND(MAX(CASE WHEN n.type = 'td' THEN n.value END), 2) AS td,
    ROUND(MAX(CASE WHEN n.type = 'exam' THEN n.value END), 2) AS exam
FROM modules m
LEFT JOIN notes n 
    ON n.module_id = m.id 
    AND n.student_id = ?
GROUP BY m.id, m.name, m.coefficient
ORDER BY m.name ASC
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$notes = [];
$somme_moyenne_coeff = 0;
$somme_coefficients = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $td = $row["td"];
    $exam = $row["exam"];
    $coef = intval($row["coefficient"]);

    if ($td !== null && $exam !== null) {
        $moyenne = round(($td * 0.4) + ($exam * 0.6), 2);
        $somme_moyenne_coeff += $moyenne * $coef;
        $somme_coefficients += $coef;
    } else {
        $moyenne = null;
    }

    $row["moyenne"] = $moyenne;
    $notes[] = $row;
}

$moyenne_generale = ($somme_coefficients > 0)
    ? round($somme_moyenne_coeff / $somme_coefficients, 2)
    : null;

// ===== MENTION =====
$mention = "-";

if ($moyenne_generale !== null) {
    if ($moyenne_generale >= 16) $mention = "Excellent";
    elseif ($moyenne_generale >= 14) $mention = "Très bien";
    elseif ($moyenne_generale >= 12) $mention = "Bien";
    elseif ($moyenne_generale >= 10) $mention = "Assez bien";
    else $mention = "Insuffisant";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes notes</title>
    <link rel="stylesheet" href="../assets/style.css?v=1">
</head>
<body>

<div class="container">
   

    <div class="card">

        <div id="pdf-content">

            <!-- ===== HEADER PDF ===== -->
            <div class="pdf-header">
                <img src="../assets/logo_university.png" class="pdf-logo">

                <div class="pdf-title">
                    <h2>Relevé de notes</h2>
                    <p>Université des Sciences et de la Technologie Houari Boumediene</p> </h2>
                </div>

                <img src="../assets/logo_faculty.png" class="pdf-logo">
            </div>

            <!-- ===== INFOS ETUDIANT ===== -->
            <div class="student-info">
                <p><strong>Nom :</strong> <?php echo $_SESSION["last_name"]; ?></p>
                <p><strong>Prénom :</strong> <?php echo $_SESSION["first_name"]; ?></p>
                <p><strong> Matricule :</strong> <?php echo $_SESSION["identifier"]; ?></p>
            </div>

            <!-- ===== STATS ===== -->
            <div class="stats-box">
                <div class="stat-item">
                    📊 Moyenne générale :
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

                <div class="stat-item">
                    🏅 Mention : <?php echo $mention; ?>
                </div>
            </div>

            <!-- ===== TABLE ===== -->
            <table>
                <tr>
                    <th>Module</th>
                    <th>Coefficient</th>
                    <th>TD</th>
                    <th>Examen</th>
                    <th>Moyenne</th>
                </tr>

                <?php foreach ($notes as $note): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($note["module_name"]); ?></td>
                        <td><?php echo $note["coefficient"]; ?></td>

                        <td class="<?php echo ($note["td"] >= 10) ? 'good' : 'bad'; ?>">
                            <?php echo ($note["td"] !== null) ? $note["td"] : "-"; ?>
                        </td>

                        <td class="<?php echo ($note["exam"] >= 10) ? 'good' : 'bad'; ?>">
                            <?php echo ($note["exam"] !== null) ? $note["exam"] : "-"; ?>
                        </td>

                        <td class="<?php echo ($note["moyenne"] >= 10) ? 'good' : 'bad'; ?>">
                            <?php echo ($note["moyenne"] !== null) ? $note["moyenne"] : "-"; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
      <br><br> 
        <button class="btn export-btn" onclick="exportPDF()">Exporter PDF</button>

    </div>

    <a class="btn" href="../dashboard_etudiant.php">Retour</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
function exportPDF() {
    const element = document.getElementById("pdf-content");

    const options = {
        margin: 0.3,
        filename: "releve_notes.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
    };

    html2pdf().set(options).from(element).save();
}
</script>

</body>
</html>
