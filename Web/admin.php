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
	
	if ( $loggedIn == true && $userType == 'admin' && $employeeID != '' )
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


		$var = array( 'doctor', 'secretary', 'staff' );
		foreach ($var as $key => $type) 
		{
			$data[$type] = array();
			
			// call show employees procedure
			$query  = "begin ceng352_project.show_employees(:p_type,:p_employees); end;";
			$cursor = oci_new_cursor($conn);
			$stid   = oci_parse( $conn, $query );


			oci_bind_by_name( $stid, ":p_type",      $type );
			oci_bind_by_name( $stid, ":p_employees", $cursor, -1, OCI_B_CURSOR );
			
			oci_execute( $stid );
	        oci_execute( $cursor );

	        while ( ($row = oci_fetch_array($cursor)) ) 
	            array_push($data[$type], $row);
        }

        oci_free_statement($stid);
        oci_free_statement($cursor);
	
	}

	else
		header("Location: index.php");	

?>

<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Admin</title>	

	
    <script src="js/jquery.min.js"     type="text/javascript"> </script>
    <script src="js/jquery-ui.min.js"  type="text/javascript"> </script>
    <script src="js/helper.js"         type="text/javascript"> </script>
	
    <link rel="stylesheet" type="text/css" href="styles/helper.css" >
    <link rel="stylesheet" type="text/css" href="styles/button.css" >
    <link rel="stylesheet" type="text/css" href="styles/table.css"  >
	<link rel="stylesheet" type="text/css" href="styles/form.css"   >

	<style type="text/css">

		body 
		{
			background-image: url('<?php echo $pic;?>');
		}

	</style>

	</head>

	<body>
		<br><br>  
		    <div style='width:20%; float:right;'>
		    		<form method="post" action="logout.php" style="float:left">
		   				<input type="submit" name="logout" class="myButton" value="Logout">
					</form>
			</div>
				
				<form method="post" action="index.php" align="left">
		   			<input type="submit" name="back" class="myButton" value="Back">
				</form>

				<h2 align="center">Welcome, System Admin</h2>  
				<h4 align="center"><i>Title: Admin</i></h4>	

		<div style='margin-top:75px;', id="accordion" >  

			<div id='doctor' style='width:70%;margin-left:15%'>	
				<h2 style='margin-left:35%'> Doctors </h2>  
				<table id='doctor_table' align="center" class="rwd-table">
			       <tr>
			       		<th>Employee ID</th>
			       		<th>Name</th>
			            <th>Surname</th>
			            <th>Phone</th>
			            <th>Salary</th>
			            <th>Qualification</th>
			            <th>Edit?</th>
			            <th>Remove?</th>
			        </tr>
			   
			        <?php

			        	for( $i = 0; $i < count($data['doctor']); $i++ )
				        {    
				            echo '<tr>';
				            echo '<td  data-th="Employee ID">' . $data['doctor'][$i]['EMPLOYEEID'] . '</td>';
				            echo '<td  data-th="Name">' . $data['doctor'][$i]['DNAME'] . '</td>';
				            echo '<td  data-th="Surname">' . $data['doctor'][$i]['DSURNAME'] . '</td>';
				            echo '<td  data-th="Phone">' . $data['doctor'][$i]['PHONE'] . '</td>';
				            echo '<td  data-th="Salary">' . $data['doctor'][$i]['SALARY'] . '</td>';
				            echo '<td  data-th="Qualification">' . $data['doctor'][$i]['QUALIFICATION'] . '</td>';
				            echo '<td  data-th="Edit?"> 
				            		<form action="edit_doctor.php" method="post">
								   	   <input type="hidden" name="employeeID" value='.$data['doctor'][$i]['EMPLOYEEID'].'>
								   	   <input type="hidden" name="doctorID" value='.$data['doctor'][$i]['DOCTORID'].'>
								   	   <input type="hidden" name="name" value='.$data['doctor'][$i]['DNAME'].'>
								   	   <input type="hidden" name="surname" value='.$data['doctor'][$i]['DSURNAME'].'>
								   	   <input type="hidden" name="password" value='.$data['doctor'][$i]['PASSWD'].'>
								   	   <input type="hidden" name="phone" value='.$data['doctor'][$i]['PHONE'].'>
								   	   <input type="hidden" name="salary" value='.$data['doctor'][$i]['SALARY'].'>
								   	   <input type="hidden" name="qualification" value='.$data['doctor'][$i]['QUALIFICATION'].'>
								   	   <input type="submit" value="Edit" title="Edit Doctor"></form>
								   	</td>';
				            echo '<td  data-th="Remove?"> 
				            		<form action="remove_employee.php" method="post">
								   	   <input type="hidden" name="employeeID" value='.$data['doctor'][$i]['EMPLOYEEID'].'>
								   	   <input type="hidden" name="type" value="doctor">
								   	   <input type="submit" value="Remove" title="Remove Doctor"></form>
								   	</td>';


				            echo '</tr>';
				        }
			        	echo "</table>";
				        if ( count($data['doctor']) == 0 )
				        	echo '<p align="center"><span class="error" >There is no any doctor.</span></p>';

				        echo '';	
			        ?>

			    <br>   
			    
			    <div style='width:100%;float:left;margin-bottom:30px;'>
					
					<button style='margin-bottom:10px'type="button" class="myButton2" id='doctor_button'>Hide Doctors</button>

			    	<form align="left" action="add_doctor.php" method="post">
						<input type="submit" value="Add Doctor" class="myButton2" title="Add Doctor">
					</form>

				</div>
					

				   	    
			</div>

			<div id='secretary' style='width:70%;margin-left:15%'>	
				<h2 style='margin-left:25%'> Secretaries </h2>  
				<table id='secretary_table' align="center" class="rwd-table">
			       <tr>
			       		<th>Employee ID</th>
			       		<th>Name</th>
			            <th>Surname</th>
			            <th>Phone</th>
			            <th>Salary</th>
			            <th>Edit?</th>
			            <th>Remove?</th>
			        </tr>
			   
			        <?php

			        	for( $i = 0; $i < count($data['secretary']); $i++ )
				        {    
				            echo '<tr>';
				            echo '<td>' . $data['secretary'][$i]['EMPLOYEEID'] . '</td>';
				            echo '<td>' . $data['secretary'][$i]['SNAME'] . '</td>';
				            echo '<td>' . $data['secretary'][$i]['SSURNAME'] . '</td>';
				            echo '<td>' . $data['secretary'][$i]['PHONE'] . '</td>';
				            echo '<td>' . $data['secretary'][$i]['SALARY'] . '</td>';
				            echo '<td  data-th="Edit?"> 
				            		<form action="edit_secretary.php" method="post">
								   	   <input type="hidden" name="employeeID" value='.$data['secretary'][$i]['EMPLOYEEID'].'>
								   	   <input type="hidden" name="secretaryID" value='.$data['secretary'][$i]['SECRETARYID'].'>
								   	   <input type="hidden" name="name" value='.$data['secretary'][$i]['SNAME'].'>
								   	   <input type="hidden" name="surname" value='.$data['secretary'][$i]['SSURNAME'].'>
								   	   <input type="hidden" name="password" value='.$data['secretary'][$i]['PASSWD'].'>
								   	   <input type="hidden" name="phone" value='.$data['secretary'][$i]['PHONE'].'>
								   	   <input type="hidden" name="salary" value='.$data['secretary'][$i]['SALARY'].'>
								   	   <input type="submit" value="Edit" title="Edit Secretary"></form>
								   	</td>';
				            echo '<td><form action="remove_employee.php" method="post">
								  	<input type="hidden" name="employeeID" value='.$data['secretary'][$i]['EMPLOYEEID'].'>
								   	<input type="hidden" name="type" value="secretary">
								   	<input type="submit" value="Remove" title="Remove Secretary"></form>
								  </td>';
				            echo '</tr>';
				        }
			        	echo "</table>";
				        if ( count($data['secretary']) == 0 )
				        	echo '<p align="center"><span class="error" >There is no any secretary.</span></p>';

				        echo '';		
			        ?>
			    <br>   
				
			    <div style='width:100%;float:left;margin-bottom:30px;'>
					
					<button style='margin-bottom:10px'type="button" class="myButton2" id='secretary_button'>Hide Secretaries</button>

			    	<form align="left" action="add_secretary.php" method="post">
						<input type="submit" value="Add Secretary" class="myButton2" title="Add Secretary">
					</form>

				</div>
					
			</div>
			

			<div id='staff' style='width:70%;margin-left:15%'>	
				<h2 style='margin-left:25%'> Staffs </h2>  
				<table id='staff_table' align="center" class="rwd-table">
			       <tr>
			       		<th>Employee ID</th>
			       		<th>Name</th>
			            <th>Surname</th>
			            <th>Phone</th>
			            <th>Salary</th>
			            <th>Edit?</th>
			            <th>Remove?</th>
			        </tr>
			   
			        <?php

			        	for( $i = 0; $i < count($data['staff']); $i++ )
				        {    
				            echo '<tr>';
				            echo '<td>' . $data['staff'][$i]['EMPLOYEEID'] . '</td>';
				            echo '<td>' . $data['staff'][$i]['SNAME'] . '</td>';
				            echo '<td>' . $data['staff'][$i]['SSURNAME'] . '</td>';
				            echo '<td>' . $data['staff'][$i]['PHONE'] . '</td>';
				            echo '<td>' . $data['staff'][$i]['SALARY'] . '</td>';
				            echo '<td  data-th="Edit?"> 
				            		<form action="edit_staff.php" method="post">
								   	   <input type="hidden" name="employeeID" value='.$data['staff'][$i]['EMPLOYEEID'].'>
   								   	   <input type="hidden" name="staffID" value='.$data['staff'][$i]['STAFFID'].'>
								   	   <input type="hidden" name="name" value='.$data['staff'][$i]['SNAME'].'>
								   	   <input type="hidden" name="surname" value='.$data['staff'][$i]['SSURNAME'].'>
								   	   <input type="hidden" name="password" value='.$data['staff'][$i]['PASSWD'].'>
								   	   <input type="hidden" name="phone" value='.$data['staff'][$i]['PHONE'].'>
								   	   <input type="hidden" name="salary" value='.$data['staff'][$i]['SALARY'].'>
								   	   <input type="submit" value="Edit" title="Edit Staff"></form>
								   	</td>';
				            echo '<td><form action="remove_employee.php" method="post">
								  	<input type="hidden" name="employeeID" value='.$data['staff'][$i]['EMPLOYEEID'].'>
								    <input type="hidden" name="type" value="staff">
								   	<input type="submit" value="Remove" title="Remove Staff"></form>
								  </td>';

				            echo '</tr>';
				        }
			        	echo "</table>";
				        if ( count($data['staff']) == 0 )
				        	echo '<p align="center"><span class="error" >There is no any staff.</span></p>';	

			        ?>   
		        <br> 
			    
			    <div style='width:100%;float:left;margin-bottom:30px;'>
					
					<button style='margin-bottom:10px'type="button" class="myButton2" id='staff_button'>Hide Staffs</button>

			    	<form align="left" action="add_staff.php" method="post">
						<input type="submit" value="Add Staff" class="myButton2" title="Add Staff">
					</form>

				</div>  
			</div>	

		</div>	
		
	</body>
</html>		   
