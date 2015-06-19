<?php
	session_start();
	
	$employeeID = '';
	$loggedIn = '';
	$userType = '';	
	$removedEmployeeID = '';
	$removedUserType = '';

	$employeeID = $_SESSION["employeeID"];
	$loggedIn   = $_SESSION["loggedin"];
	$userType   = $_SESSION['user_type'];
	

	$data = array();	
	
	if ( $loggedIn == true && $userType == 'admin' && $employeeID != '' )
	{
		if ($_POST) 
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

			$employeeID = $_POST['employeeID'];
			$type       = $_POST['type'];

			$result = NULL;
			
			// call remove employee procedure
			$query = "begin ceng352_project.remove_employee(:p_employee_id,:p_type,:p_result); commit; end;";
			$stid  = oci_parse( $conn, $query );


			oci_bind_by_name( $stid, ":p_employee_id", $employeeID );
			oci_bind_by_name( $stid, ":p_type",        $type );
			oci_bind_by_name( $stid, ":p_result",      $result );
			oci_execute( $stid );

			//$result = trim($result);
			header("Location: admin.php");	
		}
	}

	else
		header("Location: index.php");

?>

<html>
	<head>
	<title>Remove Employee</title>	
	<style>
		.error {color: #FF0000;}
		table {
			width:60%;
		}
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
		th, td {
			padding: 5px;
			text-align: center;
		}
		table#t01 tr:nth-child(even) {
			background-color: #eee;
		}
		table#t01 tr:nth-child(odd) {
		   background-color:#fff;
		}
		table#t01 th	{
			background-color: #1E90FF; 
			color: white;
		}
	</style>

	</head>

	<body>

	</body>
</html>		   
