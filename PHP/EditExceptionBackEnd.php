<?php
    session_start();
    include "dbConnect.php";

    $oldJustificationValue = "";
    $oldExceptionValue = "";
    $oldReviewDate = "";
    $ruleID = "";
    
    $lastUpdated = getCurrentTime(date("Y-m-d H:i:s.v"));

    //If fields are not empty
    if(isset($_POST['updateExceptionID']) && isset($_POST['updateJustValue']) && isset($_POST['updateExpValue']) 
        && isset($_POST['updateRvwDate']) && isset($_SESSION['customerID']) && isset($_SESSION['userID']) && isset($_SESSION['userName']))
    {

        $newJustificationValue = $_POST['updateJustValue'];
        $newExceptionValue = $_POST['updateExpValue'];
        $newReviewDate = $_POST['updateRvwDate'];
        $exceptionID = $_POST['updateExceptionID'];

        $lastUpdatedBy = $_SESSION['userID'];
        $customerID = $_SESSION['customerID'];


        $sqlQuery = "SELECT justification, exception_value, review_date, rule_id FROM exception WHERE exception_id='$exceptionID'";
        $result = mysqli_query($dbc, $sqlQuery);

        //Finds and assigns the latest exception id
        if($result){
          if($result -> num_rows == 1){
            $row = $result->fetch_assoc();
            
            $ruleID = $row["rule_id"];
            $oldJustificationValue = $row["justification"];
            $oldExceptionValue = $row["exception_value"];
            $oldReviewDate = $row["review_date"];
          }
        }

        //Formatting the dates
        $oldReviewDateFormatting = date('Y-m-d H:i:s.v', strtotime($oldReviewDate));
        $oldReviewDate = getCurrentTime($oldReviewDateFormatting);

        $newReviewDateFormatting = date('Y-m-d H:i:s.v', strtotime($newReviewDate));
        $newReviewDate = getCurrentTime($newReviewDateFormatting);


        alterException($exceptionID, $lastUpdatedBy, $newJustificationValue, $newExceptionValue, $newReviewDate, $lastUpdated, $dbc);
        addExceptionAudit($exceptionID, $lastUpdatedBy, $customerID, $ruleID, $lastUpdated, $oldExceptionValue, $newExceptionValue, $oldJustificationValue, $newJustificationValue, $oldReviewDate, $newReviewDate, $dbc);
        header("Location: ../ManagerDashboard.php");
    }

    //Updates the expcetion table
    function alterException($exceptionID, $lastUpdatedBy, $newJustificationValue, $newExceptionValue, $newReviewDate, $lastUpdated, $dbc){

        $lockTable = "LOCK TABLES exception WRITE;";
        $unlockTables = "UNLOCK TABLES;";

        $sqlUpdateQuery = "UPDATE exception
            SET last_updated_by = '$lastUpdatedBy', justification = '$newJustificationValue', exception_value = '$newExceptionValue', review_date = '$newReviewDate', last_updated = '$lastUpdated'
            WHERE exception_id = '$exceptionID';";
        try{
            mysqli_query($dbc, $lockTable);
            mysqli_query($dbc, $sqlUpdateQuery);
            mysqli_query($dbc, $unlockTables);

        }catch(Exception $e){
            echo $e;
        }
    }


    //Creates a nwe entry to the exception audit
    function addExceptionAudit($exceptionID, $userID, $customerID, $ruleID, $lastUpdated, $oldExceptionValue, $newExceptionValue, $oldJustificationValue, $newJustificationValue, $oldReviewDate, $newReviewDate, $dbc){

        //Locks and unlocks tavles
        $lockTable = "LOCK TABLES exception_audit WRITE;";
        $unlockTables = "UNLOCK TABLES;";

        //Adds to audit table ---CHANGE IT TO REVIEW_DATE WHEN THE DB IS FIXED
        $userInsert = "INSERT INTO `exception_audit` 
        (`exception_audit_id`,`exception_id`,`user_id`,`customer_id`, `rule_id`, `action`, `action_dt`, `old_exception_value`, `new_exception_value`, `old_justification`, `new_justification`, `old_review_date`, `new_review_date`)
        VALUES(NULL, '$exceptionID', '$userID', '$customerID',' $ruleID', 'update', '$lastUpdated', '$oldExceptionValue', '$newExceptionValue', '$oldJustificationValue', '$newJustificationValue', '$oldReviewDate', '$newReviewDate');";

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
?>