	<!-- config.php should be here as the first include  -->
	<?php require_once('config.php') ?>
	<?php require_once( ROOT_PATH . '/includes/public_functions.php') ?>
	<?php require_once( ROOT_PATH . '/includes/registration_login.php') ?>
	<!-- Retrieve all posts from database  -->
	<?php $posts = getPublishedPosts(); ?>
	<?php $postsx = filterTable(); ?>
	<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>
	
	<title>RENT CTG</title>
</head>
<body>
	<!-- container - wraps whole page -->
<div class="container">
		<!-- navbar -->
		<?php include(ROOT_PATH . '/includes/navbar.php') ?>
		<!-- // navbar -->
		<!-- banner -->
		<?php include(ROOT_PATH . '/includes/banner.php') ?>
		
			<div class="content">
		
				<form style="width: 30%; margin: 5px auto; " action="index.php" method="post">
						<input style="border: 5px solid DarkSlateGrey;"type="text" name="valueToSearch" placeholder="Value To Search"><br>
						<input style="border: 5px solid DarkSlateGrey;"class="btnx" type="submit" name="search" value="Filter"><br>
				</form>	 
				<h2 class="content-title">Recent Avilable Homes For Rent and Sell </h2>
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
									<h4><span style="color:black;">PRICE : BDT </span><?php echo $postx['price'] ?></h4><br>
									<h4><span style="color:black;">PURPOSE : </span><?php echo $postx['post_type'] ?></h4><br>
									<h4><span style="color:black;">LOCATION : </span><?php echo $postx['location'] ?></h4><br>
									<div class="info">
										<span><?php echo date("F j, Y ", strtotime($postx["created_at"])); ?></span>
										<span class="read_more">Click for details...</span>
									</div>
								</div>
							</a>
					</div>
				<?php endforeach ?>
						
					
			</div>
			
			
			<div><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29523.010491190445!2d91.81211658623879!3d22.339415504332823!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30acd8a71c5c3451%3A0x8145d1408572eb24!2sKotwali%2C%20Chittagong!5e0!3m2!1sen!2sbd!4v1581867647799!5m2!1sen!2sbd"
			width="600" height="450" frameborder="0" style= "display: block;margin-left: auto;margin-right: auto;" allowfullscreen=""></iframe>
			</div><br>	
					<!-- Page content -->
		
			<div><iframe src="https://www.google.com/maps/d/embed?mid=1s3x2deO-YRJfYKn4DXFueoIVeETz-FQg"
			width="600" height="450" frameborder="0" style= "display: block;margin-left: auto;margin-right: auto;" allowfullscreen=""></iframe>
			</div><br>	
			
			
		<!-- footer -->
		<?php include(ROOT_PATH . '/includes/footer.php') ?>