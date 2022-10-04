
<?php
      $db = new mysqli(
        "localhost",
        "root", //username
        "password", //password
        "brightsolidproject" //database name
    );

  if (!$db) {
    printf('Connect Error: ' . mysqli_connect_errno());
  }
?> 
