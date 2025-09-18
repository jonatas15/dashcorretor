<template>
    <div class="map-container">
        <div v-if="!mapReady" class="loading-overlay">
            Carregando mapa...
        </div>
        <l-map
            style="height: 100%; width: 100%;"
            :zoom="13"
            :center="mapCenter"
            :use-global-leaflet="true"
            @ready="onMapReady"
        >
            <l-tile-layer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            />
            <l-feature-group ref="featureGroup">
                <l-geo-json
                    v-for="(area, idx) in selectedAreas.filter(a => a.type !== 'Circle')"
                    :key="idx"
                    :geojson="area"
                    :options="{ color: 'blue', fillOpacity: 0.2, weight: 2 }"
                />
            </l-feature-group>
            <l-marker
                v-for="imovel in filteredImoveis"
                :key="imovel.id"
                :lat-lng="[imovel.lat, imovel.lng]"
                :options="markerOptions(imovel)"
            >
                <l-popup>
                    <div>
                        <h4>{{ imovel.nome }}</h4>
                        <p>Coordenadas: {{ imovel.lat }}, {{ imovel.lng }}</p>
                    </div>
                </l-popup>
            </l-marker>
        </l-map>
        <button class="clear-button" @click="clearSelection">
            Limpar Seleção
        </button>
        <div class="imoveis-counter">
            Imóveis visíveis: {{ filteredImoveis.length }} / {{ imoveis.length }}
        </div>
    </div>
</template>

<script setup>
import { ref, computed, toRaw } from 'vue'
import { LMap, LTileLayer, LMarker, LPopup, LFeatureGroup, LGeoJson } from '@vue-leaflet/vue-leaflet'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import 'leaflet-draw/dist/leaflet.draw.css'
import 'leaflet-draw'
import booleanPointInPolygon from '@turf/boolean-point-in-polygon'
import { point, polygon } from '@turf/helpers'

console.log('Script setup inicializado')

const mapReady = ref(false)
const mapCenter = ref([-23.55052, -46.633308])
const imoveis = ref([
    { id: 1, nome: 'Imóvel 1', lat: -23.55052, lng: -46.633308 },
    { id: 2, nome: 'Imóvel 2', lat: -23.545, lng: -46.63 },
    { id: 3, nome: 'Imóvel 3', lat: -23.56, lng: -46.64 },
])
const selectedAreas = ref([])


const filteredImoveis = computed(() => {
    console.log('Calculando filteredImoveis, áreas:', selectedAreas.value.length);
    if (!selectedAreas.value.length) return imoveis.value;
    return imoveis.value.filter(imovel => {
        const pt = point([imovel.lng, imovel.lat]);
        return selectedAreas.value.some(area => {
            try {
                if (area.type === 'Circle') {
                    // Verificar se o ponto está dentro do círculo
                    const center = L.latLng(area.center[0], area.center[1]);
                    const distance = center.distanceTo(L.latLng(imovel.lat, imovel.lng));
                    return distance <= area.radius;
                } else if (area.geometry && area.geometry.coordinates) {
                    // Para polígonos, usar Turf.js
                    const poly = polygon(area.geometry.coordinates);
                    return booleanPointInPolygon(pt, poly);
                }
                return false; // Ignorar áreas malformadas
            } catch (error) {
                console.error('Erro ao verificar ponto em área:', error);
                return false;
            }
        });
    });
});

function markerOptions(imovel) {
    try {
        return {
            icon: L.icon({
                iconUrl: '/images/marker-icon.png',
                shadowUrl: '/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }),
            title: imovel.nome
        }
    } catch (error) {
        console.error('Erro ao configurar ícone do marcador:', error)
        return { title: imovel.nome }
    }
}

function onMapReady(map) {
    console.log('Mapa inicializado:', map)
    mapReady.value = true
    try {
        const rawMap = toRaw(map)  // Desproxiar o mapa
        const drawnItems = new L.FeatureGroup()
        rawMap.addLayer(drawnItems)

        const drawControl = new L.Control.Draw({
            position: 'topleft',
            draw: {
                polygon: {
                    shapeOptions: { color: 'blue', weight: 2, fillOpacity: 0.2 },
                    allowIntersection: true,
                    showArea: true
                },
                marker: false,
                polyline: false,
                rectangle: false,
                circle: {
                    shapeOptions: { color: 'red', weight: 2, fillOpacity: 0.2 }
                },
                circlemarker: false,
            },
            edit: {
                featureGroup: drawnItems,  // Mantenha raw
                edit: {
                    selectedPathOptions: {
                        color: '#ff0000',
                        fillColor: '#ff0000',
                        fillOpacity: 0.3
                    }
                },
                remove: true
            }
        })
        rawMap.addControl(drawControl)  // Adicionar controle desproxiado

        // Eventos no mapa desproxiado
        rawMap.on(L.Draw.Event.CREATED, function (event) {
            const layer = event.layer
            drawnItems.addLayer(layer)
            if (layer instanceof L.Polygon) {
                const geojson = layer.toGeoJSON()
                selectedAreas.value.push(geojson)
                console.log('Polígono criado:', geojson)
            } else if (layer instanceof L.Circle) {
                const center = layer.getLatLng()
                const radius = layer.getRadius()
                selectedAreas.value.push({
                    type: 'Circle',
                    center: [center.lat, center.lng],
                    radius: radius
                })
                console.log('Círculo criado:', { center, radius })
            }
        })

        rawMap.on(L.Draw.Event.EDITED, function (event) {
            const layers = event.layers
            selectedAreas.value.length = 0
            layers.eachLayer(function (layer) {
                if (layer instanceof L.Polygon) {
                    selectedAreas.value.push(layer.toGeoJSON())
                } else if (layer instanceof L.Circle) {
                    const center = layer.getLatLng()
                    const radius = layer.getRadius()
                    selectedAreas.value.push({
                        type: 'Circle',
                        center: [center.lat, center.lng],
                        radius: radius
                    })
                }
            })
            console.log('Camadas editadas:', selectedAreas.value)
        })

        rawMap.on(L.Draw.Event.DELETED, function (event) {
            const layers = event.layers
            layers.eachLayer(function (layer) {
                if (layer instanceof L.Polygon) {
                    const geojson = layer.toGeoJSON()
                    selectedAreas.value = selectedAreas.value.filter(
                        area => area.type !== 'Circle' && JSON.stringify(area) !== JSON.stringify(geojson)
                    )
                } else if (layer instanceof L.Circle) {
                    const center = layer.getLatLng()
                    const radius = layer.getRadius()
                    selectedAreas.value = selectedAreas.value.filter(
                        area => area.type !== 'Circle' || 
                                (area.center[0] !== center.lat || 
                                area.center[1] !== center.lng || 
                                area.radius !== radius)
                    )
                }
            })
            console.log('Camada(s) deletada(s):', selectedAreas.value)
        })
    } catch (error) {
        console.error('Erro em onMapReady:', error)
    }
}

function clearSelection() {
    selectedAreas.value.length = 0
    if (mapReady.value && $refs.featureGroup?.mapObject) {
        toRaw($refs.featureGroup.mapObject).clearLayers()  // Desproxiar aqui também
    }
    console.log('Seleção manualmente limpa')
}

// Fallback para mapReady
setTimeout(() => {
    if (!mapReady.value) {
        console.warn('Evento ready não disparado, forçando mapReady = true')
        mapReady.value = true
    }
}, 5000)
</script>

<style scoped>
/* Estilos conforme sugerido acima */
.map-container {
    height: 100vh;
    width: 100%;
    position: relative;
}

.loading-overlay {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.8);
    padding: 8px;
    border-radius: 4px;
}

.clear-button {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1000;
    padding: 8px 16px;
    background: #ff4d4f;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.imoveis-counter {
    position: absolute;
    bottom: 10px;
    left: 10px;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.8);
    padding: 8px;
    border-radius: 4px;
}
</style>