<?php
	session_start();
	$pic = "pics/index.jpg";

	$employeeID = '';
	$loggedIn = '';
	$userType = '';	


	$employeeID = $_SESSION["employeeID"];
	$loggedIn   = $_SESSION["loggedin"];
	$userType   = $_SESSION['user_type'];
	
	
	$data = array();	
	$user_name = '';
	
	if ( $loggedIn == true && $userType == 'staff' && $employeeID != '' )
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

		$data['rooms'] = array();
		$data['users'] = array();
		$type = 'staff';
		
		// call get employee procedure
		$query  = "begin ceng352_project.get_employee(:p_employee_id,:p_type,:p_employees); end;";
		$cursor = oci_new_cursor($conn);
		$stid   = oci_parse( $conn, $query );
	

		oci_bind_by_name( $stid, ":p_employee_id", $employeeID );
		oci_bind_by_name( $stid, ":p_type",        $type );
		oci_bind_by_name( $stid, ":p_employees",   $cursor, -1, OCI_B_CURSOR );
		
		oci_execute( $stid );
        oci_execute( $cursor );

        while ( ($row = oci_fetch_array($cursor)) ) 
            array_push($data['users'], $row);

        $user_name = $data['users'][0]['SNAME'] . ' ' . $data['users'][0]['SSURNAME'];

        
        oci_free_statement($stid);
        oci_free_statement($curs);
		

		// call responsible rooms procedure
		$query  = "begin ceng352_project.responsible_rooms(:p_staff_id,:p_rooms); end;";
		$cursor = oci_new_cursor($conn);
		$stid   = oci_parse( $conn, $query );
	

		oci_bind_by_name( $stid, ":p_staff_id", $employeeID );
		oci_bind_by_name( $stid, ":p_rooms",    $cursor, -1, OCI_B_CURSOR );
		
		oci_execute( $stid );
        oci_execute( $cursor );

        while ( ($row = oci_fetch_array($cursor)) ) 
            array_push($data['rooms'], $row);


        oci_free_statement($stid);
        oci_free_statement($curs);
		
	}

	else	
		header("Location: index.php");	

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Staff</title>	
		<!--
        <script src="js/jquery.min.js"     type="text/javascript"> </script>
        <script src="js/jquery-ui.min.js"  type="text/javascript"> </script>
        <script src="js/helper.js"         type="text/javascript"> </script>
		-->	
        <link rel="stylesheet" type="text/css" href="styles/helper.css" >
        <link rel="stylesheet" type="text/css" href="styles/button.css" >
        <link rel="stylesheet" type="text/css" href="styles/table.css"  >
   		<link rel="stylesheet" type="text/css" href="styles/form.css"   >

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
		<br><br>
        <div style='width:20%; float:right'>
    		<form method="post" action="logout.php" style="float:left">
   				<input type="submit" name="logout" class="myButton" value="Logout">
			</form>
		</div>
		
		<form method="post" action="index.php" align="left">
   			<input type="submit" name="back" class="myButton" value="Back">
		</form>
		
		<h2 align="center"> <?php echo 'Welcome, ' . $user_name; ?> </h2>   
		<h4 align="center"><i>Title: Staff</i></h4>	
		
	<div style='width:70%;margin-left:15%; margin-top:70px;'>	
		<h2 style='margin-left:40%'> Your Assigned Rooms </h2>  
		<div>
		<table style='margin-left:35%' align="center" class="rwd-table">
	       <tr>
	       		<th>Room ID</th>
	       		<th>Room Name</th>
	            <th># of Patients</th>
	        </tr>
	   
	        <?php
	        	
	        	for( $i = 0; $i < count($data['rooms']); $i++ )
		        {    
		            echo '<tr>';
		            echo '<td>' . $data['rooms'][$i]['ROOMID'] . '</td>';
		            echo '<td>' . $data['rooms'][$i]['RNAME'] . '</td>';
		            echo '<td>' . $data['rooms'][$i]['NUMBEROFPATIENT'] . '</td>';
		            echo '</tr>';
		        }
	        	echo "</table>";
		        if ( count($data['rooms']) == 0 )
		        {
		        	echo '<p align="center"><span class="error" >There is no currently assigned roomf for you!</span></p>';
		        }
	        ?>
	</div>        

	</body>
</html>		   
