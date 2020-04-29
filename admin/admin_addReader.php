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
            // $flag_c=NULL;
            // connectDB($db, $flag_c);
            // if($flag_c){
            //     echo "Failed to connect to MySQL: ".mysqli_connect_error();
            //     exit();
            // }
            // mysqli_select_db($db, $project);

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
                <h2>New Reader</h2>
                <?php
                    $reader_type = POST("reader_type", $flag_empty, $flag_isset);
                    if(!$flag_isset|| $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $reader_name = POST("reader_name", $flag_empty, $flag_isset);
                    if(!$flag_isset|| $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $reader_address = POST("reader_address", $flag_empty, $flag_isset);
                    if(!$flag_isset|| $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $query = "INSERT INTO `as2757`.`READER` (`READERID`, `RTYPE`, `RNAME`, `ADDRESS`) VALUES (NULL, '$reader_type', '$reader_name', '$reader_address');";
                    $ms->query($query);
                    $reader_id = $ms->insert_id;
                ?>
                <div class= "table">
                    <h3>Inserted The Following Reader Information</h3>
                    <table>
                        <tr>
                            <th>Reader ID</th>
                            <th>Reader Type</th>
                            <th>Reader Name</th>
                            <th>Reader Address</th>
                        </tr>
                        <tr>
                            <td><?php echo($reader_id);?></td>
                            <td><?php echo($reader_type);?></td>
                            <td><?php echo($reader_name);?></td>
                            <td><?php echo($reader_address);?></td>
                        </tr>
                    </table>
                </div>
                <div class= "table">
                    <h3>Updated Reader Table:</h3>
                    <table>
                            <tr>
                                <th>Reader ID</th>
                                <th>Reader Type</th>
                                <th>Reader Name</th>
                                <th>Reader Address</th>
                            </tr>
                            <?php
                                $query = "SELECT * FROM `READER`;";
                                $result = $ms->query($query);
                                while($row = $result->fetch_assoc()){
                                    echo("<tr>");
                                    echo("<td>" . $row['READERID'] . "</td>");
                                    echo("<td>" . $row['RTYPE'] . "</td>");
                                    echo("<td>" . $row['RNAME'] . "</td>");
                                    echo("<td>" . $row['ADDRESS'] . "</td>");
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