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
<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

if (isset($_GET["id"])) {

    $id = intval($_GET["id"]);

    // Récupérer l'utilisateur
    $select_sql = "SELECT * FROM users WHERE id = ?";
    $select_stmt = mysqli_prepare($conn, $select_sql);
    mysqli_stmt_bind_param($select_stmt, "i", $id);
    mysqli_stmt_execute($select_stmt);

    $result = mysqli_stmt_get_result($select_stmt);
    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($select_stmt);

    if ($user) {

        $role = $user["role"];

        /*
            Si l'utilisateur est un étudiant,
            il faut supprimer ses notes avant de supprimer son compte.
        */
        if ($role == "student") {
            $delete_notes_sql = "DELETE FROM notes WHERE student_id = ?";
            $delete_notes_stmt = mysqli_prepare($conn, $delete_notes_sql);
            mysqli_stmt_bind_param($delete_notes_stmt, "i", $id);
            mysqli_stmt_execute($delete_notes_stmt);
            mysqli_stmt_close($delete_notes_stmt);
        }

        /*
            Si l'utilisateur est un enseignant,
            il ne faut pas supprimer directement si des modules lui sont affectés.
            On met teacher_id à NULL pour garder les modules.
        */
        if ($role == "teacher") {
            $update_modules_sql = "UPDATE modules SET teacher_id = NULL WHERE teacher_id = ?";
            $update_modules_stmt = mysqli_prepare($conn, $update_modules_sql);
            mysqli_stmt_bind_param($update_modules_stmt, "i", $id);
            mysqli_stmt_execute($update_modules_stmt);
            mysqli_stmt_close($update_modules_stmt);
        }

        // Supprimer l'utilisateur
        $delete_sql = "DELETE FROM users WHERE id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($delete_stmt, "i", $id);

        if (mysqli_stmt_execute($delete_stmt)) {

            if ($role == "student") {
                header("Location: students_list.php?success=1");
            } elseif ($role == "teacher") {
                header("Location: teachers_list.php?success=1");
            } elseif ($role == "admin") {
                header("Location: admins_list.php?success=1");
            } else {
                header("Location: dashboard_admin.php");
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