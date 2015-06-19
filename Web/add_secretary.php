<?php
	session_start();
	$pic = "pics/index.jpg";

	$employeeID = '';
	$loggedIn = '';
	$userType = '';	

	$employeeID = $_SESSION["employeeID"];
	$loggedIn   = $_SESSION["loggedin"];
	$userType   = $_SESSION['user_type'];	
	
	$secretaryID = $name = $surname = $phone = $salary = '';

	if ( $loggedIn == true && $userType == 'admin' && $employeeID != '' )
	{
		if ( $_POST['secretaryID'] && $_POST['name'] && $_POST['surname'] && $_POST['phone'] && $_POST['salary'])
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


			$secretaryID   = $_POST['secretaryID'];
			$name          = $_POST['name'];
			$surname       = $_POST['surname'];
			$phone         = $_POST['phone'];
			$salary        = $_POST['salary'];

			$type = 'secretary';


			// add employee procedure
			$query = "begin ceng352_project.add_employee(:p_employee_id,:p_passwd,:p_type,:p_result); commit; end;";
			$stid = oci_parse( $conn, $query );
			
			oci_bind_by_name( $stid, ":p_employee_id", $secretaryID );
			oci_bind_by_name( $stid, ":p_passwd",      $secretaryID );
			oci_bind_by_name( $stid, ":p_type",        $type );
			oci_bind_by_name( $stid, ":p_result",      $result );
			oci_execute( $stid );


			// add secretary procedure
			$query  = "begin ceng352_project.add_secretary(";
			$query .= ":p_secretary_id,:p_employee_id,:p_passwd,:p_sname,:p_ssurname,:p_phone,:p_salary";
			$query .= ",:p_result); commit; end;";
			//echo $query;
			$stid = oci_parse( $conn, $query );
			
			oci_bind_by_name( $stid, ":p_secretary_id",     $secretaryID );
			oci_bind_by_name( $stid, ":p_employee_id",   $secretaryID );
			oci_bind_by_name( $stid, ":p_passwd",        $secretaryID );
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
		<title>Secretary Add</title>	
	    <script src="js/jquery.min.js"     type="text/javascript"> </script>
	    <script src="js/jquery-ui.min.js"  type="text/javascript"> </script>
	    <script src="js/helper.js"         type="text/javascript"> </script>

	    <link rel="stylesheet" type="text/css" href="styles/helper.css">
	    <link rel="stylesheet" type="text/css" href="styles/table.css" >
		<link rel="stylesheet" type="text/css" href="styles/form.css"  >

		
		<style type="text/css">

			body 
			{
				background-image: url('<?php echo $pic;?>');
			}

		</style>

	</head>

	<body>

			<div class="form-style-5" style='margin-left:40%; width:20%;'>

				<form method="post" action="add_secretary.php" >
					<br><br>
					<p style='font-size:150%;margin-bottom:40px;color:#1A1A00'> <b><i> Add Secretary to System </i></b></p>
				
				<legend><span class="number">1</span> Secretary Info</legend>
				<input type="text" name="secretaryID" placeholder="Secretary ID *" >
				<input type="text" name="name" placeholder="Secretary Name *" >
				<input type="text" name="surname" placeholder="Secretary Surname *" >
				<input type="text" name="phone" placeholder="Secretary Phone *" >
				<input type="text" name="salary" placeholder="Secretary Salary *" >
				
				<input type="submit" name="add" value="Add Secretary" />
				</form>
			</div>


	</body>
</html>		   
