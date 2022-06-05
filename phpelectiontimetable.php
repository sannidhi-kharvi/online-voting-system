<?php
require("PHPMailer_5.2.0/class.phpmailer.php");
$con=mysqli_connect('localhost','root','','voting');
$sql=mysqli_query($con,"select * from election");
if(mysqli_num_rows($sql)>0)
{
	$row=mysqli_fetch_assoc($sql);
    $getusers=mysqli_query($con,"select fname,lname,email from voter");

    $mail = new PHPMailer();
    $mail->IsSMTP();   
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );                                   
    foreach($getusers as $row1)
    {
        $mail->AddAddress($row1['email']);
        $mail->WordWrap = 50;                        
        $mail->IsHTML(true); 
        $mail->Subject = "Election Time Table For The ".($row['election_name'])."";
        $mail->Body ="
        <H3>Election Time Table For The ".($row['election_name'])."<H3><BR>
        <table border='1' cellspacing='0' cellpadding='5' align='center'>
        <thead style='background-color: #3A89FD;color: #ffffff;padding: 10px;'>
            <tr>
                <th>Election Name</th>
                <th>Election Start Time</th>
                <th>Election End Time</th>
            </tr>
        </thead>
        <tbody style='padding: 10px;'>
            <tr>
                <td>".($row['election_name'])."</td>
                <td>".($row['start_time'])."</td>
                <td>".($row['end_time'])."</td>
            <tr>
		</tbody>
        </table>";
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
}