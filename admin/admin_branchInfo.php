<html>
    <head>
        <title>Library System</title>
        <link href="../std/lib.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php
            require("../std/FuncDefs.php");
            errorReporting();

            session_start();
            
            if(!isAdminLoggedIn()){
                header("Location: ../logout.php");
            }

            $ms = mysqliOOP();

            $flag_empty=TRUE;
            $flag_isset = FALSE;

        ?>
        <div class = "logout">
                <a href="../logout.php">Logout</a>
        </div>
        <div class = "back">
                <a href="../back.php">Back</a>
        </div>
        <div class = "container">
            <div class = "main">
                <h2>Printing Branch Information</h2>
                <?php
                    $branch_libID = POST("branch_libID", $flag_empty, $flag_isset);
                    if(!$flag_isset|| $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $query = "SELECT * FROM `BRANCH` WHERE LIBID = $branch_libID;";
                    $query2 = "SELECT * FROM `BRANCH`;";
                    $result = $ms->query($query);
                ?>
                <div class= "table">
                    <h3>Branch Information requested based on the LibID</h3>
                    <table>
                        <tr>
                            <th>Library ID</th>
                            <th>Library Name</th>
                            <th>Library Location</th>
                        </tr>
                        <?php
                            while($row = $result->fetch_assoc()){
                                echo("<tr>");
                                echo("<td>" . $row['LIBID'] . "</td>");
                                echo("<td>" . $row['LNAME'] . "</td>");
                                echo("<td>" . $row['LLOCATION'] . "</td>");
                                echo("</tr>");
                            }
                        ?>
                    </table>
                </div>
                <div class= "table">
                    <h3>Full Branch Table</h3>
                    <table>
                        <tr>
                            <th>Library ID</th>
                            <th>Library Name</th>
                            <th>Library Location</th>
                        </tr>
                        <?php
                            $result = $ms->query($query2);
                            while($row = $result->fetch_assoc()){
                                echo("<tr>");
                                echo("<td>" . $row['LIBID'] . "</td>");
                                echo("<td>" . $row['LNAME'] . "</td>");
                                echo("<td>" . $row['LLOCATION'] . "</td>");
                                echo("</tr>");
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <?php
            mysqliCloseOOP($ms);
        ?>
    </body>
</html>