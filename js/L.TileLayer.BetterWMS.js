function bubbleSort(arr){
  for(let i = 0; i < arr.length; i++){
      for(let j = 0; j < arr.length - i - 1; j++){
          if(arr[j + 1] > arr[j]){
              [arr[j + 1],arr[j]] = [arr[j],arr[j + 1]]
          }
      }
  };
  return arr;
};
let parser; let parser1; let parserc;
let doc; let doc1; let docc;
let elm; let elm1; let elmc;
let latlngString;
L.TileLayer.BetterWMS = L.TileLayer.WMS.extend({

  onAdd: function (map) {
    L.TileLayer.WMS.prototype.onAdd.call(this, map);
    map.on('click', this.getFeatureInfo, this);
  },
  
  onRemove: function (map) {
    L.TileLayer.WMS.prototype.onRemove.call(this, map);
    map.off('click', this.getFeatureInfo, this);
  },
  
  getFeatureInfo: function (evt) {
    let url = this.getFeatureInfoUrl(evt.latlng),
        showResults = L.Util.bind(this.showGetFeatureInfo, this);
    $.ajax({
      url: url,
      success: function (data, status, xhr) {
        let err = typeof data === 'string' ? null : data;
        showResults(err, evt.latlng, data);
      },
      error: function (xhr, status, error) {
        showResults(error);  
      }
    });
  },
  
  getFeatureInfoUrl: function (latlng) {
    let point = this._map.latLngToContainerPoint(latlng, this._map.getZoom()),
        size = this._map.getSize(),
        
        params = {
          request: 'GetFeatureInfo',
          service: 'WMS',
          srs: 'EPSG:4326',
          styles: this.wmsParams.styles,
          transparent: this.wmsParams.transparent,
          version: this.wmsParams.version,      
          format: this.wmsParams.format,
          bbox: this._map.getBounds().toBBoxString(),
          height: size.y,
          width: size.x,
          layers: this.wmsParams.layers,
          query_layers: this.wmsParams.layers,
          info_format: 'text/html',
          feature_count: '10',
        };
    
    params[params.version === '1.3.0' ? 'i' : 'x'] = Math.round(point.x);
    params[params.version === '1.3.0' ? 'j' : 'y'] = Math.round(point.y);
    
    return this._url + L.Util.getParamString(params, this._url, true);
  },
  
  showGetFeatureInfo: function (err, latlng, content) {
    if (err) { console.log(err); return; }
    if (content.length != 658 && (typeof popup == "undefined" || !popup.isOpen()) && !rulerControl._choice && drawControl._toolbars.draw._activeMode == null) {
      document.getElementById('content').innerHTML = content;
      document.getElementById('more').innerHTML = latlng;
      document.getElementById('datapopup').style.display = "block";
      parser = new DOMParser();
      doc = parser.parseFromString(content, "text/html");
      elm = doc.querySelectorAll("th");
      parser1 = new DOMParser();
      doc1 = parser.parseFromString(content, "text/html");
      elm1 = doc.querySelectorAll("td");
      parserc = new DOMParser();
      docc = parser.parseFromString(content, "text/html");
      elmc = doc.querySelector("caption");
      latlngString = `${latlng.lat},${latlng.lng}`;
    }
  }
});

L.tileLayer.betterWms = function (url, options) {
  return new L.TileLayer.BetterWMS(url, options);  
};

function download_csv_file() {
  let csv = "";
  let delimiter = ",";

  for (let i of elm) {
    csv += field_in_quotes(i.innerHTML, delimiter) + delimiter;
  }
  csv += "\n";
  let iterator = 0;
  for (let i = 0; i < elm1.length; i++) {
    csv += field_in_quotes(elm1[i].innerHTML, delimiter) + delimiter;
    if (i == elm.length - 1 + iterator) {
      csv += "\n";
      iterator += elm.length;
    }
  }
  if (latlngString != "") {
    csv += "\n";
    csv += "Latitude,Longitude\n";
    csv += latlngString;
  }

  let csvContent = "data:text/csv;charset=utf-8," + encodeURIComponent(csv);

  let hiddenElement = document.createElement('a');
  hiddenElement.href = csvContent;
  hiddenElement.target = '_blank';
  
  hiddenElement.download = elmc.innerHTML + ".csv";
  hiddenElement.click();
}

function field_in_quotes(field, delimiter) {
  if (field.includes(delimiter)) {
    field = '"' + field.replace(/"/g, '""') + '"';
  }
  return field;
}
