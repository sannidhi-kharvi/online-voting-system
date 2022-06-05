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
	<style>
		body{
			background-image: url("images/login.jpeg");
			height: 100%;
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
		}
	</style>
</head>
<body>
	<div class="main">
		<div class="container">
			<div class="wrapper">
				<div class="heading my-3">
					<h1 class="text text-large">Voting Form</h1>
				</div>
				<form class="form" id="admin-form">
					<div class="input-control">
						<input type="text" name="aadhaar" class="input-field" placeholder="Enter aadhaar Card Number" maxlength="12" minlength="12" pattern="[0-9]+" autocomplete="off" required>
					</div>
					<div class="input-control justify-content-end">
						<button name="submit" class="btn btn-primary input-submit">Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$("#admin-form").submit(function (e) {
			e.preventDefault();
			
			$.ajax({
				url: "phpuserlogin.php",
				type: "POST",
				data: $("#admin-form").serialize(),
				encode: true,
			}).done(function (data) {
				if(data=="LOGIN SUCCESSFUL"){
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: data,
						showConfirmButton: true,
					}).then(okay => {
						if (okay) {
							window.location.href = "generateotp.php";
						}
					});
				}
				else if(data=="AADHAAR CARD NUMBER NOT REGISTERED"){
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: data,
						showConfirmButton: true,
					})
				}
				else{
					Swal.fire({
						position: 'center',
						icon: 'info',
						title: data,
						showConfirmButton: true,
					})
				}
    		});
		});
	</script>
</body>
</html>