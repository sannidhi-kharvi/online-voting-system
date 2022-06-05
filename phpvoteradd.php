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
$login=0;

$sql="select * from voter where aadhaar='$aadhaar'"; 
$res=mysqli_query($con,$sql);

$sql1="select * from voter where email='$email'"; 
$res1=mysqli_query($con,$sql1);

$sql2="select * from voter where number='$number'"; 
$res2=mysqli_query($con,$sql2);

if(mysqli_num_rows($res)>0){
    echo "Aadhaar Number Already Registered";
}elseif(mysqli_num_rows($res1)>0){
    echo "E-Mail Already Registered";
}elseif(mysqli_num_rows($res2)>0){
    echo "Phone Number Already Registered";
}else{
    $sql3="insert into voter values('$fname','$lname','$dob','$gender','$district','$taluk','$booth','$number','$aadhaar','','$email','$login')";
    $res3=mysqli_query($con,$sql3);
    if($res3){
        echo "Voter Registered Successfully";
    }else{
        echo "Registeration Unsuccessful";
    }
}