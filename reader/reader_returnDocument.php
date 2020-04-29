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
        ?>
        <div class = "logout">
                <a href="../logout.php">Logout</a>
        </div>
        <div class = "back">
                <a href="../back.php">Back</a>
        </div>
        <div class = "container">
            <div class = "main">
                <h2>Checking Copy Status</h2>
                <?php
                    $BORNUMBER = GET("BORNUMBER", $flag_empty, $flag_isset);
                    if(!$flag_isset || $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                ?>
                <?php
                    returnDocumentCopy($BORNUMBER);

                ?>
            </div>
        </div>
        <?php
            mysqliCloseOOP($ms);
            header("Location: ../back.php");
            exit();
        ?>
    </body>
</html>