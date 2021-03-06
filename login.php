<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST["email"];
	$password = $_POST["password"];

	$dbh = new PDO('sqlite:info/login.db');
	$stmt = $dbh->prepare("SELECT rowid, * FROM login WHERE email = ? ORDER BY rowid DESC LIMIT 1");
	$stmt->bindParam(1, $email);
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach ($result as $val) {
		$p = $val['password'];
		$r = $val['rowid'];
	}


	if (isset($_COOKIE['alevior'])) {
		header('Location: home.php');
	} elseif (hash('sha512', $password) == $p){
		$hour = time() + 60 * 60;
		setcookie('alevior', $r, $hour, '/');
		header('Location: home.php');
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login | Alevior</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>
		<section id="banner">
			<h2><strong>Alevior</strong></h2>
			<ul class="actions">
				<li><a href="index.php" class="button special">Home</a></li>
				<li><a href="index.php#about" class="button special">About Us</a></li>
				<li><a href="index.php#contact" class="button special">Contact Us</a></li>
			</ul>
		</section>
		<section id="one" class = "wrapper">
			<div class="inner">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="row uniform">
						<div class="6u$ 12u$(xsmall)">
							<input type="email" name="email" id="email" value="" placeholder="Email" />
						</div>
						<div class="6u$ 12u$(xsmall)">
							<input type="password" name="password" id="password" value="" placeholder="Password" />
						</div>
						<?php if($_SERVER["REQUEST_METHOD"] == "POST") {echo "<p style='color:red;margin:0px'>Incorrect Username or Password</p>";} ?>
						<div class="12u$">
							<ul class="actions">
								<li><input type="submit" value="Login" /></li>
							</ul>
						</div>
					</div>
				</form>
			</div>
		</section>
	</body>
</html>