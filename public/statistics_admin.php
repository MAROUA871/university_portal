<?php
/* =========================
   Sécurité & accès
========================= */
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

/* =========================
   Récupération des données
========================= */

$sql = "
SELECT 
    u.id AS student_id,
    u.identifier,
    u.first_name,
    u.last_name,
    u.email,
    m.id AS module_id,
    m.coefficient,
    ROUND(MAX(CASE WHEN n.type = 'td' THEN n.value END), 2) AS td,
    ROUND(MAX(CASE WHEN n.type = 'exam' THEN n.value END), 2) AS exam
FROM users u
CROSS JOIN modules m
LEFT JOIN notes n 
    ON n.student_id = u.id
    AND n.module_id = m.id
WHERE u.role = 'student'
GROUP BY 
    u.id,
    u.identifier,
    u.first_name,
    u.last_name,
    u.email,
    m.id,
    m.coefficient
ORDER BY u.last_name ASC, u.first_name ASC
";

$result = mysqli_query($conn, $sql);

$students = [];

/* =========================
   Calcul des moyennes
========================= */
while ($row = mysqli_fetch_assoc($result)) {

    $id = $row["student_id"];

    if (!isset($students[$id])) {
        $students[$id] = [
            "identifier" => $row["identifier"],
            "first_name" => $row["first_name"],
            "last_name" => $row["last_name"],
            "email" => $row["email"],
            "somme_moyenne_coeff" => 0,
            "somme_coefficients" => 0
        ];
    }

    $td = $row["td"];
    $exam = $row["exam"];
    $coef = intval($row["coefficient"]);

    if ($td !== null && $exam !== null && $coef > 0) {
        $moyenne = ($td * 0.4) + ($exam * 0.6);

        $students[$id]["somme_moyenne_coeff"] += $moyenne * $coef;
        $students[$id]["somme_coefficients"] += $coef;
    }
}

/* =========================
   Statistiques
========================= */
$results = [];

$total = 0;
$admis = 0;
$ajournes = 0;
$excellents = 0;
$somme = 0;

foreach ($students as $s) {

    if ($s["somme_coefficients"] > 0) {

        $moy = round($s["somme_moyenne_coeff"] / $s["somme_coefficients"], 2);
        $statut = ($moy >= 10) ? "Admis" : "Ajourné";

        $total++;
        $somme += $moy;

        if ($moy >= 10) $admis++;
        else $ajournes++;

        if ($moy >= 16) $excellents++;

        $s["moyenne_generale"] = $moy;
        $s["statut"] = $statut;

        $results[] = $s;
    }
}

$moyenne_promo = ($total > 0) ? round($somme / $total, 2) : 0;
$taux = ($total > 0) ? round(($admis / $total) * 100, 2) : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="container">

    <!-- =========================
         Titre
    ========================== -->
    <h1>Statistiques des étudiants</h1>

    <!-- =========================
         Résumé
    ========================== -->
    <div class="card">
        <h2>📊 Résumé général</h2>

        <div class="stats-box">
            <div class="stat-item">👨‍🎓 Total : <?= $total ?></div>
            <div class="stat-item">🟢 Admis : <?= $admis ?></div>
            <div class="stat-item">🔴 Ajournés : <?= $ajournes ?></div>
            <div class="stat-item">🌟 ≥16 : <?= $excellents ?></div>
            <div class="stat-item">📊 Moyenne : <?= number_format($moyenne_promo,2) ?></div>
            <div class="stat-item">✅ Taux : <?= number_format($taux,2) ?>%</div>
        </div>
    </div>

    <!-- =========================
         Tableau
    ========================== -->
    <div class="card">
        <h2>📋 Résultats détaillés</h2>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔎 Rechercher...">
        </div>

        <button class="btn" onclick="exportPDF()">Exporter PDF</button>

        <div id="pdf-content">
            <table id="dataTable" border="1" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Moyenne</th>
                    <th>Statut</th>
                    <th>Catégorie</th>
                </tr>

                <?php foreach ($results as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s["identifier"]) ?></td>
                    <td><?= htmlspecialchars($s["first_name"]) ?></td>
                    <td><?= htmlspecialchars($s["last_name"]) ?></td>
                    <td><?= htmlspecialchars($s["email"]) ?></td>

                    <td><?= number_format($s["moyenne_generale"],2) ?></td>
                    <td><?= $s["statut"] ?></td>

                    <td>
                        <?php
                        if ($s["moyenne_generale"] >= 16) echo "Excellent";
                        elseif ($s["moyenne_generale"] >= 10) echo "Validé";
                        else echo "Ajourné";
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </div>

    <!-- Retour -->
    <a class="btn" href="dashboard_admin.php">Retour</a>

    <!-- =========================
         Bloc étudiants
    ========================== -->
    <div class="students-block">
        <p class="students-label">Réalisé par</p>

        <div class="students-grid">

            <div class="student-entry">
                <span class="student-name">Bouderraz Maroua</span>
                <span class="student-meta">232335477206 <span class="student-group">Groupe 4</span></span>
            </div>

            <div class="student-entry">
                <span class="student-name">Abaoui Melissa</span>
                <span class="student-meta">212431859912 <span class="student-group">Groupe 2</span></span>
            </div>

            <div class="student-entry">
                <span class="student-name">Aissaoui Yousra</span>
                <span class="student-meta">232331413601 <span class="student-group">Groupe 4</span></span>
            </div>

            <div class="student-entry">
                <span class="student-name">Aitouamar Aya</span>
                <span class="student-meta">242431438719 <span class="student-group">Groupe 2</span></span>
            </div>

        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#dataTable tr");

    rows.forEach((row, i) => {
        if (i === 0) return;
        row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
    });
});

function exportPDF() {
    html2pdf().from(document.getElementById("pdf-content")).save("statistiques.pdf");
}
</script>

</body>
</html>