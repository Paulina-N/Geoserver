<?php
session_start();
include_once 'includes/dbh.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/favicon.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Geoserver</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="css/add.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<!-- Leaflet -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.1/dist/leaflet.css"
	integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
	crossorigin=""/>
	<!-- Leaflet -->
	<script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js"
		integrity="sha256-NDI0K41gVbWqfkkaHj15IzU7PtMoelkzyKp8TOaFQ3s="
		crossorigin="">
	</script>
	<!-- Ruler -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/gokertanrisever/leaflet-ruler@master/src/leaflet-ruler.css" integrity="sha384-P9DABSdtEY/XDbEInD3q+PlL+BjqPCXGcF8EkhtKSfSTr/dS5PBKa9+/PMkW2xsY" crossorigin="anonymous">
	<!-- ZoomBox -->
	<link rel="stylesheet" href="boxzoom/leaflet-control-boxzoom.css" />
	<!-- Opacity -->
	<link rel="stylesheet" href="opacity/Control.Opacity.css" />
	<!-- Show coordinates -->
	<link rel="stylesheet" href="show_coordinates/Leaflet.Coordinates-0.1.5.css" />
	<!-- Draw on map -->
	<link rel='stylesheet' href='draw/leaflet.draw-src.css'/>
	<!-- Zoom history -->
	<link rel="stylesheet" type="text/css" href="history/leaflet-history.css">
	

	<script>
		var urlsOfLayers = <?php echo json_encode($allLayersUrls, JSON_HEX_TAG); ?>;
		var namesOfLayers = <?php echo json_encode($allLayersNames, JSON_HEX_TAG); ?>;
		var titlesOfLayers = <?php echo json_encode($allLayersTitles, JSON_HEX_TAG); ?>;
	</script>

</head>

<body>

<?php
	if (!isset($_SESSION["useremail"])) {
		header("location: login.php");
	}
	else {
		?>
		<div class="wrapper">

		<?php
		require("sidebar.php");
		?>

		<div class="main">
			
		<?php
		require("navbar.php");
		?>
		<?php
	}
	?>