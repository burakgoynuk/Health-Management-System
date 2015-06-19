<?php
	session_start();
	$pic = "pics/doctor.jpg";

	$employeeID = '';
	$loggedIn = '';
	$userType = '';	
	$exTable = 'show';

	$employeeID = $_SESSION["employeeID"];
	$loggedIn   = $_SESSION["loggedin"];
	$userType   = $_SESSION['user_type'];
	

	$data = array();	
	
	if ( $loggedIn == true && $userType == 'doctor' && $employeeID != '' )
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
		
		// call current patients procedure
		$query  = "begin ceng352_project.current_patients_records(:p_doctor_id,:p_records); end;";
		$cursor = oci_new_cursor($conn);
		$stid   = oci_parse( $conn, $query );

		oci_bind_by_name( $stid, ":p_doctor_id", $employeeID );
		oci_bind_by_name( $stid, ":p_records",   $cursor, -1, OCI_B_CURSOR );
		
		oci_execute( $stid );
        oci_execute( $cursor );

        while ( ($row = oci_fetch_array($cursor)) ) 
            array_push($data['records'], $row);

        oci_free_statement($stid);
        oci_free_statement($cursor);


        /*********************************************************************************************************/


        $data['exPatients'] = array();
		
		// call old patients procedure
		$query  = "begin ceng352_project.show_old_patients(:p_doctor_id,:p_records); end;";
		$cursor = oci_new_cursor($conn);
		$stid   = oci_parse( $conn, $query );


		oci_bind_by_name( $stid, ":p_doctor_id", $employeeID );
		oci_bind_by_name( $stid, ":p_records",     $cursor, -1, OCI_B_CURSOR );
		
		oci_execute( $stid );
        oci_execute( $cursor );

        while ( ($row = oci_fetch_array($cursor)) ) 
            array_push($data['exPatients'], $row);


        oci_free_statement($stid);
        oci_free_statement($cursor);


		/*********************************************************************************************************/


		$data['users'] = array();
		$type = 'doctor';
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

        $user_name = $data['users'][0]['DNAME'] . ' ' . $data['users'][0]['DSURNAME'];

	
	}

	else
		header("Location: index.php");	

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Doctor</title>	
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

		<h2 align="center"><?php echo 'Welcome, ' . $user_name; ?></h2> 
		<h4 align="center"><i>Title: Doctor</i></h4>	
		
	<div style='width:70%;margin-left:15%; margin-top:70px;'>	
		<h2 style='margin-left:35%'> Your Patients </h2>  
		<table align="center" class="rwd-table">
	       <tr>
	       		<th>Record ID</th>
	       		<th>Patient  SSN</th>
	       		<th>Patient Name</th>
	       		<th>Patient Surname</th>
	            <th>Complaint</th>
	            <th>Status</th>
	            <th>Treatment</th>
	            <th>Save</th>
	        </tr>
	   
	        <?php

	        	for( $i = 0; $i < count($data['records']); $i++ )
		        {    
		            echo '<tr>';
		            echo '<td>' . $data['records'][$i]['RECORDID'] . '</td>';
		            echo '<td>' . $data['records'][$i]['SSN'] . '</td>';
		            echo '<td>' . $data['records'][$i]['PNAME'] . '</td>';
		            echo '<td>' . $data['records'][$i]['PSURNAME'] . '</td>';
		            echo '<td>' . ucfirst($data['records'][$i]['COMPLAINT']) . '</td>';
		            
		           
		            $selectedStatus = 0;
		            switch ($data['records'][$i]['STATUS']) 
		            {
		            	case 'Confirmed':
		            		$selectedStatus = 0; break;
		            	
		            	case 'InTreatment':
		            		$selectedStatus = 1; break;
		            		
		            	case 'Bed':
		            		$selectedStatus = 2; break;
		            		
		            	case 'End':
		            		$selectedStatus = 3; break;    				            				            		
		            };
					
		            echo '<form action="save_status.php" method="post">';
				    	echo '<td><select name="status">';
	  						echo '<option value="New" disabled>New</option>';
	  						echo '<option value="Confirmed"';    if($selectedStatus == 0) echo ' selected'; echo '>Confirmed</option>';
	  						echo '<option value="InTreatment"';  if($selectedStatus == 1) echo ' selected'; echo '>In Treatment</option>';
	  						echo '<option value="Bed"';          if($selectedStatus == 2) echo ' selected'; echo '>Bed</option>';
	  						echo '<option value="End"';          if($selectedStatus == 3) echo ' selected'; echo '>End</option>';	
						echo '</select></td>';	

						$selectedTreatment = 0;	
			            switch ($data['records'][$i]['TREATMENT']) 
			            {
			            	case 'Medicine':
			            		$selectedTreatment = 0; break;
			            	
			            	case 'Test':
			            		$selectedTreatment = 1; break;
			            		
			            	case 'Analysis':
			            		$selectedTreatment = 2; break;
			            		
			            	case 'Rest':
			            		$selectedTreatment = 3; break;  

			            	case 'None':
			            		$selectedTreatment = 4; break;   			            		  				            				            		
			            };

						echo '<td><select name="treatment">';
	  						echo '<option value="Medicine"';    if($selectedTreatment == 0) echo ' selected'; echo '>Medicine</option>';
	  						echo '<option value="Test"';        if($selectedTreatment == 1) echo ' selected'; echo '>Test</option>';
	  						echo '<option value="Analysis"';    if($selectedTreatment == 2) echo ' selected'; echo '>Analysis</option>';
	  						echo '<option value="Rest"';        if($selectedTreatment == 3) echo ' selected'; echo '>Rest</option>';
	  						echo '<option value="None"';        if($selectedTreatment == 4) echo ' selected'; echo '>None</option>';	
						echo '</select></td>';

						echo   '<input type="hidden" name="recordID" value='.$data['records'][$i]['RECORDID'].'>
								<input type="hidden" name="ssn" value='.$data['records'][$i]['SSN'].'>
						 		<td><input type="submit" value="Save" title="Save Changes"></form>
						   		</td>';


		            echo '</tr>';
		        }
	        	echo "</table>";
		        if ( count($data['records']) == 0 )
		        	echo '<p align="center"><span class="error" >There is no any record for you, lets have a coffee!.</span></p>';	
	        ?>
	    <br><br>
	</div>
	  	

	<div style='width:70%;margin-left:15%;margin-top:50px;'>	
		<h2 style='margin-left:35%'> Your Old Patients </h2>  
		<table align="center" class="rwd-table">
	       <tr>
	       		<th>Record ID</th>
	       		<th>Patient  SSN</th>
	       		<th>Patient Name</th>
	       		<th>Patient Surname</th>
	            <th>Complaint</th>
	            <th>Status</th>
	            <th>Treatment</th>
	        </tr>

	        <?php

	        	for( $i = 0; $i < count($data['exPatients']); $i++ )
		        {    
		            echo '<tr>';
		            echo '<td>' . $data['exPatients'][$i]['RECORDID'] . '</td>';
		            echo '<td>' . $data['exPatients'][$i]['SSN'] . '</td>';
		            echo '<td>' . $data['exPatients'][$i]['PNAME'] . '</td>';
		            echo '<td>' . $data['exPatients'][$i]['PSURNAME'] . '</td>';
		            echo '<td>' . ucfirst($data['exPatients'][$i]['COMPLAINT']) . '</td>';
		            echo '<td>' . $data['exPatients'][$i]['STATUS'] . '</td>';
		            echo '<td>' . $data['exPatients'][$i]['TREATMENT'] . '</td>';
		            echo '</tr>';
		        }
	        	echo "</table>";
		        if ( count($data['exPatients']) == 0 )
		        	echo '<p align="center"><span class="error" >There is no any old patient about you.</span></p>';	
	        ?>
	    </div>
	</body>
</html>		   
