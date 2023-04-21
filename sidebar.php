<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="index.php">
			<span class="align-middle"><?php  ?></span>
		</a>

		<ul class="sidebar-nav">
			<li class="sidebar-item">
				<a class="sidebar-link" href="index.php">
					<i class="align-middle" data-feather="map"></i> <span class="align-middle">Map</span>
				</a>
			</li>
			<li class="sidebar-item">
				<a class="sidebar-link" href="settings.php">
				<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Settings</span>
				</a>
			</li>
			<li class="sidebar-item">
				<a class="sidebar-link" href="profile.php">
					<i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
				</a>
			</li>
			<?php
			if (basename($_SERVER['PHP_SELF']) == "index.php") { ?>
				<li class="sidebar-item">
					<a class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#layers" aria-expanded="false">
						<i class="align-middle" data-feather="layers"></i> <span class="align-middle">Layers</span>
					</a>
					<ul class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" id="layers">
						<ul class="radio">
							<label class="form-check">
								<input class="form-check-input" type="radio" id="satellite" name="check" checked>
								<span class="form-check-label">Satellite</span>
							</label>
							<label class="form-check">
								<input class="form-check-input" type="radio" id="street" name="check">
								<span class="form-check-label">Open Street Map</span>
							</label>
							<label class="form-check">
								<input class="form-check-input" type="radio" id="gray" name="check">
								<span class="form-check-label">Gray</span>
							</label>
						</ul>

						<?php
						$allLayers = array();
						$allLayersNames = array();
						while ($row = mysqli_fetch_array($layersResult)) {
							$layerTitle = $row['title'];
							$layersGroup = $row['link'];
							$layerName = $row['name'];
							$layerUrl = $row['url'];
							array_push($allLayersNames, $layerName);
							$allLayers[$layerTitle] = $layersGroup;
							array_push($allLayersUrls, $layerUrl);
						}
						if (isset($groupResult)) {
							foreach ($groupResult as $groupId => $groupName) { ?>
							<li name="groups" class="sidebar-item">
								<a class="sidebar-link collapsed" data-bs-toggle="collapse"
									data-bs-target="#groupSubmenu<?php echo $groupId; ?>"
									aria-expanded="false"><?php echo $groupName; ?> </a>
								<ul class="sidebar-dropdown list-unstyled collapse" id="groupSubmenu<?php echo $groupId; ?>">
									<ul class="allGroups" id="<?php echo $groupName; ?>">
										<?php $i = 0;
											foreach ($allLayers as $title => $layersGroup) {
												$sqlParent=mysqli_query($conn, "SELECT name FROM groups WHERE id='$layersGroup'");
												if (mysqli_num_rows($sqlParent) > 0) {
													$row = mysqli_fetch_assoc($sqlParent);
													$res = $row['name'];
													if ($res == $groupName) { ?>
														<label id="<?php echo $allLayersUrls[$i]; ?>" class="form-check layer-url"><input
															class="form-check-input layercheckbox" type="checkbox" name="<?php echo $groupName ?>"
															id="<?php echo $allLayersNames[$i] ?>"><span class="form-check-label"><?php echo $title; ?>
															</span></label> <?php
														
													}
													$i = $i + 1;
												}
											}
										?>
									</ul>
								</ul>
							</li>
						<?php }
						} ?>
					</ul>
				</li>

				<li class="sidebar-item">
					<a class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#instructions" aria-expanded="false">
						<i class="align-middle" data-feather="help-circle"></i> <span class="align-middle">Instructions</span>
					</a>
					<ul class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" id="instructions">
							
						<li class="sidebar-item">
							<a class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#history"
								aria-expanded="false"><img src="img/icons/history.PNG"
								style="width: 30px; height: 20px; border-radius: 4px;" alt="Zooming history"> Zooming history</a>
							<ul class="sidebar-dropdown list-unstyled collapse" id="history">
								<ul><label>Click back and forward buttons to go to previous or next extent</label></ul>
							</ul>
						</li>
						<li class="sidebar-item">
							<a class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#squarezoom"
								aria-expanded="false"><img src="img/icons/squarezoom.PNG" style="width: 30px; height: 30px; border-radius: 4px;"
								alt="Square zooming"> Square zooming</a>
							<ul class="sidebar-dropdown list-unstyled collapse" id="squarezoom">
								<ul><label>Draw a square on the map to zoom in to an area. One-time zoom per icon click</label></ul>
							</ul>
						</li>
						<li class="sidebar-item">
							<a class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#ruler"
								aria-expanded="false"><img src="img/icons/ruler.PNG" style="width: 30px; height: 30px; border-radius: 4px;"
								alt="Ruler"> Ruler</a>
							<ul class="sidebar-dropdown list-unstyled collapse" id="ruler">
								<ul><label>Ruler for the distance and bearing measuring. Press ESC or double-click
									to stop using the ruler, and press ESC again to clean the map</label></ul>
							</ul>
						</li>
						<li class="sidebar-item">
							<a class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#opacity"
								aria-expanded="false"><img src="img/icons/opacity.PNG" style="width: 100px; height: 20px; border-radius: 4px;"
								alt="Opacity"> Opacity</a>
							<ul class="sidebar-dropdown list-unstyled collapse" id="opacity">
								<ul><label>Change the transparency of all active layers by sliding through the slider</label></ul>
							</ul>
						</li>
						<li class="sidebar-item">
							<a class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#coordinates"
								aria-expanded="false"><img src="img/icons/coordinates.PNG"
								style="width: 200px; height: 17px; border-radius: 4px;" alt="Coordinates"></a>
							<ul class="sidebar-dropdown list-unstyled collapse" id="coordinates">
								<ul><label>Hover the mouse on the map to see live longitude and latitude, or click on the icon
									to put your ones to put a marker on the map</label></ul>
							</ul>
						</li>
						<li class="sidebar-item">
							<a class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#print"
								aria-expanded="false"> Print the map</a>
							<ul class="sidebar-dropdown list-unstyled collapse" id="print">
								<ul><label>Use the shortcut CTRL+P to print the map</label></ul>
							</ul>
						</li>
						<li class="sidebar-item">
							<a class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#sort"
								aria-expanded="false"> Sort layers</a>
							<ul class="sidebar-dropdown list-unstyled collapse" id="sort">
								<ul><label>Sort the layers or the groups of the layers by pressing, holding and moving themup or down
									in the list of layers. Layers on top of the list show up on top of other layers on the map</label></ul>
							</ul>
						</li>
						<li class="sidebar-item">
							<a class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#data"
								aria-expanded="false"> See data</a>
							<ul class="sidebar-dropdown list-unstyled collapse" id="data">
								<ul><label>Click on any layer on the map to see the popup with all the information about each layer.
									Be aware that order of the layers does not affect order of the popups</label></ul>
							</ul>
						</li>
					</ul>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
</nav>
