<?php  include('config.php'); ?>
<!-- Source code for handling registration and login -->
<?php  include('includes/registration_login.php'); ?>

<?php include('includes/head_section.php'); ?>

<title>RENT CTG | Sign up </title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	<!-- // Navbar -->
			<div>
					<?php 
					session_start();
					if (isset($_SESSION['user']['username'])): ?>
					<div class="logged_in_info_register">
						<span>welcome <?php echo $_SESSION['user']['username'] ?></span>
						<span><a href="logout.php">logout</a></span>
					</div>
					<?php endif ?>
					
					
					<?php if (isset($_SESSION['user']['username'])){ ?>
					
					<h1 style="text-align: center; margin-top: 20px;">YOU ARE ALREADY REGISTERED</h1>
				
					<?php }else{ ?>
					
					<div style="width: 40%; margin: 100px auto;">
						<form method="post" action="register.php" >
							<h2>Register Now</h2>
							<?php include(ROOT_PATH . '/includes/errors.php') ?>
							<input  type="text" name="username" value="<?php echo $username; ?>"  placeholder="Username">
							<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
							<input type="password" name="password_1" placeholder="Password">
							<input type="password" name="password_2" placeholder="Password confirmation">
							<button type="submit" class="btn" name="reg_user">Register</button>
							<p>
								Already a member? <a href="login.php">Sign in</a>
							</p>
						</form>
					</div>
					
					<?php } ?>
			</div>	
</div>
<!-- // container -->
<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->
