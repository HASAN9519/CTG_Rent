<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- Get all topics -->
<?php $topics = getAllTopics();	?>
	<title>Admin | Create Post</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Middle form - to create and edit  -->
		<div class="action create-post-div">
			<h1 class="page-title">Create/Edit Post</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . 'admin/create_post.php'; ?>" >
				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- if editing post, the id is required to identify that post -->
				<?php if ($isEditingPost === true): ?>
					<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
				<?php endif ?>

				<input type="text" name="title" value="<?php echo $title; ?>" placeholder="Title">
				
				<input type="text" name="post_type" value="<?php echo $post_type; ?>" placeholder="post_type">
				<input type="text" name="vandorname" value="<?php echo $vandorname; ?>" placeholder="vandorname">
				<input type="text" name="address" value="<?php echo $address; ?>" placeholder="address">
				<input type="text" name="email" value="<?php echo $email; ?>" placeholder="email">
				<input type="text" name="mobileno" value="<?php echo $mobileno; ?>" placeholder="mobileno">
				<input type="text" name="location" value="<?php echo $location; ?>" placeholder="location">
				<input type="text" name="bedroom" value="<?php echo $bedroom; ?>" placeholder=" bedroom">
				<input type="text" name="bathroom" value="<?php echo $bathroom; ?>" placeholder="bathroom">
				<input type="text" name="squarefeet" value="<?php echo $squarefeet; ?>" placeholder="squarefeet">
				<input type="text" name="feature" value="<?php echo $feature ; ?>" placeholder="feature">
				<input type="text" name="price" value="<?php echo $price ; ?>" placeholder="price">
				<input type="text" name="paytime" value="<?php echo $paytime ; ?>" placeholder="paytime">
				<input type="text" name="gmap" value="<?php echo $gmap ; ?>" placeholder="gmap">
				
				<label style="float: left; margin: 5px auto 5px;">Featured image</label>
				<input type="file" name="image" >
				
				<label style="float: left; margin: 5px auto 5px;">Featured image</label>
				<input type="file" name="image2" >
				
				<label style="float: left; margin: 5px auto 5px;">Featured image</label>
				<input type="file" name="image3" >
				
				<textarea name="body" id="body" cols="30" rows="10"><?php echo $body; ?></textarea>
				<select name="topic_id">
					<option value="" selected disabled>Choose topic</option>
					<?php foreach ($topics as $topic): ?>
						<option value="<?php echo $topic['id']; ?>">
							<?php echo $topic['name']; ?>
						</option>
					<?php endforeach ?>
				</select>
				
				
				
				
				<!-- Only admin users can view publish input field -->
				<?php if ($_SESSION['user']['role'] == "Admin"): ?>
					<!-- display checkbox according to whether post has been published or not -->
					<?php if ($published == true): ?>
						<label for="publish">
							Publish
							<input type="checkbox" value="1" name="publish" checked="checked">&nbsp;
						</label>
					<?php else: ?>
						<label for="publish">
							Publish
							<input type="checkbox" value="1" name="publish">&nbsp;
						</label>
					<?php endif ?>
				<?php endif ?>
				
				<!-- if editing post, display the update button instead of create button -->
				<?php if ($isEditingPost === true): ?> 
					<button type="submit" class="btn" name="update_post">UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_post">Save Post</button>
				<?php endif ?>

			</form>
		</div>
		<!-- // Middle form - to create and edit -->
	</div>
</body>
</html>

<script>
	CKEDITOR.replace('body');
</script>
