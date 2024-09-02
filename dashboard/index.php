<?php
include '../connect.php';
session_start();
if (empty($_SESSION['email']) && empty($_SESSION['password'])) {
	header('location:../');
}
// print_r($_SESSION);
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
// $timeNow = date('H:i:s');
// echo $timeNow;
// $week1 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-1) and now()  ";
// $result1 = mysqli_query($con, $week1);
// $w1 = mysqli_num_rows($result1);
// echo "$w1";

if ($sort == "month") {
	$week1 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-28) and adddate(now(),-21) ";
	$result1 = mysqli_query($con, $week1);
	$w1 = mysqli_num_rows($result1);
	// echo "$w1";
	$week2 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-21) and adddate(now(),-14)";
	$result2 = mysqli_query($con, $week2);
	$w2 = mysqli_num_rows($result2);
	// echo "$w2";
	$week3 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-14) and adddate(now(),-7)";
	$result3 = mysqli_query($con, $week3);
	$w3 = mysqli_num_rows($result3);
	// echo "$w3";
	$week4 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-7) and now()";
	$result4 = mysqli_query($con, $week4);
	$w4 = mysqli_num_rows($result4);
	$femalemonth = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_gender='Female' AND user_createdAt between adddate(now(),-28) and now() ";
	$result5 = mysqli_query($con, $femalemonth);
	$fm = mysqli_num_rows($result5);
	$malemonth = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_gender='Male' AND user_createdAt between adddate(now(),-28) and now() ";
	$result6 = mysqli_query($con, $malemonth);
	$mm = mysqli_num_rows($result6);
}
if ($sort == "day") {
	// $week1 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-1) and now()  ";
	// $result1 = mysqli_query($con, $week1);
	// $w1 = mysqli_num_rows($result1);
	$time1 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),INTERVAL -4 HOUR) and now()";
$result12 = mysqli_query($con, $time1);
$t1 = mysqli_num_rows($result12);
$time2 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),INTERVAL -8 HOUR) and adddate(now(),INTERVAL -4 HOUR)";
$result13 = mysqli_query($con, $time2);
$t2 = mysqli_num_rows($result13);
$time3 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),INTERVAL -12 HOUR) and adddate(now(),INTERVAL -8 HOUR)";
$result14 = mysqli_query($con, $time3);
$t3 = mysqli_num_rows($result14);
$time4 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),INTERVAL -16 HOUR) and adddate(now(),INTERVAL -12 HOUR)";
$result15 = mysqli_query($con, $time4);
$t4 = mysqli_num_rows($result15);
$time5 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),INTERVAL -20 HOUR) and adddate(now(),INTERVAL -16 HOUR)";
$result16 = mysqli_query($con, $time5);
$t5 = mysqli_num_rows($result16);
$time6 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),INTERVAL -24 HOUR) and adddate(now(),INTERVAL -20 HOUR)";
$result17 = mysqli_query($con, $time6);
$t6 = mysqli_num_rows($result17);
	$femaleday = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_gender='Female' AND user_createdAt between adddate(now(),-1) and now() ";
	$result5 = mysqli_query($con, $femaleday);
	$fd = mysqli_num_rows($result5);
	$maleday = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_gender='Male' AND user_createdAt between adddate(now(),-1) and now() ";
	$result6 = mysqli_query($con, $maleday);
	$md = mysqli_num_rows($result6);
}
if ($sort == "week") {
	$week1 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-1) and now()";
	$result1 = mysqli_query($con, $week1);
	$w1 = mysqli_num_rows($result1);
	$week2 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-2) and adddate(now(),-1)";
	$result2 = mysqli_query($con, $week2);
	$w2 = mysqli_num_rows($result2);
	$week3 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-3) and adddate(now(),-2)";
	$result3 = mysqli_query($con, $week3);
	$w3 = mysqli_num_rows($result3);
	$week4 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-4) and adddate(now(),-3)";
	$result4 = mysqli_query($con, $week4);
	$w4 = mysqli_num_rows($result4);
	$week5 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-5) and adddate(now(),-4)";
	$result5 = mysqli_query($con, $week5);
	$w5 = mysqli_num_rows($result5);
	$week6 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-6) and adddate(now(),-5)";
	$result6 = mysqli_query($con, $week6);
	$w6 = mysqli_num_rows($result6);
	$week7 = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between adddate(now(),-7) and adddate(now(),-6)";
	$result7 = mysqli_query($con, $week7);
	$w7 = mysqli_num_rows($result7);
	$femaleweek = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_gender='Female' AND user_createdAt between adddate(now(),-7) and now() ";
	$result5 = mysqli_query($con, $femaleweek);
	$fw = mysqli_num_rows($result5);
	$maleweek = "SELECT user_id FROM `em_users` WHERE user_deletedAt is null AND user_gender='Male' AND user_createdAt between adddate(now(),-7) and now() ";
	$result6 = mysqli_query($con, $maleweek);
	$mw = mysqli_num_rows($result6);
}
// echo "$w4";
// $week5 = "SELECT * FROM `em_users` WHERE user_deletedAt is null AND user_createdAt between '2024-07-28' AND '2024-07-31'";
// $result5 = mysqli_query($con, $week5);
// $w5 = mysqli_num_rows($result5);
// $male = "SELECT gender FROM `em_users` WHERE gender='Male'";
// $maleRes = mysqli_query($con, $male);
// $maleResults = mysqli_num_rows($maleRes);
// $female = "SELECT gender FROM `em_users` WHERE gender='Female'";
// $femaleRes = mysqli_query($con, $female);
// $femaleResults = mysqli_num_rows($femaleRes);
// $mon=[];
// for($i=0;$i<=12;$i++){
// 	$month= "SELECT * FROM `em_users` WHERE user_deletedAt is null AND month(user_createdAt)=$i";
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
	<!-- <script src="https://code.highcharts.com/modules/export-data.js"></script> -->
	<!-- <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
	<!-- Bootstrap -->
	<link href="../css/dashboard.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/barchart.css">
	<link rel="stylesheet" href="../css/linechart.css">
	<link rel="stylesheet" href="../css/piechart.css">
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
					<li class="active"><a href="">Dashboard</a></li>
					<?php
					// if($admin=='yes'){
					// 	echo "";
					// }
					?>
					<li><a href=' ../list-users '>Users</a></li>
					<li><a href=" ../showProfile ">My profile</a></li>
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
					<li><a href="../dashboard/?sort=month" id="activeLink" class="dashboard">Dashboard</a></li>
					<li><a href="../list-users " class="user">Users</a>
						<ul class="submenu">
						<ul class="submenu">
							<li><a href="../list-users">List Users</a></li>
							<li><a href="../add-user">Add Users</a></li>
							<li><a href="#">Edit User</a></li>
						</ul>
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
											echo "['Day 1','Day 2','Day 3','Day 4','Day 5','Day 6','Day 7']";
										else
											echo "['00-04','04-08','08-12','12-16','16-20','20-24']"; ?>,
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
												echo "[$w7,$w6,$w5,$w4,$w3,$w2,$w1]";
											else
												echo "[$t6,$t5,$t4,$t3,$t2,$t1]"; ?>
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
													y: <?php if($sort=='month') {echo $mm;}else if($sort=='day'){echo $md;} else {echo $mw;}?>
												},
												{
													name: 'Female',
													y: <?php if($sort=='month') {echo $fm;}else if($sort=='day'){echo $fd;} else {echo $fw;} ?>
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
										echo "['Day 1','Day 2','Day 3','Day 4','Day 5','Day 6','Day 7']";
									else
										echo "['00-04','04-08','08-12','12-16','16-20','20-24']"; ?>,
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
										echo "[$w1,$w2,$w3,$w4,$w5,$w6,$w7]";
									else
										echo "[$t6,$t5,$t4,$t3,$t2,$t1]"; ?>
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
			window.location.href = "http://localhost/crud_design/dashboard/?sort=" + data;
		}
	</script>
</body>

</html>