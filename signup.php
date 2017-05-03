<?php
session_start();

#require_once 'includes/auth.php';
require_once 'includes/login.php';
require_once 'includes/function.php';

if (isset($_POST['submit'])) { //check if the form has been submitted
	if ((empty($_POST['username'])) || (empty($_POST['password'])) || (empty($_POST['first_name'])) || (empty($_POST['last_name'])) || (empty($_POST['email']))) {
		$message = '<p class="error">Please fill out all of the form fields!</p>';
	} else {
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);
		$username = sanitizeMySQL($conn, $_POST['username']);
		$password = sanitizeMySQL($conn, $_POST['password']);

		$salt1 = "qm&h*";
	  $salt2 = "pg!@";
	  $sandhpassword = hash('ripemd128', "$salt1$password$salt2");

		$first_name = sanitizeMySQL($conn, $_POST['first_name']);
		$last_name = sanitizeMySQL($conn, $_POST['last_name']);
		$email = sanitizeMySQL($conn, $_POST['email']);
		$query = "INSERT INTO users VALUES(\"$username\", \"$sandhpassword\", \"$first_name\", \"$last_name\", \"$email\", NULL)";
		$result = $conn->query($query);
		if (!$result) {
			die ("Database access failed: " . $conn->error);
		} else {
			$message = "<p class=\"message\">Successfully sign up! <a href=\"signin.php\">Return to login page</a></p>";
		}
	}
}
?>

<?php
include_once 'includes/header.php';
if (isset($message)) echo $message;
?>
<form method="post" action="">
	<fieldset>
		<legend>Sign up</legend>
		<label for="username">Username:</label>
		<input type="text" name="username"><br>
		<label for="password">Password:</label>
		<input type="text" name="password"><br>
		<label for="first_name">First Name:</label>
		<input type="text" name="first_name"><br>
		<label for="last_name">Last Name:</label>
		<input type="text" name="last_name"><br>
		<label for="email">Email:</label>
		<input type="text" name="email"><br>
		<input type="submit" name="submit">
	</fieldset>
</form>
<?php include_once 'includes/footer.php'; ?>
