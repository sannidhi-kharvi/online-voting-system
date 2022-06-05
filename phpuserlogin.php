<?php
session_start();

$con=mysqli_connect('localhost','root','','voting');
$aadhaar=$_POST['aadhaar'];

$sql="select start_time,end_time from election";
$res=mysqli_query($con,$sql);
if(mysqli_num_rows($res)>0) {
    $row=mysqli_fetch_assoc($res);
    $start_time=$row['start_time'];
    $end_time=$row['end_time'];
    if(function_exists('date_default_timezone_set')) {
        date_default_timezone_set("Asia/Kolkata");
    }
    $time=date("Y-m-d H:i:s");

    $sql1="select * from voter where aadhaar='$aadhaar'";
    $res1=mysqli_query($con,$sql1);
    if(mysqli_num_rows($res1)>0)
    {
        if($time>$start_time && $time<$end_time) {
            $sql2="select * from voter where aadhaar='$aadhaar' and login='1';";
            $res2=mysqli_query($con,$sql2);
            if(mysqli_num_rows($res2)>0) {
                echo 'YOU HAVE ALREDAY GIVEN VOTE..';
            }
            else {
                $sql3="update voter set login=1 where aadhaar='$aadhaar'";
                $res3=mysqli_query($con,$sql3);
                $_SESSION['aadhaar']=$aadhaar;
                echo "LOGIN SUCCESSFUL";
            }
        }
        else if($time>$start_time) {
            echo 'ELECTION OVER!';
        }
        else {
            echo 'ELECTION NOT STARTED YET!';
        }
    }
    else {
        echo "AADHAAR CARD NUMBER NOT REGISTERED";
    }
}