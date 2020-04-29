<html>
    <head>
        <title>Library System</title>
        <link href="../std/lib.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php
            include("../std/FuncDefs.php");
            errorReporting();
            session_start();
            $flag_c=NULL;
            connectDB($db, $flag_c);
            if($flag_c){
                echo "Failed to connect to MySQL: ".mysqli_connect_error();
                exit();
            }
            mysqli_select_db($db, $project);
            $flag_empty=TRUE;
            $flag_isset = FALSE;

            $admin_user = POST("admin_user", $flag_empty, $flag_isset);
            if($flag_isset && !$flag_empty){
                if(isset($_POST["admin_pass"]) && strcmp(trim($_POST["admin_pass"]), "") != 0){
                    $admin_pass = $_POST["admin_pass"];
                    if(authenticate($admin_user, $admin_pass)){
                        $_SESSION["logged_in"] = TRUE;
                        $_SESSION["user_type"] = "admin";
                        $_SESSION["user"] = $admin_user;
                    }
                }
            }
            if(!isAdminLoggedIn()){
                header("Location: ../logout.php");
                exit();
            }
        ?>
        <div class = "logout">
                <a href="../logout.php">Logout</a>
        </div>
        <div class = "container">
            <div class = "main">
                <h2>Library System</h2>
                <h3>Admin Submenu</h3>
                <form id= "admin_addNewReader" name= "admin_addNewReader" method= "post" action= "admin_addReader.php">
                    <h3>Add New Reader</h3>
                    <label>Reader Type (example: 'aggressive'):</label>
                    <input type="text" name="reader_type" id="reader_type" required = "required" maxlength= "25">
                    <label>Reader Name:</label>
                    <input type="text" name="reader_name" id="reader_name" required = "required" maxlength= "25">
                    <label>Reader Address:</label>
                    <input type="text" name="reader_address" id="reader_address" required = "required" maxlength= "50">
                    <input type="submit" value="Generate Reader ID">
                </form>
                <form id= "admin_addDocCopy" name= "admin_addDocCopy" method= "post" action= "admin_addDocCopy.php">
                    <h3>Add New Document Copy</h3>
                    <label>Document ID:</label>
                    <input type="number" name="copy_docid" id="copy_docid" required = "required" min = "1" step= "1">
                    <label>Copy Number:</label>
                    <input type="number" name="copy_copynumber" id="copy_copynumber" required = "required" min = "1" step= "1">
                    <label>Library ID:</label>
                    <input type="number" name="copy_libid" id="copy_libid" required = "required" min = "1" step= "1">
                    <label>Position:</label>
                    <input type="text" name="copy_position" id="copy_position" required = "required" maxlength= "25">
                    <input type="submit" value="Add Copy">
                </form>
                <form id= "admin_checkCopyStatus" name= "admin_checkCopyStatus" method= "post" action= "admin_checkCopyStatus.php">
                    <h3>Check Status Of A Document Copy In A Library</h3>
                    <label>Document ID:</label>
                    <input type="number" name="copy_docid" id="copy_docid" required = "required" min = "1" step= "1">
                    <label>Copy Number:</label>
                    <input type="number" name="copy_copynumber" id="copy_copynumber" required = "required" min = "1" step= "1">
                    <label>Library ID:</label>
                    <input type="number" name="copy_libid" id="copy_libid" required = "required" min = "1" step= "1">
                    <input type="submit" value="Check Status">
                </form>
                <form id= "admin_branchInfo" name= "admin_branchInfo" method= "post" action= "admin_branchInfo.php">
                    <h3>Check Status Of A Document Copy In A Library</h3>
                    <label>Library ID:</label>
                    <input type="number" name="branch_libID" id="branch_libID" required = "required" min = "1" step= "1">
                    <input type="submit" value="Print Branch Information">
                </form>
                <form id= "admin_topTenMostFreqBorrowersInBranch" name= "admin_topTenMostFreqBorrowersInBranch" method= "post" action= "admin_topTenMostFreqBorrowersInBranch.php">
                    <h3>Top Ten Most Frequent Borrowers And Top Ten Most Borrowed Books In Branch</h3>
                    <label>Library ID:</label>
                    <input type="number" name="branch_libID" id="branch_libID" required = "required" min = "1" step= "1">
                    <input type="submit" value="Process">
                </form>
                <div class="table">
                    <?php
                        $br = "SELECT * FROM `BORROWS` WHERE `RDTIME` IS NOT NULL;";
                        $numReaders = "SELECT * FROM READER;";
                        $ms = mysqliOOP();
                        $fineSum = 0.0;
                        $maxBorrowLimitDays = 20;
                        $br_res = $ms->query($br);
                        if($br_res->num_rows > 0){
                            while($row = $br_res->fetch_assoc()){
                                $borrow = $row["BDTIME"];
                                $return = $row["RDTIME"];
                                $fineSum += computeFine($borrow, $return);
                            }
                        }
                        $r_res = $ms->query($numReaders);
                        $avg = $fineSum / $r_res->num_rows;
                    ?>
                    <h2>The Average Fine for a reader is: $<?php echo(round($avg, 2));?></h2>
                    <h3>The fine calculation method is: $0.20 per day after <?php echo($maxBorrowLimitDays);?> days of borrowing</h3>
                </div>
                <div class = "table">
                    <h3>Top 10 Borrowed Books This Year</h3>
                    <table>
                        <tr>
                            <th>Document ID</th>
                            <th>Book Title</th>
                            <th>Number Of Times Borrowed</th>
                        </tr>
                        <?php
                            $yr = date("Y");
                            $query = "SELECT R.DOCID, D.TITLE, (SELECT COUNT(*) FROM BORROWS AS B WHERE B.DOCID = R.DOCID AND YEAR(B.BDTIME) = '$yr') AS CT FROM BOOK AS R, DOCUMENT AS D WHERE R.DOCID = D.DOCID GROUP BY R.DOCID ORDER BY CT DESC, R.DOCID ASC;";
                            $result = $ms->query($query);
                            $count = 0;
                            while($row = $result->fetch_assoc()){
                                echo("<tr>");
                                echo("<td>" . $row['DOCID'] . "</td>");
                                echo("<td>" . $row['TITLE'] . "</td>");
                                echo("<td>" . $row['CT'] . "</td>");
                                echo("</tr>");
                                $count = $count + 1;
                                if($count >= 10){
                                    break;
                                }
                            }
                            mysqliCloseOOP($ms);
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>