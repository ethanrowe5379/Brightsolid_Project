<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="DashboardTemplate.css">
</head>

<body >
    <?php 
        include "connectDB.php";
    ?>
    <header>
        <h1>Brightsolid</h1>
        <?php
          // $sql = "SELECT * FROM rule";
          // $result = $db->query($sql);
          // while($row = $result->fetch_assoc()){
          //   echo($row['user_name']);
          // }
        ?>
        <img src="">
    </header>

    <main >
        <div class="container card" id="col">
            <h2>Compliant</h2>
                <?php 
                  $sql = "SELECT rule_id, rule_name FROM rule";
                  $result = $db->query($sql);
                  while($row = $result->fetch_assoc()){
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
                ?>
        </div>

        <div class="container card"id="col">
            <h2>Non-Compliant</h2>
                <div class="row card text-bg-success" id="innerCard">
                      <h5 class="col">Rule #?</h5>
                      <button class="col-auto btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#compliance21" aria-expanded="false" aria-controls="compliance21">
                          Toggle Report
                        </button>
                        <div class="collapse" id="compliance21">
                          <div class="card">
                            <p style="color:black;">hello</p>
                          </div>
                        </div>
                </div>
        </div>

        <div class="container card" id="col">
            <h2>Exceptions</h2>
            
        </div>

    </main>


    <footer></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
        crossorigin="anonymous"></script>
</body>

</html>