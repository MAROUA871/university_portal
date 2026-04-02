<?php
// app/models/User.php
// Ce fichier contient des fonctions liées à la table users.
// Il est écrit en style procédural, sans programmation orientée objet.

// Importer la connexion à la base de données
require_once __DIR__ . "/../../config/bd.php";

/**
 * Chercher un utilisateur à partir de son identifiant.
 * Retourne :
 * - les informations de l'utilisateur sous forme de tableau associatif si trouvé
 * - null si aucun utilisateur n'est trouvé
 */
function findUserByIdentifier($identifier)
{
    // Utiliser la connexion créée dans bd.php
    global $conn;

    // Requête SQL sécurisée
    $sql = "SELECT * FROM users WHERE identifier = ?";

    // Préparer la requête
    $stmt = mysqli_prepare($conn, $sql);

    // Vérifier si la préparation a réussi
    if (!$stmt) {
        return null;
    }

    // Associer l'identifiant au point d'interrogation
    // "s" signifie que c'est une chaîne de caractères
    mysqli_stmt_bind_param($stmt, "s", $identifier);

    // Exécuter la requête
    mysqli_stmt_execute($stmt);

    // Récupérer le résultat
    $result = mysqli_stmt_get_result($stmt);

    // Récupérer une seule ligne
    $user = mysqli_fetch_assoc($result);

    // Fermer la requête
    mysqli_stmt_close($stmt);

    // Retourner le résultat
    return $user;
}
?>