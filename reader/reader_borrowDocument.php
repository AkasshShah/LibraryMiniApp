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
                    $bor_docid = POST("bor_docid", $flag_empty, $flag_isset);
                    if(!$flag_isset || $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $bor_copyno = POST("bor_copyno", $flag_empty, $flag_isset);
                    if(!$flag_isset || $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                    $bor_libid = POST("bor_libid", $flag_empty, $flag_isset);
                    if(!$flag_isset || $flag_empty){
                        // header("Location: ../index.php?auth=1");
                        exit();
                    }
                ?>
                <?php
                    $readerID = $_SESSION["user"];
                    if(isCopyBorrowable($bor_docid, $bor_copyno, $bor_libid, $readerID)){
                        borrowCopy($bor_docid, $bor_copyno, $bor_libid, $readerID);
                        echo("<h3>The Document Copy Now Has Been Borrowed</h3>");
                    }
                    else{
                        echo("<h3>Cannot borrow the Document Copy is currently borrowed or reserved</h3>");
                    }
                ?>
            </div>
        </div>
        <?php
            mysqliCloseOOP($ms);
        ?>
    </body>
</html>