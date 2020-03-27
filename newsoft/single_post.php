<?php  include('config.php'); ?>
<?php  include('includes/public_functions.php'); ?>
<?php 
	if (isset($_GET['post-slug'])) {
		$post = getPost($_GET['post-slug']);
	}
	$topics = getAllTopics();
?>
<?php include('includes/head_section.php'); ?>

<title> <?php echo $post['post_type'] ?> | RENT CTG</title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	<!-- // Navbar -->
	
	<div class="contentf">
	
		<?php if (isset($_SESSION['user']['username'])): ?>
		<div class="logged_in_infox">
		<span>welcome <?php echo $_SESSION['user']['username'] ?></span>
		<span><a href="logout.php">logout</a></span>
		</div>
		<?php endif ?>
				
			<div class="content">
				<!-- Page wrapper -->
				<div class="post-wrapper">
					<!-- full post div -->
					<div class="full-post-div">
					<?php if ($post['published'] == false): ?>
						<h2 class="post-title">Sorry... This post has not been published</h2>
					<?php else: ?>
						<h2 class="post-title"><?php echo $post['title']; ?></h2><br>
						
						<h5><span style="color:black;">Click Image for more</h5><br>
						
								<div class="bod">
								<div class="row">
								  <div class="column">
									<img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" style="width: 500px;height: 300px;border-radius: 10px ;border: 1px solid black;" onclick="openModal();currentSlide(1)" class="hover-shadow cursor"><br><br>
								  </div>
								</div>

								<div id="myModal" class="modal">
								  <span class="close cursor" onclick="closeModal()">&times;</span>
								  <div class="modal-content">

									<div class="mySlides">
									  <div class="numbertext">1 / 3</div>
									  <img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" style="width:100%">
									</div>

									<div class="mySlides">
									  <div class="numbertext">2 / 3</div>
									  <img src="<?php echo BASE_URL . '/static/images/' . $post['image2']; ?>" style="width:100%">
									</div>

									<div class="mySlides">
									  <div class="numbertext">3 / 3</div>
									  <img src="<?php echo BASE_URL . '/static/images/' . $post['image3']; ?>" style="width:100%">
									</div>
									
									<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
									<a class="next" onclick="plusSlides(1)">&#10095;</a>

									<div class="caption-container">
									  <p id="caption"></p>
									</div>

									<div class="column">
									  <img class="demo cursor" src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" style="width:100%" onclick="currentSlide(1)">
									</div>
									<div class="column">
									  <img class="demo cursor" src="<?php echo BASE_URL . '/static/images/' . $post['image2']; ?>" style="width:100%" onclick="currentSlide(2)" >
									</div>
									<div class="column">
									  <img class="demo cursor" src="<?php echo BASE_URL . '/static/images/' . $post['image3']; ?>" style="width:100%" onclick="currentSlide(3)" >
									</div>
									
								  </div>
								</div>
								</div>
								<script>
								function openModal() {
								  document.getElementById("myModal").style.display = "block";
								}

								function closeModal() {
								  document.getElementById("myModal").style.display = "none";
								}

								var slideIndex = 1;
								showSlides(slideIndex);

								function plusSlides(n) {
								  showSlides(slideIndex += n);
								}

								function currentSlide(n) {
								  showSlides(slideIndex = n);
								}

								function showSlides(n) {
								  var i;
								  var slides = document.getElementsByClassName("mySlides");
								  var dots = document.getElementsByClassName("demo");
								  var captionText = document.getElementById("caption");
								  if (n > slides.length) {slideIndex = 1}
								  if (n < 1) {slideIndex = slides.length}
								  for (i = 0; i < slides.length; i++) {
									  slides[i].style.display = "none";
								  }
								  for (i = 0; i < dots.length; i++) {
									  dots[i].className = dots[i].className.replace(" active", "");
								  }
								  slides[slideIndex-1].style.display = "block";
								  dots[slideIndex-1].className += " active";
								  captionText.innerHTML = dots[slideIndex-1].alt;
								}
								</script>
						
						
						<h2><span style="color:black;">Details</h2><br><br>
						
						<h5><span style="color:black;">ADDRESS : </span><?php echo $post['address'] ?></h5><br>
						<h5><span style="color:black;">LOCATION : </span><?php echo $post['location'] ?></h5><br>
						<h5><span style="color:black;">PRICE : BDT </span><?php echo $post['price'] ?><span>  </span><?php echo $post['paytime'] ?></h5><br>
						<h5><span style="color:black;">BED(s) : </span><?php echo $post['bedroom'] ?></h5><br>
						<h5><span style="color:black;">BATH(s) : </span><?php echo $post['bathroom'] ?></h5><br>
						<h5><span style="color:black;">AREA : </span><?php echo $post['squarefeet'] ?><span> Sq.Ft.</span></h5><br>
						<h5><span style="color:black;">PURPOSE : </span><?php echo $post['post_type'] ?></h5><br>
						<h5><span style="color:black;">FEATURE : </span><?php echo $post['feature'] ?></h5><br>
						
						<h5><span style="color:black;">DESCRIPTION :</h5>
						<div class="post-body-div">
							<?php echo html_entity_decode($post['body']); ?>
						</div><br>
						<h5><span style="color:black;">Location on map</h5><br>
						<div><iframe src="<?php echo $post['gmap']; ?>"
						width="800"  height="450" frameborder="0" style= "display: block;margin-left: auto;margin-right: auto;border-radius: 10px; border: 1px solid black;" allowfullscreen=""></iframe>
						</div><br>	
						
					<?php endif ?>
					</div>
					<!-- // full post div -->
					
					<!-- comments section -->
					<!--  coming soon ...  -->
				</div>
				<!-- // Page wrapper -->

				<!-- post sidebar -->
				<div class="post-sidebar">
					<div class="card">
						<div class="card-header">
							<h2>CATAGORY</h2>
						</div>
						<div class="card-content">
							<?php foreach ($topics as $topic): ?>
								<a 
									href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $topic['id'] ?>">
									<?php echo $topic['name']; ?>
								</a> 
							<?php endforeach ?>
						</div>
					</div>
				</div>
				<!-- // post sidebar -->
			</div>
	</div>		
</div>
<!-- // content -->

<?php include( ROOT_PATH . '/includes/footer.php'); ?>
