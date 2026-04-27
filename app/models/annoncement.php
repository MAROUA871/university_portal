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
<!-- Aissaoui Yousra
 232331413601
 GROUPE 4
-->
<?php
//=================================================================
// File: app/models/announcement.php
// Job: All DB queries for announcements — procedural functions only
//=================================================================

// ── CREATE ──────────────────────────────────────────────────────
// Insert a new announcement.
// module_id = NULL means it's a general announcement (admin only).
function announcement_create($conn, $user_id, $title, $content, $module_id = null) {
    $sql = "INSERT INTO announcements (user_id, title, content, module_id, posted_at)
            VALUES (:user_id, :title, :content, :module_id, NOW())";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        ':user_id'   => $user_id,
        ':title'     => $title,
        ':content'   => $content,
        ':module_id' => $module_id, // NULL for general
    ]);
}

// ── GET MODULES FOR A TEACHER ────────────────────────────────────
// A teacher can only post in modules assigned to them.
function announcement_get_modules_for_teacher($conn, $teacher_id) {
    $stmt = $conn->prepare("SELECT id, code, name FROM modules WHERE teacher_id = :tid ORDER BY name");
    $stmt->execute([':tid' => $teacher_id]);
    return $stmt->fetchAll();
}

// ── GET ALL MODULES (admin use) ──────────────────────────────────
// Admin sees every module dynamically (no hardcoded list).
function announcement_get_all_modules($conn) {
    $stmt = $conn->prepare("SELECT id, code, name FROM modules ORDER BY name");
    $stmt->execute();
    return $stmt->fetchAll();
}

// ── GET ANNOUNCEMENTS FOR A STUDENT ─────────────────────────────
// Returns:
//   - General announcements (module_id IS NULL)
//   - Announcements for modules the student is enrolled in
function announcement_get_for_student($conn, $student_id) {
    $sql = "
        SELECT a.id, a.title, a.content, a.posted_at,
               u.first_name, u.last_name, u.role,
               m.name AS module_name, m.code AS module_code
        FROM announcements a
        JOIN users u ON u.id = a.user_id
        LEFT JOIN modules m ON m.id = a.module_id
        WHERE
            a.module_id IS NULL  -- general announcements
            OR a.module_id IN (
                SELECT module_id FROM enrollments WHERE student_id = :sid
            )
        ORDER BY a.posted_at DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':sid' => $student_id]);
    return $stmt->fetchAll();
}

// ── GET ALL ANNOUNCEMENTS (admin view) ───────────────────────────
function announcement_get_all($conn) {
    $sql = "
        SELECT a.id, a.title, a.content, a.posted_at,
               u.first_name, u.last_name, u.role,
               m.name AS module_name, m.code AS module_code
        FROM announcements a
        JOIN users u ON u.id = a.user_id
        LEFT JOIN modules m ON m.id = a.module_id
        ORDER BY a.posted_at DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// ── GET ANNOUNCEMENTS POSTED BY A TEACHER ───────────────────────
function announcement_get_by_teacher($conn, $teacher_id) {
    $sql = "
        SELECT a.id, a.title, a.content, a.posted_at,
               m.name AS module_name, m.code AS module_code
        FROM announcements a
        LEFT JOIN modules m ON m.id = a.module_id
        WHERE a.user_id = :tid
        ORDER BY a.posted_at DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':tid' => $teacher_id]);
    return $stmt->fetchAll();
}