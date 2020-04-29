<html>
    <head>
        <title>Library System</title>
        <link href="std/lib.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php
            require("std/FuncDefs.php");
            errorReporting();
            session_start();
            if(isAdminLoggedIn()){
                header("Location: admin/admin_submenu.php");
                exit();
            }
            if(isReaaderLoggedIn()){
                header("Location: reader/reader_submenu.php");
                exit();
            }
            $_SESSION['logged_in'] = FALSE;
        ?>
        <div class = "container">
            <div class = "main">
                <h2>Library System</h2>
                <form id = "reader_login" name = "reader_login" method = "post" action = "reader/reader_submenu.php">
                    <label>Card Number (Reader ID):</label>
                    <input type="text" name="reader_id" id="reader_id" required = "required">
                    <input type="submit" value = "Reader Login">
                </form>
                <form id = "admin_login" name = "admin_login" method="post" action = "admin/admin_submenu.php">
                    <label>Admin User:</label>
                    <input type="text" name="admin_user" id="admin_user" required = "required">
                    <label>Admin Pass:</label>
                    <input type="password" name="admin_pass" id="admin_pass" required = "required">
                    <input type="submit" value = "Admin Login">
                </form>
            </div>
        </div>
    </body>
</html>