<?php
include 'connect.php';
session_start();
if (empty($_SESSION['email']) && empty($_SESSION['password'])) {
	header('location:signin.php');
}
// print_r($_SESSION);
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
	// $admin=$row['is_Admin'];
} ?>
<?php
$sort = $_GET['sort'];

switch ($sort) {
	case 'day':
		$datesort = 'adddate(now(),-1)';
	case 'week':
		$datesort = 'adddate(now(),-7)';
	case 'month':
		$datesort = 'adddate(now(),-30)';
	default:
		$datesort = '';
}
if ($sort == "month") {
	$week1 = "SELECT user_id FROM `employee_users` WHERE deleted_at is null AND createdAt between adddate(now(),-28) and adddate(now(),-21) ";
	$result1 = mysqli_query($con, $week1);
	$w1 = mysqli_num_rows($result1);
	// echo "$w1";
	$week2 = "SELECT user_id FROM `employee_users` WHERE deleted_at is null AND createdAt between adddate(now(),-21) and adddate(now(),-14)";
	$result2 = mysqli_query($con, $week2);
	$w2 = mysqli_num_rows($result2);
	// echo "$w2";
	$week3 = "SELECT user_id FROM `employee_users` WHERE deleted_at is null AND createdAt between adddate(now(),-14) and adddate(now(),-7)";
	$result3 = mysqli_query($con, $week3);
	$w3 = mysqli_num_rows($result3);
	// echo "$w3";
	$week4 = "SELECT user_id FROM `employee_users` WHERE deleted_at is null AND createdAt between adddate(now(),-7) and now()";
	$result4 = mysqli_query($con, $week4);
	$w4 = mysqli_num_rows($result4);
}
if ($sort == "day") {
	$week1 = "SELECT user_id FROM `employee_users` WHERE deleted_at is null AND createdAt between adddate(now(),-1) and now()  ";
	$result1 = mysqli_query($con, $week1);
	$w1 = mysqli_num_rows($result1);
}
if ($sort == "week") {
	$week1 = "SELECT user_id FROM `employee_users` WHERE deleted_at is null AND createdAt between adddate(now(),-7) and now()";
	$result1 = mysqli_query($con, $week1);
	$w1 = mysqli_num_rows($result1);
}
// echo "$w4";
// $week5 = "SELECT * FROM `employee_users` WHERE deleted_at is null AND createdAt between '2024-07-28' AND '2024-07-31'";
// $result5 = mysqli_query($con, $week5);
// $w5 = mysqli_num_rows($result5);
$male = "SELECT gender FROM `employee_users` WHERE gender='Male'";
$maleRes = mysqli_query($con, $male);
$maleResults = mysqli_num_rows($maleRes);
$female = "SELECT gender FROM `employee_users` WHERE gender='Female'";
$femaleRes = mysqli_query($con, $female);
$femaleResults = mysqli_num_rows($femaleRes);
// $mon=[];
// for($i=0;$i<=12;$i++){
// 	$month= "SELECT * FROM `employee_users` WHERE deleted_at is null AND month(createdAt)=$i";
// 	$resultMonth=mysqli_query($con,$month);
// 	$mon[]=mysqli_num_rows($resultMonth);
// }
// print_r($mon[7]);

?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<!-- <script src="https://code.highcharts.com/modules/exporting.js"></script> -->
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<!-- Bootstrap -->
	<link href="css/dashboard.css" rel="stylesheet">
	<link rel="stylesheet" href="barchart.css">
	<link rel="stylesheet" href="linechart.css">
	<link rel="stylesheet" href="piechart.css">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
		/* .charts{
			display: flex;
			flex-direction: column;
			width: 50%;
		} */
		/* .part1{
			display: flex;
			width: 200px;
		} */
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
					<li class="active"><a href=" dashboard.php?sort=month ">Dashboard</a></li>
					<?php
					// if($admin=='yes'){
					// 	echo "";
					// }
					?>
					<li><a href=' list-users.php '>Users</a></li>
					<li><a href=" showProfile.php ">My profile</a></li>
					<li><a href=" geoloclist.php ">Configuration</a></li>
				</ul>

			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="clear"></div>
	<div class="content">
		<div class="wrapper">
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
			<div class="right_side_content" style="height: 730px;">
				<h1>Dashboard</h1>
				<!-- <div class="tab"> -->
				<div style="padding: 5px; ">
					<select name="userdata" style="width:200px; text-align: center; padding: 5px; font-size: 15px;"
						id="userdata" onclick="sortData()">
						<option <?php if ($_GET['sort'] == 'month')
							echo "selected='selected'"; ?> value="month">1 month
						</option>
						<option <?php if ($_GET['sort'] == 'week')
							echo "selected='selected'"; ?> value="week">1 week
						</option>
						<option <?php if ($_GET['sort'] == 'day')
							echo "selected='selected'"; ?> value="day">1 day
						</option>
					</select>
				</div>
				<div style="" class="charts">
					<div class="part1" style="display: flex; ">
						<div style="">
							<figure style="" class="highcharts-figure1">
								<div id="container1"></div>
							</figure>
							<script>
								Highcharts.chart('container1', {
									chart: {
										type: 'column'
									},
									title: {
										text: 'Users Signed in July',
										align: 'left'
									},
									// subtitle: {
									//     text:
									//         'Source: <a target="_blank" ' +
									//         'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>',
									//     align: 'left'
									// },
									xAxis: {
										categories: <?php if ($sort == 'month') {
											echo "['Week 1', 'Week 2', 'Week 3', 'Week 4']";
										} else if ($sort == 'week')
											echo "['Week 1']";
										else
											echo "['Day 1']"; ?>,
										crosshair: true,
										accessibility: {
											description: 'Countries'
										}
									},
									yAxis: {
										min: 0,
										title: {
											text: 'Number of Users'
										}
									},
									plotOptions: {
										column: {
											pointPadding: 0.2,
											borderWidth: 0
										}
									},
									series: [
										{
											name: 'Users',
											data: <?php if ($sort == 'month')
												echo "[$w1, $w2, $w3, $w4]";
											elseif ($sort == 'week')
												echo "[$w1]";
											else
												echo "[$w1]"; ?>
										}
									]
								});
							</script>
						</div>
						<div>
							<figure style=" " class="highcharts-figure2">
								<div id="container2"></div>
							</figure>
							<script>
								Highcharts.chart('container2', {
									chart: {
										type: 'pie'
									},
									title: {
										text: 'Male-Female Ratio'
									},
									tooltip: {
										valueSuffix: ''
									},
									subtitle: {
										text:
											''
									},
									plotOptions: {
										series: {
											allowPointSelect: true,
											cursor: 'pointer',
											dataLabels: [{
												enabled: true,
												distance: 20
											}, {
												enabled: true,
												distance: -40,
												format: '{point.percentage:.1f}%',
												style: {
													fontSize: '1.2em',
													textOutline: 'none',
													opacity: 0.7
												},
												filter: {
													operator: '>',
													property: 'percentage',
													value: 10
												}
											}]
										}
									},
									series: [
										{
											name: 'users',
											colorByPoint: true,
											data: [
												{
													name: 'Male',
													y: <?php echo $maleResults; ?>
												},
												{
													name: 'Female',
													y: <?php echo $femaleResults; ?>
												}
											]
										}
									]
								});
							</script>
						</div>
					</div>
					<div style="">
						<figure style="height: 400px;" class="highcharts-figure3">
							<div id="container3"></div>
						</figure>
						<script>
							Highcharts.chart('container3', {

								title: {
									text: '',
									align: 'left'
								},

								subtitle: {
									text: '',
									align: 'left'
								},

								yAxis: {
									title: {
										text: 'Number of Users'
									}
								},

								xAxis: {
									categories: <?php if ($sort == 'month') {
										echo "['Week 1', 'Week 2', 'Week 3', 'Week 4']";
									} else if ($sort == 'week')
										echo "['Week 1']";
									else
										echo "['Day 1']"; ?>,
									// accessibility: {
									// 	rangeDescription:['weel1']
									// }
								},

								legend: {
									layout: 'vertical',
									align: 'right',
									verticalAlign: 'middle'
								},

								plotOptions: {
									series: {
										label: {
											connectorAllowed: false
										},
										// pointStart: 2010
									}
								},

								series: [{
									name: 'Users signed in',
									data: <?php if ($sort == 'month')
										echo "[$w1, $w2, $w3, $w4]";
									elseif ($sort == 'week')
										echo "[$w1]";
									else
										echo "[$w1]"; ?>
								}],

								responsive: {
									rules: [{
										condition: {
											maxWidth: 500
										},
										chartOptions: {
											legend: {
												layout: 'horizontal',
												align: 'center',
												verticalAlign: 'bottom'
											}
										}
									}]
								}
							});
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer" style="position:fixed; bottom:0px; ">
		<div class="wrapper">
			<p>Copyright © 2014 yourwebsite.com. All rights reserved</p>
		</div>

	</div>
	<script>
		function sortData() {
			data = document.getElementById('userdata').value;
			window.location.href = "http://localhost/crud_design/dashboard.php?sort=" + data;
		}
	</script>
</body>

</html>