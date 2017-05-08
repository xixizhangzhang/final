<?php
session_start();

include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

// $query = "SELECT project_id, project_name, project_link, project_description, category_name
// 		FROM project NATURAL JOIN category WHERE category_id=2 ORDER BY project_id ASC";

		$query = "SELECT project_id, project_name, image, project_link, project_description, category_name, first_name, last_name
				FROM project NATURAL JOIN category NATURAL JOIN post NATURAL JOIN users WHERE category_id=2 ORDER BY project_id ASC";

$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

while ($row = $result->fetch_assoc()) {
	echo "<div class='card'>";
	echo "<img src=\"image/".$row["image"]."\" width=\"300\" height=\"300\"><br>";
	echo "<a href=\"post.php?id=".$row["project_id"]."\">".$row["project_name"]."</a>";
	echo "<p>Link: ".$row["project_link"]."</p><p>Description: ".$row["project_description"]."</p><p>Category: ".$row["category_name"]."</p> <p>Author: ".$row["first_name"]." ".$row["last_name"]."</p>";
	echo "</div>";
}



// echo "<table><tr> <th>Name</th> <th>Image</th> <th>Link</th> <th>Description</th> <th>Category</th> <th>Author Name</th></tr>";
// while ($row = $result->fetch_assoc()) {
// 	echo '<tr>';
// 	echo "<td>";
// 	echo "<a href=\"post.php?id=".$row["project_id"]."\">".$row["project_name"]."</a>";
// 	echo "</td><td>";
// 	echo "<img src='http://localhost/final/image ".$row['project_name']."' height='50' width=auto>";
// 	echo "</td><td>".$row["project_link"]."</td><td>".$row["project_description"]."</td><td>".$row["category_name"]."</td><td>".$row["first_name"]." ".$row["last_name"]."</td>";
// 	echo '</tr>';
// }
//
// echo "</table>";
echo "<a href=\"addnewproject.php\">Add a New Project</a>";

include_once 'includes/footer.php';
?>
