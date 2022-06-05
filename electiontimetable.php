<?php
session_start();

if(!isset($_SESSION['admin'])) {
	header('location: adminlogout.php');
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
    <nav class="navbar navbar-expand-md navbar-dark bg-primary sticky-top">
        <a href="javascript:void(0)" class="navbar-brand">Online Voting System</a>
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ml-3" id="navbarNavDropdown">
            <ul class="navbar-nav ml-3">
                <li class="nav-item">
                    <a class="nav-link" href="candidatelist.php">Candidate List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="voterlist.php">Voter List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="election.php">Election</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Email</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="electiontimetable.php">Election Time Table</a>
                    <a class="dropdown-item" href="electionresult.php">Election Result</a>
                    </div>
                </li>
            </ul>
            <button type="button" class="nav-item btn btn-danger ml-auto" data-toggle="modal" data-target="#logoutmodal">
                Logout
            </button>
        </div>
    </nav>

    <div class="container-fluid">
        <h1 class="d-flex justify-content-center">Election Time Table</h1>
		
        <table class="table table-dark text-center table-bordered table-responsive-md table-hover mt-5">
            <thead>
                <tr>
                    <th>Election Name</th>
                    <th>Election Start Time</th>
                    <th>Election End Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $con=mysqli_connect('localhost','root','','voting');
                $qry="select * from election";
                $res=mysqli_query($con,$qry);
                while($row=mysqli_fetch_array($res))
                {?>
                <tr>
                    <td hidden><?php echo $row['id'];?></td>
                    <td><?php echo $row['election_name'];?></td>
                    <td><?php echo $row['start_time'];?></td>
                    <td><?php echo $row['end_time'];?></td>
                </tr>
                <?php
                }?>
            </tbody>
        </table>
        
        <div class="d-flex justify-content-center mt-5">
            <button type="button" id="email" class="btn btn-success btn-lg d-flex align-self-center">Send Email</button>
        </div>
        
        <!-- Logout Modal -->
        <div class="modal fade" id="logoutmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">Are you sure want to logout?</div>
                    <form method="POST" action="adminlogout.php">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Logout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

	<script>
		$('#email').on('click', function (){
            $.ajax({
				url: "phpelectiontimetable.php",
				type: "POST",
				cache: false,
                contentType: false,
                processData: false
			}).done(function (data) {
				if(data=="Email Sent Sucessfully"){
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: data,
						showConfirmButton: true,
					}).then(okay => {
						if (okay) {
							location.reload();
						}
					});
				}else{
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