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
  include "connectDB.php";
  ?>
  <header>
    <h1>Brightsolid</h1>
    <img src="">
  </header>

  <main>
    <div class="container">
      <h1>Complaint</h1>
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

        $result = $db->query($sql);


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
                            </tr>
                          </thead>
                          <tbody>
                          ';
                            $sqlResources = "SELECT rule.rule_id, rule.rule_name, resource.resource_id, resource.resource_name, non_compliance.rule_id AS 'noncompliant', exception.rule_id AS 'exception' FROM resource
                            JOIN rule
                            ON resource.resource_type_id = rule.resource_type_id
                            LEFT JOIN exception
                            ON rule.rule_id = exception.rule_id AND resource.resource_name = exception.exception_value
                            LEFT JOIN non_compliance
                            ON resource.resource_id = non_compliance.resource_id AND rule.rule_id = non_compliance.rule_id
                            WHERE rule.rule_id = " . $row['rule_id'] . ";";
                            
                            $resultResources = $db->query($sqlResources);

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

    <h1>Non-Compliant</h1>
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th scope="col">Rule Name</th>
          <th scope="col">Rule Description</th>
          <th scope="col">Resource Name</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT rule_id, rule_name, rule_description, resource_type_id FROM rule 
        ORDER BY resource_type_id ASC;";

        $result = $db->query($sql);


        if ($result->num_rows == 0) {
          echo ("No Rules Compliant");
        } else {
          while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <th>'. $row['rule_name'] .'</th>
                    <th>'. $row['rule_description'] .'</th>
                    <th>';
                    
                    $sqlResource = "SELECT * FROM resource, non_compliance WHERE non_compliance.resource_id = resource.resource_id AND resource.resource_type_id = " . $row['resource_type_id'] . ";";

                    $resultResource = $db->query($sqlResource);

                    if ($resultResource->num_rows == 0) {
                      echo "No Non-Compliant Resources";
                    } else {
                    while ($rowResource = $resultResource->fetch_assoc()) {
                      echo $rowResource['resource_name'] . ", ";
                    }
                  }
                    echo '</th>
                  </tr>;
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
    $db->close();
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
<link rel="stylesheet" href="DashboardTemplate.css">
</html>