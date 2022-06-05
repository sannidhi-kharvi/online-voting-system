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
                <li class="nav-item active">
                    <a class="nav-link" href="candidatelist.php">Candidate List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="voterlist.php">Voter List</a>
                </li>
                <li class="nav-item">
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
        <h1 class="d-flex justify-content-center">Candidate List</h1>
        <button type="button" class="btn btn-success ml-auto" data-toggle="modal" data-target="#candidateaddmodal">
            Add Candidate
        </button>
		
        <table class="table table-dark text-center table-bordered table-responsive-md table-hover mt-5" style="overflow: auto;">
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th>Candidate Photo</th>
                    <th>Candidate Party Photo</th>
                    <th>Candidate Party Name</th>
                    <th>Election Name</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $con=mysqli_connect('localhost','root','','voting');

                function encode_image ($filename) {
                    if ($filename) {
                        $imgbinary = @fread(@fopen($filename, "r"), @filesize($filename));
                        return 'data:image/jpeg;base64,' . base64_encode($imgbinary);
                    }
                }
                $qry="select * from candidate";
                $res=mysqli_query($con,$qry);
                while($row=mysqli_fetch_array($res))
                {?>
                <tr>
                    <td hidden><?php echo $row['candidate_id'];?></td>
                    <td><?php echo $row['candidate_name'];?></td>
                    <td><?php echo '<img src="'.encode_image($row['candidate_photo']).'" class="m-auto" alt="Image" style="width:50px; height:50px;" >'?></td>
                    <td><?php echo '<img src="'.encode_image($row['candidate_party_photo']).'" class="m-auto" alt="Image" style="width:50px; height:50px;" >'?></td>
                    <td><?php echo $row['candidate_party'];?></td>
                    <td><?php echo $row['election_name'];?></td>
                    <td>
                        <button type="button" class="btn btn-info editbtn">Edit</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger deletebtn">Delete</button>
                    </td>
                </tr>
                <?php
                }?>
            </tbody>
        </table>
        
		<!-- Add Candidate Modal -->
        <div class="modal fade" id="candidateaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Candidate Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form" id="candidate-form" autocomplete="off">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Enter Candidate Name</label>
                                <input type="text" class="form-control" name="candidate_name" placeholder="Enter candidate Name" pattern="[A-Z a-z]+" title="Please enter only characters" required>
                            </div>
                            <div class="form-group">
                                <label">Select Candidate Photo</label>
                                <input type="file" class="form-control-file" name="candidate_photo" required>
                            </div>
                            <div class="form-group">
                                <label>Select Candidate Party Photo</label>
                                <input type="file" class="form-control-file" name="party_photo" required>
                            </div>
                            <div class="form-group">
                                <label>Enter Political Party</label>
                                <input type="text" class="form-control" name="party_name" placeholder="Enter Party Name" pattern="[A-Z a-z]+" title="Please enter only characters" required>
                            </div>
                            <?php
                            $qry1="select * from election";
                            $res1=mysqli_query($con,$qry1);
                            if($row=mysqli_fetch_array($res1))
                            {
                            ?>
                            <div class="form-group">
                                <label for="Election Name">Election Name</label>
                                <input type="text" class="form-control" name="election_name" value="<?php echo $row['election_name'];?>" readonly>
                            </div>
                            <?php
                            }?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="add" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

		<!-- Edit Modal -->
        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Edit Candidate Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form" id="edit-form" autocomplete="off">
                        <div class="modal-body">
                            <input type="hidden" id="candidate_id" name="candidate_id">
                            <div class="form-group">
                                <label>Candidate Name</label>
                                <input type="text" class="form-control" id="candidate_name" name="candidate_name" placeholder="Enter candidate Name" required="" pattern="[A-Z a-z]+" title="Please enter only characters" >
                            </div>
                            <div class="form-group">
                                <label>Candidate Photo</label>
                                <input type="file" class="form-control-file" id="candidate_photo" name="candidate_photo">
                            </div>
                            <div class="form-group">
                                <label>Candidate Party Photo</label>
                                <input type="file" class="form-control-file" id="party_photo" name="party_photo">
                            </div>
                            <div class="form-group">
                                <label>Political Party</label>
                                <input type="text" class="form-control" name="party_name" id="party_name" placeholder="Enter Party Name" pattern="[A-Z a-z]+" title="Please enter only characters" required>
                            </div>
                            <div class="form-group">
                                <label>Election Name</label>
                                <input type="text" class="form-control" id="election_name" name ="election_name" readonly>
                            </div>	
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="update" class="btn btn-primary" >Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Candidate</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="submit" id="delete-form" class="btn btn-primary">YES</button>
                    </div>
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
		$("#candidate-form").submit(function (e) {
			e.preventDefault();
            
			$.ajax({
				url: "phpcandidateadd.php",
				type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false
			}).done(function (data) {
				if(data=="Candidate Registered Successfully"){
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
                }else if(data=="Registeration Unsuccessful"){
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

        $("#edit-form").submit(function (e) {
			e.preventDefault();

			$.ajax({
				url: "phpcandidateedit.php",
				type: "POST",
                data: new FormData(this),
				cache: false,
                contentType: false,
                processData: false
			}).done(function (data) {
				if(data=="Candidate Updated Successfully"){
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
				}else if(data=="Failed To Update The Candidate"){
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
            $('#candidate_id').val(data[0]);
            $('#candidate_name').val(data[1]);
            $('#party_name').val(data[4]);
            $('#election_name').val(data[5]);
        });

        var data;
        $('.deletebtn').on('click',function(){
            $('#deletemodal').modal('show');
            $tr = $(this).closest('tr');
            data = $tr.children("td").map(function(){
                return $(this).text();
            }).get();
            $('#deletemodal .modal-body').html("Are you sure want to remove Candidate " + data[1] + "?");
        });

        $('#delete-form').on('click',function(){
            let cid = data[0];
            $.ajax({
				url: "phpcandidatedelete.php",
				type: "POST",
                data: {candidate_id : cid},
				encode: true,
			}).done(function (data) {
                if(data=="Candidate Deleted Successfully"){
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