<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

/*
    Objectif :
    - Calculer la moyenne générale de chaque étudiant
    - Utiliser les coefficients des modules
    - Afficher les statistiques :
        total étudiants
        admis
        ajournés
        excellents >= 16
        moyenne générale de la promo
*/

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

while ($row = mysqli_fetch_assoc($result)) {
    $student_id = $row["student_id"];

    if (!isset($students[$student_id])) {
        $students[$student_id] = [
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
    $coefficient = intval($row["coefficient"]);

    if ($td !== null && $exam !== null && $coefficient > 0) {
        $moyenne_module = ($td * 0.4) + ($exam * 0.6);

        $students[$student_id]["somme_moyenne_coeff"] += $moyenne_module * $coefficient;
        $students[$student_id]["somme_coefficients"] += $coefficient;
    }
}

/* =========================
   CALCUL DES STATISTIQUES
========================= */

$results = [];

$total_etudiants = 0;
$total_admis = 0;
$total_ajournes = 0;
$total_excellents = 0;
$somme_moyennes_generales = 0;

foreach ($students as $student) {
    if ($student["somme_coefficients"] > 0) {
        $moyenne_generale = round(
            $student["somme_moyenne_coeff"] / $student["somme_coefficients"],
            2
        );

        $statut = ($moyenne_generale >= 10) ? "Admis" : "Ajourné";

        $total_etudiants++;
        $somme_moyennes_generales += $moyenne_generale;

        if ($moyenne_generale >= 10) {
            $total_admis++;
        } else {
            $total_ajournes++;
        }

        if ($moyenne_generale >= 16) {
            $total_excellents++;
        }

        $student["moyenne_generale"] = $moyenne_generale;
        $student["statut"] = $statut;

        $results[] = $student;
    }
}

$moyenne_promo = ($total_etudiants > 0)
    ? round($somme_moyennes_generales / $total_etudiants, 2)
    : 0;

$taux_reussite = ($total_etudiants > 0)
    ? round(($total_admis / $total_etudiants) * 100, 2)
    : 0;
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

    <h1>Statistiques des étudiants</h1>

    <div class="card">
        <h2>📊 Résumé général</h2>

        <div class="stats-box">
            <div class="stat-item">
                👨‍🎓 Total étudiants : <?php echo $total_etudiants; ?>
            </div>

            <div class="stat-item">
                🟢 Admis : <?php echo $total_admis; ?>
            </div>

            <div class="stat-item">
                🔴 Ajournés : <?php echo $total_ajournes; ?>
            </div>

            <div class="stat-item">
                🌟 Moyenne ≥ 16 : <?php echo $total_excellents; ?>
            </div>

            <div class="stat-item">
                📊 Moyenne promo : <?php echo number_format($moyenne_promo, 2); ?>
            </div>

            <div class="stat-item">
                ✅ Taux réussite : <?php echo number_format($taux_reussite, 2); ?>%
            </div>
        </div>
    </div>

    <div class="card">
        <h2>📋 Résultats détaillés</h2>

        <div class="search-box">
            <label for="searchInput">Recherche rapide</label>
            <input type="text" id="searchInput" placeholder="🔎 Rechercher par nom ou identifiant...">
        </div>

        <div class="export-container">
            <button class="btn export-btn" onclick="exportPDF()">Exporter PDF</button>
        </div>

        <div id="pdf-content">
            <table id="dataTable" border="1" width="100%" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Identifiant</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Moyenne générale</th>
                    <th>Statut</th>
                    <th>Catégorie</th>
                </tr>

                <?php foreach ($results as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student["identifier"]); ?></td>
                        <td><?php echo htmlspecialchars($student["first_name"]); ?></td>
                        <td><?php echo htmlspecialchars($student["last_name"]); ?></td>
                        <td><?php echo htmlspecialchars($student["email"]); ?></td>

                        <td class="<?php echo ($student["moyenne_generale"] >= 10) ? 'good' : 'bad'; ?>">
                            <?php echo number_format($student["moyenne_generale"], 2); ?>
                        </td>

                        <td>
                            <?php if ($student["statut"] == "Admis"): ?>
                                <span class="status-pass">Admis</span>
                            <?php else: ?>
                                <span class="status-fail">Ajourné</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php
                            if ($student["moyenne_generale"] >= 16) {
                                echo "Excellent";
                            } elseif ($student["moyenne_generale"] >= 10) {
                                echo "Validé";
                            } else {
                                echo "Ajourné";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <a class="btn" href="dashboard_admin.php">Retour au dashboard</a>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#dataTable tr");

    rows.forEach(function(row, index) {
        if (index === 0) return;

        let text = row.innerText.toLowerCase();

        if (text.includes(filter)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

function exportPDF() {
    const element = document.getElementById("pdf-content");

    const options = {
        margin: 0.5,
        filename: "statistiques_etudiants.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
    };

    html2pdf().set(options).from(element).save();
}
</script>

</body>
</html>