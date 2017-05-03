<?php
session_start();

print_r($_SESSION);

require_once 'includes/auth.php';
require_once 'includes/login.php';
require_once 'includes/function.php';

if (isset($_POST['submit'])) { //check if the form has been submitted
	// if ((empty($_POST['project_name'])) || (empty($_POST['filename'])) || (empty($_POST['project_link'])) || (empty($_POST['project_description'])) || (empty($_POST['category_id']))) {
	// 	$message = '<p class="error">Please fill out all of the form fields!</p>';
	// } else {
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);
		$name = sanitizeMySQL($conn, $_POST['project_name']);
		$image = sanitizeMySQL($conn, $_POST['filename']);
		$link = sanitizeMySQL($conn, $_POST['project_link']);
		$description = sanitizeMySQL($conn, $_POST['project_description']);
		$category_id = sanitizeMySQL($conn, $_POST['category_id']);
		$user_id = $_SESSION['user_id'];
		$date = date("Y-m-d");
		$query1 = "INSERT INTO project VALUES(\"$name\", \"$image\", \"$link\", \"$description\", NULL, \"$category_id\", \"$user_id\")";
		$result1 = $conn->query($query1);
		$last_id = $conn->insert_id;

		$query2 = "INSERT INTO post VALUES(\"$user_id\", \"$last_id\", \"$date\", NULL)";
		$result2 = $conn->query($query2);

		#if ($_FILES) {
		$uploads_dir = 'image';
		$tmp_name = $_FILES["filename"]["tmp_name"];
		$name = basename($_FILES["filename"]["name"]);
		move_uploaded_file($tmp_name, "$uploads_dir/$name");
		echo "Uploaded image '$name'<br><img src='$uploads_dir/$name'>";
		// }

		if ((!$result1) || (!$result2)){
			die ("Database access failed: " . $conn->error);
		} else {
			$message = "<p class=\"message\">Successfully added new project named $name! <a href=\"project.php\">Return to project list</a></p>";
		}
	// }
}

?>

<?php
include_once 'includes/header.php';
if (isset($message)) echo $message;
?>

<form method="post" action="" enctype="multipart/form-data">
		<label for="project_name">Name:</label>
		<input type="text" name="project_name"><br>
		<label for="project_link">Link:</label>
		<input type="text" name="project_link"><br>
		<label for="project_description">Description:</label>
		<input type="text" name="project_description"><br>
		<label for="category_id">Category:</label>
		<select name="category_id">
		  <option value="1">web</option>
		  <option value="2">mobile</option>
			<option value="3">website</option>
		</select><br>
		<label for="image">Select Image:</label>
		<input type="file" name="filename" size='10'><br>
		<input type="submit" name="submit">
</form>


<?php include_once 'includes/footer.php'; ?>
