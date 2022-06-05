<?php
$con=mysqli_connect('localhost','root','','voting');

if(function_exists('date_default_timezone_set'))
{
    date_default_timezone_set("Asia/Kolkata");
}
$time=date("Y/m/d H:i:s");

$election_name = $_POST['election_name'];
$start_time=$_POST['start_time'];
$end_time=$_POST['end_time'];
if($start_time == $end_time){
    echo "Election Start-Time And Election End-Time Cant Be Same";
}elseif($end_time < $start_time){
    echo "Election Start-Time Must Be Lesser Than Election End-Time";
}elseif($start_time < $time){
    echo "You Entered Date-Time Already Elapsed! Please Select Further Date-Time";
}else{
    $sql="update election set election_name='$election_name', start_time='$start_time',end_time='$end_time' where id=1";
    $res=mysqli_query($con,$sql);
    if($res){
        echo "Election Updated Successfully";
    }else{
        echo "Failed To Update The Election";
    }
}
