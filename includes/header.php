<!DOCTYPE html>
<html>
<head>
<title>UX/UI Design Projects</title>
<link rel="stylesheet" type="text/css" href="includes/project.css" />
</head>
<body style="background-image: url('image/gradient.png')">
<a class='home' href="project.php"><img src="image/logo.png" width="25" height=auto></a>
<header class='top'>
	<h1>UX/UI Design Projects</h1>
	<?php
	if (isset($_SESSION['fname']) && isset($_SESSION['lname']) ) {
		echo "<h3>Welcome, ".$_SESSION['fname']." ".$_SESSION['lname'];
		echo " | <small><a href=\"signout.php\">Logout</a></small></h3>";
	} else {
    echo "<small><a href=\"signup.php\">Signup</a></small> ";
		echo "<small><a href=\"signin.php\">Login</a></small> <br>";
	}
	?>

	<?php

	$query = "SELECT category_name
			FROM category NATURAL JOIN project ORDER BY category_id ASC";


	echo "<a href=\"web.php\"> Web App | </a>";
	echo "<a href=\"mobile.php\"> Mobile App | </a>";
	echo "<a href=\"website.php\">Website</a>";
	 ?>

</header>
<div id="body">
