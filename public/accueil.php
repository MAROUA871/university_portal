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
    <style>
        /* Student credits block — scoped styles that won't clash with existing style.css */
        .students-block {
            margin-top: 2rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 1.2rem;
        }

        .students-label {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .students-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem 1.5rem;
        }

        .student-entry {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
        }

        .student-name {
            font-size: 0.78rem;
            font-weight: 600;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .student-meta {
            font-size: 0.68rem;
            color: #999;
            font-family: monospace;
            letter-spacing: 0.02em;
        }

        .student-group {
            display: inline-block;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: rgba(0,0,0,0.06);
            color: #666;
            padding: 0.1rem 0.35rem;
            border-radius: 3px;
            margin-left: 0.25rem;
        }

        /* Responsive: stack to 1 column on small screens */
        @media (max-width: 480px) {
            .students-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                    <span class="student-name">Abaoui Mellisa</span>
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