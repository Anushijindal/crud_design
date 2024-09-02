<?php
include '../connect.php';
include '../passwordEmail/index.php';
session_start();
if (!empty($_SESSION['email']) && !empty($_SESSION['password'])) {
  header('location:../dashboard/?sort=month');
}
// $_SESSION['message1']="";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$err_msg = false;
// $_SESSION['message'] = "";
if (isset($_POST['reset'])) {
  $email = $_POST['email'];
  $time = time();
  $token = rand();
  $token = $token . " " . $time;
  // echo "$token";
  // $exp=explode('+',$token);
  // $exp=$exp[1];
  // print_r($exp);

  // if(time()=="$time"+900)

  $sql = "SELECT user_email,user_first_name,user_id FROM `em_users` WHERE user_email='$email'";
  $result = mysqli_query($con, $sql);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $user_firstname = $row['user_first_name'];
    $user_email = $row['user_email'];
    $user_id = $row['user_id'];
    // echo $user_email;
    // echo "$token";
    $update_token = "UPDATE `em_users` SET user_token = '$token' WHERE user_email='$user_email' AND user_first_name='$user_firstname'";
    $result1 = mysqli_query($con, $update_token);
    if ($result1) {
      sendPasswordEmail($user_firstname, $user_email, $token, $user_id,'forget','Password Reset Request');
      $_SESSION['message'] = "Email is sent to You. Please Verify Yourself.";
      // echo "Token is added";
      $err_msg = true;
      // header("location:signin.php");
    } else {
      $_SESSION['message'] = "OOPS! Something went Wrong";
      // echo "OOPS! error occurred";
    }
  } else {
    $_SESSION['message'] = "Email Not Found. Please try Again.";
    // echo "Email Not Found";
  }


}

// function sendPasswordEmail($name, $email, $token, $id)
// {
//   // global $err_msg;
//   $mail = new PHPMailer(true);
//   try {
//     // Server settings
//     $mail->SMTPSecure = "ssl";
//     $mail->Host = 'smtp.gmail.com';
//     $mail->Port = '465';
//     $mail->Username = 'anushi.arcs@gmail.com'; // SMTP account username
//     $mail->Password = 'kwem jfbi lqsc jucl';
//     $mail->SMTPKeepAlive = true;
//     $mail->Mailer = "smtp";
//     $mail->IsSMTP(); // telling the class to use SMTP
//     $mail->SMTPAuth = true; // enable SMTP authentication
//     $mail->CharSet = 'utf-8';
//     $mail->SMTPDebug = 0;

//     // Recipients
//     $mail->setFrom('anushi.arcs@gmail.com', 'Anushi Jindal');
//     $mail->addAddress($email, $name);

//     // Content
//     $mail->isHTML(true);
//     $mail->Subject = 'Password Reset Request';
//     // $mail->Body = 'Hello ' . $get_name . ',<br><br>This is a test email sent from PHPMailer. Your reset token is: ' . $token;

//     $mail->Body = "
//     <div style='text-align: center;margin:auto;border: 2px solid black;width: 50%;padding: 10px;background-color: #EEF7FF;border-radius: 20px;' class='template'>
//         <h1>Welcome $name</h1>
//         <h4>We send you this email because you are requesting for password change.</h4>
//         <p>For security purposes we need to verify youself.</p>
//         <p>Please click below for verification</p>
//         <button style='background-color: #3FA2F6;padding: 3px 5px;color: white;margin-right: 10px;' class='right'><a style='text-decoration:none;color:white;' 
//         href = 'http://localhost/crud_design/pass-reset.php?token=$token&user_id=$id'>Reset Password</a></button>
//         <p><a style='text-decoration:none;' href = 'http://localhost/crud_design/signin.php'>That wasn't me!</a></p>
//         <p>Facing difficuly in button? Copy the link: <a style='color-blue;'>http://localhost/crud_design/pass-reset.php?token=$token&user_id=$id</a></p>
//         <p>Thanks for connecting with us!</p>
//     </div>
//     ";
//     // Send email
//     $mail->send();
//     echo 'Message has been sent';
//     // $err_msg = true;
//     header("Location: " . $_SERVER['HTTP_REFERER'] . "");
//   } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//   }
// }
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>

  <!-- Bootstrap -->
  <link href="../css/dashboard.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style>
    .signup {
      font-size: 15px;
      display: inline-flex;
      gap: 10px;
      padding: 5px;
      margin-top: 10px;
    }

    .box {
      height: 260px;
    }

    input {
      padding: 2px;
    }

    .form-control {
      padding: 6px 12px;
      height: 40px;
    }

    .btn_signup {
      background: none repeat scroll 0 0 #5A7C5A;
      border: medium none;
      border-radius: 4px;
      color: #ffffff;
      cursor: pointer;
      font-family: "OpenSansSemibold";
      font-size: 13px;
      height: 20px;
      text-transform: uppercase;
      width: 87px;
      /* margin-top: 10px; */
    }

    .btn_signup a {
      color: white;
    }

    .req {
      color: red;
    }

    .right {
      background-color: #3FA2F6;
      padding: 3px 5px;
      color: white;
      margin-right: 10px;
    }

    .wrong {
      background-color: #C40C0C;
      padding: 3px 5px;
      color: white;
    }

    .template {
      text-align: center;
      border: 2px solid black;
      width: 30%;
      padding: 10px;
      background-color: #EEF7FF;
      border-radius: 20px;
    }
  </style>
</head>

<body>
  <div class="login_section">
    <div class="wrapper relative">
      <div style="display:none" class="meassage_successful_login">You have Successfull Edit </div>
      <div class="heading-top">
        <div class="logo-cebter"><a href="#"><img src="../images/at your service_banner.png"></a></div>
      </div>
      <div class="box">
        <div class="outer_div">
          <h2>Admin <span>Fogot Password</span></h2>
          <?php
          // if ($err_msg === true) {
          //   echo "<div class='error-message-div error-msg' ><img src='images/unsucess-msg.png'><strong>Cool!</strong> Email
          //   is sent. </div>";
          // }
          //   if ($empty_msg === true) {
          //     echo "<div class='error-message-div error-msg' ><img src='images/unsucess-msg.png'><strong>ERROR!</strong> Please Enter Email
          //     and Password. </div>";
          //   }
          if (!empty($_SESSION['message'])) {
            if ($_SESSION['message'] == 'Email is sent to You. Please Verify Yourself.') {
              echo "<div style='background-color:#ACE1AF;' class='error-message-div error-msg'>
            <p style='color:green;'>$_SESSION[message]</p>
          </div>";
            } else {
              echo "<div class='error-message-div error-msg'>
            <p>$_SESSION[message]</p>
          </div>";
            }

          }
          ?>

          <form method="POST" class="margin_bottom" role="form" autocomplete="on">
            <div class="form-group">
              <label for="email">Email <span class="req">*</span></label>
              <input type="text" name="email" class="form-control" value=<?php echo $_POST['email']; ?>>
            </div>
            <input type="submit" class="btn_login" value="reset" name="reset">
          </form>
          <div class="signup">
            <p>New User?</p>
            <a href="../signup">Signup</a>
          </div><br><br>
        </div>
      </div>
    </div>
</body>

</html>