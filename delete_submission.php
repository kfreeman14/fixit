<?php
include('checkauth.php');
include('mysqli_connect.php');
include('functions.php');
if ($_SERVER['REQUEST_METHOD']=='POST'):
	$id = filter_var($_POST['form_id'], FILTER_SANITIZE_STRING);
$query = "DELETE FROM fixit_submission WHERE id=$id";
mysqli_query($dbc, $query) or die(mysqli_error($dbc));
mysqli_close($dbc);
header('location:index.php');
exit();
else:
$id = filter_var($_GET['id'], FILTER_SANITIZE_ENCODED);
$query = "SELECT * FROM fixit_submission WHERE id=$id";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
mysqli_close($dbc);
$row = mysqli_fetch_array($result);
if ($_SESSION['user']!=$row['username']):
	header('location:index.php');
exit();
endif;
endif;
?><!DOCTYPE html>
<html>
<head>
	<title>Fix It</title>
	<?php include('stylesheets.php'); ?>
</head>
<body>
	<?php include('navbar.php'); ?>
	<div class="container">
	<h1>Delete Submission</h1>
	<form method="post">
		<p>Are you sure you want to delete this submission?</p>
		<img src="images/<?php echo $row['image'] ?>" width="500px">
		<p><em><?php echo $row['description'] ?></em></p>
		<p>Sumbitted on <?php echo local_datetime($row['created_at']) ?></p>
		<input type="hidden" name="form_id" value="<?php echo $row['id'] ?>">
		<button>Delete</button>
	</form>
	<p><a href="index.php">Back</a></p>
</div>
</body>
</html>