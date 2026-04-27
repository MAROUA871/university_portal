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

if (!isset($_SESSION["role"]) || !in_array($_SESSION["role"], ["admin", "teacher"])) {
    header("Location: login.php");
    exit();
}

require_once "../config/bd.php";

$is_admin = $_SESSION["role"] === "admin";
$teacher_id = $_SESSION["id"] ?? 0;

/* =========================
   FILTRE MODULE
========================= */
$filter_module = isset($_GET["module_id"]) ? intval($_GET["module_id"]) : 0;

/* =========================
   MODULES DU TEACHER
========================= */
$modules = [];

if (!$is_admin) {
    $sql_modules = "SELECT id, code, name FROM modules WHERE teacher_id = ? ORDER BY name ASC";
    $stmt_modules = mysqli_prepare($conn, $sql_modules);
    mysqli_stmt_bind_param($stmt_modules, "i", $teacher_id);
    mysqli_stmt_execute($stmt_modules);
    $result_modules = mysqli_stmt_get_result($stmt_modules);

    while ($row = mysqli_fetch_assoc($result_modules)) {
        $modules[] = $row;
    }

    mysqli_stmt_close($stmt_modules);
}

/* =========================
   REQUETE PRINCIPALE
========================= */
if ($is_admin) {
    $sql = "
        SELECT id, identifier, first_name, last_name, email,status
        FROM users
        WHERE role = 'student'
        ORDER BY last_name ASC, first_name ASC
    ";

    $stmt = mysqli_prepare($conn, $sql);
} else {
    $sql = "
        SELECT
            users.id,
            users.identifier,
            users.first_name,
            users.last_name,
            users.email,
            modules.id AS module_id,
            modules.code,
            modules.name AS module_name,
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

    if ($filter_module > 0) {
        $sql .= " AND modules.id = ? ";
    }

    $sql .= "
        GROUP BY users.id, users.identifier, users.first_name, users.last_name, users.email, modules.id, modules.code, modules.name
        ORDER BY users.last_name ASC, users.first_name ASC
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if ($filter_module > 0) {
        mysqli_stmt_bind_param($stmt, "ii", $teacher_id, $filter_module);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $teacher_id);
    }
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

/* =========================
   STOCKER LES LIGNES
========================= */
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

/* =========================
   STATISTIQUES
========================= */
$total = 0;
$admis = 0;
$ajourne = 0;
$somme_moyennes = 0;

if (!$is_admin) {
    foreach ($rows as $user) {
        $td = $user["td_note"];
        $exam = $user["exam_note"];
        $moyenne = ($td !== null && $exam !== null) ? round(($td * 0.4) + ($exam * 0.6), 2) : null;

        if ($moyenne !== null) {
            $total++;
            $somme_moyennes += $moyenne;

            if ($moyenne >= 10) {
                $admis++;
            } else {
                $ajourne++;
            }
        }
    }
}

$moyenne_generale = ($total > 0) ? round($somme_moyennes / $total, 2) : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Liste des étudiants</h1>

    <?php if (isset($_GET["success"])): ?>
        <p style="color:green; font-weight:bold;">Étudiant supprimé avec succès.</p>
    <?php endif; ?>

    <?php if (isset($_GET["updated"])): ?>
        <p style="color:green; font-weight:bold;">Étudiant modifié avec succès.</p>
    <?php endif; ?>

    <div class="card">

        <?php if (!$is_admin): ?>
            <form method="GET" class="module-filter-box">
                <label for="module_id">Filtrer par module</label>
                <select name="module_id" id="module_id" onchange="this.form.submit()">
                    <option value="0">-- Tous les modules --</option>
                    <?php foreach ($modules as $module): ?>
                        <option value="<?php echo $module["id"]; ?>" <?php echo ($filter_module == $module["id"]) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($module["code"] . " - " . $module["name"]); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            
        <?php endif; ?>

        <div class="search-box">
            <label for="searchInput">Recherche rapide (nom ou identifiant)</label>
            <input type="text" id="searchInput" placeholder="🔎Rechercher par nom, iderntifiant ...">
        </div>

        
            <button class="btn export-btn" onclick="exportPDF()">Exporter PDF</button>
        
          <br><br>
        <div id="pdf-content">
            <?php if (!$is_admin): ?>
                <div class="stats-box">
                    <div class="stat-item">👨‍🎓 Total : <?php echo $total; ?></div>
                    <div class="stat-item">🟢 Admis : <?php echo $admis; ?></div>
                    <div class="stat-item">🔴 Ajournés : <?php echo $ajourne; ?></div>
                    <div class="stat-item">📊 Moyenne Générale : <?php echo number_format($moyenne_generale, 2); ?></div>
                </div>
            <?php endif; ?>

            <table border="1" width="100%" cellpadding="10" cellspacing="0" id="dataTable">
                <tr>
                    <th>Identifiant</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>

                    <?php if (!$is_admin): ?>
                        <th>Module</th>
                        <th>TD</th>
                        <th>Examen</th>
                        <th>Moyenne</th>
                        <th>Statut</th>
                        
                    <?php endif; ?>

                    <?php if ($is_admin): ?>
                        <th>Action</th>
                        <th>Etat</th>
                    <?php endif; ?>
                </tr>

                <?php foreach ($rows as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user["identifier"]); ?></td>
                        <td><?php echo htmlspecialchars($user["first_name"]); ?></td>
                        <td><?php echo htmlspecialchars($user["last_name"]); ?></td>
                        <td><?php echo htmlspecialchars($user["email"]); ?></td>

                        <?php if (!$is_admin): ?>
                            <?php
                            $td = $user["td_note"];
                            $exam = $user["exam_note"];
                            $moyenne = ($td !== null && $exam !== null) ? round(($td + $exam) / 2, 2) : null;
                            ?>
                            <td><?php echo htmlspecialchars($user["code"] . " - " . $user["module_name"]); ?></td>

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
                                <?php
                                if ($moyenne === null) {
                                    echo "-";
                                } elseif ($moyenne >= 10) {
                                    echo "<span class='status-pass'>Admis</span>";
                                } else {
                                    echo "<span class='status-fail'>Ajourné</span>";
                                }
                                ?>
                            </td>
                        <?php endif; ?>

                        <?php if ($is_admin): ?>
                            <td class="actions">
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="edit-link">
                                    ✏️ Edit
                                </a>
                                <br>

                                <a href="delete_user.php?id=<?php echo $user['id']; ?>"
                                   class="delete-link"
                                   onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                    🗑️ Delete
                                </a>
                            </td>
                            <td>
                                <?php if ($user["status"] == 1): ?>
                                    <span class="status-dot active"></span>
                                <?php else: ?>
                                    <span class="status-dot inactive"></span>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <a class="btn" href="<?php echo $is_admin ? 'dashboard_admin.php' : 'dashboard_enseignant.php'; ?>">
        Retour au dashboard
    </a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#dataTable tr");

    rows.forEach((row, index) => {
        if (index === 0) return;

        let identifier = row.cells[0]?.innerText.toLowerCase() || "";
        let firstName  = row.cells[1]?.innerText.toLowerCase() || "";
        let lastName   = row.cells[2]?.innerText.toLowerCase() || "";

        if (
            identifier.includes(filter) ||
            firstName.includes(filter) ||
            lastName.includes(filter)
        ) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

function exportPDF() {
    const element = document.getElementById("pdf-content");

    const opt = {
        margin: 0.5,
        filename: 'liste_etudiants.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
    };

    html2pdf().set(opt).from(element).save();
}
</script>

</body>
</html>