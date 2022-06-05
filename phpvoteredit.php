<?php
session_start();

$con=mysqli_connect('localhost','root','','voting');
if(mysqli_connect_error()) {
	echo "connection fail";
}

$fname=$_POST['fname'];
$lname=$_POST['lname'];
$dob=$_POST['dob'];
$gender=$_POST['gender'];
$district=$_POST['district'];
$taluk=$_POST['taluk'];
$booth=$_POST['booth'];
$number=$_POST['number'];
$aadhaar=$_POST['aadhaar'];
$email=$_POST['email'];

$sql1="select * from voter where aadhaar!='$aadhaar' AND email='$email'"; 
$res1=mysqli_query($con,$sql1);

$sql2="select * from voter where aadhaar!='$aadhaar' AND number='$number'"; 
$res2=mysqli_query($con,$sql2);

if(mysqli_num_rows($res1)>0){
    echo "E-Mail Already Registered";
}elseif(mysqli_num_rows($res2)>0){
    echo "Phone Number Already Registered";
}else{
    $sql3="UPDATE voter SET fname='$fname', lname='$lname', dob='$dob', gender='$gender', district='$district', taluk='$taluk', booth='$booth', number='$number', email='$email' WHERE aadhaar='$aadhaar'";
    $res3=mysqli_query($con,$sql3);
    if($res3){
        echo "Voter Updated Successfully";
    }else{
        echo "Failed To Update The Candidate";
    }
}