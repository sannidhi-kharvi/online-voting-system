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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.js" ></script>
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
                <li class="nav-item active">
                    <a class="nav-link" href="election.php">Election</a>
                </li>
                <li class="nav-item dropdown">
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
		
        <table class="table table-dark text-center table-bordered table-responsive-md table-hover mt-5" style="overflow: auto;">
            <thead>
                <tr>
                    <th>Election Name</th>
                    <th>Election Start Time</th>
                    <th>Election End Time</th>
                    <th>Action</th>
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
                    <td><?php echo $row['election_name'];?></td>
                    <td><?php echo $row['start_time'];?></td>
                    <td><?php echo $row['end_time'];?></td>
                    <td>
                        <button type="button" class="btn btn-info editbtn">Edit</button>
                    </td>
                </tr>
                <?php
                }?>
            </tbody>
        </table>

        <!-- Edit Modal -->
        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Election Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form" id="edit-form" autocomplete="off">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Election Name</label>
                                <input type="text" class="form-control" id="election_name" name="election_name" placeholder="Enter Election Name" required>
                            </div>	
                            <div class="form-group">
                                <label>Election Start Time</label>
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="start_time" name="start_time" data-target="#datetimepicker1" />
                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>	
                            <div class="form-group">
                                <label>Election End Time</label>
                                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="end_time" name="end_time" data-target="#datetimepicker2" />
                                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>	
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
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
        $(function () {
            $("#datetimepicker1").datetimepicker({
                format: "YYYY/MM/DD HH:mm:ss",
            });
            $("#datetimepicker2").datetimepicker({
                format: "YYYY/MM/DD HH:mm:ss",
            });
        });

		$("#edit-form").submit(function (e) {
			e.preventDefault();

			$.ajax({
				url: "phpelection.php",
				type: "POST",
                data: new FormData(this),
				cache: false,
                contentType: false,
                processData: false
			}).done(function (data) {
				if(data=="Election Updated Successfully"){
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
				}else if(data=="Failed To Update The Election"){
                    Swal.fire({
						position: 'center',
						icon: 'error',
						title: data,
						showConfirmButton: true,
					})
                }else{
					Swal.fire({
						position: 'center',
						icon: 'warning',
						title: data,
						showConfirmButton: true,
					})
				}
    		});
		});

		$('.editbtn').on('click', function (){
            $('#editmodal').modal('show');
            $tr = $(this).closest('tr');
            let data = $tr.children("td").map(function(){
                return $(this).text();
            }).get();
            $('#election_name').val(data[0]);
            $('#start_time').val(data[1]);
            $('#end_time').val(data[2]);
        });
	</script>
</body>
</html>