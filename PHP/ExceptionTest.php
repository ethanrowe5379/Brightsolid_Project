<!DOCTYPE html>
<?php session_start();?>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Login.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brightsolid Admin Portal</title>

</head>

  <body>
    <content>

      <div class="text-center"> 
        <img src="Graphics\BrightSolidLogo.png" class="img-fluid" alt="Logo" id="BrightSolidLogo">
        <h1>Creating Exception</h1>
      </div> 
            
        <div id="CreateUserForm">
            <form action="ExceptionBackEnd.php" method="post" autocomplete="off"> 
                <div class="container">
                    <h1>Create Exception</h1>

                    <input type="number" min="1" placeholder="Enter Resource ID" name="resourceID" required><br>
                    <input type="number" min="1" placeholder="Enter Rule ID" name="ruleID" required><br>
                    <input type="text" placeholder="Enter Exception Value" name="expValue" required><br>
                    <input type="text" placeholder="Enter Justification" name="justValue" required><br>
                    <input type="date" placeholder="" name="rvwDate" required><br>
                    <input type="text" placeholder="" name="currentDate" id="currentDate" required readonly><br>

                    <script>
                    
                        var utc = new Date().toJSON().slice(0,10).replace(/-/g,'/');
                        document.getElementById("currentDate").value = utc;
                    </script> 
                    <!-- WE ALREADY HAVE CUSTOMER ID AND USER name -->
                    <button class="btn btn-primary" type="submit" id="createExceptionConfirm">Create Exception</button>

                </div>
            </form>
        </div>

    </content>
  </body>
</html>