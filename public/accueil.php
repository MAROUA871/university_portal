<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion de la scolarité</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <div class="card">

        <!-- Zone des logos -->
        <div class="top-logos">

            <!-- Logo université -->
            <div class="logo-side">
                <img src="assets/logo_university.png" alt="Logo Université" class="side-logo">
            </div>

            <!-- Bloc central -->
            <div class="logo-center">
                <img src="assets/university_portal_logo.png" alt="Logo UNIVERSITY PORTAL" class="university_portal-logo">

                
            </div>

            <!-- Logo faculté -->
            <div class="logo-side">
                <img src="assets/logo_faculty.png" alt="Logo Faculté" class="side-logo">
            </div>

        </div>

        <!-- Titre -->
        <h1 class="main-title">Application de gestion de la scolarité</h1>

        <!-- Description en français -->
        <p class="description-fr">
            Cette application permet la gestion des étudiants, des enseignants,
            des modules, des notes et de l’authentification selon les rôles.
        </p>

        <!-- Description en arabe -->
        <p class="description-ar" dir="rtl">
            يتيح هذا التطبيق تسيير الطلبة والأساتذة والمقاييس والعلامات
            مع نظام تسجيل الدخول حسب نوع المستخدم.
        </p>

        <!-- Boutons de connexion par rôle -->
        <div class="login-buttons">
            <a href="login.php?role=teacher" class="role-btn teacher-btn">Connexion Enseignant</a>
            <a href="login.php?role=student" class="role-btn student-btn">Connexion Étudiant</a>
            <a href="login.php?role=admin" class="role-btn admin-btn">Connexion Administrateur</a>
        </div>

    </div>
</div>

</body>
</html>