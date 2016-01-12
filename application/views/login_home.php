<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="/assets/styles.css">
	<meta charset="utf-8">
	<title>Login</title>
</head>
<body>
	<div id="wrapper">
	<h1>Try out the Poke App!</h1>
		<div id="login">
			<h3>Login</h3>
			<form action="logins/login_user" method="post">
				<input type="text" name="email" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<input type="submit" value="Login">
			</form>
		</div>
		<div id="register">
			<h3>Register</h3>
			<form action="logins/register_user" method="post">
				<input type="text" name="first_name" placeholder="First Name">
				<input type="text" name="last_name" placeholder="Last Name">
				<input type="text" name="alias" placeholder="Alias">
				<input type="text" name="email" placeholder="Email">
				<input type="hidden" name="history" value="0">
				<input type="password" name="password" placeholder="Password">
				<p>Password should be at least 8 characters.</p>
				<input type="text" name="password_confirm" placeholder="Confirm Password">
				<input type="submit" value="Register">
			</form>
		</div>
		<div id="errors">
			<?= $this->session->flashdata("errors"); ?>
		</div>
	</div>
</body>
</html>