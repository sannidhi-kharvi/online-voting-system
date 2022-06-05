<?php
session_start();

$con=mysqli_connect('localhost','root','','voting');
if(mysqli_connect_error()) {
	echo "connection fail";
}

$aadhaar=$_SESSION['aadhaar'];
$uotp=$_POST['otp'];
$sql="select otp from voter where aadhaar='$aadhaar'";
$qry=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($qry);
$cotp=$row['otp'];

if($uotp == $cotp) {
	echo "OTP Verified";
}
else{
	echo "OTP Is Not Valid";
}