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

   <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
     <ol class="carousel-indicators">
       <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
       <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
       <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
     </ol>
     <div class="carousel-inner">
       <div class="carousel-item active">
         <img src="repo1.jpg" class="d-block w-100" alt="...">
       </div>
       <div class="carousel-item">
         <img src="repo2.jpg" class="d-block w-100" alt="...">
       </div>
       <div class="carousel-item">
         <img src="https://source.unsplash.com/2400x700/?exam,maths" class="d-block w-100" alt="...">
       </div>
     </div>
     <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
       <span class="carousel-control-prev-icon" aria-hidden="true"></span>
       <span class="sr-only">Previous</span>
     </a>
     <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
       <span class="carousel-control-next-icon" aria-hidden="true"></span>
       <span class="sr-only">Next</span>
     </a>
   </div>



   <div class="container">
     <h1 class="text-center my-3">e-Repository</h1>
     <div class="row my-4">
       <?php

          $sql = "SELECT * FROM `subjects`";
          $result = mysqli_query($con,$sql);
          while($row = mysqli_fetch_assoc($result))
          {
            $id = $row['subject_id'];
            $name = $row['subject_name'];
            $desc = $row['subject_description'];
            echo '
            <div class="col-md-4 my-2">
              <div class="card" style="width: 18rem;">
                <img src="https://source.unsplash.com/500x400/?'. $name .'" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">'. $name .'</h5>
                  <p class="card-text">'. substr($desc,0,90) .'....</p>
                  <a href="questions.php?subjectid='. $id .'" class="btn btn-primary">View Questions</a>
                </div>
              </div>
            </div>
            ';
          }

       ?>
       <!-- loop -->

       <!-- upto -->
     </div>
   </div>
   <div class="container-fluid bg-dark text-light">
     <p class="text-center mb-0">Copyrights e-Exam Portal 2021 | All Rights Reserved</p>
   </div>
 </body>
 </html>
