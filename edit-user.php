<?php
include 'connect.php';
 ?>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="css/dashboard.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <div class="header">
    <div class="wrapper">
      <div class="logo"><a href="#"><img src="images/logo.png"></a></div>


      <div class="right_side">
        <ul>
          <li>Welcome</li>
          <li><a href="">Log Out</a></li>
        </ul>
      </div>
      <div class="nav_top">
        <ul>
          <li class="active"><a href=" home.php ">Dashboard</a></li>
          <li><a href=" settings.php ">Users</a></li>
          <li><a href=" agentloclist.php ">Setting</a></li>
          <li><a href=" geoloclist.php ">Configuration</a></li>
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
          <li><a href="#">Home</a></li>
          <li><a href="#">List Users</a></li>
          <li>Edit Users</li>
        </ul>
      </div>
      <div class="left_sidebr">
        <ul>
          <li><a href="" class="dashboard">Dashboard</a></li>
          <li><a href="" class="user">Users</a>
            <ul class="submenu">
              <li><a href="">Mange Users</a></li>

            </ul>

          </li>
          <li><a href="" class="Setting">Setting</a>
            <ul class="submenu">
              <li><a href="">Chnage Password</a></li>
              <li><a href="">Mange Contact Request</a></li>
              <li><a href="#">Manage Login Page</a></li>

            </ul>

          </li>
          <li><a href="" class="social">Configuration</a>
            <ul class="submenu">
              <li><a href="">Payment Settings</a></li>
              <li><a href="">Manage Email Content</a></li>
              <li><a href="#">Manage Limits</a></li>
            </ul>

          </li>
        </ul>
      </div>
      <div class="right_side_content">
        <h1>Edit Users</h1>
        <div class="list-contet">
          <div class="error-message-div error-msg"><img src="images/unsucess-msg.png"><strong>UnSucess!</strong> Your
            Message hasn't been Send </div>

          <form class="form-edit">
            <div class="form-row">
              <div class="form-label">
                <label>User Name : <span></span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="username" placeholder="Enter Username" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>First Name : <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="fname" placeholder="Enter First Name" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Last Name : <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="lname" placeholder="Enter Last Name" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Email: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="email" placeholder="Enter Email" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Security Email: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="semail" placeholder="Enter Security Email" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Time Lag: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="timelag" placeholder="9" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Registration type: <span></span> </label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="register" placeholder="Enter Registration Type" />
              </div>
            </div>
            <div class="form-row radio-row">
              <div class="form-label">
                <label>Zero Knowledge: <span></span> </label>
              </div>
              <div class="input-field">
                <label><input type="radio" name="zeroknow"> <span>Yes </span></label><label> <input type="radio"
                    name="zeroknow"> <span>No</span> </label>
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Phone: <span></span> </label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="phone" placeholder="Enter Phone" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Country: <span></span> </label>
              </div>
              <div class="input-field">
                <div class="select">
                  <select>
                    <option>India</option>
                    <option>Uk</option>
                    <option>Us</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-row radio-row">
              <div class="form-label">
                <label>Admin: <span></span> </label>
              </div>
              <div class="input-field">
                <label><input type="radio" name="is_admin"> <span>Yes </span></label><label> <input type="radio"
                    name="is_admin"> <span>No</span> </label>
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Password: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="password" class="search-box" name="password" placeholder="Enter Password" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label><span></span> </label>
              </div>
              <div class="input-field">
                <input type="submit" class="submit-btn" value="Save">
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
  <div class="footer">
    <div class="wrapper">
      <p>Copyright © 2014 yourwebsite.com. All rights reserved</p>
    </div>

  </div>

</body>

</html>