<?php
session_start();
$con=mysqli_connect('localhost','root','','voting');

$id=$_POST['candidate_id'];
$sql="update candidate set vote=vote+1 where candidate_id='$id'";
$res=mysqli_query($con,$sql);
if($res){
    echo "Your Vote Successfully Submitted";
}else{
    echo "Vote Unsuccessful";
}