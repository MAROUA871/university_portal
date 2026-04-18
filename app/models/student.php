<?php

class Student {

    public static function getAll($db) {

        $res = $db->query("SELECT * FROM users WHERE role='student'");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}