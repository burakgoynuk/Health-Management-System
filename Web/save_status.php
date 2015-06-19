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
	
	if ( $loggedIn == true && $userType == 'doctor' && $employeeID != '' )
	{
		if ($_POST) 
		{
			$recordID        = $_POST['recordID'];
			$newStatus       = $_POST['status'];
			$newTreatment    = $_POST['treatment'];
			$patientSSN      = $_POST['ssn'];
			
			$result = NULL;
			

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


			if ( $newStatus == '' )
			{
				// Nothing
			}


			/*********************************************************************************************************/


			else if ( $newStatus == 'Bed' )
			{
				// call arrange room procedure
				$query  = "begin ceng352_project.arrange_room(:p_record_id,:p_ssn,:p_result); end;";
				$stid   = oci_parse( $conn, $query );

				oci_bind_by_name( $stid, ":p_record_id", $recordID );
				oci_bind_by_name( $stid, ":p_ssn",       $patientSSN );
				oci_bind_by_name( $stid, ":p_result",    $result );
				
				oci_execute( $stid );

		        oci_free_statement($stid);
			}


			/*********************************************************************************************************/


			else if ( $newStatus == 'End' )
			{
				// call end treatment procedure
				$query  = "begin ceng352_project.end_treatment(:p_record_id,:p_result); end;";
				$stid   = oci_parse( $conn, $query );

				oci_bind_by_name( $stid, ":p_record_id",  $recordID );
				oci_bind_by_name( $stid, ":p_result",     $result );
				
				oci_execute( $stid );

		        oci_free_statement($stid);
			}
	

			/*********************************************************************************************************/


			// call set status procedure
			$query  = "begin ceng352_project.set_status(:p_record_id,:p_new_status,:p_result); end;";
			$stid   = oci_parse( $conn, $query );

			oci_bind_by_name( $stid, ":p_record_id",  $recordID );
			oci_bind_by_name( $stid, ":p_new_status", $newStatus );
			oci_bind_by_name( $stid, ":p_result",     $result );
			
			oci_execute( $stid );

	        oci_free_statement($stid);


			/*********************************************************************************************************/


			// call set treatment procedure
			$query  = "begin ceng352_project.set_treatment(:p_record_id,:p_new_treatment,:p_result); end;";
			$stid   = oci_parse( $conn, $query );

			oci_bind_by_name( $stid, ":p_record_id",     $recordID );
			oci_bind_by_name( $stid, ":p_new_treatment", $newTreatment );
			oci_bind_by_name( $stid, ":p_result",        $result );
			
			oci_execute( $stid );

	        oci_free_statement($stid);
	

			header("Location: doctor.php");	
		}
	}

	else
		header("Location: index.php");

?>

<html>
	<head>
	<title>Change Record</title>	
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
