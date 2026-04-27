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
//=========================================================
// File: app/controllers/AnnouncementController.php
// Job: procedural controller for announcements
//=========================================================
require_once __DIR__ . '/../models/modules.php';
//require_once __DIR__ . '/../config/bd.php';
require_once __DIR__ . "/../../config/bd.php";
require_once __DIR__ . '/../models/announcement.php';

session_start();

// ── SECURITY ────────────────────────────────────────────
if (!isset($_SESSION['role'], $_SESSION['id'])) {
    header('Location: ../../public/index.php');
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['id'];

// ── VARIABLES ───────────────────────────────────────────
$success = '';
$error = '';
$errors = [];
$module_id = '';
$title = '';
$body = '';

// ── FORM HANDLING ───────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($role, ['teacher', 'admin'])) {

    $module_id = trim($_POST['module_id'] ?? '');
    $title     = trim($_POST['title'] ?? '');
    $body      = trim($_POST['body'] ?? '');

    // VALIDATION
    if (empty($title)) {
        $errors['title'] = 'Title is required.';
    }

    if (empty($body)) {
        $errors['body'] = 'Message is required.';
    }

    // Teacher must select module
    if ($role === 'teacher' && $module_id === '') {
        $errors['module_id'] = 'Module is required.';
    }

    // Admin can choose general (0)
    if ($role === 'admin' && $module_id === '0') {
        $module_id = null;
    }

    // SECURITY CHECK (IMPORTANT)
    if ($role === 'teacher' && !empty($module_id)) {
        if (!teacher_owns_module($conn, $user_id, $module_id)) {
            $errors['module_id'] = 'Invalid module selection.';
        }
    }

    // SAVE
    if (empty($errors)) {

        $saved = announcement_create(
            $conn,
            $user_id,
            $title,
            $body,
            $module_id ?: null
        );

        if ($saved) {
            $success = "Announcement created successfully.";
            $module_id = $title = $body = '';
        } else {
            $error = "Database error while saving announcement.";
        }

    } else {
        $error = "Please fix the errors.";
    }
}

// ── DATA LOADING (CLEAN + SINGLE SOURCE OF TRUTH) ───────

if ($role === 'admin') {

    $modules = getAllModules($conn);
    $announcements = announcement_get_all($conn);

} elseif ($role === 'teacher') {

    $modules = getModulesByTeacher($conn, $user_id);
    $announcements = announcement_get_by_teacher($conn, $user_id);

} elseif ($role === 'student') {

    $modules = [];
    $announcements = announcement_get_for_student($conn, $user_id);
}

// ── VIEW ────────────────────────────────────────────────
if ($role === 'admin' || $role === 'teacher') {
    require __DIR__ . '/../views/announcement/create.php';
} else {
    require __DIR__ . '/../views/announcement/list.php';
}