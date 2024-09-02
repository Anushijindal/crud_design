<?php
include 'connect.php';
session_start();
if (empty($_SESSION['email']) && empty($_SESSION['password'])) {
	header('location:signin.php');
}
$email = $_SESSION['email'];
// echo "$email";
// $password=$_SESSION['password'];
$sql = "SELECT user_firstname,user_lastname,user_email,user_country_id,
user_state_id,user_city_id,user_street_address,user_phone,user_password,
user_role_id,gender FROM employee_users WHERE user_email='$email'";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
	$user_firstname = $row['user_firstname'];
	$user_firstname = ucfirst($user_firstname);
	$user_role_id = $row['user_role_id'];
	if ($user_role_id != 3 && $user_role_id != 4) {
		header('location:dashboard.php?sort=month');
	}
}
$sort = "updated_at";
$order = 'ASC';
$search_val = "";
if (isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}
if (isset($_GET['search_val'])) {
	$search_val = $_GET['search_val'];
	$search_val = trim($search_val);
}
if (isset($_GET['sort'])) {
	$sort = $_GET['sort'];
}
if (isset($_GET['order'])) {
	$order = $_GET['order'];
}
?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>

	<!-- Bootstrap -->
	<link href="css/dashboard.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
		.heading {
			color: black;
		}

		.disabled_li {
			color: black;
			background-color: white;
			font-size: 12px;
			padding: 2px 6px;
			color: #333333;
			font-weight: 550;
			font-family: 'OpenSansSemibold';
		}
	</style>
</head>

<body>
	<div class="header">
		<div class="wrapper">
			<div class="logo"><a href="#"><img src="images/logo.png"></a></div>


			<div class="right_side">
				<ul>
					<li>Welcome <?php echo $user_firstname; ?></li>
					<li><a href="logout.php">Log Out</a></li>
				</ul>
			</div>
			<div class="nav_top">
				<ul>
					<li><a href=" dashboard.php?sort=month ">Dashboard</a></li>
					<li class="active"><a href=" list-users.php ">Users</a></li>
					<li><a href=" showProfile.php ">My Profile</a></li>
					<li><a href=" #">Configuration</a></li>
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
					<li><a href="dashboard.php?sort=month">Home</a></li>
					<li>List Users</li>
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
					<li><a href="" class="Setting">My Profile</a>
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
				<h1>List Users</h1>
				<div class="list-contet">
					<div class="form-left">
						<div class="form">
							<form role="form" method="GET">
								<!-- <label>Sort By : </label>
								<div class="select">
									<select name="sort" id="sort_val" onclick="sortdata()">
										<option <?php
										// if ($sort == "user_email")
										// 	echo 'selected="selected"' 
										?>
												value="user_email">Email</option>
											<option <?php
											// if ($sort == "user_firstname")
											// echo 'selected="selected"' 
											?>
												value="user_firstname">First Name</option>
											<option <?php
											// if ($sort == "user_phone")
											// echo 'selected="selected"' 
											?>
												value="user_phone">Phone</option>
											<option <?php
											// if ($sort == "role_name")
											// echo 'selected="selected"' 
											?>
												value="role_name">User type</option>
											<option <?php #if ($sort == "user_country_id")
											#echo 'selected="selected"' ?>
												value="user_country_id">Country</option>
											<option <?php #if ($sort == "createdAt")
											#echo 'selected="selected"' ?>
												value="createdAt">Created_at</option>
										</select>
									</div> -->
								<input type="text" class="search-box search-upper" name="search_val"
									placeholder="Search.." value=<?php echo $_GET['search_val']; ?>>
								<input type="submit" class="submit-btn" value="Search">
							</form>
						</div>
						<a href="add-user.php" class="submit-btn add-user">Add</a>
					</div>
					<table width="100%" cellspacing="0">
						<tbody>
							<tr>
								<th width="50px"><a class="heading" href="list-users.php?sort=updated_at&order=
										<?= $sort == "updated_at" && $order == "ASC" ? "DESC" : "ASC" ?>
										&search_val=<?php echo $search_val; ?>&page=1">S.no <?php if
										   ($sort === "updated_at" && $order === "DESC")
											   echo "<i class='fa-solid fa-arrow-down fa-2xs'></i>";
										   else if ($sort === "updated_at" && $order === "ASC")
											   echo "<i class='fa-solid fa-arrow-up fa-2xs'></i>"
											   	?></a>
										</th>
										<th width="120px"><a class="heading" href="list-users.php?sort=user_firstname&order=
										<?= $sort == "user_firstname" && $order == "ASC" ? "DESC" : "ASC" ?>
										&search_val=<?php echo $search_val; ?>&page=1">User Name <?php if
										   ($sort === "user_firstname" && $order === "DESC")
											   echo "<i class='fa-solid fa-arrow-down fa-2xs'></i>";
										   else if ($sort === "user_firstname" && $order === "ASC")
											   echo "<i class='fa-solid fa-arrow-up fa-2xs'></i>"
											   	?></a></th>
										<th width="98px"><a class="heading" href="list-users.php?sort=user_email&order=
										<?= $sort == "user_email" && $order == "ASC" ? "DESC" : "ASC" ?>
										&search_val=<?php echo $search_val; ?>&page=1">E-mail <?php if
										   ($sort === "user_email" && $order === "DESC")
											   echo "<i class='fa-solid fa-arrow-down fa-2xs'></i>";
										   else if ($sort === "user_email" && $order === "ASC")
											   echo "<i class='fa-solid fa-arrow-up fa-2xs'></i>"
											   	?></a></th>
										<th width="120px"><a class="heading" href="list-users.php?sort=role_name&order=
										<?= $sort == "role_name" && $order == "ASC" ? "DESC" : "ASC" ?>
										&search_val=<?php echo $search_val; ?>&page=1">User Type <?php if
										   ($sort === "role_name" && $order === "DESC")
											   echo "<i class='fa-solid fa-arrow-down fa-2xs'></i>";
										   else if ($sort === "role_name" && $order === "ASC")
											   echo "<i class='fa-solid fa-arrow-up fa-2xs'></i>"
											   	?></a></th>
										<th width="113px"><a class="heading" href="list-users.php?sort=user_phone&order=
										<?= $sort == "user_phone" && $order == "ASC" ? "DESC" : "ASC" ?>
										&search_val=<?php echo $search_val; ?>&page=1"> Mobile <?php if
										   ($sort === "user_phone" && $order === "DESC")
											   echo "<i class='fa-solid fa-arrow-down fa-2xs'></i>";
										   else if ($sort === "user_phone" && $order === "ASC")
											   echo "<i class='fa-solid fa-arrow-up fa-2xs'></i>"
											   	?></a></th>
										<th width="97px"><a class="heading" href="list-users.php?sort=user_country_id&order=
										<?= $sort == "user_country_id" && $order == "ASC" ? "DESC" : "ASC" ?>
										&search_val=<?php echo $search_val; ?>&page=1">User Country <?php if
										   ($sort === "user_country_id" && $order === "DESC")
											   echo "<i class='fa-solid fa-arrow-down fa-2xs'></i>";
										   else if ($sort === "user_country_id" && $order === "ASC")
											   echo "<i class='fa-solid fa-arrow-up fa-2xs'></i>"
											   	?></a></th>
										<th width="126px"><a class="heading" href="">Action</a></th>
									</tr>
								<?php
										   $num_rows = 10;
										   $sql = "SELECT * FROM employee_roles LEFT JOIN employee_users on 
											employee_roles.role_id=employee_users.user_role_id AND employee_users.deleted_at 
											is null WHERE user_firstname LIKE '%$search_val%' 
											or user_email LIKE '%$search_val%'
											or user_country_id LIKE '%$search_val%'
											or role_name LIKE '%$search_val%'";
										   $result = mysqli_query($con, $sql);
										   $total_rows = mysqli_num_rows($result);
										   $numPage = ceil($total_rows / $num_rows);
										   $first_row = ($page - 1) * $num_rows;
										   $sql = "SELECT * FROM employee_roles LEFT JOIN employee_users on 
										   employee_roles.role_id=employee_users.user_role_id AND employee_users.deleted_at 
										   is null  WHERE user_firstname LIKE '%$search_val%' 
										   or user_email LIKE '%$search_val%'
										   or user_country_id LIKE '%$search_val%'
										   or role_name LIKE '%$search_val%' ORDER BY $sort $order LIMIT $num_rows OFFSET $first_row";
										   // $sql="SELECT * FROM employee_users";
										   $result = mysqli_query($con, $sql);
										   $sno = $first_row;
										   if (mysqli_num_rows($result) > 0) {
											   while ($row = mysqli_fetch_assoc($result)) {
												   $sno++;
												   // $role_id = $row['role_id'];
										   		$user_id = $row['user_id'];
												   $role_name = $row['role_name'];
												   $user_firstname = $row['user_firstname'];
												   $user_lastname = $row['user_lastname'];
												   $user_email = $row['user_email'];
												   $user_phone = $row['user_phone'];
												   // $user_street_address = $row['user_street_address'];
										   		// $user_password = $row['user_password'];
										   		// $active_status = $row['Active_status'];
										   		$country = $row['user_country_id'];
												   // $state = $row['user_state_id'];
										   		// $city = $row['user_city_id'];
										   		echo '<tr>
						<td>' . $sno . '</td>
						<td>' . $user_firstname . " " . $user_lastname . '</td>
						<td>' . $user_email . '</td>		
						<td>' . $role_name . '</td>		
						<td>' . $user_phone . '</td>					
						<td>' . $country . '</td>	
						<td><a style="margin:5px;" href="editUser.php?user_id=' . $user_id . '"><i class="fa-solid fa-pen fa-lg" style="color: #f3d512;"></i></a>
						<a style="margin:2px;" onClick="return confirm(`Are you sure You want to Delete it?`)" href="delete-user.php?user_id=' . $user_id . '"><i class="fa-solid fa-xmark fa-xl" style="color: #ff0000;"></i></a>
						</td>					
				  </tr>';
											   }
										   }
										   ?>

						</tbody>
					</table>
					<!-- <div class="paginaton-div">
						<ul>
							<li><a href="#">Prev</a></li>
							<li><a href="#" class="active">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">Next</a></li>


						</ul>
					</div> -->
					<div class="paginaton-div">
						<ul>
							<?php
							if ($page > 1) {
								echo '<li><a href="?sort=' . $sort . '&order=' . $order . '&search_val=' . $search_val . '&page=' . ($page - 1) . '">Prev</a></li>';
							} else {
								echo '<li class="disabled_li">Prev</li>';
							}
							for ($i = 1; $i <= $numPage; $i++) {
								if ($i == $page) {
									echo '<li><a style="background-color: #ff651b;margin:2px; color:white;" href="?sort=' . $sort . '&order=' . $order . '&search_val=' . $search_val . '&page=' . $i . '">' . $i . '</a></li>';
								} else {
									echo '<li><a style="margin:2px;" href="?sort=' . $sort . '&order=' . $order . '&search_val=' . $search_val . '&page=' . $i . '">' . $i . '</a></li>';
								}
							}
							if ($page < $numPage) {
								echo '<li><a href="?sort=' . $sort . '&order=' . $order . '&search_val=' . $search_val . '&page=' . ($page + 1) . '">Next</a></li>';
							} else {
								echo '<li class="disabled_li" >Next</li>';
							}
							?>
						</ul>
					</div>

				</div>
			</div>

		</div>
	</div>
	<div class="footer" style="position: fixed; bottom: 0px ">
		<div class="wrapper">
			<p>Copyright © 2014 yourwebsite.com. All rights reserved</p>
		</div>

	</div>
	<script>
		function sortdata() {
			let getsort = document.getElementById("sort_val").value;
			// console.log(getsort);
			window.location.href = "http://localhost/dashboard/HTML1/list-users.php?sort=" + getsort + "&order=<?php echo $order; ?>&search_val=<?php echo $search_val; ?>"
		}
	</script>
</body>

</html>