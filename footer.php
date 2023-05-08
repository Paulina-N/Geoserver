<footer class="footer">
	<div class="container-fluid">
		<div class="row text-muted">
			<div class="col-10 text-start">
				<p class="mb-0">
					<strong>© 2023 Map</strong>
				</p>
			</div>
			<div class="col-2 text-start">
				<select name="selectCountry" id="selectCountry" onchange="changeCountry(this.value)" style="float: right;">
					<option value="Spain">Spain</option>
					<option value="USA">USA</option>
					<option value="Europe">Europe</option>
				</select>
			</div>
		</div>
	</div>
</footer>
</div>
</div>
</div>

<script src="js/app.js"></script>
<script type="module">import WMSCapabilities from 'wms-capabilities';</script>
<!-- Ruler -->
<script src="https://cdn.jsdelivr.net/gh/gokertanrisever/leaflet-ruler@master/src/leaflet-ruler.js"
integrity="sha384-N2S8y7hRzXUPiepaSiUvBH1ZZ7Tc/ZfchhbPdvOE5v3aBBCIepq9l+dBJPFdo1ZJ"
crossorigin="anonymous"></script>
<!-- ZoomBox -->
<script src="boxzoom/leaflet-control-boxzoom.js"></script>
<!-- Zoom history -->
<script type="text/javascript" src="history/leaflet-history.js"></script>
<!-- Show coordinates -->
<script src="show_coordinates/Leaflet.Coordinates-0.1.5.min.js"></script>
<!-- Draw on map -->
<script src='draw/leaflet.draw-src.js'></script>
<!-- WMS Capabilities -->
<script src="node_modules\wms-capabilities\dist\wms-capabilities.min.js"></script>
<!-- axios -->
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
<!-- Custom -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="js/L.TileLayer.BetterWMS.js"></script>
<script src="js/layersData.js"></script>
<script src="opacity/Control.Opacity.js"></script>
<script src="jquery/jquery-ui-1.10.3.custom.min.js"></script>
<link rel="stylesheet" href="jquery/jquery-ui-1.10.3.custom.min.css" />
<script src="js/map.js"></script>

</body>

</html>

<script>
	function changeCountry(country) {
		if(country == "Spain") {
			map.setView(L.latLng(37.75, -1), 10);
		}
		else if (country == "USA") {
			map.setView(L.latLng(33, -86), 5);
		}
		else if (country == "Europe") {
			map.setView(L.latLng(50, 20), 5);
		}
	}
</script>
