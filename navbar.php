<nav class="navbar navbar-expand navbar-light navbar-bg">
	<a class="sidebar-toggle js-sidebar-toggle">
		<i class="hamburger align-self-center"></i>
	</a>
	<?php
		if (isset($_SESSION["useremail"])) {
	?>
	<div class="navbar-collapse collapse">
		<?php
		if (isset($companyName)) {
			echo '<h3>' . $companyName . '</h3>';
		} else {
			echo '<a href="settings.php"><h4>Join a Company!</h4></a>';
		}
		?>
		<ul class="navbar-nav navbar-align">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
					<img src="img/uploads/<?php echo $profileImage ?>"class="avatar img-fluid rounded me-1"
						alt="<?php echo $firstName ?>" /> <span class="text-dark"><?php echo $firstName; ?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-end">
					<a class="dropdown-item" href="profile.php"><img src="img/icons/profile.png"
						style="height: 15px; width:15px" alt="profile"></img> Profile</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="includes/logout.inc.php">Log out</a>
				</div>
			</li>
			<?php
			} else {
				?>
				<a href="login.php">
					<button type="submit" name="submit" class="btn btn-lg btn-primary">Log in</button>
				</a>
				<?php
			}
			?>
		</ul>
	</div>
</nav>
