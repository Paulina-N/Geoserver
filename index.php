<?php
require_once("header.php");
?>

<main class="content" id="map-content">
	<div id="map"></div>
	<div id="datapopup">
		<div>
			<div action="" id="layerdata" method="post" name="layerdata">
				<h2>Data</h2>
				<hr>
				<p id="content"></p>
				<p id="more"></p>
				<button onclick="download_csv_file()" id="downloadcsv" class="btn btn-success"
				style="float: right">Export to CSV</button>
				<button onclick="closepopup()" class="btn btn-danger" >Cancel</button>
			</div>
		</div>
	</div>
</main>

<script>
	function closepopup() {
		document.getElementById('datapopup').style.display = "none";
	}
</script>

<?php
require_once("footer.php");
?>
