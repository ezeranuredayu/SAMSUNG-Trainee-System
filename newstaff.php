<?php
include_once 'dbconnect.php';

if(isset($_POST['signin'])) {	 
	$staff_username = $_POST['staff_username'];
	$staff_password = $_POST['staff_password'];
	$staff_name = $_POST['staff_name'];
	$staff_phone = $_POST['staff_phone'];
	$staff_email = $_POST['staff_email'];
	
	$sql = "INSERT INTO staff (staff_username, staff_password, staff_name, staff_phone, staff_email)
	        VALUES ('$staff_username', '$staff_password', '$staff_name', '$staff_phone', '$staff_email')";
	
	if (mysqli_query($conn, $sql)) {
		echo "
		<script>
			window.location.href = 'index.php';
		</script>
		";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
	mysqli_close($conn);
}
?>
