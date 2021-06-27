<?php

session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);
    if(isset($_SESSION['user_id']))
    {
      if($_SERVER['REQUEST_METHOD'] == "POST")
      {
        //something was posted
        $marks = 0;
        $ctr = 0;
        $correct = 0;
        $attempt = 0;
        $id = $_GET['examid'];
        $sql = "select * from paper where exam_id='$id'";
        $sql2 = "SELECT exam_subject FROM `exams` where `exam_id` = $id";
        $result = mysqli_query($con, $sql);
        $result2 = mysqli_query($con, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $subject = $row2['exam_subject'];
        while($row = mysqli_fetch_assoc($result))
        {
          $ctr = $ctr+1;
          $qid = $row['q_id'];
          $qans = $row['q_ans'];
          $status = array_key_exists('question-'. $qid .'-answers', $_POST) ? True : False;
          if($status)
          {
            $attempt = $attempt+1;
            $ans = $_POST['question-'. $qid .'-answers'];
            if($qans == $ans)
            {
              $correct = $correct+1;
              $marks = $marks+1;
            }
            else
            {
              $marks = $marks-0.25;
            }
          }
        }
        $user_id = $user_data['id'];
        $sql3 = "insert into results (exam_id,user_id,result_attempt,result_correct,result_marks,result_total_marks) values ('$id','$user_id','$attempt','$correct','$marks','$ctr')";
        $result3 = mysqli_query($con,$sql3);
        header("location:result.php?examid=".$id);
      }
    }

?>
