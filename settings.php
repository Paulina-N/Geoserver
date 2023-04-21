<?php
require_once("header.php");
include_once 'includes/dbh.inc.php';
?>
<main class="content">
	<div id="applied" class="alert-success" style="display: none;">
		<button type="button" class="btn-close" onclick="this.parentElement.style.display='none';"></button>
		<strong>Your request was sent!</strong>
	</div>
	<div id="notapplied" class="alert-danger" style="display: none;">
		<button type="button" class="btn-close" onclick="this.parentElement.style.display='none';"></button>
		<strong>You didn't choose a company!</strong>
	</div>
	<div class="container-fluid p-0">
	<?php if ($adminID != $userID) { ?>
		<h1 class="h3 mb-3">Company</h1>

		<div class="row">
			<div class="col-md-12">
				<div class="card flex-fill">
					<div class="card-header">
						<h5 class="card-title mb-0">Apply to Join a Company</h5>
					</div>
					<div class="card-body">
						<select id="selectCompany" class="form-select mb-3">
							<option selected>Choose a company</option>
							<?php
								$sql = "SELECT * FROM companies";
								$result = mysqli_query($conn, $sql);
								while ($row = mysqli_fetch_array($result)) {
									?>
									<option value="<?php echo $row['id'];?>"><?php echo $row['name']; ?></option>
									<?php
								}
							?>
						</select>
						<button class="btn btn-success"
							onclick="sendJoinRequest('<?php echo $userID; ?>', document.getElementById('selectCompany').value)">
							Send request</button>
						<?php
							if (isset($_POST["companyId"])) {
								$companyId = $_POST["companyId"];
								$userId = $_POST["userId"];
								mysqli_query($conn, "INSERT INTO join_companies (`userId`, `companyId`, `status`)
									VALUES ('$userId', '$companyId', 'PENDING')");
							}
						?>
					</div>
					<div class="card-header">
						<h5 class="card-title mb-0">History</h5>
					</div>
					<div class="card-body companies-table">
						<table id="layertable" class="table table-hover my-0">
							<tbody>
								<tr>
									<th>Company</th>
									<th>Status</th>
								</tr>
								<?php
									$sql = "SELECT * FROM join_companies WHERE userId='$userID'";
									$result = mysqli_query($conn, $sql);
									while ($row = mysqli_fetch_array($result)) {
										$companyId = $row['companyId'];
										$res = mysqli_query($conn, "SELECT name FROM companies WHERE id='$companyId'");
										$company = mysqli_fetch_array($res);
										echo '<tr><td>' . $company['name'] . '</td>';
										echo '<td>' . $row['status'] . '</td></tr>';
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php } else { ?>
			<h1 class="h3 mb-3">Join Requests</h1>
			<div class="row">
				<div class="col-md-7">
					<div class="card flex-fill">
						<div class="card-header">
							<h5 class="card-title mb-0">List of People who Want to Join your Company</h5>
						</div>
						<div class="card-body join-requests-table">
							<table class="table table-hover my-0">
								<tbody>
									<tr>
										<th>Full Name</th>
										<th>Email</th>
										<th>Action</th>
									</tr>
									<?php
										$sql = "SELECT * FROM join_companies WHERE companyId='$companyID' AND status='PENDING'";
										$result = mysqli_query($conn, $sql);
										while ($row = mysqli_fetch_array($result)) {
											$userId = $row['userId'];
											$requestId = $row['id'];
											$res = mysqli_query($conn, "SELECT usersId, usersFirstName, usersLastName, usersEmail
												FROM users WHERE usersId='$userId'");
											$user = mysqli_fetch_array($res);
											echo '<tr id=' . $requestId . '><td>' . $user['usersFirstName'] . ' ' . $user['usersLastName'] . '</td>';
											echo '<td>' . $user['usersEmail'] . '</td>';
											echo '<td><button class="btn btn-success"
												onclick="acceptRequest(' . $requestId . ', ' . $companyID . ', ' . $user['usersId'] . ')"
												style="margin-right: 20px;">Accept</button><button class="btn btn-danger"
												onclick="rejectRequest(' . $requestId . ')">Reject</button></td></tr>';
										}
										if (isset($_POST['accept'])) {
											$accept = $_POST['accept'];
											$requestId = $_POST['requestId'];
											$companyId = $_POST['companyId'];
											$userId = $_POST['userId'];
											mysqli_query($conn, "UPDATE join_companies SET status='$accept' WHERE id='$requestId'");
											mysqli_query($conn, "UPDATE users SET companyId='$companyId' WHERE usersId='$userId'");
										}
										if (isset($_POST['reject'])) {
											$reject = $_POST['reject'];
											$requestId = $_POST['requestId'];
											mysqli_query($conn, "UPDATE join_companies SET status='$reject' WHERE id='$requestId'");
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="card flex-fill">
						<div class="card-header">
							<h5 class="card-title mb-0">Team Members</h5>
						</div>
						<div class="card-body join-requests-table">
							<table class="table table-hover my-0">
								<tbody>
									<tr>
										<th>Full Name</th>
										<th>Email</th>
										<th>Action</th>
									</tr>
									<?php
									$result = mysqli_query($conn, "SELECT * FROM users WHERE companyId='$companyID'");
									while ($row = mysqli_fetch_array($result)) {
										$userId = $row['usersId'];
										$res = mysqli_query($conn, "SELECT * FROM join_companies WHERE userId='$userId' AND status='ACCEPTED'");
										if (mysqli_num_rows($res) > 0) {
										$joinRequest = mysqli_fetch_array($res);
										$requestId = $joinRequest['id'];
										echo '<tr id="list' . $requestId . '"><td>' . $row['usersFirstName'] . ' ' . $row['usersLastName'] . '</td>';
										echo '<td>' . $row['usersEmail'] . '</td>';
										echo '<td><button class="btn btn-danger"
											onclick="removeTeammate(' . $requestId . ', ' . $userId . ')">Remove</button></td></tr>';
										}
									}
									if (isset($_POST['removeTeammate'])) {
										$requestId = $_POST['requestId'];
										$userId = $_POST['userId'];
										mysqli_query($conn, "DELETE FROM join_companies WHERE id='$requestId'");
										mysqli_query($conn, "UPDATE users SET companyId='0' WHERE usersId='$userId'");
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
		<h1 class="h3 mb-3"> Map Settings</h1>

		<?php
		if ($userID == $adminID || $adminID == null) {
			$is_admin = true;
		} else {
			$is_admin = false;
		}

		$disabled = '';
		if (!$is_admin) {
			$disabled = 'disabled';
		}
		?>

		<div class="row">
			<div class="col-md-7">
				<div class="card flex-fill">
					<div class="card-header">
						<h5 class="card-title mb-0">Layers<button id="new" <?php echo $disabled; ?> onclick="addLayer()"
							class="btn btn-success" style="float: right">Add new layer</button></h5>
					</div>

					<div id="layerpopup">
						<div id="popupAddLayer">
							<form action="#" id="layerform" method="post" name="layerform">
								<h2>Add New Layer</h2>
								<hr>
								<input id="layertitle" name="layertitle" type="text"
									class="form-control" placeholder="Layer title" required><br>
								<input id="layername" name="layername" type="text"
									class="form-control" placeholder="Layer name (underscore instead of space)" required><br>
								<input id="layerlink" name="layerlink" type="text"
									class="form-control" placeholder="Url" required><br>
								<input type="hidden" id="companyID" value="<?php echo $companyID; ?>"><br>
								<button onclick="sendLayerData()" id="submit" class="btn btn-success" style="float: right">Create</button>
								<button onclick ="closeForm()" class="btn btn-danger" style="float: left">Cancel</button>
							</form>
						</div>
					</div>
					<div id="editlayerpopup">
						<div id="popupAddLayer">
							<form action="" id="layerform" method="post" name="layerform">
								<h2>Edit Layer</h2>
								<hr>
								<input id="elayertitle" name="layertitle" type="text" class="form-control" placeholder="Layer title"><br>
								<input id="elayername" name="layername" type="text" class="form-control" placeholder="Layer name (underscores instead of spaces)"><br>
								<input id="elayerlink" name="layerlink" type="text" class="form-control" placeholder="Url"><br>
								<input type="hidden" id="elayerid" name="layerid" type="text" class="form-control" placeholder="ID"><br>
								<input type="hidden" id="companyID" value="<?php echo $companyID; ?>"><br>
								<button onclick="sendLayerData1()" id="submit" class="btn btn-success" style="float: right">Send</button>
								<button onclick ="closeForm1()" class="btn btn-danger" style="float: left">Cancel</button>
							</form>
						</div>
					</div>
					<div id="removelayerpopup">
						<div id="popupAddLayer">
							<form action="#" id="layerform1" method="post" name="layerform1">
								<h2>Delete Layer?</h2>
								<hr>
								<p>Are you sure you want to delete layer?</p>
								<input type="hidden" id="rlayerid" name="layerid" type="text" class="form-control" placeholder="ID"><br>
								<button onclick="sendLayerData2()" id="submit" class="btn btn-success" style="float: right">Delete</button>
								<button onclick ="closeForm2()" class="btn btn-danger" style="float: left">Cancel</button>
							</form>
						</div>
					</div>

					<table id="layertable" class="table table-hover my-0">
						<tbody>
							<th>Layer</th>
							<th>Group</th>
							<th>Edit</th>
							<th>Delete</th>
						<?php
							
							while ($row = mysqli_fetch_array($layersResult)) {
							$layerId = $row['id'];
							$layer = $row['title'];
							$layername = $row['name'];
							$layerUrl = $row['url'];
							$linkToGroup = $row['link'];
							?>
							<tr id="<?php echo $row['id']; ?>">
								<td> <?php echo $layer; ?> </td>
								<td>
									<select <?php echo $disabled; ?> id="<?php echo $layerId; ?>" class="form-select"
										onchange="handleSelectChange(event, this.value, '<?php echo $layer; ?>')">

									<?php
									if ($linkToGroup == null || $linkToGroup == 0) { ?>
										<option selected hidden>Group is not set</option>
									<?php } else {
										$sqlParent=mysqli_query($conn, "SELECT name FROM groups WHERE id='$linkToGroup'");
										$group = mysqli_fetch_assoc($sqlParent);
										$resName = $group['name']; ?>
										<option class="layersList" selected hiddenvalue="<?php echo $linkToGroup;?>"
											id="<?php echo $linkToGroup;?>"> <?php echo $resName; ?> </option>
									<?php }
									?>

									<?php foreach ($groupResult as $groupId => $groupName) {
										?>
										<option value="<?php echo $groupId;?>" id="<?php echo $groupId;?>"> <?php echo $groupName; ?> </option>
									<?php } ?>
								</select>
								</td>
								
								<td><button <?php echo $disabled; ?> onclick="editLayer('<?php echo $layer; ?>', '<?php echo $layername; ?>',
									'<?php echo $layerUrl; ?>', '<?php echo $layerId; ?>')" class="btn btn-warning btn-sm">Edit</button></td>
								<td><button <?php echo $disabled; ?> onclick="removeLayer('<?php echo $layerId; ?>')"
									class="btn btn-danger btn-sm">Delete</button></td>
								<?php if (isset($_POST["removeLayerId"])) {
											$rid = $_POST["removeLayerId"];
											$sql=mysqli_query($conn,"DELETE FROM layers WHERE id=$rid");
										}
										if (isset($_POST["editLayer"])) {
											$elayertitle = $_POST["editLayer"];
											$elayername = $_POST["editLayerName"];
											$elayerlink = $_POST["layerlink"];
											$elayerid = $_POST["editlayerid"];
											$companyID = $_POST["companyID"];
											$sql=mysqli_query($conn, "UPDATE layers SET title='$elayertitle', name='$elayername',
												url='$elayerlink', companyID='$companyID' WHERE id='$elayerid'");
										}
										if (isset($_POST["chosenGroupId"])) {
											$chosenGroupId = $_POST["chosenGroupId"];
											$chosenLayer = $_POST["layertitle"];
											$sql=mysqli_query($conn, "UPDATE layers SET link='$chosenGroupId' WHERE title='$chosenLayer'");
										}  ?>
							</tr>
            				<?php } ?>
							<?php
							if (isset($_POST["addLayer"])) {
								$atitle = $_POST["addLayer"];
								$aname = $_POST["layername"];
								$alink = $_POST["layerlink"];
								$companyID = $_POST["companyID"];
								$sql=mysqli_query($conn,
									"INSERT INTO layers (`title`, `name`, `url`, `companyId`)
									VALUES ('$atitle', '$aname', '$alink', '$companyID')"
									);
									
							}
							?>
						</tbody>
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-5">
				<div class="card flex-fill">
					<div class="card-header">
						<h5 class="card-title mb-0">Groups <button <?php echo $disabled; ?> onclick="addGroup()"
							class="btn btn-success" style="float: right">Add new group</button></h5>
					</div>

					<div id="grouppopup">
						<div id="popupAddLayer">
							<form action="#" id="layerform1" method="post" name="layerform">
								<h2>Add New Group</h2>
								<hr>
								<input id="groupname" name="groupname" type="text" class="form-control" placeholder="Group name"><br>
								<input type="hidden" id="companyID" value="<?php echo $companyID; ?>"><br>
								<button onclick="sendGroupData()" id="submit"
									class="btn btn-success" style="float: right">Create</button>
								<button onclick ="closeGroupForm()" class="btn btn-danger" style="float: left">Cancel</button>
							</form>
						</div>
					</div>
					<div id="editgrouppopup">
						<div id="popupAddLayer">
							<form action="#" id="layerform1" method="post" name="layerform">
								<h2>Modify Group</h2>
								<hr>
								<input id="editgroupname" name="groupname" type="text" class="form-control" placeholder="Group name"><br>
								<input type="hidden" id="editgroupid" name="groupid" type="text" class="form-control" placeholder="Group id"><br>
								<input type="hidden" id="companyID" value="<?php echo $companyID; ?>"><br>
								<button onclick="sendGroupData1()" id="submit" class="btn btn-success" style="float: right">Send</button>
								<button onclick ="closeGroupForm1()" class="btn btn-danger" style="float: left">Cancel</button>
							</form>
						</div>
					</div>

					<div id="removegrouppopup">
						<div id="popupAddLayer">
							<form action="#" id="layerform1" method="post" name="layerform">
								<h2>Delete Group?</h2>
								<hr>
								<p>Are you sure you want to delete group?</p>
								<input type="hidden" id="rgroupid" name="groupid" type="text" class="form-control" placeholder="Group id"><br>
								<button onclick="sendGroupData2()" id="submit" class="btn btn-success" style="float: right">Delete</button>
								<button onclick ="closeGroupForm2()" class="btn btn-danger" style="float: left">Cancel</button>
							</form>
						</div>
					</div>

					<table id="table" class="table table-hover my-0">
						<th>Group</th>
						<th>Edit</th>
						<th>Delete</th>
						<tbody>
						<?php foreach ($groupsResult as $group) {
							?>
							<tr id="<?php echo $group['id'];?>">
								<td> <?php echo $group['name']; ?> </td>
								<td><button <?php echo $disabled; ?> onclick="editGroup('<?php echo $group['name']; ?>',
									'<?php echo $group['id']; ?>')" class="btn btn-warning btn-sm">Edit</button></td>
								<td><button <?php echo $disabled; ?> onclick="removeGroup('<?php echo $group['id']; ?>')"
									class="btn btn-danger btn-sm">Delete</button></td>
								<?php if (isset($_POST["removeGroupId"])) {
											$rid = $_POST["removeGroupId"];
											$sql=mysqli_query($conn, "DELETE FROM groups WHERE id=$rid");
										}
										if (isset($_POST["editGroup"])) {
											$groupId = $_POST["groupId"];
											$ename = $_POST["editGroup"];
											$companyID = $_POST["companyID"];
											$sql=mysqli_query($conn, "UPDATE groups SET name='$ename', companyID='$companyID' WHERE id='$groupId'");
										} ?>
							</tr>
            				<?php } ?>
							<?php
							if (isset($_POST["addGroup"])) {
								$aname = $_POST["addGroup"];
								$companyID = $_POST["companyID"];
								$sql=mysqli_query($conn, "INSERT INTO groups (`name`, `companyID`) VALUES ('$aname', '$companyID')");
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
require_once("footer.php");
?>

<script>
function addGroup() {
	document.getElementById("grouppopup").style.display = "block";
}

function editGroup(groupName, groupId) {
	document.getElementById('editgroupname').value = groupName;
	document.getElementById('editgroupid').value = groupId;
	document.getElementById("editgrouppopup").style.display = "block";
}

function removeGroup(groupId) {
	document.getElementById('rgroupid').value = groupId;
	document.getElementById('removegrouppopup').style.display = "block";
}

function sendGroupData() {
	let addGroup = document.getElementById("groupname").value;
	let companyID = document.getElementById("companyID").value;
	
	$.post("settings.php", { addGroup: addGroup, companyID: companyID });
}

function sendGroupData1() {
	let editGroup = document.getElementById("editgroupname").value;
	let groupId = document.getElementById("editgroupid").value;
	let companyID = document.getElementById("companyID").value;
	
	$.post("settings.php", { editGroup: editGroup, groupId: groupId, companyID: companyID });
}

function sendGroupData2() {
	let removeGroupId = document.getElementById("rgroupid").value;

	$.post("settings.php", { removeGroupId: removeGroupId });
}

function closeGroupForm() {
	document.getElementById("grouppopup").style.display = "none";
}

function closeGroupForm1() {
	document.getElementById("grouppopup").style.display = "none";
}

function closeGroupForm2() {
	document.getElementById("removegrouppopup").style.display = "none";
}

// LAYER CUD
function addLayer() {
	document.getElementById("layerpopup").style.display = "block";
}

function editLayer(layertitle, layername, layerUrl, layerId) {
	document.getElementById('elayertitle').value = layertitle;
	document.getElementById('elayername').value = layername;
	document.getElementById('elayerlink').value = layerUrl;
	document.getElementById('elayerid').value = layerId;
	document.getElementById("editlayerpopup").style.display = "block";
}

function removeLayer(layerID) {
	document.getElementById('rlayerid').value = layerID;
	document.getElementById('removelayerpopup').style.display = "block";
}

function sendLayerData() {
	let addLayer = document.getElementById("layertitle").value;
	let layername = document.getElementById("layername").value;
	let layerlink = document.getElementById("layerlink").value;
	let companyID = document.getElementById("companyID").value;
	
	$.post("settings.php", { addLayer: addLayer, layername: layername, layerlink: layerlink, companyID: companyID });
}

function sendLayerData1() {
	let editLayer = document.getElementById("elayertitle").value;
	let editLayerName = document.getElementById("elayername").value;
	let layerlink = document.getElementById("elayerlink").value;
	let layerid = document.getElementById("elayerid").value;
	let companyID = document.getElementById("companyID").value;
	
	$.post("settings.php", { editLayer: editLayer, editLayerName: editLayerName,
			layerlink: layerlink, editlayerid: layerid, companyID: companyID });
}

function sendLayerData2() {
	let layerId = document.getElementById("rlayerid").value;
	
	$.post("settings.php", { removeLayerId: layerId });
}

function closeForm() {
	document.getElementById("layerpopup").style.display = "none";
}

function closeForm1() {
	document.getElementById("editlayerpopup").style.display = "none";
}
function closeForm2() {
	document.getElementById("removelayerpopup").style.display = "none";
}

function handleSelectChange(event, chosenGroupId, layertitle) {
	let chosenGroup = event.target.value;
	$.post("settings.php", { chosenGroupId: chosenGroupId, layertitle: layertitle });
}

function sendJoinRequest(userId, companyId) {
	if (companyId == "Choose a company") {
		document.getElementById("notapplied").style.display = "block";
	}
	else {
		document.getElementById("applied").style.display = "block";
		$.post("settings.php", { companyId: companyId, userId: userId });
	}
}

function acceptRequest(requestId, companyId, userId) {
	let accept = "ACCEPTED";
	let removeRow = document.getElementById(requestId);
	removeRow.parentNode.removeChild(removeRow);
	$.post("settings.php", { accept: accept, requestId: requestId, companyId: companyId, userId: userId });
}

function rejectRequest(requestId) {
	let reject = "REJECTED";
	let removeRow = document.getElementById(requestId);
	removeRow.parentNode.removeChild(removeRow);
	$.post("settings.php", { reject: reject, requestId: requestId });
}

function removeTeammate(requestId, userId) {
	let removeRow = document.getElementById("list" + requestId);
	removeRow.parentNode.removeChild(removeRow);
	let removeTeammate = 1;
	$.post("settings.php", { removeTeammate: removeTeammate, userId: userId, requestId: requestId });
}
</script>
