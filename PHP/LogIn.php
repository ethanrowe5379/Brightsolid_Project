<?php 

session_start();

?>
<?php 
    include "dbConnect.php";
    
    //If fields are not empty
    if(isset($_POST['uname']) && $_POST['psw'])
    {
        //Set variables
        $username = ($_POST['uname']);
        $password = ($_POST['psw']);
        
        $password = hash('sha3-256', $password); //Feels like hashing the password from the start is the best idea
        getUsername($username, $password, $dbc);
    }
    else{
        errorMessage();
    }

    //Checks if the user exists
    function getUsername($username, $password, $dbc){

        // Perform query to check if username exists
        if ($result = $dbc -> query("SELECT role_id, user_name FROM user WHERE user_name='$username' AND user_password='$password'")) { 
         
            //If one result - user is defined.
            if($result -> num_rows == 1){
                $row = $result->fetch_assoc();
                getUserRole($row["role_id"], $dbc);
            }
            else{
                errorMessage();
            }
        }
        else{
            errorMessage();
        }
    }

    //Finds the user role based on the user role ID
    function getUserRole($roleId, $dbc){
        
        if ($result = $dbc -> query("SELECT user_role_name FROM user_role WHERE user_role_id='$roleId'")) {
            $row = $result->fetch_assoc();

            $roleName = $row["user_role_name"];
            
            if($roleName == "Manager"){
                echo "Logged in as: Manager"; //FOR TESTING
                //header("refresh:3;url=Index.php"); //Goes to Manager Dashboard
            }
            else if($roleName == "Auditor"){
                echo "Logged in as: Auditor"; //FOR TESTING
                  //header("refresh:3;url=Index.php"); //Goes to Auditor dashboard
            }
        }
    }

    //Sends the login error message but also redirects the user
    function errorMessage(){
        $_SESSION['loginstatus'] = "Incorrect username or password.";
        header("refresh:2;url=Index.php"); //Goes back to login page after x seconds
    }

    mysqli_close($dbc);
?>

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
