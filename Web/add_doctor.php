<?php
	session_start();
	$pic = "pics/index.jpg";

	$employeeID = '';
	$loggedIn = '';
	$userType = '';	

	$employeeID = $_SESSION["employeeID"];
	$loggedIn   = $_SESSION["loggedin"];
	$userType   = $_SESSION['user_type'];	
	

	if ( $loggedIn == true && $userType == 'admin' && $employeeID != '' )
	{
		if ( $_POST['doctorID'] && $_POST['name'] && $_POST['surname'] && $_POST['phone'] && $_POST['salary'] )
		{
			$host   = "//144.122.71.31:8085/xe"; 	// Hostname 
			$user   = "e1818897"; 					// Username 
			$passwd = "wawZZ"; 						// Password 

			$conn = oci_connect( $user, $passwd, $host );
			
			if (!$conn) 
			{
				$m = oci_error();
				echo $m['message'], "\n";
				exit;
			}


			$doctorID      = $_POST['doctorID'];
			$name          = $_POST['name'];
			$surname       = $_POST['surname'];
			$phone         = $_POST['phone'];
			$salary        = $_POST['salary'];
			$qualification = $_POST['qualification'];

			$type = 'doctor';

			// add employee procedure
			$query = "begin ceng352_project.add_employee(:p_employee_id,:p_passwd,:p_type,:p_result); commit; end;";
			$stid = oci_parse( $conn, $query );
			
			oci_bind_by_name( $stid, ":p_employee_id", $doctorID );
			oci_bind_by_name( $stid, ":p_passwd",      $doctorID );
			oci_bind_by_name( $stid, ":p_type",        $type );
			oci_bind_by_name( $stid, ":p_result",      $result );
			oci_execute( $stid );


			// add doctor procedure
			$query  = "begin ceng352_project.add_doctor(";
			$query .= ":p_doctor_id,:p_employee_id,:p_passwd,:p_dname,:p_dsurname,:p_phone,:p_qualification,:p_salary";
			$query .= ",:p_result); commit; end;";
			//echo $query;
			$stid = oci_parse( $conn, $query );
			
			oci_bind_by_name( $stid, ":p_doctor_id",     $doctorID );
			oci_bind_by_name( $stid, ":p_employee_id",   $doctorID );
			oci_bind_by_name( $stid, ":p_passwd",        $doctorID );
			oci_bind_by_name( $stid, ":p_dname",         $name );
			oci_bind_by_name( $stid, ":p_dsurname",      $surname );
			oci_bind_by_name( $stid, ":p_phone",         $phone );
			oci_bind_by_name( $stid, ":p_qualification", $qualification );
			oci_bind_by_name( $stid, ":p_salary",        $salary );
			oci_bind_by_name( $stid, ":p_result",        $result );
			oci_execute( $stid );

			header("Location: admin.php");
		}	
	}

	else
		header("Location: index.php");

?>

<html>
	<head>

		<title>Doctor Add</title>	
	    <script src="js/jquery.min.js"     type="text/javascript"> </script>
	    <script src="js/jquery-ui.min.js"  type="text/javascript"> </script>
	    <script src="js/helper.js"         type="text/javascript"> </script>

	    <link rel="stylesheet" type="text/css" href="styles/helper.css">
	    <link rel="stylesheet" type="text/css" href="styles/table.css" >
			<link rel="stylesheet" type="text/css" href="styles/form.css"  >
			<!--
	    	<link rel="stylesheet" type="text/css" href="styles/jquery-ui.min.css"            >
	    	<link rel="stylesheet" type="text/css" href="styles/jquery-ui.structure.min.css"  >
			-->
		
		<style type="text/css">

			body 
			{
				background-image: url('<?php echo $pic;?>');
			}

		</style>

	</head>

	<body>

			<div class="form-style-5" style='margin-left:40%; width:20%;'>

				<form method="post" action="add_doctor.php" >
					<br><br>
					<p style='font-size:150%;margin-bottom:40px;color:#1A1A00'> <b><i> Add Doctor to System </i></b></p>
				
				<legend><span class="number">1</span> Doctor Info</legend>
				<input type="text" name="doctorID" placeholder="Doctor ID *" >
				<input type="text" name="name" placeholder="Doctor Name *" >
				<input type="text" name="surname" placeholder="Doctor Surname *" >
				<input type="text" name="phone" placeholder="Doctor Phone *" >
				<input type="text" name="salary" placeholder="Doctor Salary *" >
				
				<label for="job">Qualification:</label>
				<select id="qualification" name="qualification">

				  <option value="brain">Brain</option>
				  <option value="hearth">Hearth</option>
				  <option value="dentist">Dentist</option>
				  <option value="eye">Eye</option>
				  <option value="throat">Throat</option>
				  <option value="physiology">Physiology</option>
				  <option value="dietician">Dietician</option>
				  <option value="dermatology">Dermatology</option>

				</select>      
				

				<input type="submit" name="add" value="Add Doctor" />
				</form>
			</div>

	</body>
</html>		   
