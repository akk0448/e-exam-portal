<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$protocol = $_SERVER['SERVER_PROTOCOL'];
if(strpos($protocol, "HTTPS"))
{
  $protocol = "HTTPS://";
}
else
{
  $protocol = "HTTP://";
}
$redirect_link = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="mycss.css">
  <link rel = "icon" href = "https://www.pngrepo.com/download/245762/exam.png" type = "image/x-icon">
  <title>e-Exam Portal</title>
  <style media="screen">
    .profile-header {
      transform: translateY(5rem);
    }

    body {
      background: #654ea3;
      background: -webkit-linear-gradient(to right, #654ea3, #eaafc8);
      background: linear-gradient(to right, #654ea3, #eaafc8);
      min-height: 100vh;
    }
  </style>
</head>
<body class="">
  <nav class="navbar navbar-expand-lg navbar-dark my-nav bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="e-Exam Portal.php">e-Exam Portal</a>

      
      <div class="form-inline my-2 my-lg-0">
      <a class="navbar-brand" href="#"><?php if(isset($_SESSION['user_id'])): echo "Hi, ", $user_data['user_name']; endif; ?></a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if(isset($_SESSION['user_id'])): ?>
          <button class="btn btn-outline-success" type="submit" onclick="location.href='logout.php'">Logout</button>
        <?php else: ?>
          <button class="btn btn-outline-success" type="submit" onclick="location.href='login.php?page_url=<?php echo $redirect_link; ?>'">Login</button>
        <?php endif; ?>
      </ul>
    </div>
    </div>
  </nav>


  <div class="row">
    <div class="col-lg-7 mx-auto text-white text-center pt-5">
      <h1 class="display-4">User profile page</h1>
      <p class="lead mb-0">View your all details and results</p>
      </p>
    </div>
  </div>


  <?php

    if(isset($_SESSION['user_id']))
    {
      $id = $user_data['id'];
      $name = $user_data['user_name'];
      $user_id = $user_data['user_id'];
      $address = $user_data['address'];
      $age = $user_data['age'];
      $email = $user_data['email'];
      $gender = $user_data['gender'];
      $branch = $user_data['branch'];
      $resume = $user_data['resume'];
      $skills =  $user_data['skill'];
      $skills = substr($skills,0,strlen($skills)-1);
      $skills_arr = preg_split ("/\,/", $skills);
      $C = "https://codecondo.com/wp-content/uploads/2015/03/20-Ways-To-Learn-C-Programming-For-Free.png";
      $Java = "https://ubiqum.com/assets/uploads/2019/10/screenshot-2021-02-11-at-115416.png";
      $Python = "https://www.elevano.com/wp-content/uploads/2018/10/python-programing-jobs.jpg";
      $JSP = "https://www.trainingnepal.com/wp-content/uploads/2018/04/JSP-course.jpg";
      echo '
      <div class="row py-5 px-4">
        <div class="col-xl-4 col-md-6 col-sm-10 mx-auto">


          <div class="bg-white shadow rounded overflow-hidden">
            <div class="px-4 pt-0 pb-4 bg-dark">
              <div class="media align-items-end profile-header">
                <div class="profile mr-3"><img src="'. $gender .'.jpg" alt="..." width="130" class="rounded mb-2 img-thumbnail"><a href="'. $resume .'" class="btn btn-dark btn-sm btn-block">Download CV</a></div>
                <div class="media-body mb-5 text-white">
                  <h4 class="mt-0 mb-0">'. $name .'</h4>
                  <h4 class="mt-0 mb-0">'. $email .'</h4>
                  <p class="small mb-4"> <i class="fa fa-map-marker mr-2"></i>'. $address .'</p>
                </div>
              </div>
            </div>

            <div class="bg-light p-4 d-flex justify-content-end text-center">
              <ul class="list-inline mb-0">
                <li class="list-inline-item">
                  <h5 class="font-weight-bold mb-0 d-block">'. $age .'</h5><small class="text-muted"> <i class="fa fa-calendar mr-1"></i>Age</small>
                </li>
                <li class="list-inline-item">
                  <h5 class="font-weight-bold mb-0 d-block">'. $branch .'</h5><small class="text-muted"> <i class="fa fa-building mr-1"></i>Branch</small>
                </li>
              </ul>
            </div>


            <div class="py-4 px-4">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0">Skills</h5>
              </div>
              <div class="row">';
              foreach ($skills_arr as $key)
              {
                 if($key == "C")
                {
                  $img = $C;
                }
                else if($key == "Java")
                {
                  $img = $Java;
                }
                else if($key == "Python")
                {
                  $img = $Python;
                }
                else
                {
                  $img = $JSP;
                }
                echo '<div class="col-lg-6 mb-2 pl-lg-1"><img src="'. $img .'" alt="" class="img-fluid rounded shadow-sm"></div>';
              }
              echo '</div>
              <div class="py-4">
                <h5 class="mb-3">Recent Results (Click on results for more info)</h5>
                <div class="p-4 bg-light rounded shadow-sm">';
                 $sql = "SELECT * FROM `results` where `user_id` = $id";
                 $result = mysqli_query($con, $sql);
                 $noResult = True;
                 while($row = mysqli_fetch_assoc($result))
                 {
                   $noResult = False;
                   $exam_id = $row['exam_id'];
                   $marks = $row['result_marks'];
                   $sql2 = "SELECT exam_subject FROM `exams` where `exam_id` = $exam_id";
                   $result2 = mysqli_query($con, $sql2);
                   $row2 = mysqli_fetch_assoc($result2);
                   $subject = $row2['exam_subject'];

                   echo '<p class="lead font-italic mb-0"><a class="text-dark" href="result.php?examid='. $exam_id .'">'. $subject .' => Scored - '. $marks .'</a></p>';
                 }
                 if($noResult)
                 {
                   echo '<p class="lead font-italic mb-0">Not participated in any exam yet.</p>';
                 }
                echo '</div>
              </div>
            </div>
          </div>

        </div>
      </div>
      ';
    }
    else
    {
      header("Location: login.php?page_url=".$url);
    }

   ?>


   <div class="container-fluid bg-dark text-light">
     <p class="text-center mb-0">Copyrights e-Exam Portal 2021 | All Rights Reserved</p>
   </div>
</body>
</html>
