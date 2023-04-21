// Add functionality plugins to the map
map.attributionControl.setPosition("bottomleft");

L.control.zoom({ position: 'topright' }).addTo(map);
var rulerControl = L.control.ruler().addTo(map);
L.Control.boxzoom({ position:'topright' }).addTo(map);
L.control.coordinates({ position:"bottomright" }).addTo(map);
new L.HistoryControl({}).addTo(map);

var layerGroup = L.layerGroup(namesOfLayers.map(layer => window[layer]));
var opacitySliderGroup = new L.Control.opacitySliderGroup();
map.addControl(opacitySliderGroup);
opacitySliderGroup.setOpacityLayerGroup(layerGroup);

var baseMaps = {
    "Open Street Map": OpenStreetMap,
    "Gray": Esri_WorldGrayCanvas,
    "Satellite": Satellite
};

// Custom layer control
$('#street').click(function(){
  if ($('#street').is(':checked')){
    map.addLayer(OpenStreetMap);
    map.removeLayer(Esri_WorldGrayCanvas);
    map.removeLayer(Satellite);
  }
  else
    map.removeLayer(OpenStreetMap);
});

$('#gray').click(function(){
  if ($('#gray').is(':checked')){
    map.addLayer(Esri_WorldGrayCanvas);
    map.removeLayer(OpenStreetMap);
    map.removeLayer(Satellite);
  }
  else
    map.removeLayer(Esri_WorldGrayCanvas);
});

$('#satellite').click(function(){
  if ($('#satellite').is(':checked')){
    map.addLayer(Satellite);
    map.removeLayer(Esri_WorldGrayCanvas);
    map.removeLayer(OpenStreetMap);
  }
  else
    map.removeLayer(Satellite);
});

//--------------------------------------------------
var legend, div, legendImage, legendUrl;
  legend = L.control({position: 'bottomright'});
  legend.onAdd = function (map) {
    div = L.DomUtil.create('div', 'info legend'), legendImage = '<img src="' + legendUrl + '">';
    div.innerHTML = (legendImage);
    return div;
  }
  // https://apps.nationalmap.gov/services/
$('.layercheckbox').click(function() {
  if ($("#" + this.id).is(':checked')){
    map.addLayer(window[this.id]);

    // map.fitBounds(window[this.id].getBounds());

  var encodedLayerName = encodeURIComponent(this.id.replace(/_/g, ' '));
    legendUrl = $(this).closest('label').attr('id') + "REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=" + encodedLayerName;
    legend.addTo(map);
  }
  else {
    map.removeLayer(window[this.id]);
    map.removeControl(legend);
  }
});
