<?php 
    session_start();
    if (isset($_SESSION['userRole'])) {
      if($_SESSION['userRole'] != "Admin") 
        header("Location: Index.php"); //Goes back to login page
    }
    else{
      header("Location: Index.php"); //Goes back to login page
    }
        
    include "dbConnect.php";
    
    /* WE CAN MAKE THE FIELD BORDERS RED TO INDICATE SHIT IS NOT MATCHING */

    //If fields are not empty
    if(isset($_POST['uname']) && isset($_POST['urole']) && isset($_POST['psw']) 
        && isset($_POST['repeatPsw']) && isset($_POST['customerID'])){


        //Set variables
        $username = ($_POST['uname']);
        $password = ($_POST['psw']);
        $passwordRepeated = ($_POST['repeatPsw']);
        $userRole = ($_POST['urole']);
        $customerID = ($_POST['customerID']);

        $canAdd = true;

        //Hashes the both passwords for storing and comparing.
        $password = hash('sha3-256', $password); 
        $passwordRepeated = hash('sha3-256', $passwordRepeated);
        
        //Checks if passwords match
        if(!checkPasswordMatch($password, $passwordRepeated)){
            $canAdd = false;
            errorMessage("Passwords not matching", $dbc);
        }
            
        //Checks username availability
        if(!checkUserNameAvailability($username, $dbc)){
            $canAdd = false;
            errorMessage("Username not available", $dbc);
        }
            
        //Checks username availability
        if(!checkRoleAvailability($userRole, $dbc)){
            $canAdd = false;
            errorMessage("Role not available", $dbc);
        }

        // //Checks username availability //ADD BACK IN WHEB DB IS COMPLETE!!! !IMPORTANT
        // if(!checkCustomerIDAvailability($customerID, $dbc))
        //     errorMessage("CustomerID not available");
            
        if($canAdd)
            insertUser($username, $customerID, $userRole, $password, $dbc);
    }
    else{
        errorMessage("Some fields are empty");
    }


    //Inserts new user data into database
    function insertUser($username, $customerID, $userRole, $password, $dbc){
            
        $lockTable = "LOCK TABLES user WRITE;";
        $unlockTables = "UNLOCK TABLES;";
        $test = "INSERT INTO `user` (`user_id`,`user_name`,`customer_id`,`role_id`, `user_password`)
        VALUES(NULL,'$username', 123, '$userRole' ,'$password');";
        
        try{
            mysqli_query($dbc, $lockTable);
            mysqli_query($dbc, $test);
            mysqli_query($dbc, $unlockTables);

            errorMessage("User: " . $username . " has been added successfully.", $dbc);

        }catch(Exception $e){
            echo $e;
        }
    }

    // //Checks if the the customer ID is available
    // function checkCustomerIDAvailability($customerID, $dbc){
    //     //Connec to the db and check if any username matches input
    //     if($result = $dbc -> query("SELECT customer_id FROM customer WHERE customer_id='$customerID'")){
    //         if($result -> num_rows > 0)  //If role matches have been found
    //             return true;
    //         return false;
    //     }
    //     return false;
    // }

    //Checks if the username is not already taken
    function checkRoleAvailability($roleID, $dbc){
        //Connec to the db and check if any username matches input
        if($result = $dbc -> query("SELECT user_role_id FROM user_role WHERE user_role_id='$roleID'")){
            if($result -> num_rows > 0)  //If role matches have been found
                return true;
            return false;
        }
        return false;
    }

    //Checks if the username is not already taken
    function checkUserNameAvailability($username, $dbc){

        //Connec to the db and check if any username matches input
        if($result = $dbc -> query("SELECT user_name FROM user WHERE user_name='$username'")){
            if($result -> num_rows > 0)  //If username matches have been found
                return false;
            return true;
        }
        return false;
    }

    //Checks if the two passwords match, if not return false, otherwise turns true
    function checkPasswordMatch($passwordOne, $passwordTwo){
        if($passwordOne != $passwordTwo)
            return false;
        return true;
    }

    //Sends the login error message but also redirects the user
    function errorMessage($errorCode, $dbc){
        $_SESSION['loginstatus'] = $errorCode;
        header("Location: AdminPortal.php"); //Goes back to login page after x seconds

    }
    
    header("Location: AdminPortal.php"); //Goes back to login page after x seconds
    mysqli_close($dbc);
?>
