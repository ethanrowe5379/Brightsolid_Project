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
    if($_SESSION['userRole'] != "auditor") 
      header("Location: PHP/Index.php"); //Goes back to login page
  }
  else{
    header("Location: PHP/Index.php"); //Goes back to login page
  }

  include "PHP/dbConnect.php";

?>

<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditor Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="DashboardTemplate.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.js" integrity="sha256-OtJalIqkbNqfzhs9j53+lSD/iazR2WN1sQL5iaJIjw0=" crossorigin="anonymous"></script>
    <script>
  var ruleArray = [];
  var rulePercentage = [];
</script>
  </head>

  <body>
    
  <header>
    <nav class="navbar fixed-top">  <!--add to close to disable hamburger on desktop navbar-expand-lg -->
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
        ?>
    
          <table class="table table-striped table-bordered table-hover" id="ruleTable">
            <thead class="table-dark">
              <tr>
                <th class="table-sort" scope="col" onclick="sortTable(0, 'ruleTable')">ID</th>
                <th class="table-sort" scope="col" onclick="sortTable(1, 'ruleTable')">Rule Name</th>
                <th class="table-rule-desc" scope="col">Rule Description</th>
                <th scope="col">Compliance Status</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php tbodyInsert($dbc, $foundAccountID, $overallTotalResources, $overallTotalCompliant); ?>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
  <link rel="stylesheet" href="DashboardTemplate.css">
</html>

<?php


  $dbc->close();
  
  function tbodyInsert($dbc, $foundAccountID, &$overallTotalResources, &$overallTotalCompliant) {
    $sql = "SELECT rule_id, rule_name, rule_description, resource_type_id FROM rule 
    ORDER BY rule_id ASC;";

    $result = $dbc->query($sql);


    if ($result->num_rows == 0) {
      echo ("No Rules Compliant");
    } else {
      while ($row = $result->fetch_assoc()) {
        echo '
        <tr>
          <td><strong>'. $row['rule_id'] .'</strong></td>
          <td>'. $row['rule_name'] .'</td>
          <td class="table-rule-desc">'. $row['rule_description'] .'</td>';

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
          $totalExceptions = $dataCountExceptions['count'];
          
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
          <td><strong>'. $totalcompliant .'</strong> / <strong>'. $totalResources .'</strong> compliant with <strong>'. $totalExceptions .'</strong> exceptions</td>
          <!--<td>'. $compliantStatus .'</td>-->
          
          <td> 
          
            <button class="table-btn btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom_'. $row['rule_id'] .'" aria-controls="offcanvasBottom_'. $row['rule_id'] .'">Detailed Report</button>
            
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
                  <th class="table-sort" scope="col" onclick="sortTable(0, '; echo "'$resourceTableID'"; echo')">Resource ID</th>
                  <th class="table-sort" scope="col" onclick="sortTable(1, '; echo "'$resourceTableID'"; echo')">Resource Name</th>
                  <th class="table-sort" scope="col" onclick="sortTable(2, '; echo "'$resourceTableID'"; echo')">Compliance Status</th>
                  <th class="table-sort" scope="col" onclick="sortTable(3, '; echo "'$resourceTableID'"; echo')">Exception</th>
                </tr>
              </thead>
              <tbody>
              ';
                while ($rowResources = $resultResources->fetch_assoc()) {
                  echo '<tr>';
                    echo '<td scope="row"><strong>'. $rowResources['resource_id']  .'</strong></td>';
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
                    echo '</td>';


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
                  <th class="table-sort" scope="col" onclick="sortTable(0, '; echo "'$exceptionTableID'"; echo')">Resource ID</th>
                  <th class="table-sort" scope="col" onclick="sortTable(1, '; echo "'$exceptionTableID'"; echo')">Justification</th>
                  <th class="table-sort" scope="col" onclick="sortTable(2, '; echo "'$exceptionTableID'"; echo')">Review Date</th>
                  <th class="table-sort" scope="col" onclick="sortTable(3, '; echo "'$exceptionTableID'"; echo')">Last Updated By</th>
                </tr>
              </thead>
              <tbody>
                ';
                
                while ($rowExceptions = $resultExceptions->fetch_assoc()) {
                  echo '<tr>';
                    echo '<td scope="row"><strong>'. $rowExceptions['resource_id']  .'</strong></td>';
                    echo '<td>'. $rowExceptions['justification'] . '</td>';
                    echo '<td>'. $rowExceptions['review_date'] . '</td>';
                    echo '<td>'. $rowExceptions['user_name'] . '</td>';

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

  //Gets all the exceptions with upcoming reviews in the next 30 days
  function upComingReviews($dbc, $reviewDate){

    $customerID = $_SESSION['customerID'];
  
    $sqlQuery = "SELECT * FROM exception 
    LEFT JOIN resource
    ON resource.resource_id = exception.resource_id
    WHERE customer_id = '$customerID'";
    
    $upcomingReviewsResult = $dbc->query($sqlQuery);

    if($upcomingReviewsResult){
      if($upcomingReviewsResult -> num_rows > 0){

        while ($upcomingExceptions = $upcomingReviewsResult->fetch_assoc()) {

          $currentExceptionID = $upcomingExceptions['exception_id'];
          $currentResourceID = $upcomingExceptions['resource_id'];

          if(reviewDatePassed($dbc, $upcomingExceptions['review_date']) == $reviewDate){
            echo '<tr>';
            echo '<th scope="row">'. $upcomingExceptions['rule_id']  . '</th>';
            echo '<td>'. $upcomingExceptions['resource_id']  . '</td>';
            echo '<td>'. $upcomingExceptions['resource_name']  . '</td>';
            echo '<td>'. $upcomingExceptions['justification']  . '</td>';
            echo '<td>'. $upcomingExceptions['review_date'] . '</td>';
            echo '</tr>';
          }
        }
      }
    }
  }

  //Checks if the date is in the past or future and returns true(in future/upcoming) or false(passed)
  function reviewDatePassed($dbc, $reviewDate){

    //Subtracts the BST VS GMT difference at the end of string
    if (strpos($reviewDate, '+0000')) {
      $reviewDate = trim($reviewDate, "+0000");
      $currentTime = date('Y-m-d H:i:s');
    }
    else{
      $reviewDate = trim($reviewDate, "+0100");
      $currentTime = date('Y-m-d H:i:s', strtotime('-1 hours'));
    }
 
    //Date 30 days in the future
    $compareUpcoming = date('Y-m-d H:i:s', strtotime('+30 days'));

    if(strtotime($reviewDate) < strtotime($currentTime))
      return 0;//passed

    //If the date is within 30 days
    if(strtotime($reviewDate) < strtotime($compareUpcoming))
      return 1;//Upcoming
  
    return 3; //way in the future
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