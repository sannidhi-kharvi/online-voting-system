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
		<h2 class="text-center">Verify Your OTP</h2>
        <form class="form mt-5" id="verify-otp">
            <div class="d-flex justify-content-center">
                <input type="text" name="otp" placeholder="Enter your OTP" autocomplete="off" required>
                <button name="submit" class="btn btn-primary ml-4">Verify</button>
            </div>
        </form>
    </div>

    <script>
		$("#verify-otp").submit(function (e) {
			e.preventDefault();

			$.ajax({
				url: "phpconfirmotp.php",
				type: "POST",
				data: $("#verify-otp").serialize(),
				encode: true,
			}).done(function (data) {
				if(data=="OTP Verified"){
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: data,
						showConfirmButton: true,
					}).then(okay => {
						if (okay) {
							window.location.href = "vote.php";
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