<?php
require("header.php");
?>

<?php
if (isset($_POST['uploadfile'])) {
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 100000000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'img/uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
				$sql = "UPDATE users SET profileImg='$fileNameNew' WHERE usersId='$userID'";
				mysqli_query($conn, $sql);
            }
            else {
                echo "Your file is too big!";
            }
        }
        else {
            echo "There was an error uploading your file!";
        }
    }
    else if ($file != null) {
        echo "You can't upload files of this type! Allowed types: jpg, jpeg, png.";
    }
}

if(isset($_POST["firstName"])) {
	$newFirstName = $_POST["firstName"];
	$newLastName = $_POST["lastName"];
	$newEmail = $_POST["email"];
	$sql=mysqli_query($conn, "UPDATE users SET usersFirstName='$newFirstName', usersLastName='$newLastName', usersEmail='$newEmail' WHERE usersId='$userID'");
}
?>

<main class="content">
	<?php 
		if(isset($_POST["oldpassword"])) {
			$oldPassword = $_POST["oldpassword"];
			$newPassword = $_POST["newpassword"];
			$sql=mysqli_query($conn, "SELECT usersPwd FROM users WHERE usersId='$userID'");
			if (mysqli_num_rows($sql) == 1) {
				$row = mysqli_fetch_assoc($sql);
				$userPwd = $row['usersPwd'];
			}
			$checkPwd = password_verify($oldPassword, $userPwd);
			if ($checkPwd === true) {
				$hashedPwd = password_hash($newPassword, PASSWORD_DEFAULT);
				$sql=mysqli_query($conn, "UPDATE users SET usersPwd='$hashedPwd' WHERE usersId='$userID'");
				?>
				<div class="alert-success">
					<button type="button" class="btn-close" onclick="this.parentElement.style.display='none';"></button>
					<strong>Password changed successfully!</strong>
				</div>
				<?php
			}
			else {
				?>
				<div class="alert-danger">
					<button type="button" class="btn-close" onclick="this.parentElement.style.display='none';"></button>
					<strong>Incorrect old password!</strong>
				</div>
				<?php
			}

		}
	?>
	
	<div class="container-fluid p-0">

		<div class="mb-3">
			<h1 class="h3 d-inline align-middle">Profile</h1>
		</div>

		<div class="row">
			<div class="col-md-4 col-xl-3">
				<div class="card mb-3">
					<div class="card-header">
						<h5 class="card-title mb-0">Profile Details</h5>
					</div>
					<div class="card-body text-center">
						<img src="img/uploads/<?php echo $profileImage ?>" alt="<?php echo $firstName ?>" class="rounded-circle mb-2" width="128" height="128" />
						<h5 class="card-title mb-0"><?php echo $firstName, " ", $lastName ?></h5>
					</div>
				</div>
			</div>

			

			<div class="col-md-8 col-xl-9">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Edit profile</h5>
					</div>

					<div class="card-body">
						<form action="" method="POST" enctype="multipart/form-data">
							<div class="mb-3">
								<label class="form-label">First name</label>
								<input id="firstNameInput" type="firstname" name="firstname" class="form-control" value=<?php echo $firstName; ?>>
							</div>
							<div class="mb-3">
								<label class="form-label">Last name</label>
								<input id="lastNameInput" type="lastname" name="lastname" class="form-control" value=<?php echo $lastName; ?>>
							</div>
							<div class="mb-3">
								<label class="form-label">Email</label>
								<input id="emailInput" type="email" name="email" class="form-control" value=<?php echo $email; ?>>
							</div>
							<div class="text-center mt-3">
								<button onclick="updateProfile()" class="btn btn-success">Save</button>
							</div>
							<div class="mb-3">
								<label class="form-label w-100">Profile picture</label>
								<input type="file" name="file">
							</div>
							<div class="text-center mt-3">
								<button name="uploadfile" class="btn btn-success" style="float: left">Upload</button>
							</div>
						</form>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Change password</h5>
					</div>
					
					<div class="card-body">
						<form action="" method="POST" enctype="multipart/form-data">
							<div class="mb-3">
								<label class="form-label">Old password</label>
								<input id="oldPwd" type="password" name="oldpassword" class="form-control">
							</div>
							<div class="mb-3">
								<label class="form-label">New password</label>
								<input id="newPwd" type="password" name="newpassword" class="form-control">
							</div>
							<div class="text-center mt-3">
								<button onclick="updatePassword()" class="btn btn-success">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
require("footer.php");
?>

<script>
	function updateProfile() {
		firstName = document.getElementById("firstNameInput").value;
		lastName = document.getElementById("lastNameInput").value;
		email = document.getElementById("emailInput").value;
		$.post("profile.php", { firstName: firstName, lastName: lastName, email: email });
	}
</script>