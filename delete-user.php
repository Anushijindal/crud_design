<?php
include 'connect.php';
$user_id=$_GET['user_id'];
echo $user_id;
$sql="UPDATE employee_users SET deleted_at= now(), Active_status='InActive' WHERE user_id=$user_id";
// $result=;
if(mysqli_query($con,$sql)){
    // echo "deleted";
    header('location:list-users.php');
}
?>