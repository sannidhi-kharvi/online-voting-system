<?php
session_start();

if(!isset($_SESSION['aadhaar'])) {
	header('location: logout.php');
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Online Voting System</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
<body>
	<div class="container-fluid">
		<h2 class="text-center">Voters Details</h2>

		<table class="table table-dark text-center table-bordered table-responsive-md table-hover mt-5">
			<thead>
				<tr>
					<th>Voter Name</th>
					<th>Voter E-Mail</th>
					<th>Voter Dob</th>
					<th>Voter District</th>
					<th>Voter Taluk</th>
					<th>Voter Booth_Place(Ward)</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$aadhaar=$_SESSION['aadhaar'];
				
				$con=mysqli_connect('localhost','root','','voting');
				$qry="select * from voter where aadhaar='$aadhaar'";
				$res=mysqli_query($con,$qry);
				if($row=mysqli_fetch_array($res))
				{?>
				<tr>
					<td><?php echo $row['fname'];?></td>
					<td><?php echo $row['email'];?></td>
					<td><?php echo $row['dob'];?></td>
					<td><?php echo $row['district'];?></td>
					<td><?php echo $row['taluk'];?></td>
					<td><?php echo $row['booth'];?></td>
				</tr>
				<?php
				}?>
			</tbody>
		</table>

		<div class="d-flex justify-content-center">
			<button type="submit" id="generate" class="btn btn-info btn-lg mt-5">Generate OTP</button>
		</div>
	</div>

	<script>
		$("#generate").click(function () {
			$.ajax({
				url: "phpgenerateotp.php",
				type: "POST",
				encode: true,
			}).done(function (data) {
				if(data=="OTP Sent To Your E-Mail"){
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: data,
						showConfirmButton: true,
					}).then(okay => {
						if (okay) {
							window.location.href = "confirmotp.php";
						}
					});
				}
				else {
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: data,
						showConfirmButton: true,
					})
				}
    		});
		});
	</script>
	
</body>
</html>