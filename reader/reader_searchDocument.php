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
            
            if(!isReaaderLoggedIn()){
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
                    $srchCrit = POST("srchCrit", $flag_empty, $flag_isset);
                    if(!$flag_isset || $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $fn = POST("fn", $flag_empty, $flag_isset);
                    if(!$flag_isset || $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                ?>
                <?php
                    $query = "";
                    if($srchCrit == "DOCID"){
                        $query= "SELECT D.DOCID, D.TITLE, P.PUBNAME FROM DOCUMENT AS D, PUBLISHER AS P WHERE D.DOCID = $fn AND P.PUBLISHERID = D.PUBLISHERID;";
                    }
                    else if($srchCrit == "TITLE"){
                        $query = "SELECT D.DOCID, D.TITLE, P.PUBNAME FROM DOCUMENT AS D, PUBLISHER AS P WHERE (CONVERT(D.TITLE USING utf8) LIKE '%$fn%') AND P.PUBLISHERID = D.PUBLISHERID;";
                    }
                    else{
                        $query = "SELECT D.DOCID, D.TITLE, P.PUBNAME FROM DOCUMENT AS D, PUBLISHER AS P WHERE (CONVERT(P.PUBNAME USING utf8) LIKE '%$fn%') AND P.PUBLISHERID = D.PUBLISHERID;";
                    }
                    $result = $ms->query($query);
                    if($result->num_rows > 0){ ?>
                        <div class = "table">
                            <table>
                                <tr>
                                    <th>Document ID</th>
                                    <th>Document Title</th>
                                    <th>Publisher Name</th>
                                </tr>
                                <?php
                                    while($row = $result->fetch_assoc()){
                                        echo("<tr>");
                                        echo("<td>" . $row['DOCID'] . "</td>");
                                        echo("<td>" . $row['TITLE'] . "</td>");
                                        echo("<td>" . $row['PUBNAME'] . "</td>");
                                        echo("</tr>");
                                    }
                                ?>
                            </table>
                        </div>
                <?php 
                    }
                    else{
                        echo("<h3>No Results Found</h3>");
                    }
                ?>
            </div>
        </div>
        <?php
            mysqliCloseOOP($ms);
        ?>
    </body>
</html>