<?php
include 'connect.php';
session_start();
// echo "goei";
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$file="SELECT user_image FROM `employee_users` WHERE user_email='$email'";
$res=mysqli_query($con,$file);
while($row=mysqli_fetch_array($res)){
    $filename=$row['user_image'];
}
unlink("userImages/$filename");

$sql="UPDATE `employee_users` set user_image=null WHERE user_email='$email'";
$result=mysqli_query($con,$sql); 
if($result){
    header("location:showProfile.php");
    echo "success";
}else{
    echo "oops";
}
?>