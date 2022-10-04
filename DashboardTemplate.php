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
                    
                    $sqlResource = "SELECT * FROM resource
                                    LEFT JOIN non_compliance 
                                    ON resource.resource_id = non_compliance.resource_id
                                    WHERE resource.resource_type_id = " . $row['resource_type_id'] . "
                                    ORDER BY resource.resource_type_id ASC;";
                    $resultResource = $db->query($sqlResource);

                    while ($rowResource = $resultResource->fetch_assoc()) {
                      echo $rowResource['resource_name'] . ", ";
                    }
                    echo '</th>
                  </tr>;
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
                    
                    $sqlResource = "SELECT * FROM non_compliance
                                    LEFT JOIN resource 
                                    ON resource.resource_id = non_compliance.resource_id
                                    WHERE resource.resource_type_id = " . $row['resource_type_id'] . "
                                    ORDER BY resource.resource_type_id ASC;";
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


  <footer></footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
<link rel="stylesheet" href="DashboardTemplate.css">
</html>