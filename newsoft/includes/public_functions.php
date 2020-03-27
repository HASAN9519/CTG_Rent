<?php 
/* * * * * * * * * * * * * * *
* Returns all published posts
* * * * * * * * * * * * * * */
function getPublishedPosts() {
	// use global $conn object in function
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true ORDER BY created_at DESC";
	$result = mysqli_query($conn, $sql);
	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}
/* * * * * * * * * * * * * * *
* Receives a post id and
* Returns topic of the post
* * * * * * * * * * * * * * */
function getPostTopic($post_id){
	global $conn;
	$sql = "SELECT * FROM topics WHERE id=
			(SELECT topic_id FROM post_topic WHERE post_id=$post_id) LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic;
}



/* * * * * * * * * * * * * * * *
* Returns all posts under a topic
* * * * * * * * * * * * * * * * */
function getPublishedPostsByTopic($topic_id) {
	global $conn;
	$sql = "SELECT * FROM posts ps 
			WHERE ps.id IN 
			(SELECT pt.post_id FROM post_topic pt 
				WHERE pt.topic_id=$topic_id GROUP BY pt.post_id 
				HAVING COUNT(1) = 1) ORDER BY ps.created_at DESC";
	$result = mysqli_query($conn, $sql);
	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}
/* * * * * * * * * * * * * * * *
* Returns topic name by topic id
* * * * * * * * * * * * * * * * */
function getTopicNameById($id)
{
	global $conn;
	$sql = "SELECT name FROM topics WHERE id=$id";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic['name'];
}

/* * * * * * * * * * * * * * *
* Returns a single post
* * * * * * * * * * * * * * */
function getPost($slug){
	global $conn;
	// Get single post slug
	$post_slug = $_GET['post-slug'];
	$sql = "SELECT * FROM posts WHERE slug='$post_slug' AND published=true";
	$result = mysqli_query($conn, $sql);

	// fetch query results as associative array.
	$post = mysqli_fetch_assoc($result);
	if ($post) {
		// get the topic to which this post belongs
		$post['topic'] = getPostTopic($post['id']);
	}
	return $post;
}
/* * * * * * * * * * * *
*  Returns all topics
* * * * * * * * * * * * */
function getAllTopics()
{
	global $conn;
	$sql = "SELECT * FROM topics";
	$result = mysqli_query($conn, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $topics;
}
/* * * * * * * * * * * * * * *
* Returns all published posts
* * * * * * * * * * * * * * */
function filterTable()
{
				global $conn;
				$conn = mysqli_connect("localhost", "hasan", "12345", "rentctg");
				if(isset($_POST['search']))
			{
				$valueToSearch = $_POST['valueToSearch'];
				// search in all table columns
				// using concat mysql function
				$query = "SELECT * FROM posts WHERE location='$valueToSearch' or post_type='$valueToSearch' ORDER BY created_at DESC";
				$filter_Result = mysqli_query($conn, $query);
				$postsx = mysqli_fetch_all($filter_Result, MYSQLI_ASSOC);
			}
			 else {
				$query = "SELECT * FROM posts WHERE published=true ORDER BY created_at DESC";
				$filter_Result = mysqli_query($conn, $query);
				$postsx = mysqli_fetch_all($filter_Result, MYSQLI_ASSOC);
			}
		$final_postsx = array();
		foreach ($postsx as $postx) {
		$postx['topic'] = getPostTopic($postx['id']); 
		array_push($final_postsx, $postx);
		}
		return $final_postsx;
}
function filterlocTable()
{
				global $conn;
				$conn = mysqli_connect("localhost", "hasan", "12345", "rentctg");
				if(isset($_POST['search']))
			{
				$valueToSearch1 = $_POST['valueToSearch1'];
				$valueToSearch2 = $_POST['valueToSearch2'];
				// search in all table columns
				// using concat mysql function
				$query = "SELECT * FROM posts WHERE location='$valueToSearch1' and post_type='$valueToSearch2' ORDER BY created_at DESC";
				$filter_Result = mysqli_query($conn, $query);
				$postsx = mysqli_fetch_all($filter_Result, MYSQLI_ASSOC);
			}
			 else {
				$query = "SELECT * FROM posts WHERE published=true";
				$filter_Result = mysqli_query($conn, $query);
				$postsx = mysqli_fetch_all($filter_Result, MYSQLI_ASSOC);
			}
		$final_postsx = array();
		foreach ($postsx as $postx) {
		$postx['topic'] = getPostTopic($postx['id']); 
		array_push($final_postsx, $postx);
		}
		return $final_postsx;
}
function filterbrTable()
{
				global $conn;
				$conn = mysqli_connect("localhost", "hasan", "12345", "rentctg");
				if(isset($_POST['search']))
			{
				$valueToSearch1 = $_POST['valueToSearch1'];
				$valueToSearch2 = $_POST['valueToSearch2'];
				// search in all table columns
				// using concat mysql function
				$query = "SELECT * FROM posts ps WHERE ps.post_type='$valueToSearch1' and ps.id IN
				(SELECT pt.post_id FROM post_topic pt 
				WHERE pt.topic_id='$valueToSearch2' GROUP BY pt.post_id 
				HAVING COUNT(1) = 1) ORDER BY ps.created_at DESC ";
				$filter_Result = mysqli_query($conn, $query);
				$postsx = mysqli_fetch_all($filter_Result, MYSQLI_ASSOC);
			}
			 else {
				$query = "SELECT * FROM posts WHERE published=true ORDER BY created_at DESC";
				$filter_Result = mysqli_query($conn, $query);
				$postsx = mysqli_fetch_all($filter_Result, MYSQLI_ASSOC);
			}
		$final_postsx = array();
		foreach ($postsx as $postx) {
		$postx['topic'] = getPostTopic($postx['id']); 
		array_push($final_postsx, $postx);
		}
		return $final_postsx;
}
function filterprTable()
{
				global $conn;
				$conn = mysqli_connect("localhost", "hasan", "12345", "rentctg");
				if(isset($_POST['search']))
			{
				$valueToSearch1 = $_POST['valueToSearch1'];
				
				$valueToSearch2 = $_POST['valueToSearch2'];
				
				// search in all table columns
				// using concat mysql function
				$query = "SELECT * FROM posts ps WHERE ps.price <= '$valueToSearch1' and post_type='$valueToSearch2' and  ps.id IN
				(SELECT pt.post_id FROM post_topic pt 
				WHERE pt.topic_id='3' GROUP BY pt.post_id 
				HAVING COUNT(1) = 1) ORDER BY ps.price DESC";
				$filter_Result = mysqli_query($conn, $query);
				$postsx = mysqli_fetch_all($filter_Result, MYSQLI_ASSOC);
			}
			 else {
				$query = "SELECT * FROM posts ps 
				WHERE ps.id IN 
				(SELECT pt.post_id FROM post_topic pt 
				WHERE pt.topic_id='3' GROUP BY pt.post_id 
				HAVING COUNT(1) = 1) ORDER BY ps.created_at DESC";
				$filter_Result = mysqli_query($conn, $query);
				$postsx = mysqli_fetch_all($filter_Result, MYSQLI_ASSOC);
			}
			$final_postsx = array();
			foreach ($postsx as $postx) {
			$postx['topic'] = getPostTopic($postx['id']); 
			array_push($final_postsx, $postx);
			}
			return $final_postsx;
		
}


?>