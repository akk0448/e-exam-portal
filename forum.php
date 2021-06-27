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
  <title>OpenForum</title>
</head>
<body class="">
  <nav class="navbar navbar-expand-lg navbar-dark my-nav bg-dark">
    <div class="container-fluid">
    <a class="navbar-brand" href="e-Exam Portal.php">e-Exam Portal</a>



      <ul class="navbar-nav mr-auto">
        <form class="form-inline my-2 my-lg-0" action="search.php" method="get">
          <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-info my-2 my-sm-0 mr-4" type="submit"><i class="fa fa-search"></i></button>
        </form>
      </ul>
      <a class="navbar-brand" href="#"><?php if(isset($_SESSION['user_id'])): echo "Hi, ", $user_data['user_name']; endif; ?></a>
      <div class="form-inline my-2 my-lg-0">

        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php if(isset($_SESSION['user_id'])): ?>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" onclick="location.href='logout.php'">Logout</button>
          <?php else: ?>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" onclick="location.href='login.php?page_url=<?php echo $redirect_link; ?>'">Login</button>
          <?php endif; ?>
        </ul>

      </div>
    </div>
  </nav>

  <?php

  $showAlert = False;
  $method = $_SERVER['REQUEST_METHOD'];
  if($method == "POST")
  {
    //Insert into database
    $thread_title = $_POST['title'];
    $thread_desc = $_POST['desc'];
    if(isset($_SESSION['user_id']))
    {
      $user_id = $user_data['id'];
    }
    $sql = "insert into thread (thread_title,thread_desc,thread_users_id,timestamp) values ('$thread_title','$thread_desc','$user_id',current_timestamp())";
    $result = mysqli_query($con,$sql);
    $showAlert = True;
    if($showAlert)
    {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success! </strong>Your thread has been submited successfully, wait for someone to reply.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
  }

   ?>

  <div class="container">
    <h2 class="text-center my-3">Welcome to OpenForum</h2>
  </div>

  <?php
  if(isset($_SESSION['user_id']))
  {
    echo '<div class="container my-4">
      <h1 class="py-2">Start a Discussion</h1>
      <form action="'. $_SERVER['REQUEST_URI'] .'" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail1">Thread Title</label>
          <input type="text" class="form-control" id="exampleInputEmail1" name="title" aria-describedby="emailHelp" required>
          <small id="emailHelp" class="form-text text-muted">Keep your title as small as possible</small>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Thread Description</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" name="desc" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
      </form>
    </div>';
  }
  else
  {
    echo '
    <div class="container my-4">
      <h1 class="py-2">Start a Discussion</h1>
      <p class="lead">You are not logged in. Please login to be able to post your queries.</p>
    </div>
    ';
  }


   ?>



  <div class="container mb-5" style="min-height : 389px;">
    <h1>Browse Queries</h1>
  <?php
  $sql = "select * from thread";
  $result = mysqli_query($con, $sql);
  $noResult = True;
  while($row = mysqli_fetch_assoc($result))
  {
    $noResult = False;
    $id = $row['thread_id'];
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_time = $row['timestamp'];
    $thread_users_id = $row['thread_users_id'];
    $sql2 = "SELECT user_id FROM `users` WHERE id='$thread_users_id'";
    $result2 = mysqli_query($con,$sql2);
    $row2 = mysqli_fetch_assoc($result2);

    echo '<div class="container mt-3">
      <div class="media my-3">
        <img src="userdefault.png" width="54px" class="mr-3" alt="John Doe">
        <div class="media-body">'.
          '<h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='. $id .'"> '. $title .' </a></h5>
          '. $desc .'</div>'.'<p class="font-weight-bold my-0">Asked by: '. $row2['user_id'] .' at '. $thread_time .'</p>'.
      '</div>
    </div>';
  }

  if($noResult)
  {
    echo '<div class="jumbotron container">
      <div class="container">
        <p  class="display-4">No Threads Found</p>
        <p class="lead">Be the first person to ask a question.</p>
      </div>
    </div>';
  }


  ?>
  </div>
  <div class="container-fluid bg-dark text-light">
    <p class="text-center mb-0">Copyrights e-Exam Portal 2021 | All Rights Reserved</p>
  </div>
</body>
</html>
