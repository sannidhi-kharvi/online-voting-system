<?php
session_start();
$con=mysqli_connect('localhost','root','','voting');
if(mysqli_connect_error()){
	echo "connection fail";
}
$aadhaar=$_SESSION['aadhaar'];

$sql="select email,fname from voter where aadhaar='$aadhaar'";
$qry=mysqli_query($con,$sql);
if(mysqli_num_rows($qry)>0) {
    $row=mysqli_fetch_assoc($qry);
    function generateotp()
    {
        $gene='1234567890';
        $otp=array();
        $genelength=strlen($gene)-1;
        for($i=0;$i<=4;$i++)
        {
            $n=rand(0,$genelength);
            $otp[]=$gene[$n];
        }
        return implode($otp); 
    }
    $otp=generateotp();
    
    // if(! ini_get('date.timezone') )
    // {
    //     date_default_timezone_set('GMT');
    // }
    require("PHPMailer_5.2.0/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->IsSMTP();                             
    $mail->AddAddress($row['email']);
    $mail->WordWrap = 50;                  
    $mail->IsHTML(true);                                
    $mail->Subject = "One Time Password(OTP) Confirmation";
    $mail->Body ="<H3>Your One Time Password(OTP) for Election is: ".$otp."</H3>";
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    if(!$mail->Send())
    {
        echo "E-Mail Not Sent Check Your Connection";
        exit;
    }
    echo "OTP Sent To Your E-Mail";
    $mail->clearAddresses();
    $sql1="update voter set otp='$otp' where aadhaar='$aadhaar'";
    $qry1=mysqli_query($con,$sql1);
}