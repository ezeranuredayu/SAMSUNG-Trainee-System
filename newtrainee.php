<?php
include_once 'dbconnect.php';

if(isset($_POST['signin'])) {	 
	$trainee_username = $_POST['trainee_username'];
	$trainee_password = $_POST['trainee_password'];
	$trainee_name = $_POST['trainee_name'];
	$trainee_phone = $_POST['trainee_phone'];
	$trainee_email = $_POST['trainee_email'];
	
	$sql = "INSERT INTO trainee (trainee_username, trainee_password, trainee_name, trainee_phone, trainee_email)
	        VALUES ('$trainee_username', '$trainee_password', '$trainee_name', '$trainee_phone', '$trainee_email')";
	
	if (mysqli_query($conn, $sql)) {
		echo "
		<script>
			window.location.href = 'samsunglogintrainee.php';
		</script>
		";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
	mysqli_close($conn);
}
?>
