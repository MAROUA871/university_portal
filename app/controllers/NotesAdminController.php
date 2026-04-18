<?php

require_once __DIR__ . '/../services/NotesService.php';
require_once __DIR__ . '/../models/student.php';

class NotesAdminController {

    public static function index($db) {

        $students = Student::getAll($db);

        $data = [];

        foreach ($students as $student) {

            $report = NotesService::studentReport($db, $student['id']);

            $data[] = [
                "student" => $student,
                "average" => $report['general_average'],
                "status" => $report['general_average'] >= 10 ? "Admis" : "Ajourné"
            ];
        }

        require __DIR__ . '/../views/notes/admin_list.php';
    }

    public static function detail($db, $student_id) {

        $data = NotesService::studentReport($db, $student_id);

        require __DIR__ . '/../views/notes/admin_detail.php';
    }
}