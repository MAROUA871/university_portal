<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

// Récupérer seulement les enseignants
$sql = "SELECT * FROM users WHERE role = 'teacher' ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des enseignants</title>
    <link rel="stylesheet" href="assets/style.css?v=6">
</head>
<body>

<div class="container">
    <h1>Liste des enseignants</h1>
<?php
    if (isset($_GET["success"])) {
        echo "<p style='color:green; font-weight:bold;'>Enseignant supprimé avec succès.</p>";
    }

    if (isset($_GET["updated"])) {
        echo "<p style='color:green; font-weight:bold;'>Enseignant modifié avec succès.</p>";
    }
?>


    <div class="card">
        <div class="search-box">
            <label for="searchInput">Recherche rapid</label>
            <input type="text" id="searchInput" placeholder="🔎 Rechercher par nom, iderntifiant ...">
        </div>
        <button class="btn export-btn" onclick="exportPDF()">Exporter PDF</button>
      <div id="pdf-content">
        <table border="1" width="100%" cellpadding="10" cellspacing="0" id="dataTable">
            <tr>
                
                <th>Identifiant</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Action</th>
                <th>Etat</th>
            </tr>

            <?php while ($user = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    
                    <td><?php echo $user["identifier"]; ?></td>
                    <td><?php echo $user["first_name"]; ?></td>
                    <td><?php echo $user["last_name"]; ?></td>
                    <td><?php echo $user["email"]; ?></td>
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

                </tr>
            <?php } ?>
        </table>
    </div>
    </div>

    <a class="btn" href="dashboard_admin.php">Retour au dashboard</a>
</div>
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
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
function exportPDF() {
    const element = document.getElementById("pdf-content");

    const options = {
        margin: 0.5,
        filename: "liste_enseignants.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
    };

    html2pdf().set(options).from(element).save();
}
</script>
</body>
</html>