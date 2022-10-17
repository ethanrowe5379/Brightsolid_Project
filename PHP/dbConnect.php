<?php
    //LOCAL
//     $dbc = mysqli_connect('localhost', 'root', '', 'jamiefergusdb');
//     // Check connection
//     if ($dbc -> connect_errno) {
//         echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
//         exit();
//     }

    //Zeno server
    $dbc = new mysqli(
        // Removed database connect detials for security concerns, add back in locally if you wish to test
        "", 
        "", //username
        "", //password
        "" //database name
    );

    if (!$dbc) {
        printf('Connect Error: ' . mysqli_connect_errno());
    }
?> 
