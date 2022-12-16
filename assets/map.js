import Map from 'ol/Map';
import OSM from 'ol/source/OSM';
import TileLayer from 'ol/layer/Tile';
import View from 'ol/View';

window.onload = (event) => {
    
    var achievement = document.querySelector('.informations');
            var longitudeString = achievement.dataset.longitude;
            var latitudeString = achievement.dataset.latitude;
            var longitude = parseFloat(longitudeString);
            var latitude = parseFloat(latitudeString);
        
            console.log(longitude);
            console.log(latitude);
/*
            const map = new Map({
                layers: [
                new TileLayer({
                    source: new OSM(),
                }),
                ],
                target: 'map',
                view: new View({
                center: ol.proj.fromLonLat([longitude, latitude]),
                zoom: 12,
                }),
            });

            var imageStyle = new ol.style.Style({
                image: new ol.style.Circle({
                      radius: 5,
                      snapToPixel: false,
                      fill: new ol.style.Fill({
                      color: [255 , 0 , 0 , 0.2]
                  }),
                  stroke: new ol.style.Stroke({
                      color: [255 , 0 , 0 , 1],
                      width: 1
                  })
            })
        });
            */
        var obsFeature = new ol.Feature({
            geometry : new ol.geom.Point(ol.proj.fromLonLat([longitude,latitude])),
            labelPoint: new ol.geom.Point(ol.proj.fromLonLat([longitude,latitude])),
            name: 'My Point',
            size : 10
        });

        var features = new Array(1);
        features[0] = obsFeature;
        var imageStyle = new ol.style.Style({
            image: new ol.style.Circle({
            radius: 5,
            snapToPixel: false,
            fill: new ol.style.Fill({color: 'yellow'}),
            stroke: new ol.style.Stroke({color: 'red', width: 10})
            })
        });

        obsFeature.setStyle(imageStyle);
        var observationsSourceVector = new ol.source.Vector({
            features: features
        });
        var observationsVectorLayer = new ol.layer.Vector({
            source: observationsSourceVector,
            style: imageStyle
        });

        var map = new ol.Map({
          target: 'map',
          layers: [
            new ol.layer.Tile({
              source: new ol.source.OSM()
            }),
            observationsVectorLayer
          ],
          view: new ol.View({
            center: ol.proj.fromLonLat([longitude,latitude]),
            zoom: 11
          })
        });

        map.render();
            
        };           
            





            