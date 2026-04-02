<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

// Vérifier si l'id est envoyé
if (isset($_GET["id"])) {

    $id = $_GET["id"];

    // D'abord récupérer l'utilisateur pour connaître son rôle
    $select_sql = "SELECT * FROM users WHERE id = ?";
    $select_stmt = mysqli_prepare($conn, $select_sql);
    mysqli_stmt_bind_param($select_stmt, "i", $id);
    mysqli_stmt_execute($select_stmt);

    $result = mysqli_stmt_get_result($select_stmt);
    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($select_stmt);

    if ($user) {

        // Récupérer le rôle pour savoir où rediriger
        $role = $user["role"];

        // Supprimer l'utilisateur
        $delete_sql = "DELETE FROM users WHERE id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($delete_stmt, "i", $id);

        if (mysqli_stmt_execute($delete_stmt)) {

            // Redirection selon le rôle
            if ($role == "student") {
                header("Location: students_list.php?success=1");
            } elseif ($role == "teacher") {
                header("Location: teachers_list.php?success=1");
            } elseif ($role == "admin") {
                header("Location: admins_list.php?success=1");
            }

            exit();

        } else {
            echo "Erreur lors de la suppression.";
        }

        mysqli_stmt_close($delete_stmt);

    } else {
        echo "Utilisateur non trouvé.";
    }

} else {
    echo "ID non fourni.";
}
?>