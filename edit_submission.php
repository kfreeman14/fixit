<?php
include('checkauth.php');
include('mysqli_connect.php');
if ($_SERVER['REQUEST_METHOD']=='POST'):
	$id = filter_var($_POST['form_id'], FILTER_SANITIZE_STRING);
	$description = filter_var($_POST['form_description'], FILTER_SANITIZE_STRING);
	if ($_FILES['form_image']['error']==0):
	$image = $_FILES['form_image']['name'];
	$image_extension = pathinfo($image, PATHINFO_EXTENSION);
	$image_filename = uniqid();
	$image = "$image_filename.$image_extension";
	$image_temporary = $_FILES['form_image']['tmp_name'];
	$image_destination = "images/$image";
	move_uploaded_file($image_temporary, $image_destination);
	$query = "UPDATE fixit_submission SET description='$description',  image='$image' WHERE id=$id";
	else:
		$query = "UPDATE fixit_submission SET description='$description' WHERE id=$id";
	endif;
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
	<h1>Edit Submission</h1>
	<div class="submission">
	<form method="post" enctype="multipart/form-data">
		<div>
			<label>Image</label>
			<p><img src="images/<?php echo $row['image'] ?>" width="500px"></p>
			<input type="file" name="form_image">
		</div>
		<div>
			<label>Description</label>
			<input type="text" name="form_description" value="<?php echo $row['description'] ?>">
		</div>
		<input type="hidden" name="form_id" value="<?php echo $row['id'] ?>">
		<button>Submit</button>
	</form>
	</div>
	<p><a href="index.php">Back</a></p>
</div>
</body>
</html>