// Base maps
let OpenStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {});
let Esri_WorldGrayCanvas = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {});
let Satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {});

let map = L.map('map', { 
    center: [37.75, -1],
    zoom: 10,
    minZoom: 2,
    zoomControl: false,
    layers: [Satellite]
});

let editableLayers = new L.FeatureGroup();
map.addLayer(editableLayers);

let options = {
    position: 'topleft',
    draw: {
        circle: true, 
        rectangle: true,
        marker: true
    },
    edit: {
        featureGroup: editableLayers,
        remove: true
    }
};
let drawControl = new L.Control.Draw(options);
map.addControl(drawControl);

//register events
map.on(L.Draw.Event.CREATED, function(e){
    editableLayers.addLayer(e.layer);
});

let j = 300;
for (let nameOfLayer of namesOfLayers) {
    map.createPane(nameOfLayer);
    map.getPane(nameOfLayer).style.zIndex = j;
    j--;
}

for(let i = 0; i < namesOfLayers.length; i++) {
    window[namesOfLayers[i]] = L.tileLayer.betterWms(urlsOfLayers[i], {
        layers: titlesOfLayers[i],
        format: 'image/png',
        transparent: true,
        pane: namesOfLayers[i],
    });
}