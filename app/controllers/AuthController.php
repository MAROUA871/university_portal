<?php
// app/controllers/AuthController.php

session_start();

require_once "../../config/bd.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $identifier = trim($_POST['identifier']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role'] ?? '');

    $sql = "SELECT * FROM users WHERE identifier = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $identifier);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {

        if (password_verify($password, $user["password"])) {

            if (!empty($role) && $user["role"] != $role) {
                header("Location: ../../public/login.php?role=$role&error=4");
                exit();
            }

            // Bloquer compte désactivé
            if (isset($user["status"]) && intval($user["status"]) === 0) {
                header("Location: ../../public/login.php?role=$role&error=5");
                exit();
            }

            $_SESSION["id"] = $user["id"];
            $_SESSION["identifier"] = $user["identifier"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["first_name"] = $user["first_name"];
            $_SESSION["last_name"] = $user["last_name"];
            $_SESSION["status"] = $user["status"];

            if ($user["role"] == "admin") {
                header("Location: ../../public/dashboard_admin.php");
                exit();
            } elseif ($user["role"] == "teacher") {
                header("Location: ../../public/dashboard_enseignant.php");
                exit();
            } elseif ($user["role"] == "student") {
                header("Location: ../../public/dashboard_etudiant.php");
                exit();
            } else {
                header("Location: ../../public/login.php?role=$role&error=3");
                exit();
            }

        } else {
            header("Location: ../../public/login.php?role=$role&error=2");
            exit();
        }

    } else {
        header("Location: ../../public/login.php?role=$role&error=1");
        exit();
    }

    mysqli_stmt_close($stmt);

} else {
    echo "Accès non autorisé.";
}
?>