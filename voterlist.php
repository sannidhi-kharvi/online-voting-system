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
                <li class="nav-item active">
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
        <h1 class="d-flex justify-content-center">Voter List</h1>
        <button type="button" class="btn btn-success ml-auto" data-toggle="modal" id="addvoter" data-target="#voteraddmodal">
            Add Voter
        </button>
		
        <table class="table table-dark text-center table-bordered table-responsive table-hover mt-5" style="overflow: auto;">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th style="min-width:107px;">Date Of Birth</th>
                    <th>Gender</th>
                    <th>District</th>
                    <th>Taluk</th>
                    <th>Booth</th>
                    <th>Aadhaar Number</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $con=mysqli_connect('localhost','root','','voting');
                $qry="select * from voter";
                $res=mysqli_query($con,$qry);
                while($row=mysqli_fetch_array($res))
                {?>
                <tr>
                    <td><?php echo $row['fname'];?></td>
                    <td><?php echo $row['lname'];?></td>
                    <td><?php echo $row['dob'];?></td>
                    <td><?php echo $row['gender'];?></td>
                    <td><?php echo $row['district'];?></td>
                    <td><?php echo $row['taluk'];?></td>
                    <td><?php echo $row['booth'];?></td>
                    <td><?php echo $row['aadhaar'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['number'];?></td>
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
        

		<!-- Add Voter Modal -->
        <div class="modal fade" id="voteraddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Voter Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form" id="voter-form" autocomplete="off">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group">
                                <label>Date Of Birth</label>
                                <input type="date" id="dob" name="dob" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Gender</label><br>
                                <input type="radio" name="gender" value="male" required>Male
                                <input type="radio" class="ml-3" name="gender" value="female" required>Female
                            </div>
                            <div class="form-group">
                                <label>District</label>
                                <select class="browser-default custom-select" class="form-control district" name="district" id="district" size="1" required>
                                    <option value="" selected="selected">Select District</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Taluk</label>
                                <select class="browser-default custom-select" class="form-control taluk" name="taluk" id="taluk" size="1" required>
                                    <option value="" selected="selected">Select Taluk</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Booth Ward</label>
                                <select class="browser-default custom-select" class="form-control booth" name="booth" id="booth" size="1" required>
                                    <option value="" selected="selected">Select Booth Ward</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Aadhaar Card Number</label>
                                <input type="text" name="aadhaar" class="form-control" placeholder="Must be 12 Digits" title="Enter aadhaar card Number" maxlength="12" minlength="12" pattern="[0-9]+" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email"  name= "email" placeholder="Email" class="form-control" placeholder="Enter Your E-mail" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="number" class="form-control" pattern="[0-9]{10}" title="Enter Mobile Number" placeholder="Must Be 10 Digits" maxlength="10" required>
                            </div>
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
                        <h5 class="modal-title" >Edit Voter Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form" id="edit-form" autocomplete="off">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group">
                                <label>Date Of Birth</label>
                                <input type="date" id="dob1" name="dob" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Gender</label><br>
                                <input type="radio" name="gender" value="male" id="male" required>Male
                                <input type="radio" class="ml-3" name="gender" value="female" id="female" required>Female
                            </div>
                            <div class="form-group">
                                <label>District</label>
                                <select class="browser-default custom-select" class="form-control district" name="district" id="district1" size="1" required>
                                    <option value="" selected="selected">Select District</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Taluk</label>
                                <select class="browser-default custom-select" class="form-control taluk" name="taluk" id="taluk1" size="1" required>
                                    <option value="" selected="selected">Select Taluk</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Booth Ward</label>
                                <select class="browser-default custom-select" class="form-control booth" name="booth" id="booth1" size="1" required>
                                    <option value="" selected="selected">Select Booth Ward</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="aadhaar" id="aadhaar" class="form-control" placeholder="Must be 12 Digits" title="Enter aadhaar card Number" maxlength="12" minlength="12" pattern="[0-9]+" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" id="email" placeholder="Email" class="form-control" placeholder="Enter Your E-mail" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="number" id="number" class="form-control" pattern="[0-9]{10}" title="Enter Mobile Number" placeholder="Must Be 10 Digits" maxlength="10" required>
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
        var dt = new Date();
        dt.setFullYear(dt.getFullYear() - 18);
        dob.max=dt.toISOString().split('T')[0];
        dob1.max=dt.toISOString().split('T')[0];

        var electionObject = {
            "Bangalore": { "Bangalore-North": ["Dasarahalli"],
                        "Bangalore-South": ["Marthahalli"],
                        "Bangalore-East": ["Yalhanka"]},
        }

		$("#voter-form").submit(function (e) {
			e.preventDefault();
            
			$.ajax({
				url: "phpvoteradd.php",
				type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false
			}).done(function (data) {
				if(data=="Voter Registered Successfully"){
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
				url: "phpvoteredit.php",
				type: "POST",
                data: new FormData(this),
				cache: false,
                contentType: false,
                processData: false
			}).done(function (data) {
				if(data=="Voter Updated Successfully"){
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
				}else if(data=="Failed To Update The Voter"){
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

        var data;
        $('.deletebtn').on('click',function(){
            $('#deletemodal').modal('show');
            $tr = $(this).closest('tr');
            data = $tr.children("td").map(function(){
                return $(this).text();
            }).get();
            $('#deletemodal .modal-body').html("Are you sure want to remove Voter " + data[0] +" "+ data[1] + "?");
        });

        $('#delete-form').on('click',function(){
            let aadhaar = data[7];
            $.ajax({
				url: "phpvoterdelete.php",
				type: "POST",
                data: {aadhaar : aadhaar},
				encode: true,
			}).done(function (data) {
                if(data=="Voter Deleted Successfully"){
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

        $('.editbtn').on('click', function (){
            $('#editmodal').modal('show');
            $tr = $(this).closest('tr');
            let data = $tr.children("td").map(function(){
                return $(this).text();
            }).get();
            $('#fname').val(data[0]);
            $('#lname').val(data[1]);
            $('#dob1').val(data[2]);
            if(data[3]=="male"){
                $('#male').prop('checked', true);
            }else{
                $('#female').prop('checked', true);
            }
            $('#aadhaar').val(data[7]);
            $('#email').val(data[8]);
            $('#number').val(data[9]);


            let district = document.getElementById("district1"),
            taluk = document.getElementById("taluk1"),
            booth = document.getElementById("booth1");
            district.length = 1;
            for (var country in electionObject) {
                district.options[district.options.length] = new Option(country, country);
            }
            $("#district1 option[value=" + data[4] + "]").prop('selected', true);
            district.onchange = function () {
                taluk.length = 1; // remove all options bar first
                booth.length = 1; // remove all options bar first
                if (this.selectedIndex < 1) return; // done 
                for (var state in electionObject[this.value]) {
                    taluk.options[taluk.options.length] = new Option(state, state);
                }
            }
            district.onchange(); // reset in case page is reloaded
            $("#taluk1 option[value=" + data[5] + "]").prop('selected', true);
            taluk.onchange = function () {
                booth.length = 1; // remove all options bar first
                if (this.selectedIndex < 1) return; // done 
                var districts = electionObject[district.value][this.value];
                for (var i = 0; i < districts.length; i++) {
                    booth.options[booth.options.length] = new Option(districts[i], districts[i]);
                }
            }
            taluk.onchange();
            $("#booth1 option[value=" + data[6] + "]").prop('selected', true);
        });
           
        $('#addvoter').on('click', function (){
            let district = document.getElementById("district"),
            taluk = document.getElementById("taluk"),
            booth = document.getElementById("booth"); 
            select(district,taluk,booth);
        }); 

        function select(district,taluk,booth){
            district.length = 1;
            for (var country in electionObject) {
                district.options[district.options.length] = new Option(country, country);
            }
            district.onchange = function () {
                taluk.length = 1; // remove all options bar first
                booth.length = 1; // remove all options bar first
                if (this.selectedIndex < 1) return; // done 
                for (var state in electionObject[this.value]) {
                    taluk.options[taluk.options.length] = new Option(state, state);
                }
            }
            district.onchange(); // reset in case page is reloaded
            taluk.onchange = function () {
                booth.length = 1; // remove all options bar first
                if (this.selectedIndex < 1) return; // done 
                var districts = electionObject[district.value][this.value];
                for (var i = 0; i < districts.length; i++) {
                    booth.options[booth.options.length] = new Option(districts[i], districts[i]);
                }
            }
            taluk.onchange();
        }        
	</script>
</body>
</html>