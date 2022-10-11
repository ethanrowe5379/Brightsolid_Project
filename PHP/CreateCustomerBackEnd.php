<?php 
    session_start();
    // if (isset($_SESSION['userRole'])) {
    //   if($_SESSION['userRole'] != "admin") 
    //     header("Location: Index.php"); //Goes back to login page
    // }
    // else{
    //   header("Location: Index.php"); //Goes back to login page
    // }
        
    include "dbConnect.php";
    
    /* WE CAN MAKE THE FIELD BORDERS RED TO INDICATE SHIT IS NOT MATCHING */

    createCustomerSelected($dbc);

    /* ------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

    function createCustomerSelected($dbc){
        //If fields are not empty
        if(isset($_POST['CustomerName']) ){
            
            //Set variables
            $customername = ($_POST['CustomerName']);
            $canAdd = true;

            //Checks username availability
            if(!checkCustomerNameAvailability($customername, $dbc)){
                $canAdd = false;
                errorMessage("Customer already exists", $dbc);
            }
                
            if($canAdd)
                insertUser($customername, $dbc);

        }
        else{
            errorMessage("Some fields are empty");
        }
    }

    //Inserts new user data into database
    function insertCustomer($customername, $dbc){
            
        $lockTable = "LOCK TABLES user WRITE;";
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

    //Checks if the username is not already taken
    function checkCustomerNameAvailability($customername, $dbc){

        //Connec to the db and check if any username matches input
        if($result = $dbc -> query("SELECT customer_name FROM customer WHERE customer_name='$customername'")){
            if($result -> num_rows > 0)  //If username matches have been found
                return false;
            return true;
        }
        return false;
    }

/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

    //Sends the login error message but also redirects the user
    function errorMessage($errorCode, $dbc){
        $_SESSION['loginstatus'] = $errorCode;
        header("Location: AdminPortal.php"); //Goes back to login page after x seconds

    }
    
    header("Location: AdminPortal.php"); //Goes back to login page after x seconds
    mysqli_close($dbc);
?>