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



  <div class="container my-3">
    <h1 class="py-3">Search results for <em>"<?php echo $_GET['search'] ?>"</em></h1>
    <?php

    $query = $_GET["search"];
    $sql = "select * from `thread` where match (`thread_title`, `thread_desc`) against ('$query')";
    $result = mysqli_query($con, $sql);
    $noResult = True;
    while($row = mysqli_fetch_assoc($result))
    {
      $noResult = False;
      $title = $row['thread_title'];
      $desc = $row['thread_desc'];
      $thread_id = $row['thread_id'];
      $url = "thread.php?threadid=". $thread_id;

      echo '
      <div class="result">
        <h3><a class="text-dark" href="'. $url .'">'. $title .'</a></h3>
        <p>'. $desc .'</p>
      </div>
      ';
    }
    if($noResult)
    {
      echo '<div class="jumbotron container">
        <div class="container">
          <p  class="display-4">No Results Found</p>
          <p class="lead">
          Suggestions:
          <ul>
            <li>Make sure that all words are spelled correctly.</li>
            <li>Try different keywords.</li>
            <li>Try more general keywords.</li>
          </ul>
          </p>
        </div>
      </div>';
    }

    ?>
  </div>
  <div class="container-fluid bg-dark text-light fixed-bottom">
    <p class="text-center mb-0">Copyrights e-Exam Portal 2021 | All Rights Reserved</p>
  </div>
</body>
</html>
