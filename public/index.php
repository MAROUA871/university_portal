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
                <img src="assets/university_portal_logo.png" alt="Logo UNIVERSITY PORTAL" class="university-portal-logo">
            </div>

            <!-- Logo faculté -->
            <div class="logo-side">
                <img src="assets/logo_faculty.png?v=2" alt="Logo Faculté" class="side-logo">
            </div>

        </div>

        <!-- Titre -->
        <h1 class="main-title">Application de gestion de la scolarité</h1>

        <!-- Description en français -->
        <p class="description-fr">
            Cette application permet la gestion des étudiants, des enseignants,
            des modules, des notes et de l'authentification selon les rôles.
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

        <!-- Bloc étudiants réalisateurs -->
        <div class="students-block">
            <p class="students-label">Réalisé par</p>
            <div class="students-grid">

                <div class="student-entry">
                    <span class="student-name">Bouderraz Maroua</span>
                    <span class="student-meta">232335477206<span class="student-group">Groupe 4</span></span>
                </div>

                <div class="student-entry">
                    <span class="student-name">Abaoui Melissa Lyna</span>
                    <span class="student-meta">212431859912<span class="student-group">Groupe 2</span></span>
                </div>

                <div class="student-entry">
                    <span class="student-name">Aissaoui Yousra</span>
                    <span class="student-meta">232331413601<span class="student-group">Groupe 4</span></span>
                </div>

                <div class="student-entry">
                    <span class="student-name">Aitouamar Aya</span>
                    <span class="student-meta">242431438719<span class="student-group">Groupe 2</span></span>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>