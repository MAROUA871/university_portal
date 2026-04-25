<?php
/* =========================
   Sécurité & accès
========================= */
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

/* =========================
   Récupération des admins
========================= */
$sql = "SELECT * FROM users WHERE role = 'admin' ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des administrateurs</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="container">

    <!-- =========================
         Titre
    ========================== -->
    <h1>Liste des administrateurs</h1>

    <!-- =========================
         Messages
    ========================== -->
    <?php
    if (isset($_GET["success"])) {
        echo "<p style='color:green; font-weight:bold;'>Administrateur supprimé avec succès.</p>";
    }

    if (isset($_GET["updated"])) {
        echo "<p style='color:green; font-weight:bold;'>Administrateur modifié avec succès.</p>";
    }
    ?>

    <!-- =========================
         Tableau
    ========================== -->
    <div class="card">

        <div class="search-box">
            <label for="searchInput">Recherche rapide</label>
            <input type="text" id="searchInput" placeholder="🔎 Rechercher par nom ou identifiant...">
        </div>

        <button class="btn export-btn" onclick="exportPDF()">Exporter PDF</button>

        <div id="pdf-content">
            <table border="1" width="100%" cellpadding="10" cellspacing="0" id="dataTable">
                <tr>
                    <th>Identifiant</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Actions</th>
                    <th>État</th>
                </tr>

                <?php while ($user = mysqli_fetch_assoc($result)) { ?>
                    <tr>

                        <td><?= htmlspecialchars($user["identifier"]); ?></td>
                        <td><?= htmlspecialchars($user["first_name"]); ?></td>
                        <td><?= htmlspecialchars($user["last_name"]); ?></td>
                        <td><?= htmlspecialchars($user["email"]); ?></td>

                        <td class="actions">
                            <a href="edit_user.php?id=<?= $user['id']; ?>" class="edit-link">✏️ Edit</a>
                            <br>
                            <a href="delete_user.php?id=<?= $user['id']; ?>" class="delete-link"
                               onclick="return confirm('Êtes-vous sûr ?');">
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

                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>

    <!-- =========================
         Retour
    ========================== -->
    <div class="card">
        <a class="btn" href="dashboard_admin.php">Retour au dashboard</a>
    </div>

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

<!-- =========================
     Scripts
========================= -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#dataTable tr");

    rows.forEach((row, index) => {
        if (index === 0) return;

        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
function exportPDF() {
    const element = document.getElementById("pdf-content");

    html2pdf().from(element).save("liste_admins.pdf");
}
</script>

</body>
</html>