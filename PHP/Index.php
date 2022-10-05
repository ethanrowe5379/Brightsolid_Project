<!DOCTYPE html>
<?php 

  session_start();

  // if (isset($_SESSION['userRole'])) {
    
  //     switch($_SESSION['userRole']){
  //       case "Manager":
  //         //header("refresh:3;url=ManagerDashboard.php");
  //         break;
  //       case "Auditor":
  //         //header("refresh:3;url=AuditorDashboard.php");
  //         break;
  //       case "Admin":
  //         header("Location: AdminPortal.php");
  //         break;
  //       default:
  //         header("Location: Index.php");
  //         break;
  //     }
  // }

?>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Login.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brightsolid Login</title>

</head>

  <body>
    <content>

      <div class="text-center"> 
        <img src="Graphics\BrightSolidLogo.png" class="img-fluid" alt="Logo" id="BrightSolidLogo">
      </div> 
            
      <div id = "LoginForm">
        <form action="Login.php" method="post" autocomplete="off">
          <div class="container">
            <h1>Login</h1>
            <input type="text" placeholder="Enter Username" name="uname" required><br>
            <input type="password" placeholder="Enter Password" name="psw" required><br>
            <button class="btn btn-primary" type="submit" id="LoginSubmit">Login</button>
            <div>
              <p class="text-center" id="LoginStatus">
                <?php 
                  if (isset($_SESSION['loginstatus'])) {
                    $loginstatus = $_SESSION['loginstatus'];
                    echo $loginstatus;
                    unset($_SESSION['loginstatus']);
                  }
                ?>
              </p>
            </div>
          </div>
        </form>
      </div>
    </content>
  </body>





  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CreateExceptionModal">Create Exception</button>

  <div class="modal fade" id="CreateExceptionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Exception Creation</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         
          <div id="CreateException">
              <form action="ExceptionBackEnd.php" method="post" autocomplete="off"> 
                  <div class="container">
                      <h1>Create Exception</h1>

                      <input type="number" min="1" placeholder="Enter Resource ID" name="resourceID" required><br>
                      <input type="number" min="1" placeholder="Enter Rule ID" name="ruleID" required><br>
                      <input type="text" placeholder="Enter Exception Value" name="expValue" required><br>
                      <input type="text" placeholder="Enter Justification" name="justValue" required><br>
                      <input type="datetime-local" step="1" id ="reviewDate" name="rvwDate" required><br>
                      <input type="text" placeholder="" name="currentDate" id="currentDate" required readonly><br>

                      <?php 
                        //Sets the current time for the form input when creating an exception
                        $currentTime = date("Y-m-d h:i:sa");
                        $reviewMin = date("Y-m-d");
                        
                        echo 
                        "
                          <script>
                            document.getElementById('currentDate').value = '$currentTime';
                          </script>  
                        ";
                      ?>

                      <script>
                        let thisTime = new Date().toISOString().slice(0, -8) //The current time (min)
                        
                        const reviewDate = document.getElementById('reviewDate');
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

</html>
