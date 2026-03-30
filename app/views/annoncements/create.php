<!DOCTYPE html>
<!=====================================================
FILE: app/views/annoncements/create.php
JOB: the HTML form that the teacher fills to post an annoncement
======================================================-->
HTML lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Annoncement - University Portal</title>
    <style>
        /*--RESET: remove default browser styles--*/
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /*--PAGE BASE---*/
        body {
            font-family: 'segoe ui', sans-serif;
            background-color: #f4f3ef;
            color: #1a1916;
            font-size: 14px;
            min-height: 100vh;
        }

        /*LAYOUT*/
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /*----------------------------------------
        SIDEBAR - left column, fixed 220px wide
        -----------------------------------------*/
        .sidebar {
            width: 220px;
            background: #ffffff;
            border-right: 1px solid #e2e0d8;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar-header {
            padding: 20px 18px 16px;
            border-bottom: 1px solid #e2e0d8;
        }
        .app-name {font-size: 13px; font-weight: 600;}
        .app-sub {font-size: 11px; color: #9e9b92; margin-top: 2px; font-family: monospace;}

        .nav {padding: 10px 8px; }
        .nav-label {
            font-size: 10px; font-weight: 600; color: #9e9b92; text-tranform: uppercase; letter-spacing; 0.08em; padding: 10px 10px 4px;
        }

        /*Each link in the sidebar*/
        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 10px;
            border-radius: 7px;
            color: #6b6860;
            font-size: 13px;
            text-decoration: none;
            transition: background 0.12s;
        }
        .nav-item:hover {background: #f4f3ef; color: #1a1916; }

        /*Bleu higlight for the current page*/
        .nav-item.active {
            background: #e8eef8;
            color: #1a4fa0;
            font-weight: 600;
        }

        /*Teacher info pinned to the bottom of the sidebar*/
        .sidebar-user {
            padding: 12px 16px;
            border-top: 1px solid #e2e0d8;
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /*Circle showing teacher initials*/
        .avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: #e8eef8; color: #1a4fa0;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 600;
            flex-shrink: 0;
        }
        .user-name {font-size: 13px; font-weight: 500;}
        .user-role: {font-size: 11px; color: #9e9b92;}

        /*----------------------------------------
        MAIN - takes all remaining width after sidebar
        -----------------------------------------*/
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /*Sticky top bar with page title*/
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e0d8;
            padding; 16px 28px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .topbar h1 {font-size: 17px; font-weight: 600;}
        .topbar p {font-size: 12px; color: #6b6860; margin-top: 4px;}

        /*Inner padding aroud form*/
        .content {padding: 28px; max-width: 680px; }

        /*----------------------------------------
        ALERT MESSAGES
        -----------------------------------------*/
        .alert {
            padding: 11px 16px;
            border-raduis: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;    
        }
        .alert.success {
            background: #e6f4ec;
            color: #1a6e3c;
            border: 1px solid #a8d8b9;
        }
        .alert-error {
            background: #faeaea;
            color: #8f1f1f;
            border: 1px solid #e0b0b0;
        }

        /*----------------------------------------
        CARD ELEMENTS
        -----------------------------------------*/
        .form-row {margin-bottom: 16px;}
        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 16px;
        }

        /*Label above each field*/
        label {
            display: block;
            font-size: 11px; font-weight: 600; color: #6b6860; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;
        }
        .required {color: #8f1f1f;}

        /*Styling shared by input, select, textarea*/
        input[type="text"], select, textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #e2e0d8;
            border-radius: 8px;
            font-size: 13px;
            font-family: 'segoe ui', sans-serif;
            color: #1a1916;
            background: #ffffff;
            transition: border-color 0.15s;
        }
        /*Bleu border when the user clicks into a field*/
        input[type="text"]:focus, select:focus, textarea:focus {
            border-color: #1a4fa0;
            outline: none;
        }
        /*Red boreder by PHP when field has a validation error*/
        .input-error {border-color: #8f1f1f; !important;}

        /*Content textarea is taller than a normal input*/
        textarea {height: 120px; resize: vertical;}

        /*Small red error text shown below a field */
        .field-err {font-size: 11px; color: #8f1f1f; margin-top: 5px;}

        /*----------------------------------------
        BUTTONS ROW
        flex-end pushes bottons to the RIGTH side
        -----------------------------------------*/
        .btn-row {
            display: flex;
            justify-content: flex-end; /*bttons on the right*/
            gap: 8px;
            margin-top: 8px;
            padding-top: 16px;
            border-top: 1px solid #e2e0d8;
        }
        .btn {
            padding: 9px 20px; border-raduis: 8px;
            font-size: 13px; font-weight: 500;
            font-family: 'segoe ui', sans-serif;
            cursor: pointer;
            border: 1px solid #e2e0d8;
            background: #ffffff; color: #1a1916;
            transition: background 0.12s;
        }
        .btn:hover {background: #f4f3ef; }

        /*Bleu submit button*/
        .btn-primary {
            background: #1a4fa0;
            color: #ffffff;
            border-color: #1a4fa0;
        }
        .btn-primary:hover {background: #153e80; border-color: #153e80; }

    </style>
</head>
<body>
    <div class="layout">
        <--======================================
        SIDEBAR
        ========================================-->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="app-name">University Portal</div>
                <div class="app-sub">PWEB 2025/2026</div>
            </div>
            <div class="nav">
                <div class="nav-label">Teacher</div>
                <!--active = currently ob this page-->
                <a href=../../controllers/AnnoncementController.php"
                class="nav-item active">
                📢 New announcement
                </a>
                <a href="../../controllers/AnnoncementListController.php" class="nav-item">
                     📋 All announcements
                </a>
            </div>
            <!-- Teacher name and initials at bottom of sidebar -->
            <div class="sidebar-user">
                <div class="avatar">
                    <?php
                    echo strtoupper(substr($_SESSION['name'] ?? 'US', 0, 2));
                    ?>
                </div>
                <div>
                    <div class="user-name">
                        <?php echo htmlspecialchars($_SESSION['name'] ?? 'Teacher'); ?>
                    </div>
                    <div class="user-role">Teacher</div>
                </div>
            </div>
        </div>
        <!--end sidebar-->
        <--======================================
        MAIN CONTENT
        ========================================-->
        <div class="main">
            <div class="topbar">
                <h1>New Announcement</h1>
                <p>Post a message to your students.</p>
            </div>
            <div class="content">

            <!----ALERT MESSAGES--->
            $success is set by the controller after a successful INSERT. Only shows if not empty. -->
            <?php if (!empty($success)): ?>
                <div class="alert-success">
                    ✅ <?php echo $success
                </div>
            <?php endif; ?>

            <!--ERROR ALERT-------------------
            $error is set by the controller when validation fails or the INSERT fails.
            <?php if (!empty(errors)): ?>
                <div class=alert alert-error">
                    ❌ <?php echo $error; ?>
                </div>
            <?php endif; ?>


            <div class="card">
            <div class="cars-title">📢 Annoncement Details</div>

            <!---ANNONCEMENT FORM--------------
            method="POST" -> data sent in request body
            action="" -> form submits to controller -->
            <form method="POST"
            action="../../controllers/AnnoncementController.php">
            <--!--ROW 1: MODULE + AUDIENCE-->
            <div class="form-row-2">
            <!--MODULE DROPDOWN
            $modules is set by the controller which called $annoncement->getModules() we loop through it to build <option> tags -->
            <div>
            <label for "module_id">
            Module <span clas="required">*</span>
            </label>
            <select 
            name="module_id" 
            id="module_id"
            class=<?php echo isset($errors['module-id']) ? 'input-error' : ''; ?>
            >
            <option value="">-Select a module-</option>
            <?php foreach ($modules as $module): ?>
                <option 
                value="<?php echo $module['id']; ?>"
                <?php echo (isset($module_id) && $module_id == $module['id']) ? 'selected' : ''; ?>
                >
                <?php echo htmlspecialchars($module['name']); ?>
                </option>
            <?php endforeach; ?>
            </select>
            <?php if (isset($errors['module_id'])): ?>
                <div class="field-err"><?php echo $errors['module_id']; ?></div>
            <?php endif; ?>
            </div>
            
            <--AUDIENCE DROPDOWN (static options) -->
            <div>
            <label for "audience">Audience</label>
            <select name="audience" id="audience">
            <option value="all">All enrolled students</option>
            <option value="group_1">Group 1</option>
            <option value="group_2">Group 2</option>
            option value="group_3">Group 3</option>
            option value="group_4">Group 4</option>
            </select>
            </div>
            </div>
            <!--end form row-2-->


            <!--TITLE INPUT-------------------
            name="title" -> $_POST['title'] in the controller
            value="..." -> keeps text after failed submit
            class="..." -> adds red border if error
            -->
            <div class="form-row">
            <label for="title">Title <span class="required">*</span></label>
            </label>
            <input
            type="text"
            name="title"
            id="title"
            placeholder="e.g. Mini-project deadline extends to April 5"
            value="<?php echo htmlspecialchars($title ?? ''); ?>"
            class="<?php echo isset($errors['title']) ? 'input-error' : ''; ?>"
            >
            <?php if (isset($errors['title'])): ?>
                <div class="field-err"><?php echo $errors['title']; ?></div>
            <?php endif; ?>
            </div>


            <!--BODY TEXTAREA-------------------
            <div class="form-row">
            <label for="body">
            Content <span class="required">*</span>
            </label>
            <textarea
            name="body"
            id="body"
            placeholder="Write the announcement message here..."
            class="<?php echo isset($errors['body']) ? 'input-error' : ''; ?>"
            ><?php echo htmlspecialchars($body ?? ''); ?></textarea>
            <?php if (isset($errors['body'])): ?>
                <div class="field-err"><?php echo $errors['body']; ?></div>
            <?php endif; ?>
            </div>


            <!--SUBMIT BUTTON-->
            type="reset" -> clears all fields (HTML build-in)
            type="submit" -> sends form to controller -->
            <div class="btn-row">
            <button type="reset" class="btn">Clear</button>
            button type="submit" class="btn btn-primary">Post Announcement</button>
            </div>

            </form>
            </div>
            </div>
            <!--end card-->

        </div>
        <!--end content-->

    </div>
    <!--end main-->

    </div>
    <!--end layout-->

</body>
</html>