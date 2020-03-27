<?php 
include('config.php');
	
	session_start();
	if (!isset($_SESSION['user']['username'])) {
		$_SESSION['message'] = "You must log in first";
		header('location: login.php');
		exit(0);
	}
	


	// variable declaration
	$name = "";
	$address    = "";
	$email = "";
	$mobileno = "";
	$location = "";
	
	$purpose = "";
	$property_type = "";
	$errors = array(); 

	// REGISTER USER
	if (isset($_REQUEST['rent_sell_user'])) {
		// receive all input values from the form
		$user_id = $_SESSION['user']['id'];
		$name = ($_REQUEST['name']);
		$address = ($_REQUEST['address']);
		$email = ($_REQUEST['email']);
		$mobileno = ($_REQUEST['mobileno']);
		$location = ($_REQUEST['location']);
		
		$purpose = ($_REQUEST['purpose']);
		$property_type = ($_REQUEST['property_type']);
	
	
		// form validation: ensure that the form is correctly filled			
		if (empty($name)) {  array_push($errors, "Uhmm...We gonna need your name"); }
		if (empty($address)) { array_push($errors, "Oops.. address is missing"); }
		if (empty($email)) { array_push($errors, "uh-oh you forgot the email"); }
		if (empty($mobileno)) { array_push($errors, "uh-oh you forgot the mobileno"); }
		if (empty($location)) { array_push($errors, "uh-oh you forgot the location"); }
		
		if (empty($purpose)) { array_push($errors, "uh-oh you forgot the purpose"); }
		if (empty($property_type)) { array_push($errors, "uh-oh you forgot the  property_type"); }
		
		// Ensure that no user is registered twice. 
		// the email and usernames should be unique
		
		
		// register user if there are no errors in the form
		if (count($errors) == 0){
		$query = "INSERT INTO rent_sell (user_id,name, address, email, mobileno, location, purpose, property_type) 
					  VALUES('$user_id','$name', '$address', '$email', '$mobileno', '$location','$purpose','$property_type')";
			
			if(mysqli_query($conn, $query)){
				// success
				header('Location: give_rent_sell.php');
				$_SESSION['message'] = "Thank you for cooperatioon, we will reach out to you as soon as we can";
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
		<?php include(ROOT_PATH . '/includes/messages.php') ?>
		<form method="POST" action="give_rent_sell.php" enctype="multipart/form-data" >
			<h2>FILL INFORMATION ABOUT PROPERTY</h2>
			
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
			<input  type="text" name="name"   placeholder="NAME">
			<input type="text" name="address"  placeholder="ADDRESS">
			<input  type="email" name="email"   placeholder="EMAIL">
			<input type="text" name="mobileno"  placeholder="MOBILENO">
			<label>LOCATION :</label><br>
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
			<option  value="CHAWKBAZAR">Chawkbazar</option>
			</select> 
			
			
			<label>PURPOSE :</label><br>
			<select  name="purpose">
			<option  value="rent" >rent</option>
			<option  value="sell" >sell</option>
			</select>  
			<label>PROPERTY_TYPE :</label><br>
			<select  name="property_type">
			<option  value="apartment" >Apartment</option>
			<option  value="duplex" >Duplex</option>
			<option  value="building">Building</option>
			<option  value="plot">Plot</option>
			</select>  
	  
			
			<button type="submit" class="btn" name="rent_sell_user">Submit</button>
			
		</form>
	</div>
	
	
	
</div>
<!-- // container -->

<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->
