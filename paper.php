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

   <div class="container my-2">
     <h1 class="text-center my-3">Questions</h1>
   </div>
   <div class="container" style="min-height : 561px;">
     <div class="media">
       <div class="media-body my-2">
         <form class="" action="check.php?examid=<?php echo $_GET['examid']; ?>" method="post">
           <ol>
          <?php

           if(isset($_SESSION['user_id']))
           {
             $noResult = True;
             $user_id = $user_data['id'];
             $id = $_GET['examid'];
             $sql = "select * from paper where exam_id='$id'";
             $sql3 = "SELECT COUNT(result_id) FROM `results` WHERE `user_id` = $user_id AND `exam_id` = $id";
             $result = mysqli_query($con, $sql);
             $result3 = mysqli_query($con,$sql3);
             $row3 = mysqli_fetch_assoc($result3);
             if($row3['COUNT(result_id)'] == 0)
             {
               while($row = mysqli_fetch_assoc($result))
               {
                 $noResult = False;
                 $qid = $row['q_id'];
                 $qname = $row['q_name'];
                 $op1 = $row['q_op1'];
                 $op2 = $row['q_op2'];
                 $op3 = $row['q_op3'];
                 $op4 = $row['q_op4'];

                 echo '
                   <li>
                     <p class="lead">'. $qname .'</p>
                     <div>
                       <input type="radio" name="question-'. $qid .'-answers" id="question-1-answers-A" value="'. $op1 .'" />
                       <label for="question-1-answers-A">A) '. $op1 .'</label>
                     </div>
                     <div>
                       <input type="radio" name="question-'. $qid .'-answers" id="question-1-answers-B" value="'. $op2 .'" />
                       <label for="question-1-answers-B">B) '. $op2 .'</label>
                     </div>
                     <div>
                       <input type="radio" name="question-'. $qid .'-answers" id="question-1-answers-C" value="'. $op3 .'" />
                       <label for="question-1-answers-C">C) '. $op3 .'</label>
                     </div>
                     <div>
                       <input type="radio" name="question-'. $qid .'-answers" id="question-1-answers-D" value="'. $op4 .'" />
                       <label for="question-1-answers-D">D) '. $op4 .'</label>
                     </div>
                   </li>
                 ';
               }
               if($noResult)
               {
                 echo '<div class="jumbotron container">
                   <div class="container">
                     <p  class="display-4">No Questions Found</p>
                     <p class="lead">Wait for sometimes or contact some officials.</p>
                   </div>
                 </div>';
               }
               else
               {
                 echo '</ol>
                <div class="form-group row">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>';
               }
             }
             else
             {
               echo '<div class="jumbotron container">
                 <div class="container">
                   <p  class="display-4">You have already given exam</p>
                   <p class="lead"><a class="text-dark" href="result.php?examid='. $_GET['examid'] .'">Click here to check your result</a></p>
                 </div>
               </div>';
             }
           }


            ?>

       </div>
     </div>
   </div>
 </div>
   <div class="container-fluid bg-dark text-light">
     <p class="text-center mb-0">Copyrights e-Exam Portal 2021 | All Rights Reserved</p>
   </div>
 </body>
 </html>
