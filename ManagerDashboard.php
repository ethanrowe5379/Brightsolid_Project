<?php 

  session_start();

  //If log out button is pressed
  if(isset($_POST['LogOut'])){
    if (isset($_SESSION['userRole'])) 
    session_destroy();
    header("Refresh:0");
  }

  //Only correct user trying to enter this page (MGHT WANT TO PUT THE WHOLE PAGE IN THIS PHP STATMENT)
  if (isset($_SESSION['userRole'])) {

    //Have a switch to redirect to appropriate PAGE /////////////////////////////////////////////////////////////////////
    if($_SESSION['userRole'] != "manager") 
      header("Location: PHP/Index.php"); //Goes back to login page
  }
  else{
    header("Location: PHP/Index.php"); //Goes back to login page
  }
?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manager Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="DashboardTemplate.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.js" integrity="sha256-OtJalIqkbNqfzhs9j53+lSD/iazR2WN1sQL5iaJIjw0=" crossorigin="anonymous"></script>
  <script>
  var ruleArray = [];
  var rulePercentage = [];
</script>
</head>

<body>
  <?php
    include "PHP/dbConnect.php";
  ?>

    <header>
      <nav class="navbar .navbar-expand">  <!--add to close to disable hamburger on desktop navbar-expand-lg -->
        <div class="container-fluid">
          <img src="PHP/Graphics\BrightSolidLogo.png" alt="BrightSolidLogo" width="200" height="40" class="d-inline-block align-text-top">

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav"></ul>

            <div class="navbar-text">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <?php echo"<p>Username: ".$_SESSION['userName']."</p>" ?>
                </li>
                <li class="nav-item">
                  <?php echo"<p>Role: ".$_SESSION['userRole']."</p>" ?>
                </li>
                <li class="nav-item">
                  <form action="AuditorDashboard.php" method="post">
                    <button class="btn btn-primary" type="submit" name="LogOut">Log Out</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
  </header>

  <main>
    <div class="container">
      <h1>Compliance Dashboard</h1>
      <div class="graph" style="width:40%;">
          <canvas id="PieChart"></canvas>
        </div>
        <div class="graph" style="width:40%;">
          <canvas id="BarChart"></canvas>
        </div>
      <?php  

        $overallTotalResources = 0;
        $overallTotalCompliant = 0;

        $accountToBeFound = $_SESSION["customerID"];
        //$accountToBeFound = 1; // DELETE THIS AFTER TESTING///////////////////////////////////////////////////////////
        $findAccount = "SELECT account_id FROM account WHERE customer_id='$accountToBeFound';";
        $resultAccounts = $dbc->query($findAccount);

        $foundAccountID = 0;

        if($resultAccounts -> num_rows == 1){
          $accountRow = $resultAccounts->fetch_assoc();
          $foundAccountID = $accountRow["account_id"];

          reviewDatePassed($dbc, $foundAccountID);
      ?>
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Rule Name</th>
              <th scope="col">Rule Description</th>
              <th scope="col">Compliance Status</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
              tbodyInsert($dbc, $foundAccountID, $overallTotalResources, $overallTotalCompliant);
            ?>
          </tbody>
        </table>
      <?php 
        }
        else{
          echo '<h6 class="noResourceHeading">There are accounts for this customer: '.$foundAccountID.'</h6>';
        } 
      ?>


    </div >
  </main>
  <footer>

  </footer>
  <?php
    $dbc->close();
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
<link rel="stylesheet" href="DashboardTemplate.css">
</html>

<?php

  //Inserts all the items into the table
  function tbodyInsert($dbc, $foundAccountID, &$overallTotalResources, &$overallTotalCompliant) {

    //Selects all the rules in the table ----- Might want to make this only show rules which have resources
    $sql = "SELECT rule_id, rule_name, rule_description, resource_type_id FROM rule 
    ORDER BY rule_id ASC;";

    $result = $dbc->query($sql);
    
    if ($result->num_rows == 0) {
      echo ("No Rules Compliant");
    } else {
      while ($row = $result->fetch_assoc()) {
        echo '
        <tr>
          <th>'. $row['rule_id'] .'</th>
          <td>'. $row['rule_name'] .'</td>
          <td>'. $row['rule_description'] .'</td>';

          ?>

          <script>
            ruleArray.push("<?php echo $row['rule_name']; ?>")
            console.log(ruleArray);
          </script>

          <?php

          $sqlCountNon_compliance = "SELECT COUNT(resource.resource_id) AS 'count' FROM resource
          JOIN rule
          ON resource.resource_type_id = rule.resource_type_id
          LEFT JOIN exception
          ON rule.rule_id = exception.rule_id AND resource.resource_id = exception.resource_id
          LEFT JOIN non_compliance
          ON resource.resource_id = non_compliance.resource_id AND rule.rule_id = non_compliance.rule_id
          WHERE rule.rule_id = " . $row['rule_id'] . " AND resource.account_id = '$foundAccountID' AND resource.resource_id = non_compliance.resource_id;
          ";
  
          // $sqlCountNon_compliance = "SELECT COUNT(rule_id) AS 'count'
          // FROM non_compliance
          // WHERE non_compliance.rule_id = " . $row['rule_id'] . ";";
          
          $sqlCountExceptions = "SELECT COUNT(rule_id) AS 'count'
          FROM exception
          JOIN resource
          ON resource.resource_id = exception.resource_id
          WHERE exception.rule_id = ". $row['rule_id']." AND resource.account_id = '$foundAccountID';"; 
          //Will need to count exceptions where the resource
          
          $sqlCountResources = "SELECT COUNT(resource.resource_id) AS 'count' 
          FROM resource
          JOIN rule
          ON resource.resource_type_id = rule.resource_type_id
          WHERE resource.account_id = '$foundAccountID' AND rule.rule_id = " . $row['rule_id'] . ";";  //Can do the account in here
  
  
          $resultCountNon_compliance = $dbc->query($sqlCountNon_compliance);
          $resultCountExceptions = $dbc->query($sqlCountExceptions);
          $resultCountResources = $dbc->query($sqlCountResources);
  
  
          $dataCountNon_compliance = $resultCountNon_compliance->fetch_assoc();
          $dataCountExceptions = $resultCountExceptions->fetch_assoc();
          $dataCountResources = $resultCountResources->fetch_assoc();
  
  
          $totalResources = $dataCountResources['count'];
          $totalNon_compliant = $dataCountNon_compliance['count'] - $dataCountExceptions['count'];
          
          $totalcompliant = $totalResources - $totalNon_compliant;
          
          $overallTotalResources += $totalNon_compliant;
          $overallTotalCompliant += $totalcompliant;

          $compliantStatus = 0;
  
          if($totalcompliant < 1){
            $totalcompliant = 0;
          }
          else{
            $compliantStatus = ($totalcompliant/$totalResources)*100;
            ?>
              <script>
                rulePercentage.push(<?php echo $compliantStatus ?>)
                console.log(rulePercentage);
              </script>
            <?php
          }
          
  
          echo'
          <td>'. $totalcompliant .' / '. $totalResources .'</td>
          <!--<td>'. $compliantStatus .'</td>-->
          
          <td> 
          
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom_'. $row['rule_id'] .'" aria-controls="offcanvasBottom_'. $row['rule_id'] .'">Detailed Report</button>
            
            <div class="h-100 offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom_'. $row['rule_id'] .'" aria-labelledbcy="offcanvasBottom_'. $row['rule_id'] .'_Label">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottom_'. $row['rule_id'] .'_Label">Detailed Report for rule '. $row['rule_id'] .' : '. $row['rule_name'] .'</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body small">
              <div class="accordion" id="accordion_'. $row['rule_id'] .'">
              ';
                resourceTableInsert($dbc, $row, $foundAccountID);
                exceptionTableInsert($dbc, $row, $foundAccountID);
                echo'  
                </div>
              </div>
            </div>
          </td>
        </tr>
        ';
      }
    }
  }

  //Creates the resource table to be shown
  function resourceTableInsert($dbc, $row, $foundAccountID){
    echo'
    <div class="accordion-item">
      <h2 class="accordion-header" id="resourceHeading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseResources_'. $row['rule_id'] .'" aria-expanded="false" aria-controls="collapseResources_'. $row['rule_id'] .'">
          View Resources
        </button>
      </h2>
      <div id="collapseResources_'. $row['rule_id'] .'" class="accordion-collapse collapse" aria-labelledbcy="resourceHeading" data-bs-parent="#accordion_'. $row['rule_id'] .'">
        <div class="accordion-body">
        ';

      
        $sqlResources = "SELECT rule.rule_id, rule.rule_name, resource.resource_id, resource.account_id, resource.resource_name, non_compliance.rule_id AS 'noncompliant', exception.rule_id AS 'exception' FROM resource
                        JOIN rule
                        ON resource.resource_type_id = rule.resource_type_id
                        LEFT JOIN exception
                        ON rule.rule_id = exception.rule_id AND resource.resource_id = exception.resource_id
                        LEFT JOIN non_compliance
                        ON resource.resource_id = non_compliance.resource_id AND rule.rule_id = non_compliance.rule_id
                        WHERE rule.rule_id = " . $row['rule_id'] . " AND resource.account_id = '$foundAccountID';";

        $resultResources = $dbc->query($sqlResources);

        if($resultResources -> num_rows < 1){
          echo '<h6 class="noResourceHeading">There are no resources for rule '. $row['rule_id'] .'</h6>';
        }
        else{
          $resourceTableID = "resourceTable_". $row['rule_id'];
          echo'
            <table class="table table-detailed-view" id="'. $resourceTableID .'">
              <thead class="table-dark">
                <tr>
                  <th scope="col" onclick="sortTable(0, '; echo "'$resourceTableID'"; echo')">Resource ID</th>
                  <th scope="col" onclick="sortTable(1, '; echo "'$resourceTableID'"; echo')">Resource Name</th>
                  <th scope="col" onclick="sortTable(2, '; echo "'$resourceTableID'"; echo')">Compliance Status</th>
                  <th scope="col" onclick="sortTable(3, '; echo "'$resourceTableID'"; echo')">Exception</th>
                  <th scope="col">Audit</th>
                </tr>
              </thead>
              <tbody>
              ';
                while ($rowResources = $resultResources->fetch_assoc()) {
                  echo '<tr>';
                    echo '<th scope="row">'. $rowResources['resource_id']  . '</th>';
                    echo '<td>'. $rowResources['resource_name'] . '</td>';
                    
                    echo '<td>';
                    if($rowResources['noncompliant'] == NULL or $rowResources['exception'] != NULL){
                      echo 'Compliant';
                    }else{
                      echo 'Non-Compliant';
                    }
                    echo '</td>';

                    echo '<td>';
                    if($rowResources['exception'] != NULL){
                      echo 'Yes';
                    }
                    ////////////////////////////////
                    createExceptionButton($dbc, $rowResources);

                    echo '</td><td>';
                      $currentRuleID = $rowResources['rule_id']; $currentRuleResourceID = $rowResources['resource_id'];
                      viewResourceAudit($dbc, $currentRuleID, $currentRuleResourceID, $foundAccountID);
                    echo "</td>";
                  echo '</tr>';
                }
              echo'  
              </tbody>
            </table>
            ';
          }
        echo'
        </div>
      </div>
    </div>
    ';

  }

  //Inserts all the items into the exception table
  function exceptionTableInsert($dbc, $row, $foundAccountID){
    echo'
    <div class="accordion-item">
      <h2 class="accordion-header" id="exceptionHeading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExceptions_'. $row['rule_id'] .'" aria-expanded="false" aria-controls="collapseExceptions_'. $row['rule_id'] .'">
          View Exceptions
        </button>
      </h2>
      <div id="collapseExceptions_'. $row['rule_id'] .'" class="accordion-collapse collapse" aria-labelledbcy="exceptionHeading">
        <div class="accordion-body">
          ';
        
          $sqlExceptions = "SELECT exception.exception_id, exception.resource_id, exception.justification, exception.review_date, exception.last_updated, exception.resource_id, user.user_name, resource.resource_id, resource.account_id
                            FROM exception
                            LEFT JOIN user
                            ON exception.last_updated_by = user.user_id
                            JOIN resource
                            ON resource.resource_id = exception.resource_id
                            WHERE exception.rule_id = " . $row['rule_id'] . " AND resource.account_id='$foundAccountID';";

          $resultExceptions = $dbc->query($sqlExceptions);
              
          if($resultExceptions -> num_rows < 1){
            echo '<h6 class="noExceptionHeading">There are no exceptions for rule '. $row['rule_id'] .'</h6>';
          }
          else{
            $exceptionTableID = "exceptionTable_". $row['rule_id'];
            echo '
            <table class="table table-detailed-view" id="'. $exceptionTableID .'">
              <thead class="table-dark">
                <tr>
                  <th scope="col" onclick="sortTable(0, '; echo "'$exceptionTableID'"; echo')">Resource ID</th>
                  <th scope="col" onclick="sortTable(1, '; echo "'$exceptionTableID'"; echo')">Justification</th>
                  <th scope="col" onclick="sortTable(2, '; echo "'$exceptionTableID'"; echo')">Review Date</th>
                  <th scope="col" onclick="sortTable(3, '; echo "'$exceptionTableID'"; echo')">Last Updated By</th>
                  <th scope="col">Edit</th>
                  <th scope="col">Suspend</th>
                </tr>
              </thead>
              <tbody>
                ';
                
                while ($rowExceptions = $resultExceptions->fetch_assoc()) {

                  $currentResourceID = $rowExceptions['resource_id'];
                  $currentExceptionID = $rowExceptions['exception_id'];

                  echo '<tr>';
                    echo '<th scope="row">'. $rowExceptions['resource_id']  . '</th>';
                    echo '<td>'. $rowExceptions['justification'] . '</td>';
                    echo '<td>'. $rowExceptions['review_date'] . '</td>';
                    echo '<td>'. $rowExceptions['user_name'] . '</td>';
                    
                    
                    echo editExceptionButton($dbc, $currentResourceID, $currentExceptionID);
                    echo suspendExceptionButton($dbc, $currentExceptionID);
                  echo '</tr>';
                }
                
              
              echo'
            </tbody>
          </table>
          ';
          }
          echo '
        </div>
      </div>
    </div>
    ';
  }


  //Deals with creating the exception button to add new exceptions
  function createExceptionButton($dbc, $rowResources){

    $currentResourceID = $rowResources["resource_id"];
    $currentResourceName = $rowResources["resource_name"];

    if($rowResources['noncompliant'] != NULL && $rowResources['exception'] == NULL){
      echo'
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal'. $currentResourceID . '">Create</button>

        <div class="modal fade" id="Modal'. $currentResourceID . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <h1 class="modal-title fs-5">Exception Creation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

                  <div class="modal-body">

                    <div id="CreateException">
                      <form action="PHP/ExceptionBackEnd.php" method="post" autocomplete="off"> 
                        <div class="container">
                            <h1>Create Exception</h1>

                            <input type="number" min="1" placeholder="Enter Resource ID" value=' . $currentResourceID .' name="resourceID" readonly><br>
                            <input type="number" min="1" placeholder="Enter Rule ID" value=' . $rowResources["rule_id"] .' name="ruleID" readonly><br>
                            <input type="text" placeholder="Enter Exception Value" value="' . $currentResourceName .'" name="expValue" readonly><br>
                            <input type="text" placeholder="Enter Justification" name="justValue" required><br>
                            <input type="datetime-local" id ="reviewDate'.$currentResourceID.'" name="rvwDate" required><br>

      ';                
      echo '
                            <script>
                              var thisTime = new Date().toISOString().slice(0, -8); //The current time (min)
                              var reviewDate = document.getElementById("reviewDate'. $currentResourceID . '");
                          
                              reviewDate.min = thisTime;
                            </script>

                            <!-- WE ALREADY HAVE CUSTOMER ID AND USER name but to make it better we will need to get it from Jaime and DJ -->
                            <button class="btn btn-primary" type="submit" id="createExceptionConfirm">Create Exception</button>

                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      ';
    }
  }


  function editExceptionButton($dbc, $currentResourceID, $currentExceptionID){
    echo '

      <td>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditModal' . $currentExceptionID . '">Update</button>

        <div class="modal fade" id="EditModal' . $currentExceptionID . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Exception Editor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <div id="CreateException">
                  <form action="PHP/EditExceptionBackEnd.php" method="post" autocomplete="off"> 
                    <div class="container">
    ';
                            
                      $sqlQuery = "SELECT justification, exception_value, review_date FROM exception WHERE exception_id='$currentExceptionID'";

                      $justificationValue = "";
                      $exceptionValue = "";
                      $reviewDateValue = "";

                      
                      $EditResult = mysqli_query($dbc, $sqlQuery);

                      //Finds and assigns the latest exception id
                      if($EditResult){
                        if($EditResult -> num_rows == 1){
                          $row = $EditResult->fetch_assoc();
                          
                          $justificationValue = $row["justification"];
                          $exceptionValue = $row["exception_value"];
                          $reviewDateValue = $row["review_date"];
                        }
                      }
      echo'
                              
                        <label for="updateExceptionID" class="form-label">Exception ID</label>
                        <input type="text" placeholder="Exception ID" name="updateExceptionID" id="updateExceptionID" value="'. $currentExceptionID .'" required readonly><br>

                        <label for="updateJustValue" class="form-label">Justification</label>
                        <input type="text" value="'.$justificationValue.'" name="updateJustValue" id="updateJustValue" required><br>
                        
                        <label for="updateExpValue" class="form-label">Exception Value</label>
                        <input type="text" value="'.$exceptionValue.'" name="updateExpValue"  id="updateExpValue" required><br>
                        
                        <label for="updateRvwDate" class="form-label">Review Date</label>
                        <input type="datetime-local" name="updateRvwDate" id="updateRvwDate'.$currentResourceID.'" required><br>

                        <script>
                          var thisTime = new Date().toISOString().slice(0, -8) //The current time (min)
                          
                          var reviewDate = document.getElementById("updateRvwDate'.$currentResourceID.'");
                          reviewDate.min = thisTime;
                        </script>

                        <button class="btn btn-primary" type="submit" id="createExceptionConfirm">Update Exception</button>

                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </td>
      ';
  }

  function suspendExceptionButton($dbc, $currentExceptionID){
    echo '
    <td>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#SuspendModal' . $currentExceptionID . '">Suspend</button>

        <div class="modal fade" id="SuspendModal' . $currentExceptionID . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Suspend Exception Warning!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <div id="CreateException">
                  <form action="PHP/SuspendExceptionBackEnd.php" method="post" autocomplete="off"> 
                    <div class="container">
    ';
                            
                      $sqlQuery = "SELECT exception_id, exception_value FROM exception WHERE exception_id='$currentExceptionID'";

                      $EditResult = mysqli_query($dbc, $sqlQuery);

                      //Finds and assigns the latest exception id
                      if($EditResult){
                        if($EditResult -> num_rows == 1){
                          $row = $EditResult->fetch_assoc();
                          
                          $exceptionID = $row["exception_id"];
                          $exceptionValue = $row["exception_value"];
                        }
                      }
      echo'
                        <p>You are about to suspend an exception!</p>
                        <p>The details of the exception you are about to suspend are below:</p>

                        <label for="suspendExceptionID" class="form-label">Exception ID</label>
                        <input type="text" placeholder="Exception ID" name="suspendExceptionID" id="suspendExceptionID" value="'. $currentExceptionID .'" required readonly><br>

                        <label for="suspendExceptionValue" class="form-label">Exception Value</label>
                        <input type="text" name="suspendExceptionValue" id="suspendExceptionValue'. $exceptionValue.'" value="'. $exceptionValue .'"required readonly><br>

                        <p>To continue, press the button below</p>

                        <button class="btn btn-primary" type="submit" id="suspendExceptionConfirm">Suspend Exception</button>

                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </td>              
      ';
  }

  /* We will need the expcetion ID*/
  function viewResourceAudit($dbc, $currentRuleID, $currentResourceID, $foundAccountID){

    $lookForThis = "";
    if ($result = $dbc -> query("SELECT resource_name FROM resource WHERE resource_id ='$currentResourceID'")){
      if($result -> num_rows == 1){
        $row = $result->fetch_assoc();
        $lookForThis = $row['resource_name'];
      }
    }


    $sqlQuery = 
    "SELECT exception_id, action, action_dt, old_review_date, exception_id FROM exception_audit
    JOIN rule
    ON rule.rule_id = exception_audit.rule_id
    JOIN resource
    on resource.resource_type_id = rule.resource_type_id
    WHERE rule.rule_id = " . $currentRuleID . " AND resource.account_id = '$foundAccountID' AND exception_audit.old_exception_value = '$lookForThis' 
    AND resource.resource_id = $currentResourceID;
    ";

    $auditResult = mysqli_query($dbc, $sqlQuery);

    echo'
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AuditModal'.$currentResourceID. $currentRuleID .'">View</button>
        <div class="modal fade" id="AuditModal'.$currentResourceID. $currentRuleID .'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <h1 class="modal-title fs-5">Exception Audit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
          ';
              if($auditResult){
                if($auditResult -> num_rows > 0){

                  echo'
                      
                      <div class="container-flex">
                        <table class="table table-bordered table-detailed-view">
                        <thead class="table-dark">
                          <tr>
                            <th scope="col">Exception ID</th>
                            <th scope="col">Action</th>
                            <th scope="col">Action Date</th>
                            <th scope="col">Old Review Date</th>
                          </tr>
                        </thead>
                        <tbody>
                  ';
                          while ($rowExceptions = $auditResult->fetch_assoc()) {
                            echo '<tr>';
                              echo '<th scope="row">'. $rowExceptions['exception_id']  . '</th>';
                              echo '<th>'. $rowExceptions['action']  . '</th>';
                              echo '<td>'. $rowExceptions['action_dt'] . '</td>';
                              echo '<td>'. $rowExceptions['old_review_date'] . '</td>';
                            echo '</tr>';
                          }
                    echo'
                        </tbody>
                        </table>
                      </div>
                    ';
                }
                else{
                  echo '<h6 class="noResourceHeading">There are audits for this resource: '.$currentResourceID.'</h6>';
                }
        echo'
            </div>
          </div>
        </div>';         
    }
  }


  //Checks if the exception review date is in the past or not
  function reviewDatePassed($dbc, $foundAccountID){

    //Query to find expcetions which belong to this user's customers
    $sqlQuery = "SELECT exception_id, review_date 
    FROM exception
    JOIN resource
    ON resource.resource_id = exception.resource_id
    WHERE resource.account_id = '$foundAccountID'";

    $reviewQuery = mysqli_query($dbc, $sqlQuery);

    //If records have been found 
    if($reviewQuery){
      if($reviewQuery -> num_rows > 0){
        while ($rowExceptions = $reviewQuery->fetch_assoc()) {

          $reviewDate = $rowExceptions['review_date'];
          $exceptionID = $rowExceptions['exception_id'];
          
          //Subtracts the BST VS GMT difference at the end of string
          if (strpos($reviewDate, '+0000')) {
            $reviewDate = trim($reviewDate, "+0000");
            $currentTime = date('Y-m-d H:i:s');
          }
          else{
            $reviewDate = trim($reviewDate, "+0100");
            $currentTime = date('Y-m-d H:i:s', strtotime('-1 hours'));
          }
            
          //Suspends the over due review
          if(strtotime($reviewDate) <= strtotime($currentTime)) {
            suspendReviewException($dbc, $exceptionID);
          }
        }
      }
    }
  }


  //Suspends the exceptions
  function suspendReviewException($dbc, $exceptionID){

    $lastUpdatedBy = $_SESSION['userID'];
    $customerID = $_SESSION['customerID'];

    $disableForeignKeyCheck = "SET FOREIGN_KEY_CHECKS=0;";
    $enableForeignKeyCheck = "SET FOREIGN_KEY_CHECKS=1;";

    suspendExceptionAudit($exceptionID, $lastUpdatedBy, $customerID, $dbc);

    $sqlQuery = "DELETE FROM exception WHERE exception_id ='$exceptionID';";

    mysqli_query($dbc, $disableForeignKeyCheck);
    $result = mysqli_query($dbc, $sqlQuery);
    mysqli_query($dbc, $enableForeignKeyCheck);

    header("Refresh:0");
  }


    //Creates a nwe entry to the exception audit
    function suspendExceptionAudit($exceptionID, $userID, $customerID, $dbc){

      $justification = "";
      $review_date = "";
      $ruleID = "";
      $exceptionValue = "";
      $lastUpdated = getCurrentTime(date("Y-m-d H:i:s.v"));

      $exceptionValues = "SELECT justification, review_date, exception_value, rule_id FROM exception WHERE exception_id='$exceptionID'";
      try{
          $suspendAduit = mysqli_query($dbc, $exceptionValues);
          if($suspendAduit -> num_rows == 1){

              $row = $suspendAduit->fetch_assoc();

              $exceptionValue = $row['exception_value'];
              $justification = $row['justification'];
              $review_date = $row['review_date'];
              $ruleID = $row['rule_id'];
          }

      }catch(Exception $e){
          echo $e;
      }

      
      //Locks and unlocks tavles
      $lockTable = "LOCK TABLES exception_audit WRITE;";
      $unlockTables = "UNLOCK TABLES;";

      //Adds to audit table ---CHANGE IT TO REVIEW_DATE WHEN THE DB IS FIXED
      $userInsert = "INSERT INTO `exception_audit` 
      (`exception_audit_id`,`exception_id`,`user_id`,`customer_id`, `rule_id`, `action`, `action_dt`, `old_exception_value`, `new_exception_value`, `old_justification`, `new_justification`, `old_review_date`, `new_review_date`)
      VALUES(NULL, '$exceptionID', '$userID', '$customerID',' $ruleID', 'suspend', '$lastUpdated', '$exceptionValue', '$exceptionValue', '$justification', '$justification', '$review_date', '$review_date');";

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

<script>
const ctx1 = document.getElementById('PieChart');
const PieChart = new Chart(ctx1, {
    type: 'doughnut',
    data: {
        labels: ['Compliant', 'Non-Compliant'],
        datasets: [{
            <?php echo ("data: [" . $overallTotalCompliant . ", " . $overallTotalResources . "],"); ?>
            backgroundColor: [
                'rgba(0, 255, 0, 0.2)rgba(255, 0, 0, 0.5)',
                'rgba(255, 0, 0, 0.5)'
            ],
            borderWidth: 1
        }]
    },
    options: {
    }
});

</script>
<script>
const ctx2 = document.getElementById('BarChart');
const BarChart = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ruleArray,
        datasets: [{
            label: 'Compliance Percentage',
            data: rulePercentage,
            backgroundColor: [
                'rgba(255, 213, 70, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
    indexAxis: 'y',
  }
});
</script>

<script>
function sortTable(col, tableID) {
  var table = document.getElementById(tableID);
  var direction = "asc";
  var switching = true;
  var count = 0;
  while (switching) {
    switching = false;
    var rows = table.rows;
    for (var i = 1; i < (rows.length - 1); i++) {
      var shouldSwitch = false;
      var row_1 = rows[i].getElementsByTagName("td")[col];
      var row_2 = rows[i + 1].getElementsByTagName("td")[col];
      if (direction == "asc") {
        if (row_1.innerHTML.toLowerCase() > row_2.innerHTML.toLowerCase()) {
          shouldSwitch= true;
          break;
        }
      } else if (direction == "desc") {
        if (row_1.innerHTML.toLowerCase() < row_2.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      count ++;      
    } else {
      if (direction == "asc" && count == 0) {
        direction = "desc";
        switching = true;
      }
    }
  }
}
</script>