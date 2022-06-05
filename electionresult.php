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
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
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
        <h1 class="d-flex justify-content-center">Election Result</h1>
		
        <table class="table table-dark text-center table-bordered table-responsive-md table-hover mt-5" style="overflow: auto;">
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th>Candidate Photo</th>
                    <th>Candidate Party Photo</th>
                    <th>Candidate Party Name</th>
                    <th>Election Name</th>
                    <th>Total Votes</th>
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
                    <td><?php echo $row['vote'];?></td>
                </tr>
                <?php
                }?>
            </tbody>
        </table>
        
        <div class="d-flex justify-content-center mt-5">
            <button type="button" id="email" class="btn btn-success btn-lg d-flex align-self-center">Send Result</button>
        </div>

        <!-- Charts -->
        <div class="mt-5" id="chart1" style="height: 350px; width: 100%;"></div>
        <div class="mt-5" id="chart2" style="height: 350px; width: 100%;"></div>
        
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
				url: "phpelectionresult.php",
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
        
        <?php
        $con=mysqli_connect('localhost','root','','voting');
 
        $sql="select * from candidate";
        $res=mysqli_query($con,$sql);
        $dataPoints1 = array();
        while($row=mysqli_fetch_assoc($res)){ 
            array_push($dataPoints1,array("y" => $row['vote'],"label" => $row['candidate_name']));
        }
        ?>

        var options = {
            title: {
                text: "Percentage Of Total Number Of Votes Gathered By Individual Candidates",
            },
            animationEnabled: true,
            exportEnabled: true,
            data: [{
                type: "pie",
                startAngle: 0,
                toolTipContent: "<b>{label}</b>: {y}",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 18,
                indexLabel: "{label} - #percent%",
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK);?>
            }]
        };
        $("#chart1").CanvasJSChart(options);


        <?php
        $con=mysqli_connect('localhost','root','','voting');
 
        $res1=mysqli_query($con,"SELECT count(gender) as male FROM `voter` WHERE `gender`='male'");
        $male=mysqli_fetch_assoc($res1);
        
        $res2=mysqli_query($con,"SELECT count(gender) as female FROM `voter` WHERE `gender`='female'");
        $female=mysqli_fetch_assoc($res2);

        $dataPoints2 = array( 
            array("y" => $male['male'],"label" => "Male" ),
            array("y" => $female['female'], "label" => "Female" )
        );
        ?>

        var options = {
            title: {
                text: "Percentage Of Total Number Of Votes Gathered By Individual Candidates",
            },
            animationEnabled: true,
            exportEnabled: true,
            data: [{
                type: "pie",
                startAngle: 0,
                toolTipContent: "<b>{label}</b>: {y}",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 18,
                indexLabel: "{label} - #percent%",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK);?>
            }]
        };
        $("#chart2").CanvasJSChart(options);

	</script>
</body>
</html>