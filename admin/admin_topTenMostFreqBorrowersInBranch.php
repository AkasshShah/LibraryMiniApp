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
                <h2>Printing Top Ten Borrowers And The Top Ten Most Borrowed Books Of The Branch</h2>
                <?php
                    $branch_libID = POST("branch_libID", $flag_empty, $flag_isset);
                    if(!$flag_isset|| $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $query = "SELECT R.READERID, R.RNAME, (SELECT COUNT(*) FROM BORROWS AS B WHERE B.READERID = R.READERID AND B.LIBID = $branch_libID) AS CT FROM READER AS R GROUP BY R.READERID ORDER BY CT DESC, R.READERID ASC;";
                    $query2 = "SELECT R.DOCID, D.TITLE, (SELECT COUNT(*) FROM BORROWS AS B WHERE B.DOCID = R.DOCID AND B.LIBID = $branch_libID) AS CT FROM BOOK AS R, DOCUMENT AS D WHERE R.DOCID = D.DOCID GROUP BY R.DOCID ORDER BY CT DESC, R.DOCID ASC;";
                    $result = $ms->query($query);
                ?>
                <div class= "table">
                    <h3>Top 10 Borrowers</h3>
                    <table>
                        <tr>
                            <th>Reader ID</th>
                            <th>Reader Name</th>
                            <th>Number Of Documents Borrowed</th>
                        </tr>
                        <?php
                            $count = 0;
                            while($row = $result->fetch_assoc()){
                                echo("<tr>");
                                echo("<td>" . $row['READERID'] . "</td>");
                                echo("<td>" . $row['RNAME'] . "</td>");
                                echo("<td>" . $row['CT'] . "</td>");
                                echo("</tr>");
                                $count = $count + 1;
                                if($count >= 10){
                                    break;
                                }
                            }
                        ?>
                    </table>
                </div>
                <div class= "table">
                    <h3>Top 10 Borrowered Books</h3>
                    <table>
                        <tr>
                            <th>Document ID</th>
                            <th>Book Title</th>
                            <th>Number Of Times Borrowed</th>
                        </tr>
                        <?php
                            $result = $ms->query($query2);
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