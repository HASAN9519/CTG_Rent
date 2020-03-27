<?php require_once('config.php') ?>
	
<div class="navbar">
	<div class="logo_div">
		<a href="index.php"><h1>RENT CTG</h1></a>
	</div>
	<ul>
	  <li><a class="active" href="index.php">Home</a></li>
	  <li class="dropdown"><a>Search By</a>
	  <div class="dropdown-content">
      <a class="active" href="searchloc.php">LOCATION</a>
	  <a class="active" href="searchbr.php">BUY/RENT</a>
	  <a class="active" href="searchpr.php">Price</a>
	  </div>
	  </li>
	  <li><a href="#news">News</a></li>
	  <li><a href="#contact">Contact</a></li>
	  <li><a href="#about">About</a></li>
	  
	  <li class="dropdown"><a>More Info</a>
	  <div class="dropdown-content">
      <a class="active" href="register.php">Register Now</a>
	  <a class="active" href="give_rent_sell.php">Rent/Sell Property</a>
	  <a class="active" href="<?php echo BASE_URL .'admin/dashboard.php' ?>">Admin Panel</a>
	  </div>
	  </li>
	</ul>
</div>