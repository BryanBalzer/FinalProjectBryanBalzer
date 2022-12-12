<?php
    session_start();

    if($_SESSION['loggedin'] == 1)
    {
        session_destroy();
    }

    header("Location: index.php");
?>