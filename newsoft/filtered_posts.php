<?php include('config.php'); ?>
<?php include('includes/public_functions.php'); ?>
<?php include('includes/head_section.php'); ?>
<?php 
	// Get posts under a particular topic
	if (isset($_GET['topic'])) {
		$topic_id = $_GET['topic'];
		$posts = getPublishedPostsByTopic($topic_id);
	}
?>
	<title>RENT CTG</title>
</head>
<body>
<div class="container">
<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
<!-- // Navbar -->
<!-- content -->
		<div class="contentf">
			<?php if (isset($_SESSION['user']['username'])): ?>
			<div class="logged_in_infox">
			<span>welcome <?php echo $_SESSION['user']['username'] ?></span>
			<span><a href="logout.php">logout</a></span>
			</div>
			<?php endif ?>
		
			<div  class="content">
						<h2 class="content-title">
							LIST OF ALL <?php echo getTopicNameById($topic_id); ?> :
						</h2>
					
						<?php foreach ($posts as $post): ?>
							<div class="post" style="margin-left: 0px;">
								<img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" class="post_image_filter" alt="">
								<a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
									<div class="post_info">
										<h4><span style="color:black;">PRICE : BDT </span><?php echo $post['price'] ?></h4><br>
										<h4><span style="color:black;">PURPOSE : </span><?php echo $post['post_type'] ?></h4><br>
										<h4><span style="color:black;">LOCATION : </span><?php echo $post['location'] ?></h4><br>
										<div class="info">
											<span><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
											<span class="read_more">Click for details...</span>
										</div>
									</div>
								</a>
							</div>
						<?php endforeach ?>
				
			</div>
		</div>	
<!-- // content -->
</div>
<!-- // container -->
<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->