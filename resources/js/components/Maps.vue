<template>
    <div class="container">
        <h2>Lab Locations</h2>
        <gmap-map
            :center="center"
            :zoom="12"
            style="width:100%;  height: 500px;"
        >
            <gmap-marker
                :key="index"
                v-for="(m, index) in markers"
                :position="m.position"
                @click="center = m.position"
            ></gmap-marker>
        </gmap-map>
    </div>
</template>

<script>
export default {
    name: "GoogleMap",
    data() {
        return {
            // default is Toronto
            center: { lat: 43.65107, lng: -79.347015 },
            markers: [],
            places: [],
            currentPlace: null,
            labs: []
        };
    },
    created() {
        this.fetchLabs();
    },
    // mounted() {
    //   this.geolocate();
    // },

    methods: {
        // receives a place object via the autocomplete component
        setPlace(place) {
            this.currentPlace = place;
        },
        fetchLabs(page_url) {
            fetch("api/labs")
                .then(res => res.json())
                .then(res => {
                    this.labs = res.data;
                    this.labs.forEach(el => {
                        if (el.lat != "" || el.lng != "")
                            this.addMarker(el.lat, el.long);
                    });
                })
                .catch(err => console.log(err));
        },
        addMarker(lat, lng) {
            lat = parseFloat(lat);
            lng = parseFloat(lng);
            const marker = {
                lat,
                lng
            };
            console.log(marker);
            this.markers.push({ position: marker });
            this.places.push(this.currentPlace);
            this.center = marker;
        }
        // geolocate: function() {
        //   navigator.geolocation.getCurrentPosition(position => {
        //     this.center = {
        //       lat: position.coords.latitude,
        //       lng: position.coords.longitude
        //     };
        //   });
        // }
    }
};
</script>
