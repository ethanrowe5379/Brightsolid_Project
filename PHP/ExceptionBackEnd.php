<?php 
    session_start();

    include "dbConnect.php";

    $customerID = "";
    $userID = "";
    $userName = "";
    
    //If fields are not empty
    if(isset($_POST['resourceID']) && isset($_POST['ruleID']) && isset($_POST['expValue']) 
        && isset($_POST['justValue']) && isset($_POST['rvwDate']) && isset($_POST['currentDate'])
        && isset($_SESSION['customerID']) && isset($_SESSION['userID']) && isset($_SESSION['userName']))
    {

        //Session variables
        $customerID =  $_SESSION['customerID'];
        $userID = $_SESSION['userID'];
        $userName = $_SESSION['userName'];

        //Set variables
        $resourceID = $_POST['resourceID'];
        $ruleID = $_POST['ruleID'];
        $expValue = $_POST['expValue'];
        $justValue = $_POST['justValue'];
        $rvwDate = $_POST['rvwDate'];
        $currentDate = $_POST['currentDate'];

        //Add expection
        insertException($customerID, $userID, $userName, $resourceID, $ruleID, $expValue, $justValue, $rvwDate, $currentDate, $dbc);

        //Delete from non_compliance table
        deleteNonCompliance($resourceID, $ruleID, $dbc);  
    }
    else{
        echo "Variables not set";
    }


    //Inserts new exception data into database
    function insertException($customerID, $userID, $userName, $resourceID, $ruleID, $expValue, $justValue, $rvwDate, $currentDate, $dbc){
            
        $lockTable = "LOCK TABLES exception WRITE;";
        $unlockTables = "UNLOCK TABLES;";

        // $userInsert = "INSERT INTO `user` (`user_id`,`user_name`,`customer_id`,`role_id`, `user_password`)
        // VALUES(NULL,'$username', '$customerID', '$userRole' ,'$password');";

        $userInsert = "INSERT INTO `exception` 
        (`exception_id`,`customer_id`,`rule_id`,`last_updated_by`, `exception_value`, `justification`, `review_date`, `last_updated`, `resource_id`)
        VALUES(NULL,'$customerID', '$ruleID', '$userID' ,'$expValue','$justValue','$rvwDate','$currentDate','$resourceID');";

        try{
            mysqli_query($dbc, $lockTable);
            mysqli_query($dbc, $userInsert);
            mysqli_query($dbc, $unlockTables);

            //errorMessage("User: " . $username . " has been added successfully.", $dbc);

        }catch(Exception $e){
            echo $e;
        }
    }

    //Deletes a record from the non compliance table
    function deleteNonCompliance($resourceID, $ruleID, $dbc){

        $lockTable = "LOCK TABLES non_compliance WRITE;";
        $unlockTables = "UNLOCK TABLES;";

        $deleteRecord = "DELETE FROM non_compliance WHERE resource_id='$resourceID' AND rule_id='$ruleID'";
       
        try{
            mysqli_query($dbc, $lockTable);
            mysqli_query($dbc, $deleteRecord);
            mysqli_query($dbc, $unlockTables);

        
        }catch(Exception $e){
            echo $e;
        }
    }





/* so what we want to do is get all that funky data and plop it into the table  */



















?>