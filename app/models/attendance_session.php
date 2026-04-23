<?php
// attendance_session.php

function createSession($db, $user_id) {
    $token = bin2hex(random_bytes(32));

    $sql = "INSERT INTO attendance_session (user_id, qr_token, created_at) VALUES (?, ?, NOW())";
    

    $stmt = $db->prepare($sql);
    $success = $stmt->execute([$user_id, $token]);

    if ($success) {
        return $token;
    }
    return false;
}

function getSessionByToken($db, $token) {
    $sql = "SELECT * FROM attendance_session WHERE qr_token = ? LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([$token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}