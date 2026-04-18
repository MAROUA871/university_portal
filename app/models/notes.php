<?php

function get_note($conn, $student_id, $module_id, $type) {

    $stmt = $conn->prepare("
        SELECT value 
        FROM notes
        WHERE student_id = ? 
        AND module_id = ? 
        AND type = ?
        LIMIT 1
    ");

    $stmt->bind_param("iis", $student_id, $module_id, $type);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();

    return $result ? $result['value'] : 0;
}