<?php
include '../connect.php';
include "../passwordEmail/index.php";
session_start();
if (!empty($_SESSION['email']) && !empty($_SESSION['password'])) {
  header('location:../dashboard/?sort=month');
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$pattern = '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()])(?=\S+$).{8,20}$/';
$_SESSION['message'] = "";
$token = $_GET['token'];
// echo "$token" . "<br>";
$user_id = $_GET['user_id'];
$find_email = "SELECT user_email FROM `em_users` WHERE user_id='$user_id'";
$find_email_execute = mysqli_query($con, $find_email);
if ($find_email_execute) {
  while ($row = mysqli_fetch_array($find_email_execute)) {
    $email = $row['user_email'];
    // echo "$email";
  }
}
// $tokenTime = explode(" ", $token);
// $tokenTime = $tokenTime[1];
// $tokenTime = (int) $tokenTime;
// $tokenTime = $tokenTime + 1200;
// echo "$tokenTime";
if (isset($_POST['Reset'])) {
  $user_email = $_POST['email'];
  $updated_password = $_POST['new_password'];
  $confirm_pass = $_POST['confirm'];
  $sql = "SELECT user_first_name,user_token,user_email,user_id FROM `em_users` WHERE user_email='$user_email'";
  $result = mysqli_query($con, $sql);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $user_firstname = $row['user_first_name'];
    $user_token = $row['user_token'];
    // echo "$user_token";
    $user_email = $row['user_email'];
    if ($user_email == $email) {
      if ($user_token == $token) {
        $tokenTime = explode(" ", $user_token);
        $tokenTime = $tokenTime[1];
        $tokenTime = (int) $tokenTime;
        $tokenTime = $tokenTime + 10 * 60;
        $time = time();
        // echo "$time";
        if ($time > $tokenTime) {
          $_SESSION['message'] = "Token Expired. Please try again.";
          // echo "Token Expired";
          header("location:../forgotPassword");
        } else {
          // echo "Token good"; 66a3492c67841.jpeg
          if (!empty($updated_password)) {
            if (preg_match($pattern, $updated_password)) {
              if ($updated_password == $confirm_pass) {
                // $_SESSION['message'] = "";
                // echo "good";
                $updated_password = md5($updated_password);
                $sql = "SELECT * FROM `em_users` WHERE user_email='$user_email'";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) > 0) {
                  $update = "UPDATE `em_users` SET user_password='$updated_password' WHERE user_email='$email'";
                  $update_execute = mysqli_query($con, $update);
                  if ($update_execute) {
                    $_SESSION['message'] = "Password updated Successfully.";
                    $_SESSION['message'] = "";
                    // echo "updated Successfully";
                    sendPasswordEmail($user_firstname, $email, "", "", 'change', 'password changed successfully');
                    $delete_token = "UPDATE `em_users` SET user_token=null WHERE user_email='$user_email'";
                    $delete_token_execute = mysqli_query($con, $delete_token);
                    if ($delete_token_execute) {
                      // header("location:../pass-reset");
                      // echo "<h1>Password changed successfully</h1>";
                      // echo '<script>alert("Password changed successfully");</script>';
                      // sleep(20);
                      header("location:../");
                    }
                  }
                }
              } else {
                $_SESSION['message'] = "Confirm password must be same.";
                // echo "bad";
              }
            } else {
              $_SESSION['message'] = "please enter valid password.";
              // echo "please enter valid password.";
            }
          } else {
            $_SESSION['message'] = "Please enter password.";
            // echo "Please enter password.";
          }
        }
      } else {
        $_SESSION['message'] = "Invalid Token.";
        // echo "Invalid Token";
      }
    }
  } else {
    $_SESSION['message'] = "user not found";
    // echo "user not found";
  }
}
// function chnagePasswordMail($get_name, $get_email)
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
//     $mail->addAddress($get_email, $get_name);

//     // Content
//     $mail->isHTML(true);
//     $mail->Subject = 'Password Changed Successfully';

//     $mail->Body = "
//     <h2>Hello $get_name</h2>
//     <h3>Your password is successfuly Changed.</h3>
//     <h4>Thanks for signing in with us.</h4>
//     ";
//     // Send email
//     $mail->send();
//     echo 'Message has been sent';
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
      height: 400px;
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

    #message {
      display: none;
      background: #f1f1f1;
      color: #000;
      position: absolute;
      left: 345px;
      bottom: 250px;
      padding-left: 3px;
      width: 250px;
      height: 20px;
      font-weight: bold;
    }

    #message p {
      background: #f1f1f1;
      font-size: 10px;
      padding: 2px;
    }

    .valid {
      color: green;
    }

    .valid:before {
      background: #f1f1f1;
      padding-left: 5px;
      position: relative;
      right: 5px;
      content: "✔";
    }

    .invalid {
      color: red;
    }

    .invalid:before {
      background: #f1f1f1;
      padding-left: 5px;
      position: relative;
      right: 5px;
      content: "✖";
    }

    .error_msg {
      background-color: red;
    }
    #passerror,#confirm-error{
      font-size: 11px;
      color: red;
      margin: 0px 0px 5px 5px;
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
          <h2>Admin <span>Change Password</span></h2>
          <?php
          //   if ($err_msg === true) {
          //     echo "<div class='error-message-div error-msg' ><img src='images/unsucess-msg.png'><strong>Invalid!</strong> Email
          //     or password. </div>";
          //   }
          //   if ($empty_msg === true) {
          //     echo "<div class='error-message-div error-msg' ><img src='images/unsucess-msg.png'><strong>ERROR!</strong> Please Enter Email
          //     and Password. </div>";
          //   }
          ?>
          <?php
          if (!empty($_SESSION['message'])) {
            echo "<div class='error-message-div error-msg'>
            <p>$_SESSION[message]</p>
          </div>";
          }
          ?>

          <form method="POST" class="margin_bottom" role="form" autocomplete="on" onsubmit="return validateForm()">
            <div class="form-group">
              <input type="hidden" name="pass-token" value=<?php if (isset($_GET['token']))
                echo $_GET['token']; ?>>
              <label for="email">Email <span class="req">*</span></label>
              <input type="text" name="email" class="form-control" placeholder="Enter Your Email" value=<?php echo $email; ?>>
              <label for="new_password">Password <span class="req">*</span></label>
              
              <input type="password" id="new_password" name="new_password" placeholder="Enter your password"
                class="form-control" value=<?php echo $_POST['new_password']; ?>><span id="passerror"></span><br>
              <div id="message">
                <h5>Password must contain the following:</h5>
                <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                <p id="number" class="invalid">A <b>number</b></p>
                <p id="character" class="invalid">A <b>special character</b></p>
                <p id="length" class="invalid">Minimum <b>8 characters</b></p>
              </div>
              <label for="confirm">Confirm Password <span class="req">*</span></label>
              <input id="confirm" type="password" name="confirm" placeholder="confirm password" class="form-control">
              <span id="confirm-error"></span><br>
            </div>
            <input type="submit" class="btn_login" value="Reset" name="Reset">
          </form>
          <div class="signup">
            <p>New User?</p>
            <a href="../signup">Signup</a>
          </div><br><br>
        </div>
      </div>
    </div>
    <script>
      function validateForm() {
        console.log("hii");
        let isvalid = true;
        let pattern=/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()])(?=\S+$).{8,20}$/;
        let pass = document.getElementById('new_password').value;
        let confirm = document.getElementById('confirm').value;
        console.log(pass);
        document.getElementById('passerror').innerHTML = "";
        document.getElementById('confirm-error').innerHTML = "";
        if (pass == "") {
          document.getElementById('passerror').innerHTML = "Please Enter Password.";
          isvalid = false;
        }else if(!pass.match(pattern)){
          document.getElementById('passerror').innerHTML = "Please Enter Valid Password.";
          isvalid = false;
        }
        if (confirm == "") {
          document.getElementById('confirm-error').innerHTML = "Please Confirm Password.";
          isvalid = false;
        }else if(confirm!=pass){
          document.getElementById('confirm-error').innerHTML = "Please enter same Password.";
          isvalid = false;
        }
        return isvalid;
      }
      var pass = document.getElementById("new_password");
      var letter = document.getElementById("letter");
      var capital = document.getElementById("capital");
      var number = document.getElementById("number");
      var length = document.getElementById("length");
      var char = document.getElementById("character");

      pass.onfocus = function () {
        document.getElementById("message").style.display = "block";
      }

      pass.onblur = function () {
        document.getElementById("message").style.display = "none";
      }

      pass.onkeyup = function () {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (pass.value.match(lowerCaseLetters)) {
          letter.classList.remove("invalid");
          letter.classList.add("valid");
        } else {
          letter.classList.remove("valid");
          letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (pass.value.match(upperCaseLetters)) {
          capital.classList.remove("invalid");
          capital.classList.add("valid");
        } else {
          capital.classList.remove("valid");
          capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (pass.value.match(numbers)) {
          number.classList.remove("invalid");
          number.classList.add("valid");
        } else {
          number.classList.remove("valid");
          number.classList.add("invalid");
        }
        // validate characters
        var chars = /[@#$%^&-+=()]/g;
        if (pass.value.match(chars)) {
          char.classList.remove("invalid");
          char.classList.add("valid");
        } else {
          char.classList.remove("valid");
          char.classList.add("invalid");
        }
        // Validate length
        if (pass.value.length >= 8) {
          length.classList.remove("invalid");
          length.classList.add("valid");
        } else {
          length.classList.remove("valid");
          length.classList.add("invalid");
        }
      }
    </script>
</body>

</html>