<?php
session_start();

require_once "../../app/controllers/NotesController.php";

$module_id = $_GET['module_id'] ?? null;

if ($module_id) {
    notes_module($module_id);
} else {
    notes_index();
}