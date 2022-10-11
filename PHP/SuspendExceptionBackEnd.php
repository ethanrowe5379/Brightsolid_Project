<?php
    session_start();
    include "dbConnect.php";

    //If fields are not empty
    if(isset($_POST['suspendExceptionID']) && isset($_POST['suspendExceptionValue']) )
    {

        $exceptionValue = $_POST['suspendExceptionValue'];
        $exceptionID = $_POST['suspendExceptionID'];

        $lastUpdatedBy = $_SESSION['userID'];
        $customerID = $_SESSION['customerID'];

        $lastUpdated = getCurrentTime(date("Y-m-d H:i:s.v"));
        suspendExceptionAudit($exceptionID, $lastUpdatedBy, $customerID, $exceptionValue, $dbc);

        $disableForeignKeyCheck = "SET FOREIGN_KEY_CHECKS=0;";
        $enableForeignKeyCheck = "SET FOREIGN_KEY_CHECKS=1;";
        
        $sqlQuery = "DELETE FROM exception WHERE exception_id = ". $exceptionID ." AND exception_value = '". $exceptionValue ."';";
    
        mysqli_query($dbc, $disableForeignKeyCheck);
        $result = mysqli_query($dbc, $sqlQuery);
        mysqli_query($dbc, $enableForeignKeyCheck);

        header("Location: ../ManagerDashboard.php");
    }
    else{
        header("Location: ../ManagerDashboard.php"); ////ADD redirect to respective page via switch
    }

    //Creates a nwe entry to the exception audit
    function suspendExceptionAudit($exceptionID, $userID, $customerID, $exceptionValue, $dbc){

        $justification = "";
        $review_date = "";
        $ruleID = "";
        $lastUpdated = getCurrentTime(date("Y-m-d H:i:s.v"));
        $resourceID = "";

        $exceptionValues = "SELECT resource_id, justification, review_date, rule_id FROM exception WHERE exception_id='$exceptionID'";
        try{
            $suspendAduit = mysqli_query($dbc, $exceptionValues);
            if($suspendAduit -> num_rows == 1){

                $row = $suspendAduit->fetch_assoc();

                $justification = $row['justification'];
                $review_date = $row['review_date'];
                $ruleID = $row['rule_id'];
                $resourceID = $row['resource_id'];
            }

        }catch(Exception $e){
            echo $e;
        }

        
        //Locks and unlocks tavles
        $lockTable = "LOCK TABLES exception_audit WRITE;";
        $unlockTables = "UNLOCK TABLES;";

        //Adds to audit table ---CHANGE IT TO REVIEW_DATE WHEN THE DB IS FIXED
        $userInsert = "INSERT INTO `exception_audit` 
        (`exception_audit_id`,`exception_id`,`user_id`,`customer_id`, `rule_id`, `action`, `action_dt`, `old_exception_value`, `new_exception_value`, `old_justification`, `new_justification`, `old_review_date`, `new_review_date`, `resource_id`)
        VALUES(NULL, '$exceptionID', '$userID', '$customerID',' $ruleID', 'suspend', '$lastUpdated', '$exceptionValue', '$exceptionValue', '$justification', '$justification', '$review_date', '$review_date', $resourceID);";

        try{
            mysqli_query($dbc, $lockTable);
            mysqli_query($dbc, $userInsert);
            mysqli_query($dbc, $unlockTables);
        }catch(Exception $e){
            echo $e;
        }
    }

    //Sets if the current time is in BST or GMT
    function getCurrentTime($dateToFormat){

        //To check if in BST or GMT was taken from Stack Overflow https://stackoverflow.com/questions/29123753/detect-bst-in-php
        $dateTest = strtotime($dateToFormat); 
        if (date('I', $dateTest)) {
            $dateToFormat = $dateToFormat . " +0100";
        } else {
            $dateToFormat = $dateToFormat . " +0000";
        }
        return $dateToFormat;
    }
    
    $dbc->close();
?>