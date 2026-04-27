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
<?php
// attendance_session.php

function createSession($db, $user_id, $module_id) {
    $token = bin2hex(random_bytes(32));

    $sql = "INSERT INTO attendance_session (user_id, qr_token, module_id, created_at)
            VALUES (?, ?, ?, NOW())";

    $stmt = $db->prepare($sql);
    $stmt->execute([$user_id, $token, $module_id]);

    return $token;
}

function getSessionByToken($db, $token) {
    $sql = "SELECT * FROM attendance_session WHERE qr_token = ? LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([$token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}