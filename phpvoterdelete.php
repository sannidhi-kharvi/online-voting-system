<?php
session_start();

$con=mysqli_connect('localhost','root','','voting');
if(mysqli_connect_error()) {
	echo "connection fail";
}

$aadhaar=$_POST['aadhaar'];
$sql="delete from voter where aadhaar='$aadhaar'";
$res=mysqli_query($con,$sql);
if($res){
    echo "Voter Deleted Successfully";
}else{
    echo "Failed To Delete The Voter";
}