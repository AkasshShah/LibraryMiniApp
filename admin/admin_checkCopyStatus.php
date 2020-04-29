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
        ?><div class = "logout">
                <a href="../logout.php">Logout</a>
        </div>
        <div class = "back">
                <a href="../back.php">Back</a>
        </div>
        <div class = "container">
            <div class = "main">
                <h2>Checking Copy Status</h2>
                <?php
                    $copy_docid = POST("copy_docid", $flag_empty, $flag_isset);
                    if(!$flag_isset|| $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $copy_copynumber = POST("copy_copynumber", $flag_empty, $flag_isset);
                    if(!$flag_isset|| $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $copy_libid = POST("copy_libid", $flag_empty, $flag_isset);
                    if(!$flag_isset|| $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                ?>
                <?php
                    $query = "SELECT * FROM `BORROWS` WHERE `DOCID`=$copy_docid AND `COPYNO`=$copy_copynumber AND `LIBID`=$copy_libid AND `RDTIME` IS NULL;";
                    $result = $ms->query($query);
                    if($result->num_rows <= 0){
                        echo("<div class='table'>");
                        echo("<h3>The Copy Is Currently In The Library</h3>");
                        $query = "SELECT * FROM `COPY` WHERE `DOCID`=$copy_docid AND `COPYNO`=$copy_copynumber AND `LIBID`=$copy_libid;";
                        $result = $ms->query($query);
                    ?>
                    <table>
                        <tr>
                            <th>Document ID</th>
                            <th>Copy Number</th>
                            <th>Library ID</th>
                            <th>Position</th>
                        </tr>
                    <?php
                        while($row = $result->fetch_assoc()){
                            echo("<tr>");
                            echo("<td>" . $row['DOCID'] . "</td>");
                            echo("<td>" . $row['COPYNO'] . "</td>");
                            echo("<td>" . $row['LIBID'] . "</td>");
                            echo("<td>" . $row['POSITION'] . "</td>");
                            echo("</tr>");
                        }
                        echo("</table>");
                        echo("</div>");
                        $query = "SELECT * FROM `RESERVES` WHERE `DOCID`=$copy_docid AND `COPYNO`=$copy_copynumber AND `LIBID`=$copy_libid;";
                        $result = $ms->query($query);
                        echo("<div class='table'>");
                        if($result->num_rows > 0){
                            echo("<h3>The Copy Is Also Currently Reserved</h3>");
                            echo("<table><tr>");
                            echo("<th>Reservation Number</th>");
                            echo("<th>Reader ID</th>");
                            echo("<th>Document ID</th>");
                            echo("<th>Copy Number</th>");
                            echo("<th>Library ID</th>");
                            echo("<th>Reservation DateTime</th>");
                            echo("</tr>");
                            while($row = $result->fetch_assoc()){
                                echo("<tr>");
                                echo("<td>" . $row['RESUMBER'] . "</td>");
                                echo("<td>" . $row['READERID'] . "</td>");
                                echo("<td>" . $row['DOCID'] . "</td>");
                                echo("<td>" . $row['COPYNO'] . "</td>");
                                echo("<td>" . $row['LIBID'] . "</td>");
                                echo("<td>" . $row['DTIME'] . "</td>");
                                echo("</tr>");
                            }
                            echo("</table>");
                        }
                        else{
                            echo("<h3>The Copy Is Also Not Currently Reserved</h3>");
                        }
                        echo("</div>");
                    }
                    else{
                ?>
                <div class= "table">
                    <h3>The Copy Is Currently Borrowed</h3>
                    <table>
                        <tr>
                            <th>Borrowing Number</th>
                            <th>Reader ID</th>
                            <th>Document ID</th>
                            <th>Copy Number</th>
                            <th>Library ID</th>
                            <th>Borrowed DateTime</th>
                        </tr>
                        <?php
                            while($row = $result->fetch_assoc()){
                                echo("<tr>");
                                echo("<td>" . $row['BORNUMBER'] . "</td>");
                                echo("<td>" . $row['READERID'] . "</td>");
                                echo("<td>" . $row['DOCID'] . "</td>");
                                echo("<td>" . $row['COPYNO'] . "</td>");
                                echo("<td>" . $row['LIBID'] . "</td>");
                                echo("<td>" . $row['BDTIME'] . "</td>");
                                echo("</tr>");
                            }
                        ?>
                    </table>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <?php
            mysqliCloseOOP($ms);
        ?>
    </body>
</html>