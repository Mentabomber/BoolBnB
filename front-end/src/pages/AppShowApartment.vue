<script>
import axios from 'axios';
import { store } from '../store';
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
    <div class="container">
        <!-- <h1>Hello from HOME</h1> -->
        <!-- <h2>Go to 
            <router-link :to="{ name: 'about' }">ABOUT</router-link>
        </h2>
        <br><br> -->
    
        <h1>{{ apartment.title }}</h1>
        <h5><i class="fa-solid fa-location-dot"></i>{{ address.address }}</h5>
        
        <div class="foto_appartamento">
            <img :src="'http://localhost:8000/storage/uploads/' + apartment.image" alt="immagine">
        </div>

        <div class="d-flex text-align-center justify-content-between">
            <div>
                <h2><span>Descrizione</span> Appartamento</h2>
                <div class="info_appartamento">
                    <div class="col d-flex text-align-center justify-content-between">
                        <div>Stanze: {{ apartment.rooms }}</div>
                        <div>Letti: {{ apartment.beds }}</div>
                    </div>
                    <div class="col d-flex text-align-center justify-content-between">
                        <div>Metri quadrati: {{ apartment.square_meters }} m²</div>
                        <div>Bagni: {{ apartment.bathrooms }}</div>
                    </div>
                </div>
        
                <h2><span>Servizi</span> Appartamento</h2>
                <ul v-for="(apartmentService, index) in apartment.services" :key="index">
                    <li>
                        {{ apartmentService.name }}
                    </li>
                </ul>
            </div>

            <div class="map_container">
                <div class="map_view">
                    <div id='map' class='map'>
                    </div>
                </div>
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
    </div>
</template>

<style scoped lang="scss">
@use '../styles/partials/variables.scss' as *;
@use '../styles/partials/mixins.scss' as *;

.container {
    padding: 0rem;

    h1 {
        font-weight: bold;
    }

    h5 .fa-solid.fa-location-dot {
        margin-right: 0.8rem;
        margin-bottom: .5rem;
    }

    .foto_appartamento {
        width: 100%;
        border: 1px solid #15ba8f;
        border-radius: 20px;

        img {
            min-width: 100%;
            object-fit: cover;
            border-radius: 20px;
        }
    }

    h2 {
        margin-top: 2rem;
        font-weight: bold;
        span {
            color: #15ba8f;
        }
    }

    .info_appartamento {
        font-weight: bold;

        .col {
            width: 75%;
            margin-bottom: 1rem;
        }
    }

    ul {
        padding: 0.4rem 1rem 0;
        line-height: 0.5rem;

        li {
            font-style: italic;
        }
    }

    .map_container {
        border: 1px solid #15ba8f;
        min-width: 50%;
        height: 500px;
        position: relative;

        .mapboxgl-canvas {
            height: 100%;
        }

        .map_view {
            min-width: 100%;
            height: 100%;

            .map {
                width: 100%;
                height: 100%;
            }
        }
    }
}
</style>


