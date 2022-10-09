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
    
?>