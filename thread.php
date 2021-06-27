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

      <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="forum.php">OpenForum <span class="sr-only">(current)</span></a>
          </li>
        </ul>
      <!-- </div> -->
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

  $id = $_GET['threadid'];
  $showAlert = False;
  $method = $_SERVER['REQUEST_METHOD'];
  if($method == "POST")
  {
    //Insert into database
    $comment = $_POST['comment'];
    if(isset($_SESSION['user_id']))
    {
      $user_id = $user_data['id'];
    }
    $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_user_id`, `comment_time`) VALUES ('$comment', '$id', '$user_id', current_timestamp())";
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


  <?php
  $id = $_GET['threadid'];
  $sql = "select * from thread where thread_id='$id'";
  $result = mysqli_query($con, $sql);
  $noResult = True;
  while($row = mysqli_fetch_assoc($result))
  {
    // $noResult = False;
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_users_id = $row['thread_users_id'];
    $sql2 = "SELECT user_id FROM `users` WHERE id='$thread_users_id'";
    $result2 = mysqli_query($con,$sql2);
    $row2 = mysqli_fetch_assoc($result2);

    echo '<div class="jumbotron container my-4">
      <h1 class="display-4">'. $title .'</h1>
      <p class="lead">'. $desc .'</p>
      <hr class="my-4">
      <p>Spams are not allowed, user can be banned or strict actions will be taken.</p>
      <p>Posted by:<b> '. $row2['user_id'] .'</b></p>
    </div>';
  }
  ?>

  <?php

  if(isset($_SESSION['user_id']))
  {
    echo '
    <div class="container my-4">
      <h1 class="py-2">Post a comment</h1>
      <form action="' .$_SERVER['REQUEST_URI']. '" method="POST">
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Type your comment</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" name="comment" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Post Comment</button>
      </form>
    </div>
    ';
  }
  else
  {
    echo '
    <div class="container my-4">
      <h1 class="py-2">Post a comment</h1>
      <p class="lead">You are not logged in. Please login to be able to post your comments.</p>
    </div>
    ';
  }

   ?>





  <div class="container mb-5">
    <h4>Query Discussion</h4>
    <?php
    $id = $_GET['threadid'];
    $sql = "select * from comments where thread_id='$id'";
    $result = mysqli_query($con, $sql);
    $noResult = True;
    while($row = mysqli_fetch_assoc($result))
    {
      $noResult = False;
      $id = $row['comment_id'];
      $content = $row['comment_content'];
      $comment_time = $row['comment_time'];
      $comment_user_id = $row['comment_user_id'];
      $sql2 = "SELECT user_id FROM `users` WHERE id='$comment_user_id'";
      $result2 = mysqli_query($con,$sql2);
      $row2 = mysqli_fetch_assoc($result2);
      echo '<div class="container mt-3">
        <div class="media my-3">
          <img src="userdefault.png" class="mr-3" width="54px" alt="John Doe">
          <div class="media-body">
            <p class="font-weight-bold my-0">'. $row2['user_id'] .' at '. $comment_time .'</p>
            <p>'. $content .'</p>
          </div>
        </div>
      </div>';
    }

    if($noResult)
    {
      echo '<div class="jumbotron container">
        <div class="container">
          <p  class="display-4">No Comments Found</p>
          <p class="lead">Be the first person to give a reply.</p>
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
