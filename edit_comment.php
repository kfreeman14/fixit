<?php
include('checkauth.php');
include('mysqli_connect.php');
if ($_SERVER['REQUEST_METHOD']=='POST'):
	$id = filter_var($_POST['form_id'], FILTER_SANITIZE_STRING);
	$submission_id = filter_var($_POST['form_submission_id'], FILTER_SANITIZE_STRING);
	$comment = filter_var($_POST['form_comment'], FILTER_SANITIZE_STRING);
	$query = "UPDATE fixit_comment SET comment='$comment' WHERE id=$id";
	mysqli_query($dbc, $query) or die(mysqli_error($dbc));
	mysqli_close($dbc);
	header("location:view_submission.php?id=$submission_id");
	exit();
else:
	$id = filter_var($_GET['id'], FILTER_SANITIZE_ENCODED);
	$submission_id = filter_var($_GET['submissionid'], FILTER_SANITIZE_ENCODED);
	$query = "SELECT * FROM fixit_comment WHERE id=$id";
	$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
	mysqli_close($dbc);
	$row = mysqli_fetch_array($result);
if ($_SESSION['user']!=$row['username']):
	header("location:view_submission.php?id=$submission_id");
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
	<h1>Edit Comment</h1>
	<form method="post">
		<div>
			<label>Comment</label>
			<input type="text" name="form_comment" value="<?php echo $row['comment'] ?>">
		</div>
		<input type="hidden" name="form_id" value="<?php echo $row['id'] ?>">
		<input type="hidden" name="form_submission_id" value="<?php echo $submission_id ?>">
		<button>Submit</button>
	</form>
	<p><a href="view_submission.php?<?php echo $submission_id ?>">Back</a></p>
</div>
</body>
</html>