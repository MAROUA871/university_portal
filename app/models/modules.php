<?php

function teacher_owns_module($conn, $teacher_id, $module_id) {
    $stmt = $conn->prepare("
        SELECT id 
        FROM modules 
        WHERE id = ? AND teacher_id = ?
    ");

    $stmt->bind_param("ii", $module_id, $teacher_id);
    $stmt->execute();

    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

/**
 * NEW: get all modules with coefficients
 */
function get_all_modules($conn) {

    $stmt = $conn->prepare("SELECT * FROM modules");
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}