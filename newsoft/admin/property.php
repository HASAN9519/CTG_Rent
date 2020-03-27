<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php 
/* - - - - - - - - - - 
-  Post functions
- - - - - - - - - - -*/
// get all posts from DB
function getAllPosts()
{
	$post_id = 0;
	$published = 0;
	global $conn;
	if (in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
		$sql = "SELECT * FROM rent_sell";
	} 
	$result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['author'] = getPostAuthorById($post['user_id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}
// get the author/username of a post
function getPostAuthorById($user_id)
{
	global $conn;
	$sql = "SELECT username FROM users WHERE id=$user_id";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		// return username
		return mysqli_fetch_assoc($result)['username'];
	} else {
		return null;
	}
}


/* - - - - - - - - - - 
-  Post actions
- - - - - - - - - - -*/
// if user clicks the create post button

// if user clicks the Edit post button

// if user clicks the update post button

// if user clicks the Delete post button
if (isset($_GET['delete-post'])) {
	$post_id = $_GET['delete-post'];
	deletePost($post_id);
}

/* - - - - - - - - - - 
-  Post functions
- - - - - - - - - - -*/

	// if user clicks the publish post button
	if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
		$message = "";
		if (isset($_GET['publish'])) {
			$message = "Post published successfully";
			$post_id = $_GET['publish'];
		} else if (isset($_GET['unpublish'])) {
			$message = "Post successfully unpublished";
			$post_id = $_GET['unpublish'];
		}
		togglePublishPost($post_id, $message);
	}
	// delete blog post
	function togglePublishPost($post_id, $message)
	{
		global $conn;
		$sql = "UPDATE rent_sell SET published=!published WHERE id=$post_id";
		
		if (mysqli_query($conn, $sql)) {
			$_SESSION['message'] = $message;
			header("location: property.php");
			exit(0);
		}
	}
	function deletePost($post_id)
	{
		global $conn;
		$sql = "DELETE FROM rent_sell WHERE id=$post_id";
		if (mysqli_query($conn, $sql)) {
			$_SESSION['message'] = "Post successfully deleted";
			header("location: property.php");
			exit(0);
		}
	}

?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>

<!-- Get all admin posts from DB -->
<?php $posts = getAllPosts(); ?>
	<title>Admin | Manage User Posts</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Display records from DB-->
		<div class="table-div"  style="width: 80%;">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($posts)): ?>
				<h1 style="text-align: center; margin-top: 20px;">No posts in the database.</h1>
			<?php else: ?>
				<table class="table">
						<thead>
						
						<th>N</th>
						
						<th>Name</th>
						<th>Address</th>
						<th>Email</th>
						<th>Mobileno</th>
						<th>Location</th>
						<th>Purpose</th>
						<th>Property_type</th>
						<th>Addate</th>
						
						<!-- Only Admin can publish/unpublish post -->
						<?php if ($_SESSION['user']['role'] == "Admin"): ?>
							<th><small>Publish</small></th>
						<?php endif ?>
						<th><small>Delete</small></th>
					</thead>
					<tbody>
					<?php foreach ($posts as $key => $post): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>

							<td><?php echo $post['name']; ?></td>
							<td><?php echo $post['address']; ?></td>
							<td><?php echo $post['email']; ?></td>
							<td><?php echo $post['mobileno']; ?></td>
							<td><?php echo $post['location']; ?></td>
							<td><?php echo $post['purpose']; ?></td>
							<td><?php echo $post['property_type']; ?></td>
							<td><?php echo $post['addate']; ?></td>
							
							<!-- Only Admin can publish/unpublish post -->
							<?php if ($_SESSION['user']['role'] == "Admin" ): ?>
								<td>
								<?php if ($post['published'] == true): ?>
									<a class="fa fa-check btn unpublish"
										href="property.php?unpublish=<?php echo $post['id'] ?>">
									</a>
								<?php else: ?>
									<a class="fa fa-times btn publish"
										href="property.php?publish=<?php echo $post['id'] ?>">		
									</a>
								<?php endif ?>
								</td>
							<?php endif ?>

							<td>
								<a  class="fa fa-trash btn delete" 
									href="property.php?delete-post=<?php echo $post['id'] ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Display records from DB -->
	</div>
</body>
</html>
