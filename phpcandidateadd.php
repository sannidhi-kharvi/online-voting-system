<?php
session_start();

$con=mysqli_connect('localhost','root','','voting');
if(mysqli_connect_error()) {
	echo "Connection Fail";
}

$candidate_name=$_POST['candidate_name'];
$candidate_photo = 'images/uploads/'.$_POST['candidate_name'].rand(1000,1000000).'.jpeg';
$party_photo= 'images/uploads/'.$_POST['party_name'].rand(1000,1000000).'.jpeg';
$candidate_party=$_POST['party_name'];
$election_name=$_POST['election_name'];
$vote=0;

$sql="select * from candidate where candidate_party ='$candidate_party'";   
$res=mysqli_query($con,$sql);

if(mysqli_num_rows($res)>0){
    echo "Candidate Party Already Registered";
}else{
    if (!move_uploaded_file($_FILES["candidate_photo"]["tmp_name"], $candidate_photo)) {
        echo "Failed To Upload Image";
    }
    if (!move_uploaded_file($_FILES["party_photo"]["tmp_name"], $party_photo)) {
        echo "Failed To Upload Image";
    }
    
    $sql1 = "INSERT INTO `candidate` (`candidate_name`, `candidate_photo`, `candidate_party_photo`, `candidate_party`, `election_name`,`vote`) VALUES('$candidate_name','$candidate_photo','$party_photo','$candidate_party','$election_name','$vote')";
    $res1=mysqli_query($con,$sql1);
    if($res1)
    {
        echo "Candidate Registered Successfully";
    }
    else{
        echo "Registeration Unsuccessful";
    }
}