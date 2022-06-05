<?php
session_start();

$con=mysqli_connect('localhost','root','','voting');
if(mysqli_connect_error()) {
	echo "connection fail";
}

$id=$_POST['candidate_id'];

$sql1="select * from candidate where candidate_id='$id'";
$res1=mysqli_query($con,$sql1);
if(mysqli_num_rows($res1)>0) {
    $row=mysqli_fetch_assoc($res1);
    $candidate_photo = $row['candidate_photo'];
    $party_photo = $row['candidate_party_photo'];
    if (file_exists($candidate_photo)) {
        unlink($candidate_photo);
    }
    if (file_exists($party_photo)) {
        unlink($party_photo);
    }
}

$sql="delete from candidate where candidate_id='$id'";
$res=mysqli_query($con,$sql);
if($res){
    echo "Candidate Deleted Successfully";
}else{
    echo "Failed To Delete The Candidate";
}