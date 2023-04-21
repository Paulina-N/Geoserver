<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard,
		template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/favicon.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-up.html" />

	<title>Sign Up | Geoserver</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Get started</h1>
							<p class="lead">
								Transform your data into insights with our advanced geoportal system.
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<form action="includes/signup.inc.php" method="post">
										<div class="mb-3">
											<label class="form-label">First name</label>
											<input class="form-control form-control-lg" type="text"
												name="firstname" placeholder="Enter your first name" />
										</div>
										<div class="mb-3">
											<label class="form-label">Last name</label>
											<input class="form-control form-control-lg" type="text"
												name="lastname" placeholder="Enter your last name" />
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="text"
												name="email" placeholder="Enter your email" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password"
												name="password" placeholder="Enter password" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password"
												name="passwordrepeat" placeholder="Repeat password" />
										</div>
										<div>
											<label class="form-check form-check-inline">
												<input id="individual" class="form-check-input" type="radio"
													name="inline-radios-example" value="individual" checked>
												<span class="form-check-label">Individual</span>
											</label>
											<label class="form-check form-check-inline">
												<input id="company" class="form-check-input" type="radio"
													name="inline-radios-example" value="company">
												<span class="form-check-label">Company</span>
											</label>
										</div>
										<div class="mb-3" id="company-field" style="display: none;">
											<label class="form-label"></label>
											<input class="form-control form-control-lg" type="text"
												name="company" placeholder="Enter your company name"/>
										</div>
										<div class="text-center mt-3">
											<button type="submit" name="submit" class="btn btn-lg btn-primary">Sign up</button>
										</div>
										<small>
											<a href="login.php">Have an account? Sign in!</a>
										</small>
									</form>
								</div>
							</div>
						</div>

						<?php
						if (isset($_GET["error"])) {
							if ($_GET["error"] == "emptyinput") {
								echo "<p>Fill in all fields!<p>";
							} elseif ($_GET["error"] == "invalidemail") {
								echo "<p>Choose a proper email!<p>";
							} elseif ($_GET["error"] == "passwordsdontmatch") {
								echo "<p>Passwords don't match!<p>";
							} elseif ($_GET["error"] == "emailExists") {
								echo "<p>This email is already registered!<p>";
							} elseif ($_GET["error"] == "smtfailed") {
								echo "<p>Something went wrong, try again!<p>";
							} elseif ($_GET["error"] == "none") {
								echo "<p>You have signed up!<p>";
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script src="jquery/jquery-ui-1.10.3.custom.min.js"></script>
	<link rel="stylesheet" href="jquery/jquery-ui-1.10.3.custom.min.css" />

	<script src="js/app.js"></script>
	<script>
		$('#individual').click(function(){
			if ($('#individual').is(':checked')){
				document.getElementById("company-field").style.display = "none";
			}
		});
		$('#company').click(function(){
			if ($('#company').is(':checked')){
				document.getElementById("company-field").style.display = "block";
			}
		});
	</script>
</body>
</html>
