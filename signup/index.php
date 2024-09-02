<?php
include '../connect.php';
include '../passwordEmail/index.php';
session_start();
if (!empty($_SESSION['email']) && !empty($_SESSION['password'])) {
  header('location:../dashboard/?sort=month');
}
// $session_email=$_SESSION['email'];
// $find_id="SELECT user_id FROM em_users WHERE user_email='$session_email'";
// $find_id_execute=mysqli_query($con,$find_id);
// if($find_id_execute){
//   while($row=mysqli_fetch_array($find_id_execute)){
//     $user_id=$row['user_id'];
//   }
// }
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$err_msg = false;
if (isset($_POST['submit'])) {
  $errors = [];
  if (empty($_POST['firstname'])) {
    $errors['fname'] = "Please Enter First Name.";
  } else {
    $user_firstname = $_POST['firstname'];
  }
  if (empty($_POST['lastname'])) {
    $errors['lastname'] = "Please Enter Last Name.";
  } else {
    $user_lastname = $_POST['lastname'];
  }
  if (empty($_POST['email'])) {
    $errors['email'] = "Please Enter Email.";
  } else {
    $user_email = $_POST['email'];
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Invalid Email Format.';
    } else {
      $sql_check = "SELECT user_email from `em_users` WHERE user_email='$user_email'";
      $result_check = mysqli_query($con, $sql_check);
      if (mysqli_num_rows($result_check) > 0) {
        $errors['email'] = "This Email already exists. Please enter different email.";
      }
    }
  }
  if (empty($_POST['phone'])) {
    $errors['phone'] = "Please Enter Phone Number.";
  } else {
    $user_phone = $_POST['phone'];
    if (strlen($user_phone) != 10) {
      $errors['phone'] = "Please Enter Valid Phone Number.";
    } else {
      $user_phone = $_POST['phone'];
    }
  }
  if (empty($_POST['password'])) {
    $errors['password'] = "Please Enter Password.";
  } else {
    $user_password = $_POST['password'];
    $pattern = '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()])(?=\S+$).{8,20}$/';
    if (!preg_match($pattern, $user_password)) {
      $errors['password'] = "Please add atleast one uppercase, one lowercase, one digit, 
        one special character and it must be atleast 8 characters long.";
    } else {
      $user_password = $_POST['password'];
      $user_password = md5($user_password);
    }
  }
  if (empty($_POST['confirm'])) {
    $errors['confirm'] = "Please confrim Password.";
  } else {
    $user_confirm = $_POST['confirm'];
    $user_confirm = md5($user_confirm);
    if ($user_confirm != $user_password) {
      $errors['confirm'] = "Password must be same.";
    } else {
      $user_confirm = $_POST['confirm'];
      $user_confirm = md5($user_confirm);
    }
    // $pattern = '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()])(?=\S+$).{8,20}$/';
    // if (!preg_match($pattern, $user_password)) {
    //     $errors['password'] = "Please add atleast one uppercase, one lowercase, one digit, 
    //     one special character and it must be atleast 8 characters long";
    // } else {
    //     $user_password = $_POST['password'];
    //     $user_password=md5($user_password);
    // }
  }
  if (empty($_POST['address'])) {
    $errors['address'] = "Please Enter Address.";
  } else {
    $user_street_address = $_POST['address'];
  }
  if (empty($_POST['gender'])) {
    $errors['gender'] = "Please Choose Gender.";
  } else {
    $gender = $_POST['gender'];
  }
  if (empty($_POST['country'])) {
    $errors['country'] = "Please Select Country.";
  }
  if ($_POST['country'] == "select") {
    $errors['country'] = "Please Select Country.";
  } else {
    $user_country_id = $_POST['country'];
    $sql = "SELECT country_id,country_name FROM `em_countries` WHERE country_id='$user_country_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $user_country_id = $row['country_name'];
  }
  if (empty($_POST['city'])) {
    $errors['city'] = "Please Select City.";
  }
  if ($_POST['city'] == "select") {
    $errors['city'] = "Please Select City.";
  } else {
    $user_city_id = $_POST['city'];
    $sql = "SELECT city_id,city_name FROM `em_cities` WHERE city_id='$user_city_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $user_city_id = $row['city_name'];
  }
  if (empty($_POST['state'])) {
    $errors['state'] = "Please Select state.";
  }
  if ($_POST['state'] == "select") {
    $errors['state'] = "Please Select State.";
  } else {
    $user_state_id = $_POST['state'];
    $sql = "SELECT state_id,state_name FROM `em_states` WHERE state_id='$user_state_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $user_state_id = $row['state_name'];
  }
  if (empty($errors)) {
    $sql = "INSERT INTO `em_users` (user_first_name,user_city_name,user_state_name,user_gender,user_last_name,user_email,user_phone,user_password,user_street_address,user_country_name,user_role_id,Active_status)
VALUES ('$user_firstname','$user_city_id','$user_state_id','$gender','$user_lastname','$user_email','$user_phone','$user_password','$user_street_address','$user_country_id','1','Active')";
    $res = mysqli_query($con, $sql);
    if ($res) {
      // $_SESSION['email'] = $user_email;
      // $_SESSION['password'] = $user_password;
      sendPasswordEmail($user_firstname, $user_email,"","",'signup','Successful SignUp');
      header('location:../');
    }
  } else {
    $err_msg = true;
  }
}

// function sendSignUp($get_name, $get_email)
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
//     $mail->Subject = 'Successful SignUp';

//     $mail->Body = "
//     <h2>Hello $get_name</h2>
//     <h3>Yor are successfully signed up.</h3>
//     <h3>Welcome to our community.</h3>
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
    /* *{
      height: 800px;
    } */
    .validate {
      font-size: 12px;
      color: red;
      padding-left: 10px;
      /* height: 10px; */
      /* position: absolute; */
      /* top: 5px; */
      /* padding-bottom: 10px; */
    }

    .req {
      color: red;
    }

    .signin {
      font-size: 15px;
      display: inline-flex;
      gap: 10px;
      padding: 5px;
      margin-top: 20px;
    }

    .box {
      /* height: 1150px; */
      width: 60%;
    }

    .form-control {
      padding: 6px 12px;
      height: 30px;
    }

    .btn_sigin {
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
    }

    .btn_sigin a {
      color: white;
    }

    .form-group-select {
      float: left;
      margin-bottom: 15px;
      /* width: 100%; */
    }

    .select-sign {
      float: left;
      margin-right: 14px;
      /* width: 162px; */
      width: 100%;
    }

    #message {
      display: none;
      background: #f1f1f1;
      color: #000;
      position: absolute;
      left: 325px;
      bottom: 350px;
      width: 250px;
      height: 20px;
      font-weight: bold;
      /* padding: 2px; */
      /* margin-top: 10px; */
    }

    #message p {
      /* padding: 10px 35px; */
      background: #f1f1f1;
      padding: 2px;
      font-size: 10px;
    }

    .valid {
      padding: 5px;
      color: green;
    }

    .valid:before {
      padding-left: 5px;
      background: #f1f1f1;
      position: relative;
      right: 5px;
      content: "✔";
    }

    .invalid {
      color: red;
    }

    .invalid:before {
      padding-left: 5px;
      background: #f1f1f1;
      position: relative;
      right: 5px;
      /* left: -35px; */
      content: "✖";
    }
    .left-arrow {
            width: 0;
            height: 0;
            right: 250px;
            top: 30px;
            position: absolute;
            border-top: 15px solid transparent;
            border-bottom: 15px solid transparent;
            border-right: 15px solid #f2f2f2;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
  </style>
</head>

<body>
  <div class="login_section" style="height: 600px;padding: 30px;">
    <div class="wrapper">
      <div style="display:none" class="meassage_successful_login">You have Successfull Edit </div>
      <div class="heading-top">
        <div class="logo-cebter"><a href="#"><img src="../images/at your service_banner.png"></a></div>
      </div>
      <div class="box" style="overflow-y:scroll; height: 750px;">
        <div class="outer_div">
          <h2>Admin <span>Signup</span></h2>
          <?php
          if ($err_msg) {
            echo "<div class='error-message-div error-msg'><img src='../images/unsucess-msg.png'><strong>Invalid!</strong> Please enter all the details correctly. </div>";
          }
          ?>
          <div id="error_msg" style="display: none;" class='error-message-div error-msg'><img
              src='../images/unsucess-msg.png'><strong>Invalid!</strong> Please
            enter all the details correctly </div>
          <form class="margin_bottom" role="form" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
              <label for="exampleInputEmail1">First Name <span class="req">*</span></label>
              <input type="text" id="firstName" name="firstname" class="form-control" value=<?php echo $_POST['firstname']; ?>><br><br>
              <p class="validate" id="firstName_error"><?php echo isset($errors['fname']) ? $errors['fname'] : ""; ?>
              </p>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Last Name <span class="req">*</span></label>
              <input type="text" id="lastName" name="lastname" class="form-control" value=<?php echo $_POST['lastname']; ?>><br><br>
              <p class="validate" id="lastName_error">
                <?php echo isset($errors['lastname']) ? $errors['lastname'] : " "; ?>
              </p>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email <span class="req">*</span></label>
              <input type="email" id="email" name="email" class="form-control" value=<?php echo $_POST['email']; ?>><br><br>
              <span class="validate"
                id="email_error"><?php echo isset($errors['email']) ? $errors['email'] : " "; ?></span>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Phone <span class="req">*</span></label>
              <input type="number" id="phone" name="phone" class="form-control" value=<?php echo $_POST['phone']; ?>><br><br>
              <span class="validate"
                id="phone_error"><?php echo isset($errors['phone']) ? $errors['phone'] : " "; ?><br></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Enter Password <span class="req">*</span></label>
              <input type="password" id="password" name="password" class="form-control" value=<?php echo $_POST['password']; ?>><br><br>
              <span class="validate"
                id="password_error"><?php echo isset($errors['password']) ? $errors['password'] : " "; ?></span>
            </div>
            <div id="message">
              <h5>Password must contain the following:</h5>
              <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
              <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
              <p id="number" class="invalid">A <b>number</b></p>
              <p id="character" class="invalid">A <b>special character</b></p>
              <p id="length" class="invalid">Minimum <b>8 characters</b></p>
              <div class="left-arrow" ></div>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Confirm Password <span class="req">*</span></label>
              <input type="password" id="confirm" name="confirm" class="form-control" value=<?php echo $_POST['confirm']; ?>><br><br>
              <span class="validate"
                id="confirm_error"><?php echo isset($errors['confirm']) ? $errors['confirm'] : " "; ?></span>
            </div>
            <div class="form-group">
              <div class="form-group" style="display: flex;">
                <label for="exampleInputPassword1">Gender: <span class="req">*</span></label>
                <label><input type="radio" id="male" checked value="Male" name="gender"> Male</label>
                <label><input type="radio" id="female" value="Female" name="gender"> Female</label>
              </div>
              <span class="validate"
                id="gender_error"><?php echo isset($errors['gender']) ? $errors['gender'] : " "; ?></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Enter Address <span class="req">*</span></label>
              <input type="text" id="address" name="address" class="form-control" value=<?php echo $_POST['address']; ?>><br><br>
              <span class="validate"
                id="address_error"><?php echo isset($errors['address']) ? $errors['address'] : " "; ?></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Select Country <span class="req">*</span></label>
              <div class="select">
                <select style="width: 300px;" name="country" id="ctr" onclick="fetch_state()">
                  <option value="select">Select Country</option>
                  <?php
                  $sql = "SELECT country_name,country_id FROM `em_countries`";
                  $result = mysqli_query($con, $sql);
                  while ($row = mysqli_fetch_assoc($result)) {
                    $country_name = $row['country_name'];
                    $country_id = $row['country_id'];
                    echo '<option value="' . $country_id . '" ';
                    if ($user_country_id === $country_name) {
                      echo 'selected="selected"';
                    }
                    echo '>' . $country_name . '</option>';
                  }
                  ?>
                </select>
              </div><br><br><br>
              <p class="validate" id="country_error"><?php echo isset($errors['country']) ? $errors['country'] : " "; ?>
              </p>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Select State <span class="req">*</span></label>
              <div class="select">
                <select style="width: 300px;" disabled name="state" id="ste" onclick="fetch_city()">
                  <option value="select">Select State</option>
                  <?php
                  // $state_name=$_POST['state'];
                  if (!empty($_POST['state'])) {
                  //   echo '<option value="' . $state_id . '" ';
                  //   if ($user_state_id == $state_name) {
                  //     echo 'selected="selected"';
                  //   }
                  //   echo '>' . $state_name . '</option>';
                    echo '<option selected >'.$user_state_id.'</option>';
                    
                  }
                  ?>
                  <!-- <script>
                    let state=document.getElementById('ste').value;
                    if(state!="select"){
                      document.getElementById('ste').removeAttribute('disabled');
                      document.getElementById('ste').value=state;
                    }
                    </script> -->
                </select>
              </div><br><br><br>
              <p class="validate" id="state_error"><?php echo isset($errors['state']) ? $errors['state'] : " "; ?></p>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Select City <span class="req">*</span></label>
              <div class="select">
                <select style="width: 300px;" disabled name="city" id="city">
                  <option value="select">Select City</option>
                  <?php
                  // $state_name=$_POST['state'];
                  if (!empty($_POST['city'])) {
                    // echo '<option value="' . $state_id . '" ';
                    // if ($user_state_id == $state_name) {
                    //   echo 'selected="selected"';
                    // }
                    // echo '>' . $state_name . '</option>';
                    echo '<option selected >'.$user_city_id.'</option>';
                  }
                  ?>
                </select>
              </div><br><br><br>
              <p class="validate" id="city_error"><?php echo isset($errors['city']) ? $errors['city'] : " "; ?></p>
            </div>
            <input type="submit" class="btn_login" value="Signup" name="submit">
            <!-- <button type="submit" class="btn_login" name="submit">Login</button> -->
          </form>
          <div class="signin">
            <p>Already a user?</p>
            <a href="../">Sign In</a>
          </div><br><br>
        </div>
      </div>
    </div>
    <script>
      // function to fetch state
      function fetch_state() {
        const country_id = document.getElementById('ctr').value;
        if (typeof (country_id) === "number") {
          document.getElementById('ste').removeAttribute("disabled");
        }
        else {
          document.getElementById('ste').setAttribute("disabled", true);
          document.getElementById('city').setAttribute("disabled", true);
        }
        // document.getElementById('ste').removeAttribute("disabled");
        console.log(country_id);
        const requestOptions = {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            country_id: country_id
          }),
          redirect: 'follow'
        };

        fetch("../getData.php/", requestOptions)
          .then(response => {

            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
              return response.json();
            } else {
              throw new Error('Response is not JSON');
            }
          })
          .then(result => {
            const countrySelect = document.getElementById('ste');
            countrySelect.innerHTML = '';
            result.forEach(element => {
              let option = document.createElement('option');
              option.textContent = element.state_name;
              option.value = element.state_id;
              countrySelect.appendChild(option);
              option = null
            });
            countrySelect.removeAttribute('disabled')
          }
          )
          .catch(error => console.log('error', error));
      }
      // function to fetch city

      function fetch_city() {
        const state_id = document.getElementById('ste').value;
        if (typeof (state_id) === "number") {
          document.getElementById('city').removeAttribute("disabled");
        } else {
          document.getElementById('city').setAttribute("disabled", true);
        }
        // document.getElementById('city').removeAttribute("disabled");
        console.log(state_id);

        const requestOptions = {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            state_id: state_id
          }),
          redirect: 'follow'
        };
        fetch("../getDataCity.php/", requestOptions)
          .then(response => {

            if (!response.ok) {
              throw new Error('Network response was not ok');
            }

            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
              return response.json();
            } else {
              throw new Error('Response is not JSON');
            }
          })
          .then(result => {
            const stateSelect = document.getElementById('city');
            stateSelect.innerHTML = '';
            result.forEach(element => {
              let option = document.createElement('option');
              option.textContent = element.city_name;
              option.value = element.city_id;
              stateSelect.appendChild(option);
              option = null
            });
            stateSelect.removeAttribute('disabled')
          }
          )
          .catch(error => console.log('error', error));
      }
      function validateForm() {
        let isValid = true;
        // document.getElementById('error_msg').style.display="block";
        let firstName = document.getElementById('firstName').value;
        let lastName = document.getElementById('lastName').value;
        let phone = document.getElementById('phone').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let country = document.getElementById('ctr').value;
        let state = document.getElementById('ste').value;
        let city = document.getElementById('city').value;
        let confirm = document.getElementById('confirm').value;
        // let role = document.getElementById('role').value;
        let address = document.getElementById('address').value;
        // let gender = document.getElementsByName('gender');
        let gender_val;
        if (!document.getElementById('male').checked && !document.getElementById('female').checked) {
          gender_val = false;
        } else {
          gender_val = true;
        }
        var pass_pattern = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()])(?=\S+$).{8,20}$/;
        var email_pattern = /[A-Za-z0-9\._%+\-]+@[A-Za-z0-9\.\-]+\.[A-Za-z]{2,}/;
        document.getElementById("firstName_error").innerHTML = "";
        document.getElementById("lastName_error").innerHTML = "";
        document.getElementById("email_error").innerHTML = "";
        document.getElementById("phone_error").innerHTML = "";
        document.getElementById("country_error").innerHTML = "";
        document.getElementById("state_error").innerHTML = "";
        document.getElementById("city_error").innerHTML = "";
        document.getElementById("gender_error").innerHTML = "";
        document.getElementById("confirm_error").innerHTML = "";
        document.getElementById("password_error").innerHTML = "";
        document.getElementById("address_error").innerHTML = "";
        if (firstName == "") {
          document.getElementById("firstName_error").innerHTML = "Please enter First Name.";
          // document.getElementById('box').style.height='10px';
          document.getElementById('error_msg').style.display = "block";
          isValid = false;

        }
        if (lastName == "") {
          document.getElementById("lastName_error").innerHTML = "Please Enter Last Name.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        }
        // if (role == "selectRole") {
        //     document.getElementById("role_error").innerHTML = "Enter role";
        //     isValid = false;
        // }
        if (country == "select") {
          document.getElementById("country_error").innerHTML = "Please Select Country.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        }
        if (city == "select") {
          document.getElementById("city_error").innerHTML = "Please Select City.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        }
        if (state == "select") {
          document.getElementById("state_error").innerHTML = "Please Select State.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        }
        if (address == "") {
          document.getElementById("address_error").innerHTML = "Please Enter Address.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        }
        if (gender_val == false) {
          document.getElementById("gender_error").innerHTML = "Please Select Gender.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        }
        if (phone == "") {
          document.getElementById("phone_error").innerHTML = "Please Enter Mobile Number.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        } else if (phone.length != 10) {
          document.getElementById("phone_error").innerHTML = "Please Enter Valid Mobile Number.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        }
        if (email == "") {
          document.getElementById("email_error").innerHTML = "Please Enter Email.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        } else if (!email.match(email_pattern)) {
          document.getElementById("email_error").innerHTML = "Please Enter Valid Email.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        }
        if (password == "") {
          document.getElementById("password_error").innerHTML = "Please Enter Password.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        } else if (!password.match(pass_pattern)) {
          document.getElementById("password_error").innerHTML = "Please enter valid password"
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        }
        // if (confirm == "") {
        //     document.getElementById("confrim_error").innerHTML = "confirm password";
        //     isValid = false;
        // }
        if (confirm != password) {
          document.getElementById("confrim_error").innerHTML = "Password must be same.";
          document.getElementById('error_msg').style.display = "block";
          isValid = false;
        }
        return isValid;
      }

      var myInput = document.getElementById("password");
      var letter = document.getElementById("letter");
      var capital = document.getElementById("capital");
      var number = document.getElementById("number");
      var length = document.getElementById("length");
      var char = document.getElementById("character");

      myInput.onfocus = function () {
        document.getElementById("message").style.display = "block";
      }

      myInput.onblur = function () {
        document.getElementById("message").style.display = "none";
      }

      myInput.onkeyup = function () {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
          letter.classList.remove("invalid");
          letter.classList.add("valid");
        } else {
          letter.classList.remove("valid");
          letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
          capital.classList.remove("invalid");
          capital.classList.add("valid");
        } else {
          capital.classList.remove("valid");
          capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
          number.classList.remove("invalid");
          number.classList.add("valid");
        } else {
          number.classList.remove("valid");
          number.classList.add("invalid");
        }
        // validate characters
        var chars = /[@#$%^&-+=()]/g;
        if (myInput.value.match(chars)) {
          char.classList.remove("invalid");
          char.classList.add("valid");
        } else {
          char.classList.remove("valid");
          char.classList.add("invalid");
        }
        // Validate length
        if (myInput.value.length >= 8) {
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