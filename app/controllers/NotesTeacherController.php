<?php

require_once __DIR__ . '/../services/NotesService.php';
require_once __DIR__ . '/../models/student.php';

class NotesTeacherController {

    public static function moduleView($db, $module_id) {

        $students = Student::getAll($db);

        $data = [];

        foreach ($students as $student) {

            $notes = NotesService::getModuleNotes(
                $db,
                $student['id'],
                $module_id
            );

            $avg = NotesService::moduleAverage(
                $notes['exam'],
                $notes['td'],
                $notes['presence']
            );

            $data[] = [
                "student" => $student,
                "notes" => $notes,
                "average" => $avg
            ];
        }

        require __DIR__ . '/../views/notes/teacher.php';
    }
}