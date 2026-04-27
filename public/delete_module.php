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

if (!isset($_GET["id"])) {
    header("Location: modules_list.php");
    exit();
}

$id = intval($_GET["id"]);

/* Supprimer d'abord les notes liées au module */
$sql_notes = "DELETE FROM notes WHERE module_id = ?";
$stmt_notes = mysqli_prepare($conn, $sql_notes);
mysqli_stmt_bind_param($stmt_notes, "i", $id);
mysqli_stmt_execute($stmt_notes);
mysqli_stmt_close($stmt_notes);

/* Supprimer le module */
$sql = "DELETE FROM modules WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: modules_list.php?deleted=1");
exit();