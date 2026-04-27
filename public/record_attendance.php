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
session_start();

require_once "../utils/auth_check.php";

$allowed_role = "student";
require_once "../utils/role_check.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrer ma présence</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

    <h2>📷 Enregistrer ma présence</h2>

    <!-- OPTION 1 -->
    <div class="card">
        <h3>Scanner le QR code</h3>
        <p>Scannez le QR code affiché par votre enseignant.</p>

        <!-- For now just info -->
        <p><em>👉 Utilisez votre téléphone pour scanner le QR code</em></p>
    </div>

    <!-- OPTION 2 -->
    <div class="card">
        <h3>Entrer le token</h3>

        <form method="GET" action="scan.php">
            <input type="text" name="token" placeholder="Entrer le token de session" required>
            <br><br>
            <button class="btn" type="submit">Valider</button>
        </form>
    </div>

    <br>
    <a class="btn" href="dashboard_etudiant.php">⬅ Retour</a>

</div>

</body>
</html>