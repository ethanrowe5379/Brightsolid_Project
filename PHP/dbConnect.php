<?php
    $dbc = mysqli_connect('localhost', 'root', '', 'appusers');
    // Check connection
    if ($dbc -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
?> 