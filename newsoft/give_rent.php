<?php 

	session_start();
	if (!isset($_SESSION['user']['username'])) {
		$_SESSION['message'] = "You must log in first";
		header('location: login.php');
		exit(0);
	}
	/*
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['userfullname']);
		header("location: index.php");
	}
	*/
	
include('config.php');
	// variable declaration
	$rentorname = "";
	$address    = "";
	$email = "";
	$mobileno    = "";
	$location = "";
	$description = "";
	$errors = array(); 

	// REGISTER USER
	if (isset($_REQUEST['rent_user'])) {
		// receive all input values from the form
		$rentorname = ($_REQUEST['rentorname']);
		$address = ($_REQUEST['address']);
		$email = ($_REQUEST['email']);
		$mobileno = ($_REQUEST['mobileno']);
		$location = ($_REQUEST['location']);
		$description = ($_REQUEST['description']);
	
	
		// form validation: ensure that the form is correctly filled			
		if (empty($rentorname)) {  array_push($errors, "Uhmm...We gonna need your username"); }
		if (empty($address)) { array_push($errors, "Oops.. address is missing"); }
		if (empty($email)) { array_push($errors, "uh-oh you forgot the email"); }
		if (empty($mobileno)) { array_push($errors, "uh-oh you forgot the mobileno"); }
		if (empty($location)) { array_push($errors, "uh-oh you forgot the location"); }
		if (empty($description)) { array_push($errors, "uh-oh you forgot the description"); }

			


		// Ensure that no user is registered twice. 
		// the email and usernames should be unique
		
		
		// register user if there are no errors in the form
		if (count($errors) == 0){
		$query = "INSERT INTO rentor (rentorname, address, email, mobileno, location, description) 
					  VALUES('$rentorname', '$address', '$email', '$mobileno', '$location','$description')";
			
			if(mysqli_query($conn, $query)){
				// success
				header('Location: pindex.php');
				exit(0);
			} else {
				echo 'query error: '. mysqli_error($conn);
				exit(0);
			}
		
			// get id of created user
			
			// put logged in user into session array
			
			// if user is admin, redirect to admin area		
		
		}

	// LOG USER IN
	
	// escape value from form
	}
?>
<?php include('includes/head_section.php'); ?>
	<title>RENT CTG</title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	<!-- // Navbar -->
	
	<div class="logged_in_info_register">
		<span>welcome <?php echo $_SESSION['user']['username'] ?></span>
		<span><a href="logout.php">logout</a></span>
	</div>
	
	
	
	
	<div style="width: 40%; margin: 100px auto;">
		<form method="POST" action="give_rent.php" enctype="multipart/form-data" >
			<h2>Information About Property</h2>
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
			<input  type="text" name="rentorname"   placeholder="rentorname">
			<input type="text" name="address"  placeholder="address">
			<input  type="email" name="email"   placeholder="email">
			<input type="text" name="mobileno"  placeholder="mobileno">
			<label>location</label><br>
			<select  name="location">
			<option  value="AGRABAD">Agrabad</option>
			<option  value="KOTWALI">kotwali</option>
			<option  value="GEC">GEC</option>
			<option  value="Muradpur">Muradpur</option>
			<option  value="OXYGEN">oxygen</option>
			<option  value="Halishahar">Halishahar</option>
			<option  value="Monsurabad">Monsurabad</option>
			<option  value="Nasirabad">Nasirabad</option>
			<option  value="WASA">wasa</option>
			<option  value="DAMPARA">Dampara</option>
			</select>  
			<input type="text" name="description"  placeholder="description">
	  
			
			<button type="submit" class="btn" name="rent_user">Submit</button>
			
		</form>
	</div>
	
	
	
</div>
<!-- // container -->

<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->