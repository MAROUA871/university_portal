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
    modules.id,
    modules.code,
    modules.name,
    modules.coefficient,
    users.first_name,
    users.last_name
FROM modules
LEFT JOIN users ON modules.teacher_id = users.id
ORDER BY modules.name ASC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des modules</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Gestion des modules</h1>

    <!-- Messages -->
    <?php if (isset($_GET["success"])): ?>
        <p style="color:green; font-weight:bold;">Module ajouté avec succès.</p>
    <?php endif; ?>

    <?php if (isset($_GET["updated"])): ?>
        <p style="color:green; font-weight:bold;">Module modifié avec succès.</p>
    <?php endif; ?>

    <?php if (isset($_GET["deleted"])): ?>
        <p style="color:green; font-weight:bold;">Module supprimé avec succès.</p>
    <?php endif; ?>

    <div class="card">

        <!-- Bouton ajouter -->
        <a class="btn" href="add_module.php">Ajouter un module</a>
       <div class="search-box">
        <label for="searchInput">Recherche rapid</label>
        <input type="text" id="searchInput" placeholder="🔎 Rechercher par nom, code ...">
       </div>
        <table border="1" width="100%" cellpadding="10" cellspacing="0" id="dataTable">
            <tr>
                <th>Code</th>
                <th>Nom du module</th>
                <th>Coefficient</th>
                <th>Enseignant</th>
                <th>Action</th>
            </tr>

            <?php while ($module = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($module["code"]); ?></td>
                    <td><?php echo htmlspecialchars($module["name"]); ?></td>
                    <td><?php echo htmlspecialchars($module["coefficient"]); ?></td>

                    <td>
                        <?php
                        if (!empty($module["first_name"])) {
                            echo htmlspecialchars($module["first_name"] . " " . $module["last_name"]);
                        } else {
                            echo "<span style='color:gray;'>Non affecté</span>";
                        }
                        ?>
                    </td>

                    <!-- ACTION STYLE COMME TEACHERS -->
                    <td class="actions">
                     <a href="edit_module.php?id=<?php echo $module['id']; ?>" class="edit-link">
                        ✏️ Edit
                     </a>
                     <br>

                     <a href="delete_module.php?id=<?php echo $module['id']; ?>"
                      class="delete-link"
                      onclick="return confirm('Voulez-vous vraiment supprimer ce module ?');">
                      🗑️ Delete
                     </a>
                    </td>
                </tr>
            <?php } ?>

        </table>
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

</body>
</html>