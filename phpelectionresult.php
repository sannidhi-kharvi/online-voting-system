<?php
require("PHPMailer_5.2.0/class.phpmailer.php");
$con=mysqli_connect('localhost','root','','voting');

$getusers=mysqli_query($con,"select fname,lname,email from voter");
$mail = new PHPMailer();
$mail->IsSMTP();     
foreach($getusers as $row1)
{		
    $qry="select candidate_name,candidate_name,candidate_party,vote from candidate";
    $res=mysqli_query($con,$qry);

    $mail->AddAddress($row1['email']);
    $mail->WordWrap = 50;                          
    $mail->IsHTML(true);                                  
    $mail->Subject = "Election Result";
        
    $body="
    <H3>Election Results<H3><BR>
    <table border='1' cellspacing='0' cellpadding='5' align='center'>
    <thead style='background-color: #3A89FD;color: #ffffff;padding: 10px;'>
        <tr>
            <th>Candidate Name</th>
            <th>Candidate Party Name</th>
            <th>Total Votes</th>
        </tr>
    </thead>";
    while($row=mysqli_fetch_array($res))
    { 			
        $body.="
        <tbody style='padding: 10px;'>
            <tr>
                <td>".($row['candidate_name'])."</td>
                <td>".($row['candidate_party'])."</td>
                <td>".($row['vote'])."</td>
            </tr>
        </tbody>";
    }
      
    $mail->Body =$body.'</table>';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
}
if(!$mail->Send()){
    echo "Email Not Sent. Check For Network Connection";
}else{
    echo "Email Sent Sucessfully";
}