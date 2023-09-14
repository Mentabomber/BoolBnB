<script>
import axios from 'axios';
const API_URL = 'http://127.0.0.1:8000/api/v1';

export default {
    name: 'AppHome',
    data() {
        return {
            apartments: [],
            pages: [],
            search: '',
            lat: '',
            long: '',
            suggestions: [],
            isActive: false,
        }
    },
    methods: {

        getApartments() {

            axios.get(API_URL + "/apartment-index")
                .then(res => {

                    const data = res.data;
                    console.log(data);

                    this.apartments = data.apartments;
                    console.log(this.apartments);
                    // this.pages = data.apartments.links;
                })
                .catch(err => console.error(err));
        },

        async searchbar() {

            try {
                const response = await axios.get("https://api.tomtom.com/search/2/search/" + this.search + ".json?key=tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1&countrySet=IT");
                this.lat = response.data.results[0].position.lat;
                this.long = response.data.results[0].position.lon;

                response.data.results.forEach(addresses => {
                    console.log(this.suggestions.length, 'lunghezza');
                    if (this.suggestions.length >= 10) {
                        console.log("eccomi");
                        this.suggestions.splice(0, 1);
                        this.suggestions.push(addresses.address);
                    } else {
                        this.suggestions.push(addresses.address);
                    }
                });
            } catch (error) {
                console.error(error);
            }

            console.log(this.suggestions, 'prova');

            // this.suggestions = response.data.results;
            // this.lat = response.data.results[0].position.lat;
            // console.log(this.lat, 'prova2');
            // suggestionsList.innerHTML = '';

            // // Mostra gli indirizzi suggeriti nell'autocompletamento
            // addresses.forEach(function (address) {
            //     suggestionsList.style.display = 'block';
            //     const suggestion = document.createElement('li');
            //     suggestion.textContent = address.address.freeformAddress;
            //     console.log(addresses.length);

            //     suggestion.addEventListener('click', function () {
            //         // Aggiungi il valore dell'indirizzo selezionato all'input di ricerca
            //         searchInput.value = address.address.freeformAddress;
            //         const indirizzo = document.getElementById('resultField');
            //         const latitudine = document.getElementById('resultFieldLA');
            //         const longitudine = document.getElementById('resultFieldLO');
            //         indirizzo.value = address.address.freeformAddress;
            //         latitudine.value = address.position.lat;
            //         longitudine.value = address.position.lon;
            //         suggestionsList.style.display = 'none';
            //         const risultatiAppartamenti = intorno(latitudine.value, longitudine.value, 20);
            //         console.log(risultatiAppartamenti, "risultato ricerca", latitudine.value, longitudine.value);
            //     });

            //     suggestionsList.appendChild(suggestion);
            // });
        },

        changeAddress(suggestion) {
            this.isActive = true;
            this.search = suggestion.freeformAddress;

        }

        // intorno(lat, lon, raggio) {
        //     const lat_min = lat - raggio / 6371 * Math.PI;
        //     const lat_max = lat + raggio / 6371 * Math.PI;
        //     const lon_min = lon - raggio / 6371 * Math.PI / Math.cos(lat);
        //     const lon_max = lon + raggio / 6371 * Math.PI / Math.cos(lat);

        //     return [lat_min, lat_max, lon_min, lon_max];
        // }
    },
    mounted() {
        this.getApartments();
    }
}
</script>


<template>
    <h1>Hello from HOME</h1>

    <form method="POST" action="{{  }}" enctype='multipart/form-data' autocomplete="off">

        <div class="autocomplete">
            <label for="address">Indirizzo</label>
            <input type="text" name="address" v-model="search" id="searchInput" placeholder="Cerca indirizzo"
                @input="searchbar()">

        </div>
        <div :class="[isActive ? 'hidden' : '']">
            <span v-for="(suggestion, i) in suggestions" :key="i" @click="changeAddress(suggestion)">
                {{ suggestion.freeformAddress }}
                <br>
            </span>
        </div>
        <input class="my-3" type="submit" value="Cerca">
    </form>

    <h1>Appartamenti</h1>
    <ul>
        <li v-for="apartment in apartments" :key="apartment.id">
            <router-link :to="{
                title: 'apartment-show',
                params: { id: apartment.id }
            }">
                {{ apartment.title }}
            </router-link>

            {{ apartment.id }}
            {{ apartment.address.address }}

            <div v-for="(apartmentService, index) in apartment.services" :key="index">
                <div>
                    {{ apartmentService.name }}
                </div>
            </div>
        </li>
    </ul>
</template>

<style>
.hidden {
    display: none;
}
</style>

