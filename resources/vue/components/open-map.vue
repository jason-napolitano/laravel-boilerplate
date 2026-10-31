<template>
    <Map.OlMap
        :style="`height: ${props.height}; width: ${props.width}; height: ${props.height};`"
        :loadTilesWhileInteracting="true"
        :loadTilesWhileAnimating="true"
    >
        <Map.OlView :projection="projection" class="min-h-80" :center="center" :zoom="zoom" ref="openMap" />
        <Layers.OlTileLayer>
            <Sources.OlSourceOSM />
        </Layers.OlTileLayer>
    </Map.OlMap>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { OpenStreetMapProvider } from 'leaflet-geosearch'
import { Layers, Map, Sources } from 'vue3-openlayers'

// --------------------------------------------------------
// props
interface ComponentProps {
    address: string
    height?: string
    width?: string
}

const props = withDefaults(defineProps<ComponentProps>(), {
    height: '500px',
    width: '100%',
})

// --------------------------------------------------------
// map references
const projection = ref('EPSG:4326')
const center = ref<number[]>([])
const zoom = ref<number>(17.5)
const openMap = ref()

// --------------------------------------------------------
// reverse geolocation
onBeforeMount(async () => {
    const { removeCommas } = useString()

    // instantiate the provider
    const provider: OpenStreetMapProvider = new OpenStreetMapProvider()

    // generate the results
    const results = await provider.search({
        query: removeCommas(props.address),
    })

    // assign the center reference of the map
    center.value = [results[0].x, results[0].y]
})
</script>
