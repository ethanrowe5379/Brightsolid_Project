<?php
    session_start();
    include "../connectDB.php";

    //If fields are not empty
    if(isset($_POST['suspendExceptionID']) && isset($_POST['suspendExceptionValue']) )
    {

        $exceptionValue = $_POST['suspendExceptionValue'];
        $exceptionID = $_POST['suspendExceptionID'];

        $lastUpdatedBy = $_SESSION['userID'];
        $customerID = $_SESSION['customerID'];


        $sqlQuery = "DELETE FROM exception WHERE exception_id = ". $exceptionID ." AND exception_value = '". $exceptionValue ."';";
        $result = mysqli_query($dbc, $sqlQuery);

        header("Location: ../ManagerDashboard.php");
    }
    else{
        header("Location: Index.php"); ////ADD redirect to respective page via switch
    }
    
?>