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

  if(isset($_SESSION['dataRaceCondition'])){
    
    $msg = $_SESSION['dataRaceCondition'];
    unset($_SESSION['dataRaceCondition']);

    echo'<script>alert("'.$msg.'")</script>';
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
      <!-- https://www.w3schools.com/howto/howto_css_sidebar_responsive.asp -->
      <div class="navbar fixed-top sidebar"  id="NewNavBar">
        <div>
          
          <div id="DesktopNavBar">

            <div class="position-absolute top-0 start-0" id="SideBarLogo">
              <img src="PHP/Graphics\SmallLogo.png" class="img-fluid" alt="Logo" id="SmallBrightSolidLogo">
            </div>
  
            <!-- Passed -->
            <a class="d-flex align-items-center justify-content-center p-3 link-dark dropdown-toggle" data-bs-toggle="modal" data-bs-target="#PassedModal" id="AccountDropDown">
              <img src="PHP/Graphics\Bell.png" class="img-fluid" alt="Logo" id="AccountIcon">
            </a>

            <div class="modal fade" id="PassedModal" aria-labelledby="UpComingModal" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">Passed Exceptions</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <div class="noPassedDiv" id="noPassedDiv"></div>
                      
                        <table class="table table-bordered table-detailed-view table-hover" id="passedTable">
                          <thead class="table-dark">
                            <tr>
                              <th scope="col">Rule ID</th>
                              <th scope="col">Resource ID</th>
                              <th scope="col">Resource Name</th>
                              <th scope="col">Justification</th>
                              <th scope="col">Review Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php upComingReviews($dbc, 0); ?>
                          </tbody>
                        </table> 

                        <script>
                          var x = document.getElementById("passedTable");
                          if(x.rows.length <= 1){
                            x.style.display = "none";

                            const passedheading = document.createElement("h6");
                            const passedMessage = document.createTextNode("There are no passed review dates.");
                            passedheading.appendChild(passedMessage);

                            const element = document.getElementById("noPassedDiv");
                            element.appendChild(passedheading);
                          }
                        </script>
                    </div>
                </div>
              </div>
            </div>
            <!-- Passed -->

            <!-- Upcoming -->
            <a class="d-flex align-items-center justify-content-center p-3 link-dark dropdown-toggle" data-bs-toggle="modal" data-bs-target="#UpComingModal" id="AccountDropDown">
              <img src="PHP/Graphics\30Days.png" class="img-fluid" alt="Logo" id="AccountIcon">
            </a>

            <div class="modal fade" id="UpComingModal" aria-labelledby="UpComingModal" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">Upcoming Exceptions</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                      <div class="noUpcomingDiv" id="noUpcomingDiv"></div>
                       
                        <table class="table table-bordered table-detailed-view table-hover" id="upcomingTable">
                          <thead class="table-dark">
                            <tr>
                              <th scope="col">Rule ID</th>
                              <th scope="col">Resource ID</th>
                              <th scope="col">Resource Name</th>
                              <th scope="col">Justification</th>
                              <th scope="col">Review Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php upComingReviews($dbc, 1); ?>
                          </tbody>
                        </table> 
          
                      <script>
                        var x = document.getElementById("upcomingTable");
                        if(x.rows.length <= 1){
                          x.style.display = "none";

                          const upcomingHeading = document.createElement("h6");
                          const upcomingMessage = document.createTextNode("There are no upcoming review dates.");
                          upcomingHeading.appendChild(upcomingMessage);

                          const element = document.getElementById("noUpcomingDiv");
                          element.appendChild(upcomingHeading);
                        }

                      </script>
                    </div>
                </div>
              </div>
            </div>
            <!-- Upcoming -->

            <!-- Account -->
            <div class="position-absolute bottom-0 end-0" id="AccountDropDown">
              <div class="dropup">
                <a class="d-flex align-items-center justify-content-center p-3 link-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="PHP/Graphics\AccountIcon.png" class="img-fluid" alt="Logo" id="AccountIcon">
                </a>
                
                <ul class="dropdown-menu" id="AccountDropDownMenu">
                  <li> <div class="d-flex justify-content-center"><?php echo $_SESSION['userName']?></div> </li>
                  <li> <div class="d-flex justify-content-center"><?php echo $_SESSION['userRole']?></div> </li>
                  <li> <hr class="dropdown-divider"> </li>
                  <li> 
                    <div class="d-flex justify-content-center">
                      <form action="AuditorDashboard.php" method="post">
                        <button class="btn btn-primary" type="submit" name="LogOut">Log Out</button>
                      </form>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <!-- Account -->
          </div>

          <!-- MOBILE NAV -->
          <div id="NavBarLogo">

            <button id="HamburgerButton" type="button" data-bs-toggle="offcanvas" data-bs-target="#MobileOffCanvas">
              <div class="Hamburger"></div>
              <div class="Hamburger"></div>
              <div class="Hamburger"></div>
            </button>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="MobileOffCanvas">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasLabelMobile"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>

              <div class="offcanvas-body" id="MobileOffcanvas">
                    
                <!-- Passed --> 
                <div id="PassedDropDownMobile">            
                  <div class="dropdown">
                    <a class="d-flex align-items-center justify-content-center p-3 link-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="PHP/Graphics\Bell.png" class="img-fluid" alt="Logo" id="AccountIcon">
                    </a>
                    
                    <ul class="dropdown-menu review-dropdown">
                      <li class="review-dropdown-li">
                        <div class="noPassedDivMobile" id="noPassedDivMobile"></div>

                        <div class="table-responsive">

                          <table class="table table-bordered table-detailed-view" id="passedTableMobile">
                            <thead class="table-dark">
                              <tr>
                                <th scope="col">Rule ID</th>
                                <th scope="col">Resource ID</th>
                                <th scope="col">Resource Name</th>
                                <th scope="col">Justification</th>
                                <th scope="col">Review Date</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php upComingReviews($dbc, 0); ?>
                            </tbody>
                          </table> 
                          
                        </div>


                        <script>
                          var x = document.getElementById("passedTableMobile");
                          if(x.rows.length <= 1){
                            x.style.display = "none";

                            const passedheading = document.createElement("h6");
                            const passedMessage = document.createTextNode("There are no passed review dates.");
                            passedheading.appendChild(passedMessage);

                            const element = document.getElementById("noPassedDivMobile");
                            element.appendChild(passedheading);
                          }
                        </script>

                      </li>
                    </ul>
                  </div>
                </div>
                <!-- Passed End-->

                
                <!-- Upcoming -->
                  <div id="UpcomingDropDownMobile"> 
                    <div class="dropdown">
                      <a class="d-flex align-items-center justify-content-center p-3 link-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="PHP/Graphics\30Days.png" class="img-fluid" alt="Logo" id="AccountIcon">
                      </a>
                      <ul class="dropdown-menu review-dropdown">
                        <li class="review-dropdown-li"> 
                          
                          <div class="noUpcomingDivMbobile" id="noUpcomingDivMbobile"></div>
                      
                          <table class="table table-bordered table-detailed-view" id="upcomingTableMobile">
                            <thead class="table-dark">
                              <tr>
                                <th scope="col">Rule ID</th>
                                <th scope="col">Resource ID</th>
                                <th scope="col">Resource Name</th>
                                <th scope="col">Justification</th>
                                <th scope="col">Review Date</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php upComingReviews($dbc, 1); ?>
                            </tbody>
                          </table> 

                          <script>
                            var x = document.getElementById("upcomingTableMobile");
                            if(x.rows.length <= 1){
                              x.style.display = "none";

                              const upcomingHeading = document.createElement("h6");
                              const upcomingMessage = document.createTextNode("There are no upcoming review dates.");
                              upcomingHeading.appendChild(upcomingMessage);

                              const element = document.getElementById("noUpcomingDivMbobile");
                              element.appendChild(upcomingHeading);
                            }
                              
                          </script>

                        </li>
                      </ul>
                    </div>
                  </div>
                <!-- Upcoming End -->

                <!-- Account  -->
                  <div id="AccountDropDownMobile">
                    <div class="dropup">

                      <a class="d-flex align-items-center justify-content-center p-3 link-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="PHP/Graphics\AccountIcon.png" class="img-fluid" alt="Logo" id="AccountIcon">
                      </a>
                      
                      <ul class="dropdown-menu">
                        <li> <div class="d-flex justify-content-center"><?php echo $_SESSION['userName']?></div> </li>
                        <li> <div class="d-flex justify-content-center"><?php echo $_SESSION['userRole']?></div> </li>
                        <li> <hr class="dropdown-divider"> </li>
                        <li> 
                          <div class="d-flex justify-content-center">
                            <form action="AuditorDashboard.php" method="post">
                              <button class="btn btn-primary" type="submit" name="LogOut">Log Out</button>
                            </form>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!-- Account  -->
              </div>

            </div>
            <img src="PHP/Graphics\BrightSolidLogo.png" class="img-fluid" alt="Logo" id="NavBarBrightSolidLogo">
          </div>
          
        </div>
      </div>
    </header>


      <main>
        <!-- Page content -->
        <div class="content">
          <div class="container">
            <div id="DashboardHeading">
              <h1>Compliance Dashboard</h1>
            </div>

            <div class="chart-container row">
              <div class="graph1 col-md-4">
                <canvas id="PieChart"></canvas>
              </div>
              <div class="graph2 col-md-8">
                <canvas id="BarChart"></canvas>
              </div>
            </div>

            <?php  

              $overallTotalResources = 0;
              $overallTotalCompliant = 0;

              $accountToBeFound = $_SESSION["customerID"];
              $findAccount = "SELECT account_id FROM account WHERE customer_id='$accountToBeFound';";
              $resultAccounts = $dbc->query($findAccount);

              $foundAccountID = 0;

              if($resultAccounts -> num_rows == 1){
                $accountRow = $resultAccounts->fetch_assoc();
                $foundAccountID = $accountRow["account_id"];
            ?>

            <div class="table-responsive">
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
            </div>
            <?php 
            }
            else{
              echo '<h6 class="noResourceHeading">There are accounts for this customer: '.$foundAccountID.'</h6>';
            } 
            ?>
          </div>
            <!-- End of table -->
        </div>
      </main>

  <footer></footer>
  <?php $dbc->close(); ?>
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
          <td><strong>'. $row['rule_id'] .'</strong></td>
          <td>'. $row['rule_name'] .'</td>
          <td class="table-rule-desc">'. $row['rule_description'] .'</td>';

          ?>

          <script>
            ruleArray.push("<?php echo 'rule ' . $row['rule_id']; ?>");
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
          <div class="table-responsive">
            <table class="table table-detailed-view table-hover" id="'. $resourceTableID .'">
              <thead class="table-dark">
                <tr>
                  <th class="table-sort" scope="col" onclick="sortTable(0, '; echo "'$resourceTableID'"; echo')">Resource ID</th>
                  <th class="table-sort" scope="col" onclick="sortTable(1, '; echo "'$resourceTableID'"; echo')">Resource Name</th>
                  <th class="table-sort" scope="col" onclick="sortTable(2, '; echo "'$resourceTableID'"; echo')">Compliance Status</th>
                  <th class="table-sort" scope="col" onclick="sortTable(3, '; echo "'$resourceTableID'"; echo')">Exception</th>
                  <th scope="col">Audit</th>
                </tr>
              </thead>
              <tbody>
              ';
                while ($rowResources = $resultResources->fetch_assoc()) {

                  if($rowResources['noncompliant'] == NULL or $rowResources['exception'] != NULL)
                    $tableRow = "resourceCompliant";
                  else
                    $tableRow = "resourceNonCompliant";
                  
                  echo '<tr id="'.$tableRow.'">';
                    echo '<td scope="row"><strong>'. $rowResources['resource_id']  .'</strong></td>';
                    echo '<td>'. $rowResources['resource_name'] . '</td>';
                    
                    if($rowResources['noncompliant'] == NULL or $rowResources['exception'] != NULL){
                      echo '<td>Compliant</td>';
                    }else{
                      echo '<td>Non-Compliant</td>';
                    }
             
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
          </div>
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
            <div class="table-responsive">
              <table class="table table-detailed-view table-hover" id="'. $exceptionTableID .'">
                <thead class="table-dark">
                  <tr>
                    <th class="table-sort" scope="col" onclick="sortTable(0, '; echo "'$exceptionTableID'"; echo')">Resource ID</th>
                    <th class="table-sort" scope="col" onclick="sortTable(1, '; echo "'$exceptionTableID'"; echo')">Justification</th>
                    <th class="table-sort" scope="col" onclick="sortTable(2, '; echo "'$exceptionTableID'"; echo')">Review Date</th>
                    <th class="table-sort" scope="col" onclick="sortTable(3, '; echo "'$exceptionTableID'"; echo')">Last Updated By</th>
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
                      echo '<td scope="row"><strong>'. $rowExceptions['resource_id']  .'</strong></td>';
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
            </div>
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
        <button class="table-btn btn btn-primary" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal'. $currentResourceID . '">Create</button>

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

  //Edit exception button
  function editExceptionButton($dbc, $currentResourceID, $currentExceptionID){
    echo '

      <td>
        <button class="table-btn btn btn-primary" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditModal' . $currentExceptionID .  '">Update</button>

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
                        <input type="datetime-local" name="updateRvwDate" id="updateRvwDate'.$currentResourceID .'" required><br>

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

  //Button for suspending exceptions
  function suspendExceptionButton($dbc, $currentExceptionID){
    echo '
    <td>
      <button class="table-btn btn btn-primary" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#SuspendModal' . $currentExceptionID .  '">Suspend</button>

        <div class="modal fade" id="SuspendModal' . $currentExceptionID .'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="text" name="suspendExceptionValue" id="suspendExceptionValue'. $exceptionValue. '" value="'. $exceptionValue .'"required readonly><br>

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
  function viewResourceAudit($dbc, $currentRuleID, $currentResourceID){

    $customerID = $_SESSION['customerID'];  

    $getAudits =
    "SELECT customer_id, rule_id, exception_id, action, action_dt, old_review_date, exception_id FROM exception_audit WHERE rule_id='$currentRuleID' AND resource_id='$currentResourceID' 
    AND customer_id = '$customerID'";

    $auditResult = mysqli_query($dbc, $getAudits);

    echo'
      <button class="table-btn btn btn-primary" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AuditModal'.$currentResourceID. $currentRuleID .'">View</button>
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
                      
                      <div class="container-flex table-responsive">
                        <table class="table table-bordered table-detailed-view table-hover">
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
      $currentTime = date('Y-m-d H:i:s');
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
