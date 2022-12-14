<?php 
    session_start();
    if (isset($_SESSION['userRole'])) {
      if($_SESSION['userRole'] != "admin") 
        header("Location: Index.php"); //Goes back to login page
    }
    else{
      header("Location: Index.php"); //Goes back to login page
    }
        
    include "dbConnect.php";

    //Checks if either the create customer or user form has been submitted
    if(isset($_POST['createCustomerConfirm']))
        checkCustomerForm($dbc);
    elseif (isset($_POST['createUserConfirm']))
        checkUserForm($dbc);
    else{
        errorMessage("Some fields are empty", $dbc);
    }

    //Form for creating customer
    function checkCustomerForm($dbc){
        if(isset($_POST['CustomerName'])){
                
            //Set variables
            $customername = ($_POST['CustomerName']);
            $canAdd = true;

            //Checks username availability
            if(!checkCustomerNameAvailability($customername, $dbc)){
                $canAdd = false;
                errorMessage("Customer already exists", $dbc);
            }
                
            if($canAdd)
                insertCustomer($customername, $dbc);
        }
    }

    //Form for creating user
    function checkUserForm($dbc){

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
            $password = hash('sha256', $password); 
            $passwordRepeated = hash('sha256', $passwordRepeated);
            
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

            //Checks customerID availability
            if(!checkCustomerIDAvailability($customerID, $dbc)){
                $canAdd = false;
                errorMessage("CustomerID not available", $dbc);
            }
                
            if($canAdd)
                insertUser($username, $customerID, $userRole, $password, $dbc);
        }
    }


    //Inserts new user data into database
    function insertUser($username, $customerID, $userRole, $password, $dbc){
            
        $lockTable = "LOCK TABLES user WRITE;";
        $unlockTables = "UNLOCK TABLES;";
        $userInsert = "INSERT INTO `user` (`user_id`,`user_name`,`customer_id`,`role_id`, `user_password`)
        VALUES(NULL,'$username', '$customerID', '$userRole' ,'$password');";
        
        try{
            mysqli_query($dbc, $lockTable);
            mysqli_query($dbc, $userInsert);
            mysqli_query($dbc, $unlockTables);

            errorMessage("User: " . $username . " has been added successfully.", $dbc);

        }catch(Exception $e){
            echo $e;
        }
    }

    //Inserts new customer into database
    function insertCustomer($customername, $dbc){
            
        $lockTable = "LOCK TABLES customer WRITE;";
        $unlockTables = "UNLOCK TABLES;";
        $customerInsert = "INSERT INTO `customer` (`customer_id`,`customer_name`)
        VALUES(NULL,'$customername');";
        
        try{
            mysqli_query($dbc, $lockTable);
            mysqli_query($dbc, $customerInsert);
            mysqli_query($dbc, $unlockTables);

            errorMessage("Customer: " . $customername . " has been added successfully.", $dbc);

        }catch(Exception $e){
            echo $e;
        }
    }

    //Checks if the the customer ID is available
    function checkCustomerIDAvailability($customerID, $dbc){
        //Connec to the db and check if any username matches input
        if($result = $dbc -> query("SELECT customer_id FROM customer WHERE customer_id='$customerID'")){
            if($result -> num_rows > 0)  //If role matches have been found
                return true;
            return false;
        }
        return false;
    }

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

    //Checks if customer_name already exists
    function checkCustomerNameAvailability($customername, $dbc){

        //Connec to the db and check if any username matches input
        if($result = $dbc -> query("SELECT customer_name FROM customer WHERE customer_name='$customername'")){
            if($result -> num_rows > 0)  //If username matches have been found
                return false;
            return true;
        }
        return false;
    }

    //Sends the login error message but also redirects the user
    function errorMessage($errorCode, $dbc){
        $_SESSION['loginstatus'] = $errorCode;
        header("Location: AdminPortal.php"); //Goes back to login page after x seconds

    }
    
    header("Location: AdminPortal.php"); //Goes back to login page after x seconds
    mysqli_close($dbc);
?>
