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
		<h2 class="text-center">Vote Candidate</h2>

        <h6 class="text-center mt-5" id="countdown">Time Remaining To Vote: 40 seconds</h6>

		<table class="table table-dark text-center table-bordered table-responsive-md table-hover mt-5" style="overflow: auto;">
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th>Candidate Photo</th>
                    <th>Candidate Party Photo</th>
                    <th>Candidate Party Name</th>
                    <th>Election Name</th>
                    <th>Vote</th>
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
                        <button type="button" class="btn btn-success votebtn">Vote</button>
                    </td>
                </tr>
                <?php
                }?>
            </tbody>
		</table>

        <div class="modal fade" id="votemodal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Are You Sure Want To Vote For This Candidate?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form" id="vote-form">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="candidate_id" name="candidate_id" readonly>
                            <div class="form-group">
                                <label>Candidate Name</label>
                                <input type="text" class="form-control" id="candidate_name"  name="candidate_name" readonly>
                            </div>
                            <div class="form-group">
                                <label>Candidate Party Name</label>
                                <input type="text" class="form-control" name="candidate_party" id="candidate_party" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary">Vote Now!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>

    <script>
        var seconds = 39;
        function secondPassed() {
            var minutes = Math.round((seconds - 30)/60),
            remainingSeconds = seconds % 60;
            if (remainingSeconds < 10) {
                remainingSeconds = "0" + remainingSeconds;
            }
            
            $('#countdown').html("Time Remaining To Vote: "+ remainingSeconds + " seconds");
            if (seconds == 0) {
                clearInterval(countdownTimer);
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Times Up! You Cant Vote For The Second Time',
                    showConfirmButton: true,
                }).then(okay => {
                    if (okay) {
                        window.location.href = "logout.php";
                    }
                });
            } else {
                seconds--;
            }
        }
        var countdownTimer = setInterval('secondPassed()', 1000);
    
        $('.votebtn').on('click',function(){
            $('#votemodal').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function(){
                return $(this).text();
            }).get();
            $('#candidate_id').val(data[0]);
            $('#candidate_name').val(data[1]);
            $('#candidate_party').val(data[4]);
        });

        $("#vote-form").submit(function (e) {
			e.preventDefault();
            $('#votemodal').modal('hide');
			clearInterval(countdownTimer);
			$.ajax({
				url: "phpvote.php",
				type: "POST",
				data: $("#vote-form").serialize(),
				encode: true,
			}).done(function (data) {
				if(data=="Your Vote Successfully Submitted"){
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: data,
						showConfirmButton: true,
					}).then(okay => {
						if (okay) {
							window.location.href = "logout.php";
						}
					});
				}
				else{
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: data,
						showConfirmButton: true,
					}).then(okay => {
						if (okay) {
							window.location.href = "logout.php";
						}
					});
				}
    		});
		});
    </script>
</body>
</html>