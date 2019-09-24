<?php
session_start();
include('mysqli_connect.php');
include('functions.php');
$query = "SELECT * FROM fixit_submission";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
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
	<?php if (isset($_SESSION['user'])): ?>
		<h1>Welcome back, <?php echo $_SESSION['user']?>!</h1>
		<h2>Submissions</h2>
		<?php while ($row = mysqli_fetch_array($result)): ?>
			<div class="submission">
			<a href="view_submission.php?id=<?php echo $row['id'] ?>"><img src="images/<?php echo $row['image'] ?>" width="500px"></a>
			<p><em><?php echo $row['description'] ?></em></p>
			<p>Sumbitted on <?php echo local_datetime($row['created_at']) ?> by <?php echo $row['username'] ?></p>
			<?php if($_SESSION['user']==$row['username']): ?>
			<p><a href="edit_submission.php?id=<?php echo $row['id'] ?>">Edit</a></p>
			<p><a href="delete_submission.php?id=<?php echo $row['id'] ?>">Delete</a></p>
			<?php endif; ?>
			</div>
		<?php endwhile; ?>
	<?php else: ?>
		<h1>Welcome to Fix It</h1>
	<?php endif; ?>
</div>
</body>
</html>