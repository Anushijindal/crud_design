<?php
include '../connect.php';
session_start();
if (empty($_SESSION['email']) && empty($_SESSION['password'])) {
    header('location:../');
}
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$passwordHash = md5($password);
$sql = "SELECT user_first_name,user_id,user_last_name,user_email,user_country_name,
user_state_name,user_city_name,user_street_address,user_phone,user_password,
user_role_id,user_gender,user_image FROM `em_users` WHERE user_email='$email'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$user_id = $row['user_id'];
$user_firstname = $row['user_first_name'];
$profilePic = $row['user_image'];
// echo $profilePic;
$user_lastname = $row['user_last_name'];
$gender = $row['user_gender'];
$user_email = $row['user_email'];
$user_country_id = $row['user_country_name'];
$user_state_id = $row['user_state_name'];
$user_city_id = $row['user_city_name'];
$user_phone = $row['user_phone'];
$user_street_address = $row['user_street_address'];
$user_role_id = $row['user_role_id'];
$get_role = "SELECT role_id,role_name FROM `em_roles` WHERE role_id='$user_role_id'";
$user_role = mysqli_query($con, $get_role);
if ($user_role) {
    $row = mysqli_fetch_array($user_role);
    $role_val = $row['role_name'];
}
// error_reporting(0);
// $msg = "";
// if (isset($_POST['submit'])) {/var/www/html/crud_design/showProfile

//     // echo "helloooo";

//     $filename = $_FILES["imageupload"]["name"];
//     // echo $filename;
//     $tempname = $_FILES["imageupload"]["tmp_name"];
//     echo "$filename";
//     // echo "efrwhrtuhit4";
//     echo "$tempname";
//     // $folder = "./userImages/".$filename;
//     $folder = "userImages/";
//     $target_file = $folder . basename($_FILES["imageupload"]["name"]);
//     echo "$folder";
//     // $uploadName=$filename.$user_id.$user_firstname;
//     // echo "$uploadName";
//     // $imgSql="INSERT INTO `em_users` (picture) VALUES ('$filename')";
//     $imgSql = "UPDATE `em_users` SET user_image = '$filename' WHERE user_id='$user_id'";
//     mysqli_query($con, $imgSql);
//     if (move_uploaded_file($tempname, $target_file)) {
//         $msg = "Image uploaded successfully";
//     } else {
//         $msg = "Failed to upload image";
//     }
//     echo "$msg";
// }
$img_path = null;
$default_img="../images/user.png";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile'])) {
    $upload_dir = '../userImages/';
    // Check if file was uploaded without errors
    if ($file['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['profile']['tmp_name'];
        $file_name = $_FILES['profile']['name'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        // Generate a unique name for the file
        $new_file_name = uniqid() . '.' . $file_extension;
        $dest_path = $upload_dir . $new_file_name;
        // Move the file to the img/ folder
        if (move_uploaded_file($file_tmp_path, $dest_path)) {
            // deleting the existing image from folder
            $check_image = "SELECT user_image FROM `em_users` WHERE user_id = '$user_id'";
            $check_image_execute = mysqli_query($con, $check_image);
            if ($check_image_execute) {
                while ($row = mysqli_fetch_array($check_image_execute)) {
                    $img = $row['user_image'];
                }
            }
            if ($img != null) {
                unlink("../userImages/$img");
            }
            // Prepare an SQL update query
            $sql1 = "UPDATE `em_users` SET user_image = '$new_file_name' WHERE user_id = '$user_id'";
            $result1 = mysqli_query($con, $sql1);
            // Execute the query
            if ($result1) {
                $image_path = $new_file_name;
                header("location:../showProfile");
            } else {
                echo "Error updating record: ";
            }
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Error uploading the file.";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <style>
        .php_validate {
            font-size: 12px;
            color: red;
            /* vertical-align: bottom; */
            margin-left: 10px;
        }

        .details {
            font-weight: normal;
            padding-left: 10px;

        }

        h4 {
            margin-bottom: 10px;
            letter-spacing: 1.2px;
            /* font-size: 12px; */
        }

        .user-details {
            margin: auto;
            padding-left: 100px;
            /* text-align: center; */
            width: 50%;
            font-size: 15px;
            /* border: 2px solid black ; */
        }

        #profile-image:hover {
            opacity: 0.8;
            /* color: black; */
        }

        .profile-pic {
            display: flex;
            justify-items: center;
            gap: 10px;
        }

        .profile-pic img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: block;
            margin: 0 0px 20px 40%;
        }

        #display-img {
            display: none;
            position: absolute;
            border-radius: 50%;
            width: 250px;
            height: 250px;
            /* position: fixed; */
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            text-align: center;
        }

        #exit {
            padding-bottom: 10px;
            padding-left: 300px;
            /* color: white; */
        }

        input[type='file'] {
            /* visibility: hidden; */
            display: none;
        }

        label {
            cursor: pointer;
            /* overflow: hidden; */
        }

        .submit-btn {
            padding: 15px 18px;
        }

        .detail-label {
            font-weight: bold;
            font-size: 14px;
        }

        .detail-div {
            display: grid;
            grid-template-columns: auto auto auto;
            width: 80%;
            margin: auto;
            margin-top: 20px;
            row-gap: 10px;
        }
        #del-msg {
			display: none;
			position: absolute;
			padding: 30px 90px;
			border: 2px solid black;
			top: 110px;
			left: 150px;
			background-color: white;
			text-align: center;
			border-radius: 30px;
			font-weight: bold;
		}

		#del-msg button {
			padding: 5px 15px;
			margin: 30px 10px 10px 20px;
		}

		#cancel {
			background-color: green;
			color: white;
			font-size: 15px;
			border-radius: 10px;
		}

		#del {
			background-color: red;
			border-radius: 10px;
			color: white;
		}

		#del a {
			font-size: 15px;
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
                    <li>Welcome <?php echo ucfirst($user_firstname); ?> </li>
                    <li><a href="../logout">Log Out</a></li>
                </ul>
            </div>
            <div class="nav_top">
                <ul>
                    <li><a href=" ../dashboard/?sort=month ">Dashboard</a></li>
                    <li><a href=" ../list-users ">Users</a></li>
                    <li class="active"><a href=" # ">My Profile</a></li>
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
                    <!-- <li><a href="list-users.php">List Users</a></li> -->
                    <li>My Profile</li>
                </ul>
            </div>
            <div class="left_sidebr">
				<ul>
					<li><a href="../dashboard/?sort=month" class="dashboard">Dashboard</a></li>
					<li><a href="../list-users "  class="user">Users</a>
						<ul class="submenu">
							<li><a href="../list-users">List Users</a></li>
							<li><a href="../add-user">Add Users</a></li>
							<li><a href="#">Edit User</a></li>
						</ul>
					</li>
					<li><a href="../showProfile" id="activeLink" class="Setting">My Profile</a>
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
                <h1>MY PROFILE</h1>
                <div class="list-contet">
                    <!-- image div -->

                    <button class="submit-btn" style="margin-left: 90% ;"><a title="Edit Profile" style="color: white;"
                            href="../editUser/?user_id=<?php echo $user_id; ?>"><i
                                class="fa-solid fa-user-pen fa-xl"></i>
                        </a></button>

                    <div class="profile-pic">
                        <img onclick="showImg()" src=<?php echo $profilePic ? '../userImages/' . $profilePic : $default_img; ?> alt="img" id="profile-image">
                        <div style="width: 8%;">
                            <form
                                style="position: absolute;right: 260px; margin-bottom:4px; display:flex; gap: 4px; display: flex; flex-direction: column; margin-top: 80px;"
                                method="POST" enctype="multipart/form-data" id="form-img">
                                <label title="Edit Image" for="img-upload" class="submit-btn"><i style="color: white;"
                                        class="fa-solid fa-marker fa-xl"></i>
                                </label>
                                <input type="file" size="10" class="image" name="profile" id="img-upload"
                                    onchange="uploadPic(event)" />
                                <p onclick="delTrue()" class="submit-btn"><a title="Delete Image"  ><i
                                            style="color: white;" class="fa-solid fa-trash-can fa-xl"></i></a></p>
                            </form>
                        </div>
                    </div>
                    <div class="display-img" id="display-img">
                        <p id="exit"><i onclick="hideImg()" class="fa-solid fa-xmark fa-xl"></i></p>
                        <img src=<?php echo $profilePic ? '../userImages/' . $profilePic : '../images/user.png'; ?>
                            alt="img" id="full-img">
                    </div>
                    <div id="del-msg" class="del-msg">
                        <p>Are You Sure you want to delete it?</p>
                        <button id="cancel" onclick="delFalse()">Cancel</button>
                        <button id="del"><a style="text-decoration: none ;color: white;"
                                href="../deleteProfilePic">Delete</a></button>
                    </div>
                    <!-- details div -->
                    <div class="user-details">
                        <h4
                            style="padding-left: 40px;background-color:blanchedalmond; width:fit-content ;padding-right: 40px; ">
                            <?php echo "$user_firstname" . " " . "$user_lastname"; ?>
                        </h4>
                        <h4 style="padding-left: 50px;font-weight: normal;"><?php echo "$role_val"; ?></h4>

                    </div>
                    <div class="detail-div">
                        <div>
                            <p class="detail-label">Email: </p><span class="details"><?php echo "$user_email"; ?></span>
                        </div>

                        <div>
                            <p class="detail-label">Phone: </p><span class="details"><?php echo "$user_phone"; ?></span>
                        </div>

                        <div>
                            <p class="detail-label">Gender: </p><span class="details"><?php echo "$gender"; ?></span>
                        </div>

                        <div>
                            <p class="detail-label">Address: </p><span
                                class="details"><?php echo "$user_street_address"; ?></span>
                        </div>

                        <div>
                            <p class="detail-label">Country: </p><span
                                class="details"><?php echo "$user_country_id"; ?></span>
                        </div>

                        <div>
                            <p class="detail-label">State: </p><span
                                class="details"><?php echo "$user_state_id"; ?></span>
                        </div>

                        <div>
                            <p class="detail-label">City: </p><span
                                class="details"><?php echo "$user_city_id"; ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="footer" style="position: fixed; bottom:0px;">
        <div class="wrapper">
            <p>Copyright © 2014 yourwebsite.com. All rights reserved</p>
        </div>
    </div>
    <script>
        function uploadPic(event) {
            let img = event.target.files[0];
            let image = document.getElementById('profile-image');
            let imgUrl = URL.createObjectURL(img);
            image.src = imgUrl;
            document.getElementById("form-img").submit();
        }
        function showImg() {
            document.getElementById('display-img').style.display = 'block';
        }
        function hideImg() {
            document.getElementById('display-img').style.display = 'none';
        }
        window.onclick = function (event) {
            let displayImg = document.getElementById('display-img');
            if (event.target == displayImg) {
                hideImg();
            }
        }
        function delTrue() {
            document.getElementById('del-msg').style.display = 'block';
        }
        function delFalse() {
            document.getElementById('del-msg').style.display = 'none';
        }

    </script>
</body>

</html>