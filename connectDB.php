
<?php
      $db = new mysqli(
        "silva.computing.dundee.ac.uk",
        "jamiefergus", //username
        "AC32006", //password
        "jamiefergusdb" //database name
    );

  if (!$db) {
    printf('Connect Error: ' . mysqli_connect_errno());
  }
?> 
