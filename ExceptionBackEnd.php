<?php 
    session_start();

    include "dbConnect.php";

    $customerID = "";
    $userID = "";
    $userName = "";

    $ruleID = "";
    $expValue = "";
    $justValue = "";
    $rvwDate = "";
    $currentDate = "";

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
        addExceptionAudit($customerID, $userID, $userName, $resourceID, $ruleID, $expValue, $justValue, $rvwDate, $currentDate, $dbc);
        //Delete from non_compliance table
        //deleteNonCompliance($resourceID, $ruleID, $dbc);  
    }
    

    //Inserts new exception data into database
    function insertException($customerID, $userID, $userName, $resourceID, $ruleID, $expValue, $justValue, $rvwDate, $currentDate, $dbc){
            
        $lockTable = "LOCK TABLES exception WRITE;";
        $unlockTables = "UNLOCK TABLES;";

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

    //Creates a nwe entry to the exception audit
    function addExceptionAudit($customerID, $userID, $userName, $resourceID, $ruleID, $expValue, $justValue, $rvwDate, $currentDate, $dbc){

        $exceptionID = "";
        $findLatest = "SELECT MAX(exception_id) AS expMax FROM exception";
        $result = mysqli_query($dbc, $findLatest);

        //Finds and assigns the latest exception id
        if($result){
          if($result -> num_rows == 1){
            $row = $result->fetch_assoc();
            $exceptionID = $row["expMax"];
          }
        }

        //Locks and unlocks tavles
        $lockTable = "LOCK TABLES exception_audit WRITE;";
        $unlockTables = "UNLOCK TABLES;";

        //Adds to audit table ---CHANGE IT TO REVIEW_DATE WHEN THE DB IS FIXED
        $userInsert = "INSERT INTO `exception_audit` 
        (`exception_audit_id`,`exception_id`,`user_id`,`customer_id`, `rule_id`, `action`, `action_dt`, `old_exception_value`, `new_exception_value`, `old_justification`, `new_justification`, `old_review_time`, `new_review_time`)
        VALUES(NULL, '$exceptionID', '$userID', '$customerID',' $ruleID', 'create', '$currentDate', '$expValue', '$expValue', '$justValue', '$justValue', '$rvwDate', '$rvwDate');";

        try{
            mysqli_query($dbc, $lockTable);
            mysqli_query($dbc, $userInsert);
            mysqli_query($dbc, $unlockTables);
        }catch(Exception $e){
            echo $e;
        }
    }
?>