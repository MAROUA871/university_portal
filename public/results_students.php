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

$sql = "
SELECT 
    u.id,
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
GROUP BY u.id, u.identifier, u.first_name, u.last_name, u.email, m.id, m.coefficient
ORDER BY u.last_name ASC, u.first_name ASC
";

$result = mysqli_query($conn, $sql);

$students = [];

while ($row = mysqli_fetch_assoc($result)) {
    $student_id = $row["id"];

    if (!isset($students[$student_id])) {
        $students[$student_id] = [
            "identifier" => $row["identifier"],
            "first_name" => $row["first_name"],
            "last_name" => $row["last_name"],
            "email" => $row["email"],
            "sum" => 0,
            "coeff_sum" => 0
        ];
    }

    $td = $row["td"];
    $exam = $row["exam"];
    $coef = intval($row["coefficient"]);

    if ($td !== null && $exam !== null && $coef > 0) {
        $module_average = ($td * 0.4) + ($exam * 0.6);

        $students[$student_id]["sum"] += $module_average * $coef;
        $students[$student_id]["coeff_sum"] += $coef;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats des étudiants</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Résultats des étudiants</h1>

    <div class="card">

        <div class="search-box">
            <label for="searchInput">Recherche rapide</label>
            <input type="text" id="searchInput" placeholder="🔎Rechercher par nom ou identifiant...">
        </div>

        <table id="dataTable">
            <tr>
                <th>Identifiant</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Moyenne générale</th>
                <th>Statut</th>
            </tr>

            <?php foreach ($students as $student): ?>
                <?php
                if ($student["coeff_sum"] > 0) {
                    $moyenne_generale = round($student["sum"] / $student["coeff_sum"], 2);
                } else {
                    $moyenne_generale = null;
                }
                ?>

                <tr>
                    <td><?php echo htmlspecialchars($student["identifier"]); ?></td>
                    <td><?php echo htmlspecialchars($student["first_name"]); ?></td>
                    <td><?php echo htmlspecialchars($student["last_name"]); ?></td>
                    <td><?php echo htmlspecialchars($student["email"]); ?></td>

                    <td class="<?php echo ($moyenne_generale !== null && $moyenne_generale >= 10) ? 'good' : 'bad'; ?>">
                        <?php echo ($moyenne_generale !== null) ? number_format($moyenne_generale, 2) : "-"; ?>
                    </td>

                    <td>
                        <?php if ($moyenne_generale === null): ?>
                            -
                        <?php elseif ($moyenne_generale >= 10): ?>
                            <span class="status-pass">Admis</span>
                        <?php else: ?>
                            <span class="status-fail">Ajourné</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

    <a class="btn" href="dashboard_admin.php">Retour au dashboard</a>
</div>

<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#dataTable tr");

    rows.forEach(function(row, index) {
        if (index === 0) return;

        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

</body>
</html>