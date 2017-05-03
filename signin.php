<?php
session_start();

require_once 'includes/login.php';
require_once 'includes/function.php';

if (isset($_POST['submit'])) { //check if the form has been submitted
	if ( empty($_POST['username']) || empty($_POST['password']) ) {
		$message = '<p class="error">Please fill out all of the form fields!</p>';
	} else {
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);
		$username = sanitizeMySQL($conn, $_POST['username']);
		$password = sanitizeMySQL($conn, $_POST['password']);
		$salt1 = "qm&h*";
		$salt2 = "pg!@";
		$password = hash('ripemd128', $salt1.$password.$salt2);
		$query  = "SELECT first_name, last_name, user_id FROM users WHERE username='$username' AND password='$password'";
		$result = $conn->query($query);
		if (!$result) die($conn->error);
		$rows = $result->num_rows;
		if ($rows==1) {
			$row = $result->fetch_assoc();
			$_SESSION['fname'] = $row['first_name'];
			$_SESSION['lname'] = $row['last_name'];
			$_SESSION['user_id'] = $row['user_id'];
			$user_id = $_SESSION['user_id'];
			$goto = empty($_SESSION['goto']) ? '/final/project.php' : $_SESSION['goto'];
			header('Location: ' . $goto);
			$date = date("Y-m-d");
			$time_from = date("H:i:s");
			$time_to = date("H:i:s");
			$query = "INSERT INTO login VALUES (\"$date\", \"$time_from\", NULL, \"$user_id\", NULL)";
			$result = $conn->query($query);
			$last_login_id = $conn->insert_id;
			$_SESSION['login_id'] = $last_login_id;
			exit;
		} else {
			$message = '<p class="error">Invalid username/password combination!</p>';
		}
	}
}
?>

<?php
include_once 'includes/header.php';
if (isset($message)) echo $message;
?>
<fieldset style="width:30%"><legend>Log-in</legend>
<form method="POST" action="">
Username:<br><input type="text" name="username" size="40"><br>
Password:<br><input type="password" name="password" size="40"><br>
<input type="submit" name="submit" value="Log-In">
</form>
</fieldset>
<?php include_once 'includes/footer.php'; ?>
