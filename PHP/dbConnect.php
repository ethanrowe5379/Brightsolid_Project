<?php
    //LOCAL
    // $dbc = mysqli_connect('localhost', 'root', '', 'brightsoliddb');
    // // Check connection
    // if ($dbc -> connect_errno) {
    //     echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    //     exit();
    // }

    //Zeno server
    $dbc = new mysqli(
        "silva.computing.dundee.ac.uk",
        "jamiefergus", //username
        "AC32006", //password
        "brightsoliddb" //database name
    );

    if (!$dbc) {
        printf('Connect Error: ' . mysqli_connect_errno());
    }
?> 