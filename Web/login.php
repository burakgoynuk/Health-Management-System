<?php
	session_start();
    
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) 
    {
        //echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
        if( $_SESSION['user_type'] == 'doctor' )
        	header("Location: doctor.php");

        else if( $_SESSION['user_type'] == 'secretary' )
        	header("Location: secretary.php");

        else if( $_SESSION['user_type'] == 'staff' )        
        	header("Location: staff.php");

        else if( $_SESSION['user_type'] == 'admin' )
        	header("Location: admin.php");
    } 
	
    
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
	

	$employeeID = '';
	$password = '';
	
	
	if ($_POST) 
	{
		$employeeID = $_POST['employeeID'];
		$password   = $_POST['password'];
		
		if ( empty($employeeID) and empty($password) )
		{
			// Comes from main page, login as employee button!
			// Do Nothing,
			// Render the same page	
			
			//echo "From index.php";
		}
		
		else 
		{

			$data['employeeID'] = $employeeID;
			$data['password']   = $password;

			$result = NULL;
			
			// call login procedure
			$query = "begin ceng352_project.login(:p_employee_id,:p_passwd,:p_result); end;";
			$stid  = oci_parse( $conn, $query );

			
			oci_bind_by_name( $stid, ":p_employee_id", $employeeID );
			oci_bind_by_name( $stid, ":p_passwd",      $password );
			oci_bind_by_name( $stid, ":p_result",      $result );
			oci_execute( $stid );

			$result = trim($result);
			
			$login_unsuccesfull = '';
			
			if( $result == '1' )
			{
				session_start();
				$_SESSION['loggedin']   = true;
				$_SESSION['employeeID'] = $employeeID;
				$_SESSION['user_type']  = 'doctor';

				$data['result'] = '1';
				header("Location: doctor.php");

			}		
			
			
			else if( $result == '2' )
			{
				session_start();
				$_SESSION['loggedin']   = true;
				$_SESSION['employeeID'] = $employeeID;
				$_SESSION['user_type']  = 'secretary';

				$data['result'] = '2';
				header("Location: secretary.php");

			}	
			

			else if( $result == '3' )
			{
				session_start();
				$_SESSION['loggedin']   = true;
				$_SESSION['employeeID'] = $employeeID;
				$_SESSION['user_type']  = 'staff';

				$data['result'] = '3';
				header("Location: staff.php");

			}	


			else if( $result == '4' )
			{
				session_start();
				$_SESSION['loggedin']   = true;
				$_SESSION['employeeID'] = $employeeID;
				$_SESSION['user_type']  = 'admin';

				$data['result'] = '4';
				header("Location: admin.php");

			}	
			

			else 
				$login_unsuccesfull = 'Login Unsuccesfull';


			oci_free_statement($stid);
			
		}
		
	}  
	

?>

<!DOCTYPE HTML>
<html>
	<head>

		<title> Login </title>	

        <script src="js/jquery.min.js"     type="text/javascript"> </script>
        <script src="js/jquery-ui.min.js"  type="text/javascript"> </script>
        <script src="js/helper.js"         type="text/javascript"> </script>

        <link rel="stylesheet" type="text/css" href="styles/helper.css">
        <link rel="stylesheet" type="text/css" href="styles/table.css" >
        <link rel="stylesheet" type="text/css" href="styles/login.css" >
	
	</head>

	<body>

		<div class="wrapper">
			<div class="container">
				<h1>Welcome</h1>
				
				<form class="form" method='post' action='login.php'>
					<input type="text" name='employeeID' placeholder="Employee ID">
					<input type="password" name='password' placeholder="Password">
					<button type="submit">Login</button>
				</form>
				<?php echo "<p style='font-size:125%;margin-bottom:40px;color:red'> <b><i>" . $login_unsuccesfull . "</i></b></p>"?>
			</div>
			
			<ul class="bg-bubbles">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>

	</body>
</html>			