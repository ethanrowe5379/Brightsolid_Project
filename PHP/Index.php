<!DOCTYPE html>
<?php session_start();?>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script type="text/javascript" src="MasterJS.js"></script>
    <link rel="stylesheet" href="Login.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brightsolid Login</title>

</head>

  <body>
    <content>

      <div class="text-center"> 
        <img src="Graphics\BrightSolidLogo.png" class="img-fluid" alt="Logo" id="BrightSolidLogo">
      </div> 
            
      <div id = "LoginForm">
        <form action="Login.php" method="post" autocomplete="off">
          <div class="container">
            <h1>Login</h1>
            <input type="text" placeholder="Enter Username" name="uname" required><br>
            <input type="password" placeholder="Enter Password" name="psw" required><br>
            <button class="btn btn-primary" type="submit" id="LoginSubmit">Login</button>
            <div>
              <p class="text-center" id="LoginStatus">
                <?php 
                  if (isset($_SESSION['loginstatus'])) {
                    $loginstatus = $_SESSION['loginstatus'];
                    echo $loginstatus;
                    unset($_SESSION['loginstatus']);
                  }
                ?>
              </p>
            </div>
          </div>
        </form>
      </div>
    </content>
  </body>
</html>