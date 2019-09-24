<?php
session_start();
include('mysqli_connect.php');
if ($_SERVER['REQUEST_METHOD']=='POST'):
	$username = filter_var($_POST['form_username'], FILTER_SANITIZE_STRING);
if (empty($username)):
	$errors[] = "Please enter a username.";
endif;
$password = filter_var($_POST['form_password'], FILTER_SANITIZE_STRING);
if (empty($password)):
	$errors[] = "Please enter a password.";
endif;
if (empty($errors)):
	$query = "SELECT password FROM fixit_user WHERE username='$username'";
$result = mysqli_query($dbc, $query) or die (mysqli_error($dbc));
$row = mysqli_fetch_array($result);
if (password_verify($password, $row['password'])):
	$_SESSION['user'] = $username;
mysqli_close($dbc);
header('location:index.php');
exit();
else:
	$errors[] = "Please enter a valid username/password.";
endif;
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
	<h1>Login</h1>
	<?php if (!empty($errors)): ?>
		<ul>
			<?php foreach($errors as $error): ?>
				<li><?php echo $error ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<form method="post">
		<div>
			<label>Email</label>
			<input type="text" name="form_username" value="<?php if(isset($username)) echo $username ?>">
		</div>
		<div>
			<label>Password</label>
			<input type="password" name="form_password">
		</div>
		<button>Login</button>
	</form>
	<p><a href="index.php">Back</a></p>
</div>
</body>
</html>