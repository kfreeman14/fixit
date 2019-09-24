<?php
session_start();
include('mysqli_connect.php');
if ($_SERVER['REQUEST_METHOD']=='POST'):
	$username = filter_var($_POST['form_username'], FILTER_SANITIZE_STRING);
if (empty($username)):
	$errors[] = "Please enter a username.";
endif;
$name = filter_var($_POST['form_name'], FILTER_SANITIZE_STRING);
if (empty($name)):
	$errors[] = "Please enter a name.";
endif;
$password = filter_var($_POST['form_password'], FILTER_SANITIZE_STRING);
if (empty($password)):
	$errors[] = "Please enter a password.";
endif;
if (empty($errors)):
	$password = password_hash($password, PASSWORD_DEFAULT);
	$token= uniqid();
	$query = "INSERT INTO fixit_user (username, name, password, token ) VALUES ('$username', '$name', '$password', '$token')";
	if (mysqli_query($dbc, $query)): 
	mysqli_close($dbc);
	mail($username, "Account activation", "Please click on the following link to activate your account: http://katiefreeman.000webhostapp.com/fixit/accountactivation.php?username=$username&token=$token", "From: FixIt <support@fixit.com>");
	header('location:accountactivation.php');
	exit();
else:
	$errors[] = "Please enter a different username.";
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
	<h1>Sign Up</h1>
	<?php if (!empty($errors)): ?>
		<ul>
			<?php foreach($errors as $error): ?>
				<li><?php echo $error ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<form method="post">
		<div>
			<label>Name</label>
			<input type="text" name="form_name" value="<?php if(isset($name)) echo $name ?>">
		</div>
		<div>
			<label>Email</label>
			<input type="text" name="form_username" value="<?php if(isset($username)) echo $username ?>">
		</div>
		<div>
			<label>Password</label>
			<input type="password" name="form_password">
		</div>
		<button>Sign Up</button>
	</form>
	<p><a href="index.php">Back</a></p>
</div>
</body>
</html>