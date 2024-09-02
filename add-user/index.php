<?php
include '../connect.php';
session_start();
if (empty($_SESSION['email']) && empty($_SESSION['password'])) {
    header('location:../');
}
$email = $_SESSION['email'];
// echo "$email";
// $password=$_SESSION['password'];
$sql = "SELECT user_first_name,user_last_name,user_email,user_country_name,
user_state_name,user_city_name,user_street_address,user_phone,user_password,
user_role_id,user_gender FROM em_users WHERE user_email='$email'";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
    $user_firstname = $row['user_first_name'];
    $user_firstname = ucfirst($user_firstname);
    $user_role_id = $row['user_role_id'];
    if ($user_role_id != 3 && $user_role_id != 4) {
        header('location:../dashboard/?sort=month');
    }
    // $admin=$row['is_Admin'];
}
if (isset($_POST['Submit'])) {
    // $user_firstname = $_POST['fname'];
    // $user_lastname = $_POST['lname'];
    // $user_email = $_POST['email'];
    // $role_name = $_POST['role_name'];
    // $user_phone = $_POST['phone'];
    // $user_country_id = $_POST['country'];
    // $is_admin = $_POST['is_admin'];
    // $user_password = $_POST['password'];
    // $user_street_address = $_POST['address'];
    // echo "$user_city_id";
    $errors = [];
    if (empty($_POST['role_name'])) {
        $errors['role_name'] = 'Role is Required';
    } else {
        $role_name = $_POST['role_name'];
    }
    if (empty($_POST['fname'])) {
        $errors['fname'] = 'Please Enter First Name.';
    } else {
        $user_firstname = $_POST['fname'];
    }
    if (empty($_POST['lname'])) {
        $errors['lname'] = 'Please Enter Last Name.';
    } else {
        $user_lastname = $_POST['lname'];
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'Please Enter Email.';
    } else {
        $user_email = $_POST['email'];
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid Email Format';
        } else {
            $sql_check = "SELECT user_email from `em_users` WHERE user_email='$user_email'";
            $result_check = mysqli_query($con, $sql_check);
            if (mysqli_num_rows($result_check) > 0) {
                $errors['email'] = "This email already exists. Please enter another email.";
            }
        }
    }
    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Please Enter Phone Number.';
    } else {
        $user_phone = $_POST['phone'];
    }
    if (empty($_POST['country'])) {
        $errors['country'] = "Please select country.";
    }
    if ($_POST['country'] === 'select') {
        $errors['country'] = "Please select country.";
    } else {
        $user_country_id = $_POST['country'];
        $sql = "SELECT country_id,country_name FROM `em_countries` WHERE country_id='$user_country_id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $user_country_id = $row['country_name'];
    }
    if (empty($_POST['address'])) {
        $errors['address'] = "Please Enter Address.";
    } else {
        $user_street_address = $_POST['address'];
    }
    if (empty($_POST['password'])) {
        $errors['password'] = "Please Enter Password.";
    } else {
        $user_password = $_POST['password'];
        $pattern = '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()])(?=\S+$).{8,20}$/';
        if (!preg_match($pattern, $user_password)) {
            $errors['password'] = "Please Enter Valid Password.";
        } else {
            $user_password = $_POST['password'];
            $user_password = md5($user_password);
        }
    }
    if (empty($_POST['city'])) {
        $errors['city'] = "Please select city.";
    }
    if ($_POST['city'] === 'select') {
        $errors['city'] = "Please select city.";
    } else {
        $user_city_id = $_POST['city'];
        $sql = "SELECT city_id,city_name FROM `em_cities` WHERE city_id='$user_city_id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $user_city_id = $row['city_name'];
    }
    // if (empty($_POST['is_admin'])) {
    //     $errors['is_admin'] = "Please choose admin";
    // } else {
    //     $is_admin = $_POST['is_admin'];
    // }
    if (empty($_POST['gender'])) {
        $errors['gender'] = "Please select gender.";
    } else {
        $gender = $_POST['gender'];
    }
    if (empty($_POST['state'])) {
        $errors['state'] = "Please select state.";
    }
    if ($_POST['state'] === 'select') {
        $errors['state'] = "Please select state.";
    } else {
        $user_state_id = $_POST['state'];
        $sql = "SELECT state_id,state_name FROM `em_states` WHERE state_id='$user_state_id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $user_state_id = $row['state_name'];
    }
    if (empty($errors)) {
        $sql = "SELECT role_id,role_name FROM `em_roles` WHERE role_name='$role_name'";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $role_id = $row['role_id'];
            $role_name = $row['role_name'];
            $role_slug = $row['role_slug'];
            $sql1 = "INSERT INTO `em_users` (user_role_id,user_gender,user_state_name,user_city_name,user_first_name,user_last_name,user_email,user_phone,user_password,user_street_address,user_country_name,Active_status)
        VALUES ('$role_id','$gender','$user_state_id','$user_city_id','$user_firstname','$user_lastname','$user_email','$user_phone','$user_password','$user_street_address','$user_country_id','Active')";
            $res = mysqli_query($con, $sql1);
            if ($res) {
                echo "success";
                header('location:../list-users/?sort=user_createdAt&search_val=&page=1');
            } else {
                echo "error";
            }
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .php_validate {
            font-size: 12px;
            color: red;
            text-align: center;
            margin-left: 100px;
            /* vertical-align: bottom; */
            margin-left: 10px;
        }

        #firstName_error,
        #lastName_error,
        #email_error,
        #phone_error,
        #address_error,
        #country_error,
        #gender_error,
        #state_error,
        #city_error,
        #password_error {
            margin-left: 230px;
        }

        #message {
            display: none;
            background: #f1f1f1;
            color: #000;
            position: absolute;
            left: 475px;
            bottom: 100px;
            width: 250px;
            height: 20px;
            font-weight: bold;
            padding-left: 3px;
            /* margin-top: 10px; */
        }

        #message p {
            /* padding: 10px 35px; */
            background: #f1f1f1;
            padding: 2px;
            font-size: 10px;
        }

        .valid {
            color: green;
        }

        .valid:before {
            background: #f1f1f1;
            position: relative;
            padding-left: 5px;
            right: 5px;
            content: "✔";
        }

        .invalid {
            color: red;
        }

        .invalid:before {
            background: #f1f1f1;
            position: relative;
            right: 5px;
            padding-left: 5px;
            content: "✖";
        }

        .left-arrow {
            width: 0;
            height: 0;
            right: 250px;
            top: 30px;
            position: absolute;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-right: 10px solid #f2f2f2;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        #activeLink{
			background-color: #214139;
		 }
    </style>
</head>

<body>
    <div class="header">
        <div class="wrapper">
            <div class="logo"><a href="#"><img src="../images/logo.png"></a></div>


            <div class="right_side">
                <ul>
                    <li>Welcome <?php echo $user_firstname; ?></li>
                    <li><a href="../logout">Log Out</a></li>
                </ul>
            </div>
            <div class="nav_top">
                <ul>
                    <li><a href=" ../dashboard/?sort=month ">Dashboard</a></li>
                    <li class="active"><a href=" ../list-users/ ">Users</a></li>
                    <li><a href=" ../showProfile">My Profile</a></li>
                </ul>

            </div>
        </div>
    </div>

    <div class="clear"></div>
    <div class="clear"></div>
    <div class="content">
        <div class="wrapper">
            <div class="bedcram">
                <ul>
                    <li><a href="../dashboard/?sort=month">Home</a></li>
                    <li><a href="../list-users">List Users</a></li>
                    <li>Add Users</li>
                </ul>
            </div>
            <div class="left_sidebr">
				<ul>
					<li><a href="../dashboard/?sort=month" class="dashboard">Dashboard</a></li>
					<li><a href="../list-users " id="activeLink" class="user">Users</a>
                    <ul class="submenu">
							<li><a  href="../list-users">List Users</a></li>
							<li><a href="../add-user">Add Users</a></li>
							<li><a href="#">Edit User</a></li>
						</ul>
					</li>
					<li><a href="../showProfile" class="Setting">My Profile</a>
						<!-- <ul class="submenu">
							<li><a href="">Change Password</a></li>
							<li><a href="">Manage Contact Request</a></li>
							<li><a href="#">Manage Login Page</a></li>

						</ul> -->

					</li>
					<!-- <li><a href="" class="social">Configuration</a>
						<ul class="submenu">
							<li><a href="">Payment Settings</a></li>
							<li><a href="">Manage Email Content</a></li>
							<li><a href="#">Manage Limits</a></li>
						</ul>

					</li> -->
				</ul>
			</div>
            <div class="right_side_content">
                <h1>Add Users</h1>
                <div class="list-contet">
                    <div class="error-message-div error-msg" id="error_msg" style="display: none;"><img
                            src="../images/unsucess-msg.png"><strong>Invalid!</strong> Please enter correct Details</div>
                    <form class="form-edit" method="POST" autocomplete="off" onsubmit="return validateForm()">
                        <!-- <div class="form-row">
              <div class="form-label">
                <label>User Name : <span></span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="username" placeholder="Enter Username" />
              </div>
            </div> -->
                        <div class="form-row">
                            <div class="form-label">
                                <label>First Name : <span>*</span></label>
                            </div>
                            <div class="input-field">
                                <input type="text" class="search-box" id="firstName" name="fname"
                                    placeholder="Enter First Name" value=<?php echo $_POST['fname']; ?>>
                            </div><span id="firstName_error"
                                class="php_validate"><?php echo isset($errors['fname']) ? $errors['fname'] : " "; ?></span>
                        </div>

                        <div class="form-row">
                            <div class="form-label">
                                <label>Last Name : <span>*</span></label>
                            </div>
                            <div class="input-field">
                                <input type="text" class="search-box" id="lastName" name="lname"
                                    placeholder="Enter Last Name" value=<?php echo $_POST['lname']; ?>>
                            </div><span class="php_validate"
                                id="lastName_error"><?php echo isset($errors['lname']) ? $errors['lname'] : " "; ?></span>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <label>Email: <span>*</span></label>
                            </div>
                            <div class="input-field">
                                <input type="email" class="search-box" id="email" name="email" placeholder="Enter Email"
                                    value=<?php echo $_POST['email']; ?>>
                            </div><br><span class="php_validate"
                                id="email_error"><?php echo isset($errors['email']) ? $errors['email'] : " "; ?></span>
                        </div>
                        <!-- <div class="form-row">
              <div class="form-label">
                <label>Security Email: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="semail" placeholder="Enter Security Email" />
              </div>
            </div> -->
                        <!-- <div class="form-row">
              <div class="form-label">
                <label>Time Lag: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="timelag" placeholder="9" />
              </div>
            </div> -->
                        <div class="form-row">
                            <div class="form-label">
                                <label>Role type: <span>*</span> </label>

                            </div>
                            <div class="input-field">
                                <div class="select">
                                    <select id="role" name="role_name">
                                        <option value="Developer" <?php if ($_POST['role_name'] === 'Developer')
                                            echo 'selected="selected"'; ?>>Developer</option>
                                        <option value="Sr. Developer" <?php if ($_POST['role_name'] === 'Sr. Developer')
                                            echo 'selected="selected"'; ?>>Sr. Developer</option>
                                        <option value="Team Lead" <?php if ($_POST['role_name'] === 'Team Lead')
                                            echo 'selected="selected"'; ?>>Team Lead</option>
                                        <option value="Manager" <?php if ($_POST['role_name'] === 'Manager')
                                            echo 'selected="selected"'; ?>>Manager</option>
                                        <option value="CEO" <?php if ($_POST['role_name'] === 'CEO')
                                            echo 'selected="selected"'; ?>>CEO</option>
                                        <option value="BDE" <?php if ($_POST['role_name'] === 'BDE')
                                            echo 'selected="selected"'; ?>>BDE</option>
                                        <option value="CTO" <?php if ($_POST['role_name'] === 'CTO')
                                            echo 'selected="selected"'; ?>>CTO</option>
                                        <option value="Office Boy" <?php if ($_POST['role_name'] === 'Office Boy')
                                            echo 'selected="selected"'; ?>>Office Boy</option>
                                        <option value="Tester" <?php if ($_POST['role_name'] === 'Tester')
                                            echo 'selected="selected"'; ?>>Tester</option>
                                        <option value="Analyst" <?php if ($_POST['role_name'] === 'Analyst')
                                            echo 'selected="selected"'; ?>>Analyst</option>
                                        <?php
                                        // $sql_role = "SELECT * FROM employee_roles";
                                        // $roles = mysqli_query($con, $sql_role);
                                        // while ($row = mysqli_fetch_assoc($roles)) {
                                        //     $role = $row['role_name'];
                                        //     echo "<option value=$role>$role</option>";
                                        // }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-row radio-row">
                            <div class="form-label">
                                <label>Zero Knowledge: <span></span> </label>
                            </div>
                            <div class="input-field">
                                <label><input type="radio" name="zeroknow"> <span>Yes </span></label><label> <input
                                        type="radio" name="zeroknow"> <span>No</span> </label>
                            </div>
                        </div> -->
                        <div class="form-row">
                            <div class="form-label">
                                <label>Phone: <span>*</span> </label>
                            </div>
                            <div class="input-field">
                                <input type="number" id="phone" class="search-box" name="phone"
                                    placeholder="Enter Phone" value=<?php echo $_POST['phone']; ?>>
                            </div><br><span class="php_validate"
                                id="phone_error"><?php echo isset($errors['phone']) ? $errors['phone'] : " "; ?></span>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <label>Address : <span>*</span></label>
                            </div>
                            <div class="input-field">
                                <input type="text" id="address" class="search-box" name="address"
                                    placeholder="Enter Address" value=<?php echo $_POST['address']; ?>>
                            </div><br><span class="php_validate"
                                id="address_error"><?php echo isset($errors['address']) ? $errors['address'] : " "; ?></span>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <label>Country: <span>*</span> </label>
                            </div>
                            <div class="input-field">
                                <div class="select">
                                    <select name="country" id="ctr" onclick="fetch_state()">
                                        <option value="select">Select Country</option>
                                        <?php
                                        $sql = "SELECT country_name,country_id FROM `em_countries`";
                                        $result = mysqli_query($con, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $country_name = $row['country_name'];
                                            $country_id = $row['country_id'];
                                            // echo "<option value='$country_id'>$country_name</option>";s
                                            echo '<option value="' . $country_id . '" ';
                                            if ($user_country_id === $country_name) {
                                                echo 'selected="selected"';
                                            }
                                            echo '>' . $country_name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><br><span class="php_validate"
                                id="country_error"><?php echo isset($errors['country']) ? $errors['country'] : " "; ?></span>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <label>State: <span>*</span> </label>
                            </div>
                            <div class="input-field">
                                <div class="select">
                                    <select disabled name="state" id="ste" onclick="fetch_city()">
                                        <option value="select">Select State</option>
                                        <?php
                                        if (!empty($_POST['state'])) {
                                            // echo '<option value="' . $state_id . '" ';
                                            // if ($user_state_id === $state_name) {
                                            //     echo 'selected="selected"';
                                            // }
                                            // echo '>' . $state_name . '</option>';
                                            echo "<option selected >$user_state_id</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div><br><span class="php_validate" id="state_error"><?php
                            echo isset($errors['state']) ? $errors['state'] : " ";
                            ?></span>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <label>City: <span>*</span> </label>
                            </div>
                            <div class="input-field">
                                <div class="select">
                                    <select disabled name="city" id="city">
                                        <option value="select">Select City</option>
                                        <?php
                                        if (!empty($_POST['city'])) {
                                            // echo '<option value="' . $city_id . '" ';
                                            // if ($user_city_id === $city_name) {
                                            //     echo 'selected="selected"';
                                            // }
                                            // echo '>' . $city_name . '</option>';
                                            echo "<option selected >$user_city_id</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div><br><span class="php_validate" id="city_error"><?php
                            echo isset($errors['city']) ? $errors['city'] : " ";
                            ?></span>
                        </div>
                        <!-- <div class="form-row radio-row">
                            <div class="form-label">
                                <label>Admin: <span>*</span> </label>
                            </div>
                            <div class="input-field">
                                <label><input type="radio" value="yes" name="is_admin"> <span>Yes </span></label>
                                <label><input type="radio" value="no" name="is_admin"> <span>No</span> </label>
                            </div><span
                                class="php_validate"><?php #echo isset($errors['is_admin']) ? $errors['is_admin'] : " "; ?></span>
                        </div> -->
                        <div class="form-row radio-row">
                            <div class="form-label">
                                <label>Gender: <span>*</span> </label>
                            </div>
                            <div class="input-field">
                                <label><input type="radio" checked <?php if ($_POST['gender'] == "Male")
                                    echo "checked='checked'" ?> id="male" value="Male" name="gender"> <span>Male </span></label>
                                    <label><input type="radio" <?php if ($_POST['gender'] == "Female")
                                    echo "checked='checked'" ?> id="female" value="Female" name="gender">
                                        <span>Female</span> </label>
                                </div><span class="php_validate"
                                    id="gender_error"><?php echo isset($errors['gender']) ? $errors['gender'] : " "; ?></span>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <label>Password: <span>*</span></label>
                            </div>
                            <div class="input-field">
                                <input type="password" id="password" class="search-box" name="password"
                                    placeholder="Enter Password" value=<?php echo $_POST['password']; ?>>
                            </div><br><span class="php_validate"
                                id="password_error"><?php echo isset($errors['password']) ? $errors['password'] : " "; ?></span>
                        </div>
                        <div id="message">
                            <h5>Password must contain the following:</h5>
                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                            <p id="number" class="invalid">A <b>number</b></p>
                            <p id="character" class="invalid">A <b>special character</b></p>
                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                            <div class="left-arrow"></div>
                        </div>
                        <!-- <div class="form-row">
                            <div class="form-label">
                                <label>Password: <span>*</span></label>
                            </div>
                            <div class="input-field">
                                <input type="checkbox" id="password" class="search-box" name="password" placeholder="Enter Password"
                                    value=<?php #echo $_POST['password']; ?>><label>I accept that the data is correct</label>
                            </div><br><span
                                class="php_validate" id="password_error" ><?php #echo isset($errors['password']) ? $errors['password'] : " "; ?></span>
                        </div> -->
                        <!-- <div style="text-align: center;" ><input type="checkbox" name="check">
                        <label for="check">I accept that data is correct</label></div> -->
                        <div class="form-row">
                            <div class="form-label">
                                <label><span></span> </label>
                            </div>
                            <div class="input-field">
                                <input type="submit" class="submit-btn" value="Submit" name="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer" style="position: static; bottom:0px;">
        <div class="wrapper">
            <p>Copyright © 2014 yourwebsite.com. All rights reserved</p>
        </div>

    </div>
    <script>
        function fetch_state() {
            const country_id = document.getElementById('ctr').value;
            if (typeof (country_id) === "number") {
                document.getElementById('ste').removeAttribute("disabled");
            }
            else {
                document.getElementById('ste').setAttribute("disabled", true);
                document.getElementById('city').setAttribute("disabled", true);
            }
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
            document.getElementById('error_msg').style.display = "block";
            let firstName = document.getElementById('firstName').value;
            let lastName = document.getElementById('lastName').value;
            let phone = document.getElementById('phone').value;
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let country = document.getElementById('ctr').value;
            let state = document.getElementById('ste').value;
            let city = document.getElementById('city').value;
            let role = document.getElementById('role').value;
            let address = document.getElementById('address').value;
            let gender = document.getElementsByName('gender');
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
            // document.getElementById("role_error").innerHTML = "";
            document.getElementById("password_error").innerHTML = "";
            document.getElementById("address_error").innerHTML = "";
            if (firstName == "") {
                document.getElementById("firstName_error").innerHTML = "Please Enter First Name.";
                isValid = false;
            }
            if (lastName == "") {
                document.getElementById("lastName_error").innerHTML = "Please Enter Last Name.";
                isValid = false;
            }
            // if (role == "selectRole") {
            //     document.getElementById("role_error").innerHTML = "Enter role";
            //     isValid = false;
            // }
            if (country == "select") {
                document.getElementById("country_error").innerHTML = "Please Select Country.";
                isValid = false;
            }
            if (city == "select") {
                document.getElementById("city_error").innerHTML = "Please Select city.";
                isValid = false;
            }
            if (state == "select") {
                document.getElementById("state_error").innerHTML = "Please Select State.";
                isValid = false;
            }
            if (address == "") {
                document.getElementById("address_error").innerHTML = "Please Enter Address.";
                isValid = false;
            }
            if (gender_val == false) {
                document.getElementById("gender_error").innerHTML = "Please Select Gender.";
                isValid = false;
            }
            if (phone == "") {
                document.getElementById("phone_error").innerHTML = "Please Enter Mobile Number.";
                isValid = false;
            } else if (phone.length != 10) {
                document.getElementById("phone_error").innerHTML = "Please Enter valid Mobile Number.";
                isValid = false;
            }
            if (email == "") {
                document.getElementById("email_error").innerHTML = "Please Enter Email.";
                isValid = false;
            } else if (!email.match(email_pattern)) {
                document.getElementById("email_error").innerHTML = "Please Enter Valid Email.";
                isValid = false;
            }
            if (password == "") {
                document.getElementById("password_error").innerHTML = "Please Enter Password.";
                isValid = false;
            } else if (!password.match(pass_pattern)) {
                document.getElementById("password_error").innerHTML = "Please Enter Valid Password."
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