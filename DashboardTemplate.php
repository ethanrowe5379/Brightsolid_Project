<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

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
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT rule_id, rule_name, rule_description, resource_type_id FROM rule 
          ORDER BY rule_id ASC;";

          $result = $dbc->query($sql);


          if ($result->num_rows == 0) {
            echo ("No Rules Compliant");
          } else {
            while ($row = $result->fetch_assoc()) {
              echo '<tr>
                      <th>'. $row['rule_id'] .'</th>
                      <th>'. $row['rule_name'] .'</th>
                      <th>'. $row['rule_description'] .'</th>
                      
                      <th> <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom_'. $row['rule_id'] .'" aria-controls="offcanvasBottom">Toggle Detailed Report</button>
                      
                      <div class="h-100 offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom_'. $row['rule_id'] .'" aria-labelledby="offcanvasBottomLabel">
                        <div class="offcanvas-header">
                          <h5 class="offcanvas-title" id="offcanvasBottomLabel">Detailed Report for rule '. $row['rule_id'] .' <br> '. $row['rule_name'] .'</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body small">
                          <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Resource ID</th>
                                <th scope="col">Resource Name</th>
                                <th scope="col">Compliance Status</th>
                                <th scope="col">Exception</th>
                              </tr>
                            </thead>
                            <tbody>
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
                                  
                                  echo '<td>'. $rowResources['exception'];

                                  $currentResourceID = $rowResources["resource_id"];
                                  $currentTime = date("Y-m-d H:i:s.v");
                                  $reviewMin = date("Y-m-d");

                                  if($rowResources['noncompliant'] != NULL && $rowResources['exception'] == NULL){
                                    
                                    echo'

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal'. $currentResourceID . '">Create Exception</button>

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
                                                        <input type="text" placeholder="Enter Exception Value" value=' . $rowResources["resource_name"] .' name="expValue" required><br>
                                                        <input type="text" placeholder="Enter Justification" name="justValue" required><br>
                                                        <input type="datetime-local" step="1" id ="reviewDate" name="rvwDate" required><br>
                                     
                                                        ';
                                                        
                                                        echo '
                                                        <script>
                                                          let thisTime = new Date().toISOString().slice(0, -8) //The current time (min)
                                                          
                                                          const reviewDate = document.getElementById("reviewDate");
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
                                  </div>';
                                  }
                                  echo '</td>';
                                echo '</tr>';
                              }
                            echo'  
                            </tbody>
                          </table>

                          <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Exception ID</th>
                                <th scope="col">Resource Name</th>
                                <th scope="col">Justification</th>
                                <th scope="col">Review Date</th>
                                <th scope="col">Last Updated By</th>
                                <th scope="col">Last Updated</th>
                                <th scope="col">Edit</th>
                              </tr>
                            </thead>
                            <tbody>
                              ';
                              
                              $sqlExceptions = "SELECT * FROM exception
                              WHERE exception.rule_id = " . $row['rule_id'] . ";";

                              $resultExceptions = $dbc->query($sqlExceptions);

                              while ($rowExceptions = $resultExceptions->fetch_assoc()) {

                                $currentResourceID = $rowExceptions['resource_id'];
                                $currentExceptionID = $rowExceptions['exception_id'];

                                echo '<tr>';
                                  echo '<th scope="row">'. $rowExceptions['exception_id']  . '</th>';
                                  echo '<td>'. $rowExceptions['exception_value'] . '</td>';
                                  echo '<td>'. $rowExceptions['justification'] . '</td>';
                                  echo '<td>'. $rowExceptions['review_date'] . '</td>';
                                  echo '<td>'. $rowExceptions['last_updated_by'] . '</td>';
                                  echo '<td>'. $rowExceptions['last_updated'] . '</td>';
                                  echo '<td>
                                    
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
                                                  <div class="container">';
                                                     
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
                                                      
                                                  
                                                      
                                                     echo
                                                        '
                                                        <label for="updateExceptionID" class="form-label">Exception ID</label>
                                                        <input type="text" placeholder="Exception ID" name="updateExceptionID" id="updateExceptionID" value="'. $currentExceptionID .'" required readonly><br>

                                                        <label for="updateJustValue" class="form-label">Justification</label>
                                                        <input type="text" value="'.$justificationValue.'" name="updateJustValue" id="updateJustValue" required><br>
                                                        
                                                        <label for="updateExpValue" class="form-label">Exception Value</label>
                                                        <input type="text" value="'.$exceptionValue.'" name="updateExpValue"  id="updateExpValue" required readonly><br>
                                                        
                                                        <label for="updateRvwDate" class="form-label">Review Date</label>
                                                        <input type="datetime-local" step="1" value="'. $reviewDateValue.'" name="updateRvwDate" id="updateRvwDate" required><br>

                                                        <script>
                                                      
                                                          let thisTime = new Date().toISOString().slice(0, -8) //The current time (min)
                                                          
                                                          const reviewDate = document.getElementById("reviewDate");
                                                          reviewDate.min = thisTime;
                                                        </script>

                                                      <!-- WE ALREADY HAVE CUSTOMER ID AND USER name but to make it better we will need to get it from Jaime and DJ -->
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


                                  </td>';
                                echo '</tr>';
                              }


                            

                              echo'
                            </tbody>
                          </table>
                        </div>
                      </div>
                      </th>
                    </tr>
                    ';
            }
          }
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