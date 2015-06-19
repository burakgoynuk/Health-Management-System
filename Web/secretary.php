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
	
	if ( $loggedIn == true && $userType == 'secretary' && $employeeID != '' )
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


		/*********************************************************************************************************/


		$data['records'] = array();
		
		// call new records procedure
		$query  = "begin ceng352_project.not_confirmed_records(:p_records); end;";
		$cursor = oci_new_cursor($conn);
		$stid   = oci_parse( $conn, $query );


		oci_bind_by_name( $stid, ":p_records", $cursor, -1, OCI_B_CURSOR );
		
		oci_execute( $stid );
        oci_execute( $cursor );

        while ( ($row = oci_fetch_array($cursor)) ) 
            array_push($data['records'], $row);


        oci_free_statement($stid);
        oci_free_statement($cursor);


        /*********************************************************************************************************/


        $data['assignedRooms'] = array();
		
		// call assigned rooms procedure
		$query  = "begin ceng352_project.find_assigned_rooms(:p_rooms); end;";
		$cursor = oci_new_cursor($conn);
		$stid   = oci_parse( $conn, $query );


		oci_bind_by_name( $stid, ":p_rooms", $cursor, -1, OCI_B_CURSOR );
		
		oci_execute( $stid );
        oci_execute( $cursor );

        while ( ($row = oci_fetch_array($cursor)) ) 
            array_push($data['assignedRooms'], $row);


        oci_free_statement($stid);
        oci_free_statement($cursor);


        /*********************************************************************************************************/
	

        $data['unassignedRooms'] = array();
		
		// call unassigned procedure
		$query  = "begin ceng352_project.find_unassigned_rooms(:p_rooms); end;";
		$cursor = oci_new_cursor($conn);
		$stid   = oci_parse( $conn, $query );


		oci_bind_by_name( $stid, ":p_rooms", $cursor, -1, OCI_B_CURSOR );
		
		oci_execute( $stid );
        oci_execute( $cursor );

        while ( ($row = oci_fetch_array($cursor)) ) 
            array_push($data['unassignedRooms'], $row);


        oci_free_statement($stid);
        oci_free_statement($cursor);     


        /*********************************************************************************************************/
	

        $data['staffs'] = array();
		$type = 'staff';

		// call responsible rooms procedure
		$query  = "begin ceng352_project.show_employees(:p_type,:p_employees); end;";
		$cursor = oci_new_cursor($conn);
		$stid   = oci_parse( $conn, $query );

		oci_bind_by_name( $stid, ":p_type",      $type );
		oci_bind_by_name( $stid, ":p_employees", $cursor, -1, OCI_B_CURSOR );
		
		oci_execute( $stid );
        oci_execute( $cursor );

        while ( ($row = oci_fetch_array($cursor)) ) 
            array_push($data['staffs'], $row);

        oci_free_statement($stid);
        oci_free_statement($cursor); 


		/*********************************************************************************************************/


		$data['users'] = array();
		$type = 'secretary';
		$user_name = '';

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

	
	}

	else
		header("Location: index.php");	

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Secretary</title>	
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
		<h4 align="center"><i>Title: Secretary</i></h4>	
		
	<div style='width:70%;margin-left:15%; margin-top:70px;'>	
		<h2 style='margin-left:35%'> Your Patients </h2>  
		<table align="center" class="rwd-table">
	       <tr>
	       		<th>Record ID</th>
	       		<th>SSN</th>
	       		<th>Patient Name</th>
	       		<th>Patient Surname</th>
	            <th>Status</th>
	            <th>Complaint</th>
	            <th>Doctor ID</th>
	            <th>Confirm</th>
	        </tr>
	   
	        <?php

	        	for( $i = 0; $i < count($data['records']); $i++ )
		        {    
		            echo '<tr>';
		            echo '<td>' . $data['records'][$i]['RECORDID'] . '</td>';
		            echo '<td>' . $data['records'][$i]['SSN'] . '</td>';
		            echo '<td>' . $data['records'][$i]['PNAME'] . '</td>';
		            echo '<td>' . $data['records'][$i]['PSURNAME'] . '</td>';
		            echo '<td>' . $data['records'][$i]['STATUS'] . '</td>';
		            echo '<td>' . $data['records'][$i]['COMPLAINT'] . '</td>';
		            echo '<td>' . 'Not Assigned' . '</td>';
		            echo '<td><form action="confirm_patient.php" method="post">
						   	   <input type="hidden" name="recordID" value='.$data['records'][$i]['RECORDID'].'>
						   	   <input type="hidden" name="complaint" value='.$data['records'][$i]['COMPLAINT'].'>
						   	   <input type="submit" value="Confirm" title="Confirm Record"></form>
						  </td>';


		            echo '</tr>';
		        }
	        	echo "</table>";
		        if ( count($data['records']) == 0 )
		        	echo '<p align="center"><span class="error" >There is no any newly created record.</span></p>';	
	        ?>
	     </div>   
	    <br><br>  
	    <div>
		    <div style='width:50%; float:left;'>
		    	<h3 align="center">Staff - Room Matchings</h3>
		    	<div style='width:70%;margin-left:30%;'>
			    
				<table align="center" class="rwd-table">
			       <tr>
			       		<th>Room ID</th>
			       		<th>Staff ID</th>
			       		<th>Unassign</th>	
			        </tr>
			   
			        <?php

			        	for( $i = 0; $i < count($data['assignedRooms']); $i++ )
				        {    
				            echo '<tr>';
				            echo '<td>' . $data['assignedRooms'][$i]['ROOMID'] . '</td>';
				            echo '<td>' . $data['assignedRooms'][$i]['STAFFID'] . '</td>';
				            echo '<td><form action="unassign_staff.php" method="post">
						   	   <input type="hidden" name="roomID" value='.$data['assignedRooms'][$i]['ROOMID'].'>
						   	   <input type="hidden" name="staffID" value='.$data['assignedRooms'][$i]['STAFFID'].'>
						   	   <input type="submit" value="Unassign" title="Unassign Staff"></form>
						   		</td>';

				            echo '</tr>';
				        }
			        	echo "</table>";
			        	echo "<br>";
				        if ( count($data['assignedRooms']) == 0 )
				        	echo '<p align="center"><span class="error" >There is no any unassigned room.</span></p>';	
			        ?>
			    <br>
			</div>
			</div> 
			<div style='width:50%; float:right;'>   
			    
			    <div style='width:70%'>
		    	<h3 align="left">Rooms having no Assignee</h3>
				<table align="center" class="rwd-table">
			       <tr>
			       		<th>Room ID</th>
			       		<th>Staff ID</th>
			       		<th>Assign</th>
			        </tr>
			   
			        <?php

			        	for( $i = 0; $i < count($data['unassignedRooms']); $i++ )
				        {    
				            echo '<tr>';
				            echo '<form action="assign_staff.php" method="post">';
				            echo '<td>' . $data['unassignedRooms'][$i]['ROOMID'] . '</td>';
				         	echo '<td><select name="staffID">';
				            
				            for( $j = 0; $j < count($data['staffs']); $j++ )
	  							echo '<option value="' . $data['staffs'][$j]['STAFFID'] . '"> ' . $data['staffs'][$j]['STAFFID'] . '</option>';
							echo '</select></td>';	

						   	echo  '<input type="hidden" name="roomID" value='.$data['unassignedRooms'][$i]['ROOMID'].'>
						   	   	  <td><input type="submit" value="Assign" title="Assign Staff"></form>
						   		  </td>';

				            echo '</tr>';
				        }

			        	echo "</table>";
			        	echo "<br>";
				        if ( count($data['assignedRooms']) == 0 )
				        	echo '<p align="center"><span class="error" >There is no any room - staff matching.</span></p>';	
			        ?>
			    <br> 
			</div>
			</div>    
		</div>	

	</body>
</html>		   
