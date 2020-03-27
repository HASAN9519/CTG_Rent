<?php
	if(isset($_POST['search']))
	{
		$valueToSearch = $_POST['valueToSearch'];
		// search in all table columns
		// using concat mysql function
		$query = "SELECT * FROM posts WHERE location='$valueToSearch' or post_type='$valueToSearch'";
		$search_result = filterTable($query);
		
	}
	 else {
		$query = "SELECT * FROM posts";
		$search_result = filterTable($query);
	}

	// function to connect and execute the query
	function filterTable($query)
	{
		$connect = mysqli_connect("localhost", "hasan", "12345", "rentctg");
		$filter_Result = mysqli_query($connect, $query);
		return $filter_Result;
	}

	?>
<!DOCTYPE html>
<html>
<head>	
	<title>RENT CTG</title>
</head>
<body>
	<!-- container - wraps whole page -->
		<!-- navbar -->
		
	<div class="content">
		<form action="test.php" method="post">
				<input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
				<input type="submit" name="search" value="Filter"><br><br>
				
			<table>
					<tr>
						<th>id</th>
						<th>user_id</th>
						<th>location</th>
						<th>squarefeet</th>
					</tr>
				<?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['id'];?></td>
                    <td><?php echo $row['user_id'];?></td>
                    <td><?php echo $row['location'];?></td>
                    <td><?php echo $row['squarefeet'];?></td>
                </tr>
                <?php endwhile;?>
            </table>
        </form>
			
	</div>
		<!-- footer -->
</body>
</html>