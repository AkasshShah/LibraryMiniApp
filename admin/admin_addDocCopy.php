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
                <h2>Add A New Document Copy</h2>
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
                    $copy_position = POST("copy_position", $flag_empty, $flag_isset);
                    if(!$flag_isset|| $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $query = "INSERT INTO `as2757`.`COPY` (`DOCID`, `COPYNO`, `LIBID`, `POSITION`) VALUES ('$copy_docid', '$copy_copynumber', '$copy_libid', '$copy_position');";
                    $ms->query($query);
                    // $reader_id = $ms->insert_id;
                ?>
                <div class= "table">
                    <h3>Inserted The Following Document Copy Information</h3>
                    <table>
                        <tr>
                            <th>Document ID</th>
                            <th>Copy Number</th>
                            <th>Library ID</th>
                            <th>Position</th>
                        </tr>
                        <tr>
                            <td><?php echo($copy_docid);?></td>
                            <td><?php echo($copy_copynumber);?></td>
                            <td><?php echo($copy_libid);?></td>
                            <td><?php echo($copy_position);?></td>
                        </tr>
                    </table>
                </div>
                <div class= "table">
                    <h3>Update Document Copy</h3>
                    <table>
                        <tr>
                            <th>Document ID</th>
                            <th>Copy Number</th>
                            <th>Library ID</th>
                            <th>Position</th>
                        </tr>
                        <?php
                            $query = "SELECT * FROM `COPY`;";
                            $result = $ms->query($query);
                            while($row = $result->fetch_assoc()){
                                echo("<tr>");
                                echo("<td>" . $row['DOCID'] . "</td>");
                                echo("<td>" . $row['COPYNO'] . "</td>");
                                echo("<td>" . $row['LIBID'] . "</td>");
                                echo("<td>" . $row['POSITION'] . "</td>");
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