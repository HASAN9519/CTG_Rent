<?php  include('../config.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>RENT CTG Admin Panel</title>
</head>
<body>
		<div>	
				
				<div class="header">
					<div class="logo">
						<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
							<h1>RENT CTG Admin Panel</h1>
						</a>
					</div>
					
					
					
					
					
					<?php if (isset($_SESSION['user'])): ?>
						<div class="user-info">
							<span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp; 
							<a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
						</div>
					<?php endif ?>
				</div>
				<div class="container dashboard">
				
				
				<?php if  (!isset($_SESSION['user']['username'])){ ?>
				<h1 style="text-align: center; margin-top: 20px;">YOU HAVE TO LOGIN FIRST</h1>
				<h2 style="text-align: center; margin-top: 20px;">LOG IN HERE <a href="<?php echo BASE_URL.'login.php'?>">log in</a></h2>
				<?php }else if (in_array(!$_SESSION['user']['role'], ["Admin", "Author"])){ ?>
				
				<h1 style="text-align: center; margin-top: 20px;">YOU ARE NOT AUTHORIZED TO ACCESS ADMIN PANEL</h1>
				
				<?php }else{ ?>
				
					<h1>Welcome</h1>
					<div class="stats">
						<a href="<?php echo BASE_URL .'index.php' ?>" class="first">
							<span>GOTO</span> <br>
							<span>HOME</span>
						</a>
						<a href="property.php">
							<span>GOTO</span> <br>
							<span>User posts</span>
						</a>
						<a>
							<span>43</span> <br>
							<span>Published comments</span>
						</a>
					</div>
					<br><br><br>
					<div class="buttons">
						<a href="users.php">Add Users</a>
						<a href="posts.php">Add Posts</a>
					</div>
				
				<?php } ?>
				</div>
				
				
				
		</div>		
</body>
</html>
