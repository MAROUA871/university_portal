<?php
//=================================================================
//File: app/controllers/AnnoncementController.php
//Job: handle the logic of the annoncement feature, talk with the model to get data and decide which view to show
//=================================================================

require_once__DIR__ .'/../config/bd.php';
require_once__DIR__ .'/../models/annoncement.php';

//start session to check who is logged in
session_start();

//__SECURITY: only teacher can post__________________
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../../public/index.php');
    exit();
}

//create an annoncement object -- pass $conn to it
//now $annoncement can talk to the database
$annoncement = new Annoncement($conn);

//___VARIABLES sent to the view___________________________
$success = '';
$error = '';
$errors = [];

//__HANDLE FORM SUBMIT___________________________________________
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Read what the tacher typed 
    $module_id =trim($_POST['module_id'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $teacher_id = $_SESSION['user_id']; //get teacher id from session

    //__VALIDATION -- check nothing is empty___________________________
    if (empty($module_id)) 
        $errors['module_id'] = 'Module is required.';

    if (empty($title))
        $errors['title'] = 'Title is required.';

    if (empty($body))
        $errors['body'] = 'The message is required.';

    //__IF NO ERRORS, --> SAVE TO THE DATABASE USING THE MODEL___________________
        if (empty($errors)) {
            $saved = $annoncement->create($module_id, $teacher_id, $title, $body);

            if ($saved) {
                $success = "Announcement created successfully.";
                //clear variables so form rests
                $module_id = $title = $body = '';
            }else {
                $error = "Failed to create announcement. Please try again.";
            }
        }else {
            $error = "Please fix the errors below.";
        }
    }

    //__GET MODULES FOR THE DROPDOWN___________________________
    $modules = $annoncement->getModules();

    //__GET MODULES FOR THE DROPDOWN___________________________
    $modules = $annoncement->getModules();

    //__LOAD THE VIEW___________________________
    //all variables above ($success, $error, $errors, $modules) are available inside the view
    //are automatically available inside the view file
    require_once__DIR__ .'/../views/annoncement/create.php';
    ?>