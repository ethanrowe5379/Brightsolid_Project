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




?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Auditor Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="DashboardTemplate.css">
</head>

<body>
  <?php
  include "PHP/dbConnect.php";
  ?>
  <header>
    <h1>Brightsolid</h1>
    <img src="">

    <?php 
      echo "
      <p>Logged in as: ".$_SESSION['userName']."</p>
      <p>Role: ".$_SESSION['userRole']."</p>"
    ?>

    <form action="AuditorDashboard.php" method="post">
      <button class="btn btn-primary" type="submit" name="LogOut">Log Out</button>
    </form>

  </header>

  <main>
    <div class="container">
      <h1>Compliance Dashboard</h1>
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
          tbodyInsert($dbc);
          ?>
        </tbody>
      </table>
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

function tbodyInsert($dbc) {
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

        $sqlCountNon_compliance = "SELECT COUNT(rule_id) AS 'count'
        FROM non_compliance
        WHERE non_compliance.rule_id = " . $row['rule_id'] . ";";
        
        $sqlCountExceptions = "SELECT COUNT(rule_id) AS 'count'
        FROM exception
        WHERE exception.rule_id = " . $row['rule_id'] . ";";
        
        $sqlCountResources = "SELECT COUNT(resource_id) AS 'count'
        FROM resource
        JOIN rule
        ON resource.resource_type_id = rule.resource_type_id
        WHERE rule.rule_id = " . $row['rule_id'] . ";";


        $resultCountNon_compliance = $dbc->query($sqlCountNon_compliance);
        $resultCountExceptions = $dbc->query($sqlCountExceptions);
        $resultCountResources = $dbc->query($sqlCountResources);


        $dataCountNon_compliance = $resultCountNon_compliance->fetch_assoc();
        $dataCountExceptions = $resultCountExceptions->fetch_assoc();
        $dataCountResources = $resultCountResources->fetch_assoc();


        $totalResources = $dataCountResources['count'];
        $totalNon_compliant = $dataCountNon_compliance['count'] - $dataCountExceptions['count'];
        
        $totalcompliant = $totalResources - $totalNon_compliant;
        

        $compliantStatus = ($totalcompliant/$totalResources)*100;

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
              resourceTableInsert($dbc, $row);
              exceptionTableInsert($dbc, $row);
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

function resourceTableInsert($dbc, $row){
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

      $sqlResources = "SELECT rule.rule_id, rule.rule_name, resource.resource_id, resource.resource_name, non_compliance.rule_id AS 'noncompliant', exception.rule_id AS 'exception' FROM resource
                       JOIN rule
                       ON resource.resource_type_id = rule.resource_type_id
                       LEFT JOIN exception
                       ON rule.rule_id = exception.rule_id AND resource.resource_id = exception.resource_id
                       LEFT JOIN non_compliance
                       ON resource.resource_id = non_compliance.resource_id AND rule.rule_id = non_compliance.rule_id
                       WHERE rule.rule_id = " . $row['rule_id'] . ";";
      
      $resultResources = $dbc->query($sqlResources);

      if($resultResources -> num_rows < 1){
        echo '<h6 class="noResourceHeading">There are no resources for rule '. $row['rule_id'] .'</h6>';
      }
      else{

        echo'
          <table class="table table-detailed-view">
            <thead class="table-dark">
              <tr>
                <th scope="col">Resource ID</th>
                <th scope="col">Resource Name</th>
                <th scope="col">Compliance Status</th>
                <th scope="col">Exception</th>
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

function exceptionTableInsert($dbc, $row){
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
      
        $sqlExceptions = "SELECT exception.exception_id, exception.justification, exception.review_date, exception.last_updated, exception.resource_id,user.user_name
                          FROM exception
                          LEFT JOIN user
                          ON exception.last_updated_by = user.user_id
                          WHERE exception.rule_id = " . $row['rule_id'] . ";";

        $resultExceptions = $dbc->query($sqlExceptions);
            
        if($resultExceptions -> num_rows < 1){
          echo '<h6 class="noExceptionHeading">There are no exceptions for rule '. $row['rule_id'] .'</h6>';
        }
        else{

          echo '
          <table class="table table-detailed-view">
            <thead class="table-dark">
              <tr>
                <th scope="col">Resource ID</th>
                <th scope="col">Justification</th>
                <th scope="col">Review Date</th>
                <th scope="col">Last Updated By</th>
                <th scope="col">Last Updated</th>
              </tr>
            </thead>
            <tbody>
              ';
              
              while ($rowExceptions = $resultExceptions->fetch_assoc()) {
                echo '<tr>';
                  echo '<th scope="row">'. $rowExceptions['resource_id']  . '</th>';
                  echo '<td>'. $rowExceptions['justification'] . '</td>';
                  echo '<td>'. $rowExceptions['review_date'] . '</td>';
                  echo '<td>'. $rowExceptions['user_name'] . '</td>';
                  echo '<td>'. $rowExceptions['last_updated'] . '</td>';
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

?>