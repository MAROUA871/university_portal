<?php

require_once __DIR__ . '/../services/NotesService.php';

class NotesStudentController {

    public static function index($db, $student_id) {

        $data = NotesService::studentReport($db, $student_id);

        require __DIR__ . '/../views/notes/student.php';
    }
}