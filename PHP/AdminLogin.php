<!DOCTYPE html>
<?php 

  session_start();
  session_unset();
 
?>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Login.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

</head>

  <body>
    <content>

      <div class="text-center"> 
        <img src="Graphics\BrightSolidLogo.png" class="img-fluid" alt="BrightSolid" id="BrightSolidLogo">
      </div> 

      <div class="container">
        <div class="row">
            <div class="col text-center">
                <div>
                    <h1>Admin Login</h1>
                </div>
            </div>
        </div>
        
    <div id = "AdminLoginForm">
        <form action="Login.php" method="post" autocomplete="off">
            <div class="container">

            <input type="text" placeholder="Enter Username" name="adminUname" required><br>
            <input type="password" placeholder="Enter Password" name="adminPsw" required><br>
            <button class="btn btn-primary" type="submit" id="LoginSubmit" name="AdminLoginSubmit">Login</button>
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