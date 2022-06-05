<?php
session_start();

$con=mysqli_connect('localhost','root','','voting');
if(mysqli_connect_error()) {
	echo "connection fail";
}
$candidate_id=$_POST['candidate_id'];
$candidate_name=$_POST['candidate_name'];
$candidate_party=$_POST['party_name'];
$election_name=$_POST['election_name'];

$sql="select * from candidate where candidate_id!='$candidate_id' AND candidate_party ='$candidate_party'";   
$res=mysqli_query($con,$sql);

if(mysqli_num_rows($res)>0){
    echo "Candidate Party Already Registered";
}else{
    $sql1="select * from candidate where candidate_id='$candidate_id'";
    $res1=mysqli_query($con,$sql1);
    if(mysqli_num_rows($res1)>0) {
        $row=mysqli_fetch_assoc($res1);
        $candidate_photo = $row['candidate_photo'];
        $party_photo = $row['candidate_party_photo'];
        if($_FILES["candidate_photo"]["name"]){
            if (file_exists($candidate_photo)) {
                unlink($candidate_photo);
            }
            $candidate_photo = 'images/uploads/'.$_POST['candidate_name'].rand(1000,1000000).'.jpeg';
            if (!move_uploaded_file($_FILES["candidate_photo"]["tmp_name"], $candidate_photo)) {
                echo "Failed To Upload Image";
                return;
            }
            $sql2 = "UPDATE candidate SET candidate_photo='$candidate_photo' WHERE candidate_id='$candidate_id'";
            $res2 = mysqli_query($con,$sql2);
        }
        if($_FILES["party_photo"]["name"]){
            if (file_exists($party_photo)) {
                unlink($party_photo);
            }
            $party_photo= 'images/uploads/'.$_POST['party_name'].rand(1000,1000000).'.jpeg';
            if (!move_uploaded_file($_FILES["party_photo"]["tmp_name"], $party_photo)) {
                echo "Failed To Upload Image";
                return;
            }
            $sql3 = "UPDATE candidate SET candidate_party_photo='$party_photo' WHERE candidate_id='$candidate_id'";
            $res3 = mysqli_query($con,$sql3);
        }
    }
    
    $sql4 = "UPDATE candidate SET candidate_name='$candidate_name', candidate_party='$candidate_party', election_name='$election_name' WHERE candidate_id='$candidate_id'";
    $res4=mysqli_query($con,$sql4);
    if($res4 || $res2 || $res3)
    {
        echo "Candidate Updated Successfully";
    }
    else{
        echo "Failed To Update The Candidate";
    }
}