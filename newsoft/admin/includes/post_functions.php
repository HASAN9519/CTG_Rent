<?php 
// Post variables
$post_id = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$post_type = "";
$vandorname = "";
$address    = "";
$email = "";
$mobileno = "";
$location = "";
$bedroom = "";
$bathroom = "";
$squarefeet = "";
$feature = "";
$price = "";
$paytime = "";
$gmap = "";

$post_slug = "";
$body = "";
$featured_image = "";
$featured_image2 = "";
$featured_image3 = "";
$post_topic = "";

/* - - - - - - - - - - 
-  Post functions
- - - - - - - - - - -*/
// get all posts from DB
function getAllPosts()
{
	global $conn;
	
	// Admin can view all posts
	// Author can only view their posts
	if ($_SESSION['user']['role'] == "Admin") {
		$sql = "SELECT * FROM posts";
	} elseif ($_SESSION['user']['role'] == "Author") {
		$user_id = $_SESSION['user']['id'];
		$sql = "SELECT * FROM posts WHERE user_id=$user_id";
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
if (isset($_POST['create_post'])) { createPost($_POST); }
// if user clicks the Edit post button
if (isset($_GET['edit-post'])) {
	$isEditingPost = true;
	$post_id = $_GET['edit-post'];
	editPost($post_id);
}
// if user clicks the update post button
if (isset($_POST['update_post'])) {
	updatePost($_POST);
}
// if user clicks the Delete post button
if (isset($_GET['delete-post'])) {
	$post_id = $_GET['delete-post'];
	deletePost($post_id);
}

/* - - - - - - - - - - 
-  Post functions
- - - - - - - - - - -*/
function createPost($request_values)
	{
		global $conn, $errors, $title,$post_type, $vandorname,$address,$email,$mobileno,$location,$bedroom,$bathroom,$squarefeet,$feature,$price,$paytime,$gmap,$featured_image,$featured_image2,
		$featured_image3,$topic_id, $body, $published;
		$user_id = $_SESSION['user']['id'];
		$title = ($request_values['title']);
		$post_type = ($request_values['post_type']);
		$vandorname = ($request_values['vandorname']);
		$address = ($request_values['address']);
		$email = ($request_values['email']);
		$mobileno = ($request_values['mobileno']);
		$location = ($request_values['location']);
		$bedroom = ($request_values['bedroom']);
		$bathroom = ($request_values['bathroom']);
		$squarefeet = ($request_values['squarefeet']);
		$feature = ($request_values['feature']);
		$price = ($request_values['price']);
		$paytime = ($request_values['paytime']);
		$gmap= ($request_values['gmap']);
		
		$body = htmlentities($request_values['body']);
		if (isset($request_values['topic_id'])) {
			$topic_id = ($request_values['topic_id']);
		}
		if (isset($request_values['publish'])) {
			$published = ($request_values['publish']);
		}
		// create slug: if title is "The Storm Is Over", return "the-storm-is-over" as slug
		$post_slug = makeSlug($title);
		// validate form
		if (empty($title)) { array_push($errors, "Post title is required"); }
		if (empty($post_type)) { array_push($errors, "post_type is required"); }
		if (empty($vandorname)) { array_push($errors, "Uhmm...We gonna need your vandorname"); }
		if (empty($address)) { array_push($errors, "Oops.. address is missing"); }
		if (empty($email)) { array_push($errors, "uh-oh you forgot the email"); }
		if (empty($mobileno)) { array_push($errors, "uh-oh you forgot the mobileno"); }
		if (empty($location)) { array_push($errors, "uh-oh you forgot the location"); }
		if (empty($squarefeet)) { array_push($errors, "uh-oh you forgot the squarefeet"); }
		if (empty($feature)) { array_push($errors, "uh-oh you forgot the feature"); }
		if (empty($price)) { array_push($errors, "uh-oh you forgot the price"); }
		if (empty($paytime)) { array_push($errors, "uh-oh you forgot the paytime"); }
		
		if (empty($body)) { array_push($errors, "Post body is required"); }
		if (empty($topic_id)) { array_push($errors, "Post topic is required"); }
		// Get image name
	  	$featured_image = $_FILES['image']['name'];
	  	if (empty($featured_image)) { array_push($errors, "Featured image is required"); }
	  	// image file directory
	  	$target = "../static/images/" . basename($featured_image);
	  	if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
	  		array_push($errors, "Failed to upload image. Please check file settings for your server");
	  	}
		
		$featured_image2 = $_FILES['image2']['name'];
		if (empty($featured_image2)) { array_push($errors, "Featured image is required"); }
	  	// image file directory
	  	$target = "../static/images/" . basename($featured_image2);
	  	if (!move_uploaded_file($_FILES['image2']['tmp_name'], $target)) {
	  		array_push($errors, "Failed to upload image. Please check file settings for your server");
	  	}
		
		$featured_image3 = $_FILES['image3']['name'];
		if (empty($featured_image3)) { array_push($errors, "Featured image is required"); }
	  	// image file directory
	  	$target = "../static/images/" . basename($featured_image3);
	  	if (!move_uploaded_file($_FILES['image3']['tmp_name'], $target)) {
	  		array_push($errors, "Failed to upload image. Please check file settings for your server");
	  	}
		
		// Ensure that no post is saved twice. 
		$post_check_query = "SELECT * FROM posts WHERE slug='$post_slug' LIMIT 1";
		$result = mysqli_query($conn, $post_check_query);

		if (mysqli_num_rows($result) > 0) { // if post exists
			array_push($errors, "A post already exists with that title.");
		}
		// create post if there are no errors in the form
		if (count($errors) == 0) {
			$query = "INSERT INTO posts (user_id, title,slug,post_type, vandorname, address, email, mobileno, location, bedroom, bathroom,  squarefeet, feature,price,paytime,gmap, image,image2,image3, body, published, created_at, updated_at)
			VALUES('$user_id', '$title', '$post_slug','$post_type', '$vandorname', '$address', '$email', '$mobileno', '$location','$bedroom','$bathroom','$squarefeet','$feature' ,'$price','$paytime','$gmap','$featured_image','$featured_image2','$featured_image3', '$body', $published, now(), now())";
			if(mysqli_query($conn, $query)){ // if post created successfully
				$inserted_post_id = mysqli_insert_id($conn);
				// create relationship between post and topic
				$sql = "INSERT INTO post_topic (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
				mysqli_query($conn, $sql);

				$_SESSION['message'] = "Post created successfully";
				header('location: posts.php');
				exit(0);
			}
		}
	}

	/* * * * * * * * * * * * * * * * * * * * *
	
	* - Takes post id as parameter
	* - Fetches the post from database
	* - sets post fields on form for editing
	* * * * * * * * * * * * * * * * * * * * * */
	function editPost($role_id)
	{
		global $conn, $title, $post_slug,$post_type,  $vandorname,$address,$email,$mobileno,$location,$bedroom,$bathroom,$squarefeet,$feature,$price,$paytime,$gmap,$body, $published, $isEditingPost, $post_id;
		$sql = "SELECT * FROM posts WHERE id=$role_id LIMIT 1";
		$result = mysqli_query($conn, $sql);
		$post = mysqli_fetch_assoc($result);
		// set form values on the form to be updated
		$title = $post['title'];
		$post_type = $post['post_type'];
		$vandorname = $post['vandorname'];
		$address = $post['address'];
		$email = $post['email'];
		$mobileno = $post['mobileno'];
		$location = $post['location'];
		$bedroom = $post['bedroom'];
		$bathroom= $post['bathroom'];
		$squarefeet = $post['squarefeet'];
		$feature =$post['feature'];
		$price =$post['price'];
		$paytime =$post['paytime'];
		$gmap =$post['gmap'];
		
		$body = $post['body'];
		$published = $post['published'];
	}

	function updatePost($request_values)
	{
		global $conn, $errors, $post_id, $title,$post_type, $vandorname,$address,$email,$mobileno,$location,$bedroom,$bathroom,$squarefeet,$feature,$price,$paytime,$gmap,
		$featured_image,$featured_image2,$featured_image3, $topic_id, $body, $published;

		$title = ($request_values['title']);
		$post_type = ($request_values['post_type']);
		$vandorname = ($request_values['vandorname']);
		$address = ($request_values['address']);
		$email = ($request_values['email']);
		$mobileno = ($request_values['mobileno']);
		$location = ($request_values['location']);
		$bedroom = ($request_values['bedroom']);
		$bathroom= ($request_values['bathroom']);
		
		$squarefeet = ($request_values['squarefeet']);
		$feature = ($request_values['feature']);
		$price = ($request_values['price']);
		$paytime = ($request_values['paytime']);
		$gmap = ($request_values['gmap']);
		
		$body = ($request_values['body']);
		$post_id = ($request_values['post_id']);
		if (isset($request_values['topic_id'])) {
			$topic_id = ($request_values['topic_id']);
		}
		// create slug: if title is "The Storm Is Over", return "the-storm-is-over" as slug
		$post_slug = makeSlug($title);

		if (empty($title)) { array_push($errors, "Post title is required"); }
		if (empty($body)) { array_push($errors, "Post body is required"); }
		
		if (empty($post_type)) { array_push($errors, "post_type is required"); }
		if (empty($vandorname)) {  array_push($errors, "Uhmm...We gonna need your vandorname"); }
		if (empty($address)) { array_push($errors, "Oops.. address is missing"); }
		if (empty($email)) { array_push($errors, "uh-oh you forgot the email"); }
		if (empty($mobileno)) { array_push($errors, "uh-oh you forgot the mobileno"); }
		if (empty($location)) { array_push($errors, "uh-oh you forgot the location"); }

		if (empty($squarefeet)) { array_push($errors, "uh-oh you forgot the squarefeet"); }
		if (empty($feature)) { array_push($errors, "uh-oh you forgot the feature"); }
		if (empty($price)) { array_push($errors, "uh-oh you forgot the price"); }
		if (empty($paytime)) { array_push($errors, "uh-oh you forgot the paytime"); }
		
		
	  	$featured_image = $_FILES['image']['name'];
		// if new featured image has been provided
		if (isset($_POST['image'])) {
			// Get image name
		  	$featured_image = $_FILES['image']['name'];
		  	// image file directory
		  	$target = "../static/images/" . basename($featured_image);
		  	if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
		  		array_push($errors, "Failed to upload image. Please check file settings for your server");
		  	}
		}

		$featured_image2 = $_FILES['image2']['name'];
		// if new featured image has been provided
		if (isset($_POST['image2'])) {
			// Get image name
		  	$featured_image = $_FILES['image2']['name'];
		  	// image file directory
		  	$target = "../static/images/" . basename($featured_image2);
		  	if (!move_uploaded_file($_FILES['image2']['tmp_name'], $target)) {
		  		array_push($errors, "Failed to upload image. Please check file settings for your server");
		  	}
		}
		
		$featured_image3 = $_FILES['image3']['name'];
		// if new featured image has been provided
		if (isset($_POST['image3'])) {
			// Get image name
		  	$featured_image3 = $_FILES['image3']['name'];
		  	// image file directory
		  	$target = "../static/images/" . basename($featured_image3);
		  	if (!move_uploaded_file($_FILES['image3']['tmp_name'], $target)) {
		  		array_push($errors, "Failed to upload image. Please check file settings for your server");
		  	}
		}
		// register topic if there are no errors in the form
		if (count($errors) == 0) {
			$query = "UPDATE posts SET title='$title', slug='$post_slug',post_type='$post_type', vandorname='$vandorname',address='$address',email='$email',mobileno='$mobileno',location='$location',bedroom='$bedroom',bathroom='$bathroom',squarefeet='$squarefeet',feature='$feature',
			price='$price',paytime='$paytime',gmap='$gmap', image='$featured_image',image2='$featured_image2',image3='$featured_image3', body='$body',published='$published', updated_at=now() WHERE id=$post_id";
			// attach topic to post on post_topic table
			if(mysqli_query($conn, $query)){ // if post created successfully
				if (isset($topic_id)) {
					$inserted_post_id = mysqli_insert_id($conn);
					// create relationship between post and topic
					$sql = "INSERT INTO post_topic (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
					mysqli_query($conn, $sql);
					$_SESSION['message'] = "Post created successfully";
					header('location: posts.php');
					exit(0);
				}
			}
			$_SESSION['message'] = "Post updated successfully";
			header('location: posts.php');
			exit(0);
		}
	}
	// delete blog post
	function deletePost($post_id)
	{
		global $conn;
		$sql = "DELETE FROM posts WHERE id=$post_id";
		if (mysqli_query($conn, $sql)) {
			$_SESSION['message'] = "Post successfully deleted";
			header("location: posts.php");
			exit(0);
		}
	}

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
		$sql = "UPDATE posts SET published=!published WHERE id=$post_id";
		
		if (mysqli_query($conn, $sql)) {
			$_SESSION['message'] = $message;
			header("location: posts.php");
			exit(0);
		}
	}





?>