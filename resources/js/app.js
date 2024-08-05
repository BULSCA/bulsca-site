import Feature from "ol/Feature.js";
import Map from "ol/Map.js";
import View from "ol/View.js";
import Point from "ol/geom/Point.js";
import { Tile as TileLayer, Vector as VectorLayer } from "ol/layer.js";
import { useGeographic } from "ol/proj.js";
import { OSM } from "ol/source.js";
import VectorSource from "ol/source/Vector.js";
import { Circle, Fill, Stroke, Style } from "ol/style.js";
import Icon from "ol/style/Icon.js";

useGeographic();

class ToggleContent {
    constructor(element) {
        this.header = element.querySelector("[toggle-header]");
        this.content = element.querySelector("[toggle-content]");

        this.open = true;

        clazz = this;

        this.header.onclick = (e) => {
            this.content.classList.toggle("collapsed");
        };
    }
}

function start() {
    document.querySelectorAll("[toggle]").forEach((e) => new ToggleContent(e));
}

window.onload = start();

var elementMap = document.getElementById("map");

if (elementMap != null) {
    var target = [
        elementMap.getAttribute("x-lat"),
        elementMap.getAttribute("x-long"),
    ]; // -174870.005788, 6868640.916334

    document.getElementById("map").style.display = "block";

    var m = new Map({
        layers: [
            new TileLayer({
                source: new OSM(),
            }),
        ],
        view: new View({
            center: target,
            zoom: 10,
        }),
        target: "map",
    });

    const startMarker = new Feature({
        type: "icon",
        geometry: new Point(target),
    });

    var markerSize = 20;
    var markerStyle = new Style({
        fill: new Fill({
            color: "white", // Color of the white fill
        }),
        stroke: new Stroke({
            color: "black", // Color of the marker border
            width: 1,
        }),
        image: new Circle({
            radius: markerSize / 2, // Radius of the circular image marker
            fill: new Fill({
                color: "transparent", // Transparent fill for the circular image marker
            }),
            stroke: new Stroke({
                color: "black", // Color of the marker border
                width: 1,
            }),
            src: "https://bulsca.co.uk/storage/logo/bulsca-marker.png", // Path to your circular image marker
        }),
    });

    const vectorLayer = new VectorLayer({
        source: new VectorSource({
            features: [startMarker],
        }),
        style: new Style({
            image: new Icon({
                fill: new Fill({ color: "white" }),
                scale: 0.05,

                src: "/storage/logo/bulsca-marker.png",
            }),
        }),
    });

    m.addLayer(vectorLayer);
}

var elementClubMap = document.getElementById("club-map");

if (elementClubMap != null) {
    var mp = new Map({
        layers: [
            new TileLayer({
                source: new OSM(),
            }),
        ],
        view: new View({
            center: [-3.306, 52.908],
            zoom: 5.8,
        }),
        target: "club-map",
    });

    let map_club_bar = document.getElementById("map-club-bar");
    let locations = JSON.parse(elementClubMap.getAttribute("x-locations"));

    var veclayer_location_map = [];

    locations.forEach((location) => {
        var locMarker = new Feature({
            type: "icon",
            geometry: new Point(location.location.split(",").reverse()),
        });
        locMarker.set("name", location.name);

        var vectorLayer = new VectorLayer({
            source: new VectorSource({
                features: [locMarker],
            }),
            style: new Style({
                image: new Icon({
                    fill: new Fill({ color: "white" }),
                    scale: 0.05,

                    src: "/storage/logo/bulsca-marker.png",
                }),
            }),
        });

        mp.addLayer(vectorLayer);

        veclayer_location_map[location.name] = vectorLayer;
    });

    var allCards = document
        .getElementById("club-cards")
        .querySelectorAll("[x-club-loc]");

    allCards.forEach((e) => {
        function apply(e) {
            let loc = e.target.getAttribute("x-club-loc").split(",").reverse();

            allCards.forEach((e) => e.classList.remove("cl-active"));
            e.target.classList.toggle("cl-active");

            if (loc.length == 2) {
                mp.getView().animate({
                    center: loc,
                    duration: 1000,
                    zoom: 12.5,
                });

                //mp.getView().setCenter(loc)
                //mp.getView().setZoom(12.5)
                map_club_bar.children[0].textContent =
                    e.target.getAttribute("x-club-name");
                //map_club_bar.style.display = 'flex'

                veclayer_location_map[
                    e.target.getAttribute("x-club-name")
                ].setStyle(
                    new Style({
                        image: new Icon({
                            fill: new Fill({ color: "white" }),
                            scale: 0.075,
                            src: "/storage/logo/bulsca-marker.png",
                        }),
                    })
                );

                elementClubMap.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                    inline: "nearest",
                });
            }
        }

        e.onmouseover = apply;
        e.onclick = apply;

        e.onmouseleave = (event) => {
            veclayer_location_map[
                event.target.getAttribute("x-club-name")
            ].setStyle(
                new Style({
                    image: new Icon({
                        fill: new Fill({ color: "white" }),
                        scale: 0.05,
                        src: "/storage/logo/bulsca-marker.png",
                    }),
                })
            );
        };
    });

    var wasHover = false;

    mp.on("click", function (evt) {
        var feature = mp.forEachFeatureAtPixel(
            evt.pixel,
            function (feature, layer) {
                return feature;
            }
        );

        if (feature) {
            allCards.forEach((e) => e.classList.remove("cl-active"));
            allCards[0].parentNode
                .querySelector('[x-club-name="' + feature.get("name") + '"]')
                .classList.toggle("cl-active");

            var loc = allCards[0].parentNode
                .querySelector('[x-club-name="' + feature.get("name") + '"]')
                .getAttribute("x-club-loc")
                .split(",")
                .reverse();
            mp.getView().animate({
                center: loc,
                duration: 1000,
                zoom: 12.5,
            });
        }
    });

    mp.on("pointermove", function (evt) {
        var feature = mp.forEachFeatureAtPixel(
            evt.pixel,
            function (feature, layer) {
                return feature;
            }
        );

        if (feature) {
            this.getTargetElement().style.cursor = "pointer";
            allCards.forEach((e) => e.classList.remove("cl-active"));
            allCards[0].parentNode
                .querySelector('[x-club-name="' + feature.get("name") + '"]')
                .classList.toggle("cl-active");
            wasHover = true;
        } else {
            this.getTargetElement().style.cursor = "";
            if (wasHover) {
                allCards.forEach((e) => e.classList.remove("cl-active"));
                wasHover = false;
            }
        }
    });
}
