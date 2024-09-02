<?php
include './connect.php';
session_start();
if (!empty($_SESSION['email']) && !empty($_SESSION['password'])) {
  header('location:./dashboard/?sort=month');
}
$err_msg = false;
$empty_msg = false;

// print_r($_SESSION);
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  if (empty($email) || empty($password)) {
    $empty_msg = true;

  }
}
$passwordHash = md5($password);
$errors = [];
if (!empty($email) && !empty($password)) {
  $sql = "SELECT user_first_name,user_last_name,user_email,user_country_name,
user_state_name,user_city_name,user_street_address,user_phone,user_password,
user_role_id,user_gender FROM `em_users` WHERE user_email='$email' AND (user_password='$password' OR user_password='$passwordHash') AND user_deletedAt is null";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);
  if ($row) {
    // echo "good";
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    // $_SESSION['user_firstname']=$firstname;
    header("location:./dashboard/?sort=month");
  } else {
    $err_msg = true;
    $errors['err'] = "Invalid email or password";
  }}
// } else {
//   $err_msg = true;
//   // $errors['err'] = "Enter email or password";
// }
// $result=mysqli_query($con,$sql);
// while($row=mysqli_fetch_array($result)){
//   echo "success";
// }
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>

  <!-- Bootstrap -->
  <link href="./css/dashboard.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style>
    /* span {
      font-size: 11px;
      color: red;
    } */

    .signup {
      font-size: 15px;
      display: inline-flex;
      gap: 10px;
      padding: 3px;
      margin-top: 10px;
    }

    .box {
      height: 360px;
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
    .req{
      color: red;
    }
    .forget{
      font-size: 13px;
      float: right;
      /* right: 0px; */
    }
    #pass-error,#email-error{
        font-size: 10px;
        color: red;
        margin: 0px 0px 5px 5px ;
    }
  </style>
</head>

<body>
  <div class="login_section">
    <div class="wrapper relative">
      <div style="display:none" class="meassage_successful_login">You have Successfull Edit </div>
      <div class="heading-top">
        <div class="logo-cebter"><a href="#"><img src="./images/at your service_banner.png"></a></div>
      </div>
      <div class="box">
        <div class="outer_div">
          <h2>Admin <span>Login</span></h2>
          <?php
          if ($err_msg === true) {
            echo "<div class='error-message-div error-msg' ><img src='./images/unsucess-msg.png'><strong>Invalid!</strong> Email
            or password. </div>";
          }
          if ($empty_msg === true) {
            echo "<div class='error-message-div error-msg' ><img src='./images/unsucess-msg.png'><strong>ERROR!</strong> Please Enter Email
            and Password. </div>";
          }
          ?>

          <form method="POST" class="margin_bottom" role="form" autocomplete="on" onsubmit="return validateForm()" >
            <div class="form-group">
              <label for="exampleInputEmail1">Email <span class="req">*</span></label>
              <input type="text" name="email" id="email" class="form-control" value=<?php echo $_POST['email']; ?>>
              <span id="email-error" ></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password <span class="req">*</span></label>
              <input type="password" id="pass" class="form-control" name="password" value=<?php echo $_POST['password']; ?>>
              <span id="pass-error" ></span>
              <!-- <span><?php #echo isset($errors['err']) ? $errors['err'] : ""; ?></span><br> -->
              <a class="forget" href="./forgotPassword">Forgot Password</a>
            </div>

            <input type="submit" class="btn_login" value="Login" name="submit">
            <!-- <button type="submit"  value="submit">Login</button> -->
          </form>
          <div class="signup">
            <p>New User?</p>
            <a href="./signup">Signup</a>
          </div><br><br>
        </div>
      </div>
    </div><script>
      function validateForm() {
        // console.log('rj4rgh');
        let isValid = true;
        let email = document.getElementById('email').value; 
        let pass = document.getElementById('pass').value;
        document.getElementById('email-error').innerHTML = "";
        document.getElementById('pass-error').innerHTML = "";
        if (email == '') {
          document.getElementById('email-error').innerHTML = "Please enter email.";
          isValid = false;
        }
        if (pass == '') {
          document.getElementById('pass-error').innerHTML = "Please enter password.";
          isValid = false;
        }
        return isValid;
      }
    </script>
</body>

</html>