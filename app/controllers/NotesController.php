<?php

require_once __DIR__ . '/../../config/bd.php';

require_once __DIR__ . '/NotesStudentController.php';
require_once __DIR__ . '/NotesTeacherController.php';
require_once __DIR__ . '/NotesAdminController.php';


/**
 * Handle main notes entry (like index)
 */
function notes_index() {

    global $conn;

    if (!isset($_SESSION["role"])) {
        header("Location: /university_portal/public/login.php");
        exit;
    }

    $role = $_SESSION["role"];

    switch ($role) {

        case 'student':
            NotesStudentController::index($conn, $_SESSION["user_id"]);
            break;

        case 'teacher':
            // handled elsewhere (notes.php)
            break;

        case 'admin':
            NotesAdminController::index($conn);
            break;

        default:
            echo "Unauthorized role";
    }
}


/**
 * Handle teacher module view
 */
function notes_module($module_id) {

    global $conn;

    if (!isset($_SESSION['user'])) {
        header("Location: /public/login.php");
        exit;
    }

    if ($_SESSION['user']['role'] !== 'teacher') {
        echo "Access denied";
        return;
    }

    NotesTeacherController::moduleView($conn, $module_id);
}