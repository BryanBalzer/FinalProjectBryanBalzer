<?php

    function deb($var_obj_arr, $exit=0)
    {
        echo "<br><br><pre>";
        print_r($var_obj_arr);
        echo "</pre><br><br>";
        
        if($exit==1)
            {exit(0); return;} # continues after echo
        else{return;}          # stops after echo
    }

     define('DB_DSN','mysql:host=localhost;dbname=serverside;charset=utf8');
     define('DB_USER','serveruser');
     define('DB_PASS','gorgonzola7!');     
     
     try {
         // Try creating new PDO connection to MySQL.
         $db = new PDO(DB_DSN, DB_USER, DB_PASS);
         //,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
     } catch (PDOException $e) {
         print "Error: " . $e->getMessage();
         die(); // Force execution to stop on errors.
         // When deploying to production you should handle this
         // situation more gracefully. ¯\_(ツ)_/¯
     }

    session_start();
 ?>