<?php

session_start();
$recordCreated = 0;
$pic = "pics/index.jpg";

if ( $_POST )
{
	
	if ( (!empty($_POST['ssn'])) && (!empty($_POST['name'])) && (!empty($_POST['surname'])) 
			&& (!empty($_POST['phone'])) && (!empty($_POST['complaint'])) )
	{
		$host   = "//144.122.71.31:8085/xe"; 	// Hostname 
		$user   = "e1818897"; 					// Username 
		$passwd = "wawZZ"; 						// Password 

		$data = array('result' => 'F');

		$conn = oci_connect( $user, $passwd, $host );
		
		if (!$conn) 
		{
			$m = oci_error();
			echo $m['message'], "\n";
			exit;
		}
		
		$ssn = $name = $surname = $phone = $address = $complaint = '';
		

		$ssn       = $_POST['ssn'];
		$name      = $_POST['name'];
		$surname   = $_POST['surname'];
		$complaint = $_POST['complaint'];
		$address   = $_POST['address'];
		$phone     = $_POST['phone'];
		
		
		// add patient procedure
		$query = "begin ceng352_project.add_patient(:p_ssn,:p_name,:p_surname,:p_phone,:p_address,:p_result); end;";
		$stid = oci_parse( $conn, $query );
		
		oci_bind_by_name( $stid, ":p_ssn",     $ssn );
		oci_bind_by_name( $stid, ":p_name",    $name );
		oci_bind_by_name( $stid, ":p_surname", $surname );
		oci_bind_by_name( $stid, ":p_phone",   $phone );
		oci_bind_by_name( $stid, ":p_address", $address );
		oci_bind_by_name( $stid, ":p_result",  $result );
		oci_execute( $stid );
		

		// add record procedure	
		$query = "begin ceng352_project.add_record(:p_ssn,:p_complaint,:p_result); end;";	
		$stid  = oci_parse( $conn, $query );
		
		oci_bind_by_name( $stid, ":p_ssn",       $ssn );
		oci_bind_by_name( $stid, ":p_complaint", $complaint );
		oci_bind_by_name( $stid, ":p_result",    $result );
		oci_execute( $stid );

		//$result = trim($result);
		
	
        oci_free_statement($stid);
		
		$recordCreated = 1;
		echo '<script type="text/javascript">'
   			, 'alert("Your record is created. You can track your record by searching button. Thanks for using Health Management System..");'
   			, '</script>';
   		
   		
	}
}

?>




<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title> Health Center </title>	
    
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

	<body background="index.jpg">
			<br>

			<!-- For Entrance -->
			<h1 align="center" style='color:#668033'> Welcome to Health Center Management System </h1>
			 
			<br><br><br>
			<div class="form-style-5" style='width:20%; float:left'>

				<form method="post" action="oldRecords.php" >
						<p style='font-size:125%;margin-bottom:40px;color:#1A1A00'> <b><i>Search your previously record by SSN  </i></b></p>
					
					<legend><span class="number">1</span> Search</legend>
					<input type="text" name="ssn" placeholder="Your SSN *" required>

					<input type="submit" name="search" value="Search" />
				</form>
			</div>
			
			<div class="form-style-5" style='margin-right:10%;width:10%; float:right'>
				<!-- For Login -->	
				<form method="post" action="login.php" align="left">
   					<p style='font-size:125%;margin-bottom:40px;color:#1A1A00'> <b><i>Login to System </i></b></p>
   					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
   					<legend><span class="number">3</span> Login</legend>
   					<input type="submit" name="login" value="Login" align="left">
				</form>

			</div>	

			<div class="form-style-5" style='margin-left:40%; width:20%;'>

				<form method="post" action="index.php" >
					<p style='font-size:125%;margin-bottom:40px;color:#1A1A00'> <b><i>Register Your Complaint to the System </i></b></p>
				
				<legend><span class="number">2</span> Patient Info</legend>
				<input type="text" name="ssn" placeholder="Your SSN *" required>
				<input type="text" name="name" placeholder="Your Name *" required>
				<input type="text" name="surname" placeholder="Your Surname *" required>
				<input type="text" name="phone" placeholder="Your Phone *" required>
				<input type="text" name="address" placeholder="Your Address " >
				
				<label for="job">Complaint:</label>
				<select id="complaint" name="complaint">

				  <option value="brain">Brain</option>
				  <option value="hearth">Hearth</option>
				  <option value="dentist">Dentist</option>
				  <option value="eye">Eye</option>
				  <option value="throat">Throat</option>
				  <option value="physiology">Physiology</option>
				  <option value="dietician">Dietician</option>
				  <option value="dermatology">Dermatology</option>


				</select>      
				

				<input type="submit" name="register" value="Register" />
				</form>
			</div>
			
			<?php
				if ( $recordCreated == 1 ){
					echo 
						'<p align="center"><span class="success">Your record is created.</p>'. 
						'<p align="center"><span class="success">You can track your record by searching button.</p>'.
						'<p align="center"><span class="success">Thanks for using Health Management System..</p>';
				}
			?>


	</body>
</html>
