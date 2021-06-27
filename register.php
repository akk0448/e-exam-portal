<?php

session_start();

    include("connection.php");
    include("functions.php");


    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      //something was posted
      $user_name = $_POST['username'];
      $user_id = $_POST['userid'];
      $password = $_POST['password'];
      $password = password_hash($password, PASSWORD_DEFAULT);
      $email = $_POST['email'];
      $age = $_POST['age'];
      $gender = $_POST['inlineRadioOptions'];
      $address = $_POST['address'];
      $branch = $_POST['branch'];
      $skill = $_POST['skill'];
      $chk="";
      foreach($skill as $chk1)
      {
        $chk.=$chk1.",";
      }
      $file_name = $_FILES['resume']['name'];
      $file_size = $_FILES['resume']['size'];
      $file_tmp = $_FILES['resume']['tmp_name'];
      $file_type = $_FILES['resume']['type'];
      $file_ext = explode('.', $_FILES['resume']['name']);
      $file_ext = end($file_ext);
      $file_ext = strtolower($file_ext);

      move_uploaded_file($file_tmp, "uploads/" . $file_name);
      $path = "http://localhost/exam/";
      $path = $path."uploads/".$file_name;

      $sql = "SELECT COUNT(user_id) FROM `users` WHERE `user_id`='$user_id'";
      $result = mysqli_query($con, $sql);
      $row = mysqli_fetch_assoc($result);
      $sql2 = "SELECT COUNT(email) FROM `users` where `email` = '$email'";
      $result2 = mysqli_query($con, $sql2);
      $row2 = mysqli_fetch_assoc($result2);
      if($row2['COUNT(email)'] == 0 && $row['COUNT(user_id)'] == 0)
      {
        $query = "insert into users (user_name,user_id,password,email,age,gender,address,branch,skill,resume) values ('$user_name','$user_id','$password','$email','$age','$gender','$address','$branch','$chk','$path')";

        mysqli_query($con,$query);
        header("Location: login.php");
        die;
      }
      else if($row2['COUNT(email)'] > 0)
      {
        echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>Failed Signup! </strong>Email already registered, try to login.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
      }
      else if($row['COUNT(user_id)'] > 0)
      {
        echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>Failed Signup! </strong>UserId already taken, try with different UserId.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
      }

    }

 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
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
    <script src="student.js"></script>
  </head>
  <body class="bdy">
    <nav class="navbar navbar-expand-lg navbar-dark my-nav " style="background-color: #542087;">
      <div class="container-fluid">
        <a class="navbar-brand" href="e-Exam Portal.php">e-Exam Portal</a>
      </div>
    </nav>
    <p class="lgp">e-Exam Portal<img class="icon" src="https://cdn3.iconfinder.com/data/icons/e-learning-outline-distance-education/512/E-learning_test-512.png" alt=""></p>
    <div class="register-form">
      <form id="form" action="<?php $_SERVER['REQUEST_URI']; ?>" onsubmit="return validateform()" method="POST" enctype="multipart/form-data">
        <h1 class='lbox'><strong>Create Account</strong></h1>
        <hr>
        <!-- Name -->
        <div class="form-group">
           <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <span class="fa fa-user"></span>
                  </span>
              </div>
              <input id="username" type="text" class="form-control" placeholder="Name" name="username">
          </div>
        </div>
        <!-- ID -->
        <div class="form-group">
           <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <span class="fa fa-id-badge"></span>
                  </span>
              </div>
              <input id="userid" type="text" class="form-control" placeholder="ID" name="userid">
          </div>
        </div>
        <!-- Password -->
        <div class="form-group">
          <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="fa fa-lock"></i>
                  </span>
              </div>
              <input id="password" type="password" class="form-control" placeholder="Password" name="password">
          </div>
        </div>
        <!-- E-Mail ID -->
        <div class="form-group">
           <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <span class="fa fa-envelope"></span>
                  </span>
              </div>
              <input id="email" type="email" class="form-control" placeholder="E-Mail ID" name="email">
          </div>
        </div>
        <!-- Age -->
        <div class="form-group">
           <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <span class="fa fa-calendar"></span>
                  </span>
              </div>
              <input id="age" type="number" class="form-control" placeholder="Age" min=0 name="age">
          </div>
        </div>
        <!-- Gender -->
        <div class="form-group">
           <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <span class="fa fa-venus-mars"></span>
                  </span>
              </div>
          </div>
          <div class="space">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" value="Male" id="male">
              <label class="form-check-label" for="Male">Male</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" value="Female" id="female">
              <label class="form-check-label" for="Female">Female</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" value="Other" id="other">
              <label class="form-check-label" for="Other">Other</label>
            </div>
          </div>
        </div>
        <!-- Address -->
        <div class="form-group">
           <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <span class="fa fa-address-card"></span>
                  </span>
              </div>
              <textarea id="address" class="form-control" placeholder="Address" rows="2" name="address"></textarea>
          </div>
        </div>
        <!-- Branch -->
        <div class="form-group">
           <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <span class="fa fa-building"></span>
                  </span>
              </div>
              <select class="form-control" id="branch" name="branch">
                <option value="" disabled selected>Branch</option>
                <option value="CSE">CSE</option>
                <option value="ECE">ECE</option>
                <option value="EEE">EEE</option>
                <option value="AEI">AEI</option>
              </select>
          </div>
        </div>
        <!-- Technical Skills -->
        <div class="form-group">
           <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <span class="ic"></span>
                  </span>
              </div>
          </div>
          <div class="space">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="skill[]" value="C">
              <label class="form-check-label" for="C">C</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="skill[]" value="Java">
              <label class="form-check-label" for="Java">Java</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="skill[]" value="Python">
              <label class="form-check-label" for="Python">Python</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="skill[]" value="JSP">
              <label class="form-check-label" for="JSP">JSP</label>
            </div>
          </div>
        </div>
        <!-- Resume Upload -->
        <div class="form-group">
           <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <span class="fa fa-file"></span>
                  </span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="resume">
                <label class="custom-file-label" for="customFile">Choose File</label>
              </div>
              <script>
                $("#customFile").on("change", function() {
                  var fileName = $(this).val().split("\\").pop();
                  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });
              </script>
          </div>
        </div>
        <!-- Submit Button -->
        <div class="form-group">
          <button id="submit" type="submit" class="btn btn-primary btn-block">Create Account</button>
        </div>
        <!-- Reset Button -->
        <div class="form-group">
          <button type="reset" id="resetbtn" class="btn btn-danger btn-block">Reset</button>
        </div>
        <script>
          $(document).ready(function() {
            $('#resetbtn').on('click', function(e) {
              $('#customFile').next('label').html('Choose File');
            });
          });
        </script>
        <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>
      </form>
    </div>
    <div class="container-fluid bg-dark text-light">
      <p class="text-center mb-0">Copyrights e-Exam Portal 2021 | All Rights Reserved</p>
    </div>
  </body>
</html>
