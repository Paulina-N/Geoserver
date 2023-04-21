// Layer groups
var climate = {
    "SIAM_weather_stations": "SIAM weather stations"
};

var environmental_protection = {
    "Environmental_zoning_for_renewable_energy": "Environmental zoning for renewable energy",
    "Flora_recovery_plan": "Flora recovery plan",
    "Macrophytes": "Macrophytes",
    "Marine_habitats": "Marine habitats",
    "Natura_2000_Network_LIC_ZEC": "Natura 2000 Network LIC ZEC",
    "Natura_2000_Network_ZEPA": "Natura 2000 Network ZEPA",
    "Natural_protected_areas": "Natural protected areas",
    "RAMSAR":"RAMSAR",
    "Temporary_exclusion_area": "Temporary exclusion area",
    "Terrestrial_habitats": "Terrestrial habitats",
    "ZEPIM": "ZEPIM",
    "Zone_0": "Zone 0",
    "Zone_A1": "Zone A1",
    "Zone_A2": "Zone A2",
    "Zone_B": "Zone B",
    "Zones": "Zones"
};

var fishing = {
    "Anchoring": "Anchoring",
    "Fartet_recovery_plan": "Fartet (Aphanius iberus) recovery plan",
    "Fishing_company_zones": "Fishing company zones",
    "Sailing_speed": "Sailing speed"
};

var hydrology = {
    "Flow_accumulation": "Flow accumulation",
    "Flow_direction": "Flow direction",
    "Mar_Menor_catchment_area": "Catchment area"
};

var land_uses = {
    "Irrigated_crops": "Irrigated crops",
    "SIOSE_Land_cover": "SIOSE Land cover",
    "SIOSE_Land_uses": "SIOSE Land uses",
    "Selected_areas_for_the_implementation_of_thermo_solar_plants": "Selected areas for the implementation of thermo solar plants",
    "Corine_Land_Cover": "Corine Land Cover"
};

var recovery_measures = {
    "Declaration_of_Urgent_Measures": "Declaration of Urgent Measures"
};

var reference_cartography = {
    "Municipalities": "Municipalities",
    "Regions": "Regions"
};

var terrain = {
    "Bathymetry": "Bathymetry",
    "DEM": "DEM",
    "Relief": "Relief",
    "Soil_regional_layer": "Soil regional layer",
};

var water_quality = {
    "Declaracion_Riesgo_Cuantitativo": "Quantitative Risk Declaration",
    "Declaracion_Riesgo_Quimico": "Chemical Risk Declaration",
    "Declaration_of_at_risk_of_not_achieving_good_quantitative_or_chemical_status": "Declaration of at risk of not achieving good quantitative or chemical status",
    "National_census_dischrages": "National census dischrages",
    "Surface_water_quality": "Surface water quality",
    "CHL": "CHL",
};

var groupid = [
    "Climate",
    "Environmental protection",
    "Fishing",
    "Hydrology",
    "Land uses",
    "Recovery measures",
    "Reference cartography",
    "Terrain",
    "Water quality"
]

var groupval = [
    climate,
    environmental_protection,
    fishing,
    hydrology,
    land_uses,
    recovery_measures,
    reference_cartography,
    terrain,
    water_quality
]

// Make layers sortable by the user
for (let i = 0; i < groupval.length; i++) {
    let wrapper = document.getElementById(groupid[i]);
    var sortable = Sortable.create(wrapper, {animation: 150,
        onEnd: function (evt) {
            var from = evt.item;
            var groupName = Object.keys(window[from.children[0].children[0].name]);
            if (evt.newIndex < evt.oldIndex) {
                for (let r = evt.newIndex; r < evt.oldIndex; r++) {
                    map.getPane(groupName[r]).style.zIndex--;
                }
                map.getPane(groupName[evt.oldIndex]).style.zIndex = parseInt(map.getPane(groupName[evt.oldIndex]).style.zIndex) + (evt.oldIndex - evt.newIndex);
    
            }
            else if (evt.newIndex > evt.oldIndex) {
                for (let r = evt.newIndex; r > evt.oldIndex; r--) {
                    map.getPane(groupName[r]).style.zIndex++;
                }
                map.getPane(groupName[evt.oldIndex]).style.zIndex = parseInt(map.getPane(groupName[evt.oldIndex]).style.zIndex) - (evt.newIndex - evt.oldIndex);
            }
            var temp = new Array, temp1 = new Array, temp2 = new Array;
            for (let r = 0; r < groupName.length; r++) {
                temp[r] = map.getPane(groupName[r]).style.zIndex;
            }
            bubbleSort(temp);
            for (let r = 0; r < groupName.length; r++) {
                for (const [key, value] of Object.entries(window[from.children[0].children[0].name])) {
                    if (map.getPane(key).style.zIndex == temp[r]) {
                        temp1[r] = key;
                        temp2[r] = value;
                        delete (window[from.children[0].children[0].name])[key];
                    }
                }
            }
            let lng = groupName.length;
            for (let r = 0; r < lng; r++) {
                (window[from.children[0].children[0].name])[temp1[r]] = temp2[r];
            }
        } 
    })
}

//Make groups of the sortable by the user
var all = new Array;
var groupSort = document.getElementById("pageSubmenu");
Sortable.create(groupSort, {
    animation: 150,
    onEnd: function (event) {
        var from1 = event.item;
        let newgroup = [];
        var r = 0, rr = 0; j = 300, order = 0;

        if (event.newIndex < event.oldIndex) order = 0;
        else order = 1;
        for (let p = 1; p <= groupval.length + 1; p++) {
            if (p == event.newIndex + order) {
                for (const key of Object.keys(window[from1.children[1].children[0].children[0].children[0].children[0].name])) {
                    all[r] = key;
                    r++;
                    newgroup[rr] = from1.children[1].children[0].children[0].children[0].children[0].name;
                }
                rr++;
            }
            if (p != event.oldIndex && p <= groupval.length) {
                for (const key of Object.keys(groupval[p-1])) {
                    all[r] = key;
                    r++;
                    newgroup[rr] = groupid[p-1];
                }
                rr++;
            }
        }
        for (let k = 0; k < all.length; k++) {
            map.getPane(all[k]).style.zIndex = j;
            j--;
        }

        for (let p = 0; p < groupval.length; p++) {
            groupval[p] = window[newgroup[p]];
            groupid[p] = newgroup[p];
        }
    }
})
