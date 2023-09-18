<script>
import axios from 'axios';
import { store } from '../store';
import Swal from 'sweetalert2';
// import map from '../js/map.js';
// import mobile_or_tablet from '../js/mobile-or-tablet.js';
// import '@../js/map.js';
// import '@../js/mobile-or-tablet.js';


export default {
    name: 'AppHome',
    data() {
        return {
            apartment: [],
            address: [],
            store,
            latitude: "",
            longitude: "",
        }
    },
    methods: {
        sendMessage() {
            const apartmentId = this.$route.params.id;
            const formData = {
               email: store.user_email,
               name: store.user_name,
               surname: store.user_surname,
               message: store.user_message,
               apartment_id: apartmentId,
            };
        
            axios.post(store.API_URL + '/api/endpoint', formData)
                .then(response => {
                // alert messaggio inviato tramite sweetalert2
                Swal.fire('Messaggio inviato con successo!');
                store.user_message = "";
                console.log(response.data);
                })
                .catch(error => {
                
                console.error(error);
                });
            
        },
        mappaTomTom() {
            let resultFieldLO = this.longitude;
            let resultFieldLA = this.latitude;

            var map = tt.map({
                key: 'tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1',
                container: 'map',
                center: [resultFieldLO, resultFieldLA],
                zoom: 20,
                dragPan: !isMobileOrTablet()
            });
            map.addControl(new tt.FullscreenControl());
            map.addControl(new tt.NavigationControl());

            function createMarker(position, color, popupText) {
                var markerElement = document.createElement('div');
                markerElement.className = 'marker';
                var markerContentElement = document.createElement('div');
                markerContentElement.className = 'marker-content';
                markerContentElement.style.backgroundColor = color;
                markerElement.appendChild(markerContentElement);
                var popup = new tt.Popup({
                    offset: 30
                }).setText(popupText);

                new tt.Marker({
                        element: markerElement,
                        anchor: 'bottom'
                    })
                    .setLngLat(position)
                    .setPopup(popup)
                    .addTo(map);
            }
            createMarker([resultFieldLO, resultFieldLA], '#5327c3', 'SVG icon');
        },

    },
    mounted() {
        const apartmentId = this.$route.params.id;

        axios.get(store.API_URL + "/apartment/" + apartmentId)
            .then(res => {

                const dataApartment = res.data.apartment[0];
                this.latitude = dataApartment.address.latitude;
                this.longitude = dataApartment.address.longitude;
                this.apartment = dataApartment;
                this.address = dataApartment.address;
                console.log(this.latitude, this.longitude);
                this.mappaTomTom();
            })
            .catch(err => console.error(err));

        let TomTomScript = document.createElement('script');
        TomTomScript.setAttribute('src', 'https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/maps/maps-web.min.js');
        document.head.appendChild(TomTomScript);

        const scripts = [
            "../js/mobile-or-tablet.js",
        ];
        scripts.forEach(script => {
            let tag = document.head.querySelector(`[src="${ script }"`);
            if (!tag) {
                tag = document.createElement("script");
                tag.setAttribute("src", script);
                tag.setAttribute("type", 'text/javascript');
                document.head.appendChild(tag); 
            }
        });
    }
}
</script>

<template>
    <!-- <h1>Hello from HOME</h1> -->
    <!-- <h2>Go to 
        <router-link :to="{ name: 'about' }">ABOUT</router-link>
    </h2>
    <br><br> -->
    <h1>Appartamento</h1>

    <br>
    {{ apartment.title }}

    {{ address.address }}
    <br>
    <img :src="'http://localhost:8000/storage/uploads/' + apartment.image" alt="immagine">
    <br>

    <div v-for="(apartmentService, index) in apartment.services" :key="index">
        <div>
            {{ apartmentService.name }}

        </div>
    </div>

    <form @submit.prevent="sendMessage">

        <label for="name">Nome: </label>
        <input type="text" name="name" v-model="store.user_name">
        <br>
        <label for="surname">Nickname: </label>
        <input type="text" name="surname" v-model="store.user_surname">
        <br>

        <label for="email">E-mail: </label>
        <input type="text" name="email" v-model="store.user_email">
        <br>
        <label for="message">Messaggio: </label>
        <textarea rows="4" cols="50" name="message" v-model="store.user_message"></textarea>
        <br>
        <input type="submit" value="Spedisci">
        <br>
    </form>

    <div style="height: 400px; margin-left: 0%;">
        <div id='map' class='map'>
        </div>
    </div>
</template>

<style >
    .marker-icon {
        background-position: center;
        background-size: 22px 22px;
        border-radius: 50%;
        height: 22px;
        left: 4px;
        position: absolute;
        text-align: center;
        top: 3px;
        transform: rotate(45deg);
        width: 22px;
    }

    .marker {
        height: 30px;
        width: 30px;
    }

    .marker-content {
        background: #c30b82;
        border-radius: 50% 50% 50% 0;
        height: 30px;
        left: 50%;
        margin: -15px 0 0 -15px;
        position: absolute;
        top: 50%;
        transform: rotate(-45deg);
        width: 30px;
    }

    .marker-content::before {

        border-radius: 50%;
        content: "";
        height: 24px;
        margin: 3px 0 0 3px;
        position: absolute;
        width: 24px;
    }
</style>


