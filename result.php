<?php

session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
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
  <title>Result</title>
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

  <?php

  if(isset($_SESSION['user_id']))
  {
      $id = $_GET['examid'];
      $user_id = $user_data['id'];
      $sql = "SELECT * FROM `results` where `exam_id` = $id AND `user_id` = $user_id";
      $sql2 = "SELECT exam_subject FROM `exams` where `exam_id` = $id";
      $result = mysqli_query($con, $sql);
      $result2 = mysqli_query($con, $sql2);
      $row = mysqli_fetch_assoc($result);
      $row2 = mysqli_fetch_assoc($result2);
      $subject = $row2['exam_subject'];
      $marks = $row['result_marks'];
      $ctr = $row['result_total_marks'];
      $correct = $row['result_correct'];
      $attempt = $row['result_attempt'];
      echo '
      <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
          <div class="flex flex-col text-center w-full mb-20">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Result of '. $subject .' Exam</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">You have successfully completed your exam. Below is how you performed. <a href="e-Exam Portal.php">Click here to return to HomePage</a></p>
          </div>
          <div class="flex flex-wrap -m-4 text-center">
            <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
              <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="26.000000pt" height="26.000000pt" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 26.000000 26.000000" preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,26.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                <path d="M30 144 c0 -87 4 -119 14 -130 10 -10 39 -14 100 -14 l86 0 0 116 c0 87 -4 119 -14 130 -10 10 -39 14 -100 14 l-86 0 0 -116z m170 -4 l0 -110 -80 0 -80 0 0 110 0 110 80 0 80 0 0 -110z m20 -20 l0 -110 -82 2 -83 2 78 3 77 4 0 104 c0 58 2 105 5 105 3 0 5 -49 5 -110z"/>
                <path d="M97 193 c-14 -13 -6 -25 8 -13 25 21 41 -3 21 -31 -17 -25 -20 -39 -8 -39 10 0 32 50 32 72 0 12 -8 18 -23 18 -13 0 -27 -3 -30 -7z"/>
                <path d="M110 90 c0 -5 5 -10 10 -10 6 0 10 5 10 10 0 6 -4 10 -10 10 -5 0 -10 -4 -10 -10z"/>
                </g>
                </svg>
                <h2 class="title-font font-medium text-3xl text-gray-900">'. $ctr .'</h2>
                <p class="leading-relaxed">Questions</p>
              </div>
            </div>
            <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
              <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                 width="512.000000pt" height="512.000000pt" class="text-indigo-500 w-12 h-12 mb-3 inline-block" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 512.000000 512.000000"
                 preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                fill="#000000" stroke="none">
                <path d="M2330 5114 c-14 -2 -65 -9 -115 -15 -433 -52 -873 -237 -1235 -517
                -117 -91 -316 -287 -413 -407 -312 -386 -508 -857 -558 -1343 -17 -170 -7
                -546 20 -695 97 -542 319 -979 696 -1366 427 -438 969 -700 1579 -762 152 -15
                504 -7 646 16 833 131 1540 653 1911 1409 121 246 201 511 241 796 20 146 17
                545 -6 695 -39 254 -116 509 -222 734 l-54 115 144 145 c89 90 147 157 151
                174 4 15 5 51 3 79 -8 79 -34 97 -323 222 -137 59 -255 113 -261 120 -6 6 -51
                126 -99 266 -48 140 -94 265 -102 278 -33 54 -137 81 -196 51 -12 -6 -90 -79
                -173 -161 l-151 -150 -80 40 c-273 138 -586 232 -892 267 -112 13 -441 19
                -511 9z m570 -328 c202 -35 392 -92 578 -174 l104 -45 -201 -201 -202 -202
                -82 27 c-192 64 -420 91 -660 77 -725 -42 -1363 -574 -1540 -1283 -121 -485
                -38 -965 240 -1385 106 -160 303 -357 463 -463 330 -218 691 -314 1083 -286
                148 10 242 28 380 70 599 183 1041 671 1179 1300 20 92 22 132 22 344 0 253
                -10 334 -64 507 l-20 63 203 203 202 203 34 -73 c116 -253 191 -605 191 -902
                0 -804 -418 -1536 -1114 -1949 -272 -161 -570 -259 -906 -298 -131 -15 -461
                -6 -585 15 -392 68 -743 223 -1049 464 -104 81 -311 293 -393 403 -215 287
                -351 594 -419 949 -32 163 -44 491 -25 658 67 575 352 1106 791 1474 332 278
                722 450 1165 513 133 19 493 14 625 -9z m1285 -235 l37 -113 -348 -349 c-192
                -192 -352 -349 -355 -349 -3 0 -18 59 -33 132 l-28 131 338 338 c186 186 341
                335 345 331 4 -4 23 -58 44 -121z m178 -793 l-338 -338 -144 40 c-79 22 -146
                41 -148 43 -2 3 156 162 352 355 l355 350 130 -56 130 -57 -337 -337z m-1562
                186 c99 -16 226 -54 315 -94 l61 -28 16 -68 c8 -38 26 -118 38 -177 l23 -108
                -90 -90 -90 -90 -77 45 c-486 276 -1112 33 -1285 -500 -49 -150 -54 -352 -13
                -507 61 -230 226 -436 442 -551 453 -241 1018 -48 1230 419 115 254 95 590
                -49 820 l-31 50 91 92 c50 50 96 90 102 88 11 -4 241 -66 312 -84 41 -11 42
                -12 79 -108 68 -178 80 -250 80 -488 0 -196 -2 -217 -28 -320 -33 -132 -93
                -285 -149 -380 -343 -587 -1031 -849 -1669 -635 -410 137 -744 474 -884 892
                -50 151 -69 268 -69 438 0 169 19 287 69 437 222 664 881 1060 1576 947z
                m-123 -819 c35 -8 86 -25 114 -37 l50 -21 -211 -211 c-115 -116 -215 -224
                -221 -239 -48 -131 77 -257 203 -203 18 7 127 106 243 220 l212 206 27 -68
                c86 -215 36 -451 -130 -617 -234 -234 -583 -232 -815 4 -228 231 -228 570 0
                802 145 148 340 208 528 164z"/>
                </g>
                </svg>
                <h2 class="title-font font-medium text-3xl text-gray-900">'. $attempt .'</h2>
                <p class="leading-relaxed">Attempted</p>
              </div>
            </div>
            <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
              <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="26.000000pt" height="26.000000pt" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 26.000000 26.000000" preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,26.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                <path d="M167 142 l-77 -76 -34 33 c-50 48 -68 30 -20 -20 21 -22 43 -39 49 -39 16 0 178 167 168 173 -5 3 -44 -29 -86 -71z"/>
                </g>
                </svg>
                <h2 class="title-font font-medium text-3xl text-gray-900">'. $correct .'</h2>
                <p class="leading-relaxed">Correct</p>
              </div>
            </div>
            <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
              <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                 width="512.000000pt" height="512.000000pt" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 512.000000 512.000000"
                 preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                fill="#000000" stroke="none">
                <path d="M1030 5106 c-179 -50 -329 -201 -376 -381 -20 -74 -20 -4256 0 -4330
                48 -182 199 -333 381 -381 41 -11 325 -14 1528 -14 l1478 0 76 25 c174 59 303
                195 349 370 20 74 20 4256 0 4330 -48 182 -199 333 -381 381 -71 19 -2987 19
                -3055 0z m3027 -228 c77 -29 152 -104 181 -181 l22 -58 0 -2079 0 -2079 -22
                -58 c-29 -77 -104 -152 -181 -181 l-58 -22 -1439 0 -1439 0 -58 22 c-77 29
                -152 104 -181 181 l-22 58 0 2079 0 2079 22 58 c28 76 104 152 178 181 55 21
                57 21 1497 21 l1442 1 58 -22z"/>
                <path d="M2205 4462 c-109 -41 -199 -123 -251 -227 l-29 -60 -3 -458 -3 -458
                30 -29 c25 -25 38 -30 78 -30 42 0 54 5 79 31 l29 30 3 180 3 179 210 0 209 0
                0 -181 0 -181 29 -29 c25 -24 38 -29 78 -29 42 0 54 5 79 31 l29 30 3 407 c2
                277 -1 426 -8 467 -26 133 -113 246 -237 307 -61 30 -77 33 -173 36 -83 2
                -116 -2 -155 -16z m257 -238 c71 -49 90 -102 96 -255 l5 -129 -212 0 -211 0 0
                125 c0 137 10 178 58 229 69 73 184 86 264 30z"/>
                <path d="M3334 4449 c-29 -30 -29 -32 -32 -160 l-4 -129 -127 0 c-127 0 -127
                0 -155 -28 -34 -37 -43 -89 -22 -130 26 -51 60 -62 191 -62 l115 0 0 -115 c0
                -131 11 -165 62 -191 41 -21 93 -12 130 22 28 28 28 28 28 155 l0 127 129 4
                c128 3 130 3 160 32 26 25 31 37 31 79 0 40 -5 53 -29 78 l-29 29 -131 0 -131
                0 0 131 0 131 -29 29 c-25 24 -38 29 -78 29 -42 0 -54 -5 -79 -31z"/>
                <path d="M1350 2337 c-14 -7 -33 -29 -43 -49 -15 -30 -16 -44 -8 -76 6 -21 20
                -47 32 -58 20 -18 51 -19 903 -22 649 -2 888 1 909 9 39 16 57 47 57 97 0 54
                -12 77 -50 97 -25 13 -143 15 -902 15 -676 0 -879 -3 -898 -13z"/>
                <path d="M1350 1697 c-14 -7 -33 -29 -43 -49 -15 -30 -16 -44 -8 -76 6 -21 20
                -47 32 -58 20 -18 56 -19 1223 -22 889 -2 1208 1 1229 9 39 16 57 47 57 97 0
                54 -12 77 -50 97 -25 13 -177 15 -1222 15 -931 0 -1198 -3 -1218 -13z"/>
                <path d="M1350 1057 c-14 -7 -33 -29 -43 -49 -15 -30 -16 -44 -8 -76 6 -21 20
                -47 32 -58 20 -18 51 -19 903 -22 649 -2 888 1 909 9 39 16 57 47 57 97 0 54
                -12 77 -50 97 -25 13 -143 15 -902 15 -676 0 -879 -3 -898 -13z"/>
                </g>
                </svg>
                <h2 class="title-font font-medium text-3xl text-gray-900">'. $marks .'</h2>
                <p class="leading-relaxed">Marks</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      ';
  }


   ?>




   <div class="container-fluid bg-dark text-light fixed-bottom">
     <p class="text-center mb-0">Copyrights e-Exam Portal 2021 | All Rights Reserved</p>
   </div>
</body>
</html>
