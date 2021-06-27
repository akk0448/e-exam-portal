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
 </head>
 <body class="">
   <nav class="navbar navbar-expand-lg navbar-dark my-nav bg-dark">
     <div class="container-fluid">
       <a class="navbar-brand" href="e-Exam Portal.php">e-Exam Portal</a>

         <ul class="navbar-nav mr-auto">
           <li class="nav-item active">
             <a class="nav-link" href="repository.php">e-Repository <span class="sr-only">(current)</span></a>
           </li>
         </ul>
         <?php
         $id = $_GET['subjectid'];
         echo '
         <form class="form-inline my-2 my-lg-0" action="searchquestion.php?subjectid='. $id .'" method="POST">
           <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
           <button class="btn btn-outline-success my-2 my-sm-0 mr-4" type="submit"><i class="fa fa-search"></i></button>
         </form>
         ';

          ?>
       
       <a class="navbar-brand" href="#"><?php if(isset($_SESSION['user_id'])): echo "Hi, ", $user_data['user_name']; endif; ?></a>
       <ul class="navbar-nav me-auto mb-2 mb-lg-0">
         <?php if(isset($_SESSION['user_id'])): ?>
           <button class="btn btn-outline-success" type="submit" onclick="location.href='logout.php'">Logout</button>
         <?php else: ?>
           <button class="btn btn-outline-success" type="submit" onclick="location.href='login.php?page_url=<?php echo $redirect_link; ?>'">Login</button>
         <?php endif; ?>
       </ul>
     </div>
   </nav>

   <?php
   $id = $_GET['subjectid'];
   $sql = "select * from subjects where subject_id='$id'";
   $result = mysqli_query($con, $sql);
   $noResult = True;
   while($row = mysqli_fetch_assoc($result))
   {
     // $noResult = False;
     $name = $row['subject_name'];
     $desc = $row['subject_description'];

     echo '<div class="jumbotron container my-4">
       <h1 class="display-4">'. $name .'</h1>
       <p class="lead">'. $desc .'</p>
       <hr class="my-4">
       <p>It offers access to a set of question papers. This E-Question Bank database comprises old question papers.</p>
     </div>';
   }
   ?>

   <div class="container mb-5" style="min-height : 193px;">
     <h1 class="py-2">Questions</h1>
     <?php

     if(isset($_SESSION['user_id']))
     {
       $id = $_GET['subjectid'];
       $sql = "select * from questions where subject_id='$id'";
       $result = mysqli_query($con, $sql);
       $noResult = True;
       while($row = mysqli_fetch_assoc($result))
       {
         $noResult = False;
         $id = $row['question_id'];
         $question = $row['question_name'];
         $answer = $row['question_answer'];
         echo '<div class="container mt-3">
           <div class="media my-3">
             <img src="questiondefault.png" class="mr-3" width="54px" alt="John Doe">
             <div class="media-body">
               <p class="font-weight-bold my-0">'. $question .'</p>
               <p>'. $answer .'</p>
             </div>
           </div>
         </div>';
       }
       if($noResult)
       {
         echo '<div class="jumbotron container">
           <div class="container">
             <p  class="display-4">No Questions Found</p>
             <p class="lead">Wait for some times, Questions will be uploaded soon.</p>
           </div>
         </div>';
       }
     }
     else
     {
       echo '
       <div class="container my-4">
         <p class="lead">You are not logged in. Please login to be able to view questions.</p>
       </div>
       ';
     }



     ?>
   </div>


   <div class="container-fluid bg-dark text-light">
     <p class="text-center mb-0">Copyrights e-Exam Portal 2021 | All Rights Reserved</p>
   </div>
 </body>
 </html>
