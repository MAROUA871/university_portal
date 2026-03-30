<?php
//=================================================================
//File: app/models/annoncement.php
//Job: talk with the database to get the annoncement data(only this file does sql)
//=================================================================


class Annoncement { 

private $conn;
public function __construct($conn) {
    $this->conn = $conn;
}

//---INSERT: save a new annoncement ------
//called by the controller when the teacher subbmits the form
public function create($module_id, $tacher-id, $title, $body) {
    $sql = "INSERT INTO annoncement (module_id, teacher_id, title, body, created_at)
            VALUES (?, ?, ?, ?, NOW())";
            //prepare the query
    $stmt = $this->conn->prepare($sql);

    //execute with real values filling the placeholders
    //return true if the query was successful, false otherwise
    return $stmt->execute([$module_id, $teacher_id, $title, $body]);
}

//--SELECT ALL: get every annoncement------
//called by the controller for the student feed
public function getAll() {
    $sql = "SELECT a.id, a.title, a,body, a.created_at, m.name AS module_name 
            FROM annoncement a
            JOIN module m ON a.module_id = m.id
            WHERE a.module_id = ?
            ORDERED BY a.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$module_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//DELETE: delete an annoncement
//called by the teacher when the teacher clicks delete
public function delete($id) {
    sql = "DELETE FROM annoncement WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
}

//---GET MODULES: for the dropdown in the form ---------
public function getModules() {
    $sql = "SELECT id, name FROM modules ORDERED BY name ASC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();  
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
<?php