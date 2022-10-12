<!DOCTYPE html>
<?php 

  session_start();

    if (isset($_SESSION['userRole'])) {
    if($_SESSION['userRole'] != "admin") 
        header("Location: AdminLogin.php"); //Goes back to login page
    }
    else{
    header("Location: AdminLogin.php"); //Goes back to login page
    }

    include "dbConnect.php";

    //If log out button is pressed
    if(isset($_POST['LogOut'])){
        if (isset($_SESSION['userRole'])) 
        session_destroy();
        header("Refresh:0");
    }

?>

<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="Login.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brightsolid Admin Portal</title>

</head>

  <body>
    <content class="AdminPortal">

        <div class="text-center"> 
            <img src="Graphics\BrightSolidLogo.png" class="img-fluid" alt="Logo" id="BrightSolidLogo">
            <h1>Admin Portal</h1>
        </div> 

        <div class="container">
            <div class="row" id="adminButtons">
                <div class="col text-center">
                    <?php 
                        createUserButton();
                    ?>
                </div>
            </div>

            <div class="row" id="adminButtons">
                <div class="col text-center">
                    <?php 
                        createCustomerButton();
                    ?>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div>
                        <form action="AdminPortal.php" method="post">
                            <button class="btn btn-primary" type="submit" name="LogOut" id="PortalBtn">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
    </content>
  </body>

  <p class="text-center" id="LoginStatus">
    <?php 
        if (isset($_SESSION['loginstatus'])) {
            $loginstatus = $_SESSION['loginstatus'];
            echo $loginstatus;
            unset($_SESSION['loginstatus']);
        }
        ?>
    </p>

</html>


<?php
        
    //The modal form for creating a new customer
    function createCustomerButton(){

        echo'
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal-Customer" id="PortalBtn">Create Customer</button>

            <div class="modal fade" id="Modal-Customer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Customer Creation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div id="CreateUser">
                            <form action="AdminBackEnd.php" method="post" autocomplete="off"> 
                                <div class="container">
                                    <h1>Create Customer</h1>

                                    <input type="text" placeholder="Enter Customer Name" name="CustomerName" required><br>
                                    <button class="btn btn-primary" type="submit" id="createCustomerConfirm" name="createCustomerConfirm">Create</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        '; 

       
    }

    //The modal form for creating a new user
    function createUserButton(){
        echo'
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal-User" id="PortalBtn">Create User</button>

            <div class="modal fade" id="Modal-User" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                        <div class="modal-header">
                            <h1 class="modal-title fs-5">User Creation</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div id="CreateUser">
                                <form action="AdminBackEnd.php" method="post" autocomplete="off"> 
                                    <div class="container">
                                        <h1>Create User</h1>

                                        <input type="text" placeholder="Enter Username" name="uname" required><br>
                                        <input type="number" min="1" placeholder="Enter CustomerID" name="customerID" required><br>
                                        <input type="number" min="1" placeholder="Enter user role" name="urole" required><br>
                                        <input type="password" placeholder="Enter Password" name="psw" required><br>
                                        <input type="password" placeholder="Repeat Password" name="repeatPsw" required><br>
                                        <button class="btn btn-primary" type="submit" id="LoginSubmit" name="createUserConfirm">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        '; 
    }
  $dbc -> close();
?>