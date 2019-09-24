<?php
include('checkauth.php');
include('mysqli_connect.php');
include('functions.php');
$id = filter_var($_GET['id'], FILTER_SANITIZE_ENCODED);
$query = "SELECT * FROM fixit_submission WHERE id=$id";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
$row = mysqli_fetch_array($result);
$query_comment = "SELECT * FROM fixit_comment WHERE submission_id=$id";
$result_comment = $result = mysqli_query($dbc, $query_comment) or die(mysqli_error($dbc));
mysqli_close($dbc);
?><!DOCTYPE html>
<html>
<head>
	<title>Fix It</title>
	<?php include('stylesheets.php'); ?>
</head>
<body>
<?php include('navbar.php'); ?>
<div class="container">
	<h1>View Submission</h1>
	<div class="submission">
	<img src="images/<?php echo $row['image'] ?>" width="500px">
	<p><em><?php echo $row['description'] ?></em></p>
	<p>Sumbitted on <?php echo local_datetime($row['created_at']) ?> by <?php echo $row['username'] ?></p>
	<?php if($_SESSION['user']==$row['username']): ?>
		<p><a href="edit_submission.php?id=<?php echo $row['id'] ?>">Edit</a></p>
		<p><a href="delete_submission.php?id=<?php echo $row['id'] ?>">Delete</a></p>
	<?php endif; ?>
	<?php while($row_comment = mysqli_fetch_array($result_comment)): ?>
		<p>On <?php echo local_datetime($row_comment['created_at'])?> <?php echo $row_comment['username'] ?> commented: <strong><?php echo $row_comment['comment'] ?></strong>
		<?php if ($_SESSION['user']==$row_comment['username']): ?>
			(<a href="edit_comment.php?id=<?php echo $row_comment['id'] ?>&submissionid=<?php echo $row['id'] ?>">Edit</a> | <a href="delete_comment.php?id=<?php echo $row_comment['id'] ?>&submissionid=<?php echo $row['id'] ?>">Delete</a>)
		<?php endif; ?></p>
	<?php endwhile; ?>
	<p><a href="add_comment.php?submissionid=<?php echo $row['id'] ?>">Add Comment</a></p>
	</div>
	<p><a href="index.php">Back</a></p>
</div>
</body>
</html>