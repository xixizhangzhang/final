<?php
session_start();
require_once 'includes/auth.php';
require_once 'includes/login.php';
require_once 'includes/function.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
$time_to = date("H:i:s");
$query = "UPDATE login SET time_end = '$time_to' WHERE login_id = ".$_SESSION['login_id']."";
$result = $conn->query($query);
session_destroy();
include_once 'includes/header.php';
echo "<p>You are now logged out.</p>";
echo "<p><a href=\"project.php\">Return to homepage</a></p>";
include_once 'includes/footer.php';

?>
