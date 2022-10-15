
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="Login.css">
        <title>Logging In</title>
    </head>

    <body id="LoggingInPage">
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status" id="LoginSpinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </body>
</html>

<?php 
    session_start();
    include "dbConnect.php";
    
    //User Login
    if(isset($_POST['LoginSubmit'])){

        //If fields are not empty
        if(isset($_POST['uname']) && isset($_POST['psw']))
        {
            //Set variables
            $username = ($_POST['uname']);
            $password = ($_POST['psw']);
            
            $password = hash('sha256', $password); //Feels like hashing the password from the start is the best idea
            getUsername($username, $password, $dbc);
        }
        else{
            errorMessage("Index.php");
        }
    }

    //Admin Login
    if(isset($_POST['AdminLoginSubmit'])){

        //If fields are not empty
        if(isset($_POST['adminUname']) && isset($_POST['adminPsw']))
        {
            //Set variables
            $username = ($_POST['adminUname']);
            $password = ($_POST['adminPsw']);
            
            $password = hash('sha256', $password); //Feels like hashing the password from the start is the best idea
            getAdminUsername($username, $password, $dbc);
        }
        else{
            $_SESSION['loginstatus'] = "Incorrect username or password.";
             header("refresh:1;url=AdminLogin.php"); //Goes back to login page after x seconds
        }
    }

    //Checks if the user exists
    function getUsername($username, $password, $dbc){

        // Perform query to check if username exists
        if ($result = $dbc -> query("SELECT role_id, user_name, customer_id, user_id FROM user WHERE user_name='$username' AND user_password='$password'")) { 
         
            //If one result - user is defined.
            if($result -> num_rows == 1){
                $row = $result->fetch_assoc();

                $_SESSION['customerID'] = $row["customer_id"];
                $_SESSION['userID'] = $row["user_id"];
                $_SESSION['userName'] = $row["user_name"];

                getUserRole($row["role_id"], $dbc);  
            }
            else{
                errorMessage("Index.php"); 
            }
        }
        else{
            errorMessage("Index.php");
        }
    }

    //Checks if the user exists
    function getAdminUsername($username, $password, $dbc){

        // Perform query to check if username exists
        if ($result = $dbc -> query("SELECT admin_username, admin_password FROM admin WHERE admin_username='$username' AND admin_password='$password'")) { 
         
            //If one result - user is defined.
            if($result -> num_rows == 1){
                $row = $result->fetch_assoc();
                $_SESSION['userRole'] = "admin";
                header("refresh:1;url=AdminPortal.php");
            }
            else{
                errorMessage("AdminLogin.php"); 
            }
        }
        else{
            errorMessage("AdminLogin.php");
        }
    }

    //Finds the user role based on the user role ID
    function getUserRole($roleId, $dbc){
        
        if ($result = $dbc -> query("SELECT user_role_name FROM user_role WHERE user_role_id='$roleId'")) {
            $row = $result->fetch_assoc();

            $roleName = $row["user_role_name"];
            $_SESSION['userRole'] = $roleName;

            sendToPage($roleName);
        }
    }

    //Sends user to correct page/dashboard
    function sendToPage($roleName){
        switch($roleName){
            case "manager":
                header("refresh:1;url=../ManagerDashboard.php");
                break;
            case "auditor":
                header("refresh:1;url=../AuditorDashboard.php");
                break;
            default:
                header("refresh:1;url=Index.php");
                break;
        }
    }

    //Sends the login error message but also redirects the user
    function errorMessage($location){
        $_SESSION['loginstatus'] = "Incorrect username or password.";
        header("refresh:2;url=$location"); //Goes back to login page after x seconds
    }

    mysqli_close($dbc);
?>
