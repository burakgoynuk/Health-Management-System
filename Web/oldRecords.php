<?php
	session_start();
	$pic = "pics/index.jpg";
	$SSN = '';
	$data = array();	
	
	if ($_POST) 
	{
		if ( !empty($_POST['ssn']) )
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

			$ssn = $_POST['ssn'];
			$data['records'] = array();
			$result = NULL;
			
			
			// call search records
			$query  = "begin ceng352_project.search_records(:p_ssn,:p_records); end;";
			$cursor = oci_new_cursor($conn);
			$stid   = oci_parse( $conn, $query );
		

			oci_bind_by_name( $stid, ":p_ssn",     $ssn );
			oci_bind_by_name( $stid, ":p_records", $cursor, -1, OCI_B_CURSOR );
			
			oci_execute( $stid );
            oci_execute( $cursor );

            while ( ($row = oci_fetch_array($cursor)) ) 
                array_push($data['records'], $row);
              

        	oci_free_statement($stid);
        	oci_free_statement($curs);  
		
		}

		else 
		{
			// empty ssn,
			// do nothing!
		}

   }  
	


?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title> Search Results </title>	
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

		<form method="post" action="index.php" align="left">
   			<input type="submit" name="back" class="myButton" value="Back">
		</form>

		
	<div style='width:70%;margin-left:15%'>	
		<h2 style='margin-left:35%'> Old Records </h2>  
		<table align="center" class="rwd-table">
	       <tr>
	       		<th>Name</th>
	       		<th>Surname</th>
	            <th>Doctor ID</th>
	            <th>Status</th>
	            <th>Complaint</th>
	            <th>Treatment</th>
	            <th>Stayed Room</th>
	            <th>Start Date</th>
	            <th>End Date</th>
	        </tr>
	   
	        <?php
	        	//echo count($data['records']);

	        	for( $i = 0; $i < count($data['records']); $i++ )
		        {    
		        	$room = $data['records'][$i]['ROOMID']; 
		        	if ( $room == '' || !isset($room) || is_null($room) )
		        		$room = 'Not stayed';

		        	$end_date = $data['records'][$i]['ENDDATE']; 
		        	if ( $end_date == '' || !isset($end_date) || is_null($end_date) )
		        		$end_date = 'Not finished yet';
		            
		            echo '<tr>';
		            echo '<td  data-th="Name">' . $data['records'][$i]['PNAME'] . '</td>';
		            echo '<td  data-th="Surname">' . $data['records'][$i]['PSURNAME'] . '</td>';
		            echo '<td  data-th="Doctor ID">' . $data['records'][$i]['DOCTORID'] . '</td>';
		            echo '<td  data-th="Status">' . $data['records'][$i]['STATUS'] . '</td>';
		            echo '<td  data-th="Complaint">' . $data['records'][$i]['COMPLAINT'] . '</td>';
		            echo '<td  data-th="Treatment">' . $data['records'][$i]['TREATMENT'] . '</td>';
		            echo '<td  data-th="Stayed Room">' . $room . '</td>';
		            echo '<td  data-th="Start Date">' . $data['records'][$i]['STARTDATE'] . '</td>';
		            echo '<td  data-th="End Date">' . $end_date . '</td>';
		            echo '</tr>';
		        }
		        
	        	echo "</table>";
		        if ( count($data['records']) == 0 )
		        {
		        	echo '<p align="center"><span class="error" >There is no record according to that ssn.</span></p>';
		        }	
	        ?>
	    </div>    
	</body>
</html>		   
