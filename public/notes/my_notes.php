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
    ROUND(MAX(CASE WHEN n.type = 'td' THEN n.value END), 2) AS td,
    ROUND(MAX(CASE WHEN n.type = 'exam' THEN n.value END), 2) AS exam
FROM modules m
LEFT JOIN notes n 
    ON n.module_id = m.id 
    AND n.student_id = ?
GROUP BY m.id, m.name
ORDER BY m.name ASC
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$notes = [];
$total_modules = 0;
$total_moyenne = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $td = $row["td"];
    $exam = $row["exam"];

    if ($td !== null && $exam !== null) {
        $moyenne = round(($td * 0.4) + ($exam * 0.6), 2);
        $total_modules++;
        $total_moyenne += $moyenne;
    } else {
        $moyenne = null;
    }

    $row["moyenne"] = $moyenne;
    $notes[] = $row;
}

$moyenne_generale = ($total_modules > 0) ? round($total_moyenne / $total_modules, 2) : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes notes</title>
    <link rel="stylesheet" href="../assets/style.css?v=8">
</head>
<body>

<div class="container">
    <h1>Mes notes</h1>

    <div class="card">

        <div id="pdf-content">

            <div class="stats-box">
                <div class="stat-item">
                    📊 Moyenne générale :
                    <?php echo ($moyenne_generale !== null) ? number_format($moyenne_generale, 2) : "-"; ?>
                </div>

                <div class="stat-item">
                    Statut général :
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
                    <th>Module</th>
                    <th>TD</th>
                    <th>Examen</th>
                    <th>Moyenne</th>
                </tr>

                <?php foreach ($notes as $note): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($note["module_name"]); ?></td>

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

        <button class="btn export-btn" onclick="exportPDF()">Exporter PDF</button>

    </div>

    <a class="btn" href="../dashboard_etudiant.php">Retour</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
function exportPDF() {
    const element = document.getElementById("pdf-content");

    const options = {
        margin: 0.5,
        filename: "mes_notes.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
    };

    html2pdf().set(options).from(element).save();
}
</script>

</body>
</html>