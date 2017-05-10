<?php
session_start();

include_once 'includes/header.php';
require_once 'includes/login.php';
require_once 'includes/function.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

if (isset($_GET['id'])) {
	$id = sanitizeMySQL($conn, $_GET['id']);
	$query = "SELECT project_id, project_name, image, project_link, project_description, category_name, first_name, last_name
			FROM project NATURAL JOIN category NATURAL JOIN post NATURAL JOIN users WHERE project_id=".$id;
	$result = $conn->query($query);
	if (!$result) die ("Invalid project id.");
	$rows = $result->num_rows;
	if ($rows == 0) {
		echo "No project found with id of $id<br>";
	} else {
		while ($row = $result->fetch_assoc()) {
			echo '<h1>'.$row["project_name"].'</h1>';
			echo "<img src=\"image/".$row["image"]."\" width=\"500\" height=\"500\"><br>";
			echo '<p>'.$row["project_name"]." is ".$row["project_description"]." It is a ".$row["category_name"]." project. You can find more info ".$row["project_link"].'</p>';
      echo '<p>Author Information:</p>';
			echo '<p>'.$row["first_name"]." ".$row["last_name"].'</p>';
			// echo $row["first_name"]." ".$row["last_name"]." (".$row["email"].")";
		}
	}
	echo "<p><a href=\"project.php\">Return to homepage</a></p>";
} else {
	echo "No project id passed";
}

include_once 'includes/footer.php';
?>
