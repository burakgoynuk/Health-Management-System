<?php
	session_start();
	$pic = "pics/index.jpg";

	$employeeID = '';
	$loggedIn = '';
	$userType = '';	

	$employeeID = $_SESSION["employeeID"];
	$loggedIn   = $_SESSION["loggedin"];
	$userType   = $_SESSION['user_type'];	
	


	$employeeID    = $_POST['employeeID'];
	$secretaryID   = $_POST['secretaryID'];
	$password      = $_POST['password'];
	$name          = $_POST['name'];
	$surname       = $_POST['surname'];
	$phone         = $_POST['phone'];
	$salary        = $_POST['salary'];


	if ( $loggedIn == true && $userType == 'admin' && $employeeID != '' )
	{
		if ( $_POST['fromEdit'] == 'true' )
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

			$employeeID    = $_POST['employeeID'];
			$secretaryID   = $_POST['secretaryID'];
			$password      = $_POST['password'];
			$name          = $_POST['name'];
			$surname       = $_POST['surname'];
			$phone         = $_POST['phone'];
			$salary        = $_POST['salary'];

			
			//echo 'EI ' . $employeeID . ' DI ' . $secretaryID . ' ' . $password . ' ' . $name . ' ' . $surname . ' ' . $phone . ' ' . $salary . ' ' . $qualification;

			$type = 'secretary';

			// add doctor procedure
			$query  = "begin ceng352_project.edit_secretary(";
			$query .= ":p_secretary_id,:p_employee_id,:p_passwd,:p_sname,:p_ssurname,:p_phone,:p_salary";
			$query .= ",:p_result); commit; end;";
			//echo $query;
			$stid = oci_parse( $conn, $query );
			
			oci_bind_by_name( $stid, ":p_secretary_id",  $secretaryID );
			oci_bind_by_name( $stid, ":p_employee_id",   $secretaryID );
			oci_bind_by_name( $stid, ":p_passwd",        $password );
			oci_bind_by_name( $stid, ":p_sname",         $name );
			oci_bind_by_name( $stid, ":p_ssurname",      $surname );
			oci_bind_by_name( $stid, ":p_phone",         $phone );
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

		<title>Secretary Edit</title>	
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

				<form method="post" action="edit_secretary.php" >
					<br><br>
					<p style='font-size:150%;margin-bottom:40px;color:#1A1A00'> <b><i> Edit Secretary </i></b></p>
				
				<legend><span class="number">1</span> Secretary Info</legend>
				<input type="hidden" name="employeeID" value=<?php echo $employeeID; ?> >
				<input type="hidden" name="secretaryID" value= <?php echo $secretaryID; ?> >
				<input type="text" name="password" value=<?php echo $password; ?> >
				<input type="text" name="name" value=<?php echo $name; ?> >
				<input type="text" name="surname" value=<?php echo $surname; ?> >
				<input type="text" name="phone" value=<?php echo $phone; ?> >
				<input type="text" name="salary" value=<?php echo $salary; ?> >
				     
				
				<input type="hidden" name="fromEdit" value="true" >
				<input type="submit" name="edit" value="Edit Secretary" />
				</form>
			</div>

	</body>
</html>		   
