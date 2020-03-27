	<!-- config.php should be here as the first include  -->
	<?php require_once('config.php') ?>
	<?php require_once( ROOT_PATH . '/includes/public_functions.php') ?>
	<?php require_once( ROOT_PATH . '/includes/registration_login.php') ?>
	<!-- Retrieve all posts from database  -->
	<?php $postsx = filterbrTable(); ?>
	<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>
	
	<title>RENT CTG</title>
</head>
<body>
	<!-- container - wraps whole page -->
<div class="container">
		<!-- navbar -->
		
		<?php include(ROOT_PATH . '/includes/navbar.php') ?>
		<!-- // navbar -->
	<div class="contentf">
	
		<?php if (isset($_SESSION['user']['username'])): ?>
		<div class="logged_in_infox">
		<span>welcome <?php echo $_SESSION['user']['username'] ?></span>
		<span><a href="logout.php">logout</a></span>
		</div>
		<?php endif ?>	
		
		<div class="content">
			<form style="width: 40%; margin: 10px auto; " action="searchbr.php" method="post">
						<label >POST TYPE :</label><br>
						<select style="border: 5px solid DarkSlateGrey;" name="valueToSearch1">
							<option  value="sell">BUY</option>
							<option  value="rent">RENT</option>
						</select> 
						<label>PROPERTY_TYPE :</label><br>
						<select  style="border: 5px solid DarkSlateGrey;" name="valueToSearch2">
							<option  value="3" >Apartment</option>
							<option  value="8" >Duplex</option>
							<option  value="9">Building</option>
							<option  value="10">Plot</option>
						</select>  
				<input style="border: 5px solid DarkSlateGrey;" class="btnx" type="submit" name="search" value="Filter"><br>
					
			</form>	    
					<h2 class="content-title">Search Result :</h2>
					<?php foreach ($postsx as $postx): ?>
				<div class="post" style="margin-left: 0px;">
						<img src="<?php echo BASE_URL . '/static/images/' . $postx['image']; ?>" class="post_image_filter" alt="">
						
						
						<!-- Added this if statement... -->
						<?php if (isset($postx['topic']['name'])): ?>
							<a 
								href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $postx['topic']['id'] ?>"
								class="btn category">
								<?php echo $postx['topic']['name'] ?>
							</a>
						<?php endif ?>

						
						<a href="single_post.php?post-slug=<?php echo $postx['slug']; ?>">
							<div class="post_info">
								<h4><span style="color:black">PRICE : BDT </span><?php echo $postx['price'] ?></h4><br>
								<h4><span style="color:black">POST_TYPE : </span><?php echo $postx['post_type'] ?></h4><br>
								<h4><span style="color:black">LOCATION : </span><?php echo $postx['location'] ?></h4><br>
								
								<div class="info">
									<span><?php echo date("F j, Y ", strtotime($postx["created_at"])); ?></span>
									<span class="read_more">Read more...</span>
								</div>
							</div>
						</a>
				</div>
			<?php endforeach ?>
				
		</div>
					<!-- Page content -->
	
		
		
	</div>	
		

		<!-- footer -->
		<?php include(ROOT_PATH . '/includes/footer.php') ?>