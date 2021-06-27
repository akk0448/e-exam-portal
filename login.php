<?php
session_start();

    include("connection.php");
    include("functions.php");


 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Ultra&display=swap" rel="stylesheet">
    <link rel = "icon" href = "https://www.pngrepo.com/download/245762/exam.png" type = "image/x-icon">
    <link rel="stylesheet" href="mycss.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  </head>
  <body class='bdy'>
    <nav class="navbar navbar-expand-lg navbar-dark my-nav " style="background-color: #542087;">
      <div class="container-fluid">
        <a class="navbar-brand" href="e-Exam Portal.php">e-Exam Portal</a>
      </div>
    </nav>

    <?php

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      //something was posted
      $email = $_POST['email'];
      $password = $_POST['password'];
      if(isset($_GET['page_url']))
      {
        $url = $_GET['page_url'];
      }
      //read from databaase
      $query = "select * from users where email = '$email' limit 1";
      $result = mysqli_query($con,$query);

      if($result)
      {
          if($result && mysqli_num_rows($result) > 0)
          {
              $user_data = mysqli_fetch_assoc($result);

              if(password_verify($password,$user_data['password']) || $password === $user_data['password'])
              {
                  $_SESSION['user_id'] = $user_data['user_id'];
                  if($url == "")
                  {
                    header("location: e-Exam Portal.php");
                  }
                  else
                  {
                    header("location: ".$url);
                  }
              }
          }
      }
      echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
              <strong>Failed login! </strong>Wrong email or password, try again with correct credentails.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }

     ?>

    <p class="lgp">e-Exam Portal<img class="icon" src="https://cdn3.iconfinder.com/data/icons/e-learning-outline-distance-education/512/E-learning_test-512.png" alt=""></p>
    <div class="login-form my-4">
        <form action="<?php $_SERVER['REQUEST_URI']; ?>" method="POST">
          <h1 class="lbox"><strong>Login</strong></h1>
          <hr>
          <div class="form-group">
        	   <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <span class="fa fa-envelope"></span>
                    </span>
                </div>
                <input type="text" class="form-control" placeholder="E-mail ID" name='email' required="required">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>
                </div>
                <input type="password" class="form-control" placeholder="Password" name='password' required="required">
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
          </div>
          <div class="bottom-action clearfix">
            <label class="float-left form-check-label"><input type="checkbox"> Remember me</label>
            <a href="#" class="float-right">Forgot Password?</a>
          </div>
        </form>
        <br><br>
        <p class="text-center small">Don't have an account! <a href="register.php">Sign up here</a>.</p>
    </div>
    <div class="container-fluid bg-dark text-light fixed-bottom">
      <p class="text-center mb-0">Copyrights e-Exam Portal 2021 | All Rights Reserved</p>
    </div>
  </body>
</html>
