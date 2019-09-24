<div class="navBar">
<div class="navContainer">
<a href="index.php" class="navHome">Fix It</a>
<div class="navItems">
<?php if (isset($_SESSION['user'])): ?>
<a href="add_submission.php" class="navItem">Add Submission</a>
<a href="logout.php" class="navItem">Logout</a>
<?php else: ?>
<a href="signup.php" class="navItem">Sign Up</a>
<a href="login.php" class="navItem">Login</a>
<?php endif; ?>
</div>
</div>
</div>