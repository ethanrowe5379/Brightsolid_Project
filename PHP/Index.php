<!DOCTYPE html>
<?php session_start();?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        form {border: 3px solid #f1f1f1;}
        
        input[type=text], input[type=password] {
          width: 100%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
        }
        
        button {
          background-color: black;
          color: white;
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          cursor: pointer;
          width: 100%;
        }
        
        button:hover {
          opacity: 0.8;
        }
            
        .container {
          padding: 16px;
          max-width: 500px;
        }
        
        span.psw {
          float: right;
          padding-top: 16px;
        }
        
        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
          span.psw {
             display: block;
             float: none;
          }
        }
        </style>
</head>

  <body>
    <div>
        <form action="Login.php" method="post" autocomplete="off">
            <div class="container">
                <h1>Login</h1>

                <input type="text" placeholder="Enter Username" name="uname" required><br>
            
                <input type="password" placeholder="Enter Password" name="psw" required><br>
            
                <button type="submit">Login</button>
            </div>
        </form>
      </div>
  </body>
</html>