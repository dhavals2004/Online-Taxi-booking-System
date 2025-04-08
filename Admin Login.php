<?php
 session_start();
 include("connection.php");
 if($_SERVER['REQUEST_METHOD'] == "POST")

   {
     $user = $_POST['username'];
     $pass = $_POST['password'];

     if(!empty($user) && !empty($pass) && !is_numeric($user))
       {
         $query = "select * from admin_regis where username = '$user' limit 1 ";
         $result = mysqli_query($con,$query);

            if($result)
           {
               if($result && mysqli_num_rows($result) > 0)
               {
                 $user_data = mysqli_fetch_assoc($result);

                 if($user_data['password']== $pass)
                  {
                     header("location: panel.php");
                     die;
                  }
               }
          }
         echo"<script type='text/javascript'> alert('wrong username or password')</script>";
        }
         else {
         echo"<script type='text/javascript'> alert('wrong username or password')</script>";
      }
   }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST">
        <input type="text"name='username' placeholder="Username or Email" required>
        <input type="password"name='password' placeholder="Password" required>
        <div class="btn2">
          <button type="submit">Login</button>
         <button type="reset">Clear</button>  
        </div>
        <p>Don't have an account? <a href="Admin Signup.php">Sign Up</a></p>
    </div>
</body>
</html>