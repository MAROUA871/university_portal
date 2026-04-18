<?php

require_once __DIR__ . '/../models/notes.php';
require_once __DIR__ . '/../models/modules.php';


function get_module_notes($conn, $student_id, $module_id) {

    return [
        "exam" => get_note($conn, $student_id, $module_id, "exam"),
        "td" => get_note($conn, $student_id, $module_id, "td"),
        "presence" => get_note($conn, $student_id, $module_id, "presence")
    ];
}


function calculate_module_average($exam, $td, $presence) {

    return ($exam * 0.6)
         + ($td * 0.4)
         + ($presence * 0.4);
}


function get_student_report($conn, $student_id) {

    $modules = get_all_modules($conn);

    $total = 0;
    $sum_coeff = 0;
    $result = [];

    foreach ($modules as $module) {

        $notes = get_module_notes($conn, $student_id, $module['id']);

        $avg = calculate_module_average(
            $notes['exam'],
            $notes['td'],
            $notes['presence']
        );

        $result[] = [
            "module" => $module,
            "notes" => $notes,
            "average" => $avg
        ];

        $total += $avg * $module['coefficient'];
        $sum_coeff += $module['coefficient'];
    }

    return [
        "modules" => $result,
        "general_average" => $sum_coeff ? ($total / $sum_coeff) : 0
    ];
}