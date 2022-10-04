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
    <!-- <div class="container card" id="col">
            <h2>Compliant</h2>
            <?php
            $sql = "SELECT t1.rule_id, t1.rule_name
                          FROM rule t1
                          LEFT JOIN exception_audit t2 
                          ON t2.rule_id = t1.rule_id
                          LEFT JOIN non_compliance_audit t3 
                          ON t3.rule_id = t1.rule_id
                          WHERE t2.rule_id IS NULL AND t3.rule_id IS NULL;";
            $result = $db->query($sql);


            if ($result->num_rows == 0) {
              echo ("No Rules Compliant");
            } else {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="row card text-bg-success" id="innerCard">
                          <h5 class="col">' . $row['rule_name'] . '</h5>
                          <button class="col-auto btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#compliance' . $row['rule_id'] . '" aria-expanded="false" aria-controls="compliance' . $row['rule_id'] . '">
                              Toggle Report
                            </button>
                            <div class="collapse" id="compliance' . $row['rule_id'] . '">
                              <div class="card">
                                <p>Lorem Ipsum</p>
                              </div>
                            </div>
                      </div>';
              }
            }
            ?>
        </div>

        <div class="container card"id="col">
            <h2>Non-Compliant</h2>
            <?php
            $sql = "SELECT r.rule_id, r.rule_name FROM rule r, exception_audit ea
                          WHERE r.rule_id = ea.rule_id";
            $result = $db->query($sql);


            if ($result->num_rows == 0) {
              echo ("No Rules Compliant");
            } else {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="row card text-bg-success" id="innerCard">
                            <h5 class="col">' . $row['rule_name'] . '</h5>
                            <button class="col-auto btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#compliance' . $row['rule_id'] . '" aria-expanded="false" aria-controls="compliance' . $row['rule_id'] . '">
                                Toggle Report
                              </button>
                              <div class="collapse" id="compliance' . $row['rule_id'] . '">
                                <div class="card">
                                  <p>Lorem Ipsum</p>
                                </div>
                              </div>
                        </div>';
              }
            }
            ?>
        </div>

        <div class="container card" id="col">
            <h2>Exceptions</h2>
            <?php
            $sql = "SELECT r.rule_id, r.rule_name FROM rule r, non_compliance_audit nca
                          WHERE r.rule_id = nca.rule_id";
            $result = $db->query($sql);


            if ($result->num_rows == 0) {
              echo ("No Rules Compliant");
            } else {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="row card text-bg-success" id="innerCard">
                            <h5 class="col">' . $row['rule_name'] . '</h5>
                            <button class="col-auto btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#compliance' . $row['rule_id'] . '" aria-expanded="false" aria-controls="compliance' . $row['rule_id'] . '">
                                Toggle Report
                              </button>
                              <div class="collapse" id="compliance' . $row['rule_id'] . '">
                                <div class="card">
                                  <p>Lorem Ipsum</p>
                                </div>
                              </div>
                        </div>';
              }
            }
            ?>
        </div> -->
    <div class="container">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">Rule Name</th>
          <th scope="col">Rule Description</th>
          <th scope="col">Resource Name</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT rule.rule_id, rule.rule_name, rule.rule_description, resource.resource_name FROM rule ,resource, account
                WHERE rule.resource_type_id = resource.resource_type_id AND resource.account_id = account.account_id AND account.customer_id = 1
                ";
        $result = $db->query($sql);


        if ($result->num_rows == 0) {
          echo ("No Rules Compliant");
        } else {
          while ($row = $result->fetch_assoc()) {
            echo '
                  <tr>
                    <th>'. $row['rule_name'] .'</th>
                    <th>'. $row['rule_description'] .'</th>
                    <th>' . $row['resource_name'] . '</th>
                  </tr>
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