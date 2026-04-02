<?php
require_once "../config/bd.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $identifier = trim($_POST["identifier"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $role = trim($_POST["role"]);
    $password = trim($_POST["password"]);

    // Vérifier si l'identifiant ou l'email existe déjà
    $check_sql = "SELECT * FROM users WHERE identifier = ? OR email = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);

    mysqli_stmt_bind_param($check_stmt, "ss", $identifier, $email);
    mysqli_stmt_execute($check_stmt);

    $check_result = mysqli_stmt_get_result($check_stmt);

    if ($check_result->num_rows > 0) {
        header("Location: add_user.php?error=1");
        exit();
    }

    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insérer le nouvel utilisateur
    $sql = "INSERT INTO users (identifier, password, role, first_name, last_name, email)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $identifier,
        $hashed_password,
        $role,
        $first_name,
        $last_name,
        $email
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: add_user.php?success=1");
        exit();
    } else {
        echo "Erreur lors de l'ajout.";
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($check_stmt);
}
?>