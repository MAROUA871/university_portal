
<?php
// app/controllers/AuthController.php
// Ce fichier récupère les données du formulaire,
// cherche l'utilisateur dans la base,
// puis vérifie le mot de passe.
session_start();

require_once "../../config/bd.php";

// Vérifier que le formulaire a bien été envoyé en POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer l'identifiant envoyé depuis le formulaire
    $identifier = trim($_POST['identifier']);

    // Récupérer le mot de passe envoyé depuis le formulaire
    $password = trim($_POST['password']);

    // Requête SQL sécurisée :
    // on cherche un utilisateur dont l'identifiant correspond à la valeur reçue
    $sql = "SELECT * FROM users WHERE identifier = ?";

    // Préparer la requête
    $stmt = mysqli_prepare($conn, $sql);

    // Associer la valeur de $identifier au point d'interrogation
    // "s" signifie que c'est une chaîne de caractères
    mysqli_stmt_bind_param($stmt, "s", $identifier);

    // Exécuter la requête
    mysqli_stmt_execute($stmt);

    // Récupérer le résultat de la requête
    $result = mysqli_stmt_get_result($stmt);

    // Récupérer une seule ligne sous forme de tableau associatif
    $user = mysqli_fetch_assoc($result);

    // Vérifier si l'utilisateur existe
    if ($user) {

        // Vérifier si le mot de passe est correct
        if (password_verify($password, $user["password"])) {
            $_SESSION["id"] = $user["id"];
            $_SESSION["identifier"] = $user["identifier"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["first_name"] = $user["first_name"];
            $_SESSION["last_name"] = $user["last_name"];            
          
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
                header("location: ../../public/login.php?error=3");
                exit();
            }
        } else {
            //Mot de passe incorrect.
            header("Location: ../../public/login.php?error=2");
            exit();
        }

    } else { 
        //Utilisateur non trouvé.
        header("Location: ../../public/login.php?error=1");
        exit();
    }

    // Fermer la requête préparée
    mysqli_stmt_close($stmt);

} else {
    // Si quelqu'un ouvre directement ce fichier sans passer par le formulaire
    echo "Accès non autorisé.";
}
?>