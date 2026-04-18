<?php

require_once __DIR__ . '/NotesStudentController.php';
require_once __DIR__ . '/NotesTeacherController.php';
require_once __DIR__ . '/NotesAdminController.php';

class NotesController {

    /**
     * Main entry point for /notes
     */
    public static function index($db) {

        $user = $_SESSION['user'];

        if (!$user) {
            header("Location: /public/login.php");
            exit;
        }

        switch ($user['role']) {

            case 'student':
                NotesStudentController::index($db, $user['id']);
                break;

            case 'teacher':
                // teacher usually needs module context
                // fallback page or redirect to module selection
                header("Location: /public/dashboard_enseignant.php");
                break;

            case 'admin':
                NotesAdminController::index($db);
                break;

            default:
                echo "Unauthorized role";
        }
    }


    /**
     * Admin/Teacher student detail view
     */
    public static function studentDetail($db, $student_id) {

        $user = $_SESSION['user'];

        if (!$user) {
            header("Location: /public/login.php");
            exit;
        }

        if ($user['role'] === 'admin') {

            NotesAdminController::detail($db, $student_id);
            return;
        }

        echo "Access denied";
    }


    /**
     * Teacher module view entry
     */
    public static function module($db, $module_id) {

        $user = $_SESSION['user'];

        if (!$user) {
            header("Location: /public/login.php");
            exit;
        }

        if ($user['role'] === 'teacher') {

            NotesTeacherController::moduleView($db, $module_id);
            return;
        }

        echo "Access denied";
    }
}