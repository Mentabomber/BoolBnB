<script>
import axios from 'axios';
import { store } from '../store'
import AppSearchbarVue from '../components/AppSearchbar.vue';


export default {
    name: 'AppHome',
    components: {
        AppSearchbarVue,
    },
    data() {
        return {
            apartments: [],
            pages: [],
            store
        }
    },
    methods: {

        // Prende gli appartamenti sponsorizzati dal database e li inserisce in home

        getApartments() {
            axios.get(store.API_URL + "/apartment-index")
                .then(res => {

                    const data = res.data;
                    this.apartments = data.apartments;
                    // this.pages = data.apartments.links;
                })
                .catch(err => console.error(err));
        },

        postApartment() {
            const position = {
                latitude: this.store.searched_latitude,
                longitude: this.store.searched_longitude,
            };
            axios.post(store.API_URL + '/search', position)
                .then(res => {
                    const data = res.data;
                    console.log(data, 'prova');
                });

        },
    },
    mounted() {
        this.getApartments();
    }
}
</script>


<template>
    <h1>Hello from HOME</h1>
    <AppSearchbarVue @search="postApartment" />

    <h1>Appartamenti</h1>
    <ul>
        <li v-for="apartment in apartments" :key="apartment.id">
            {{ apartment.id }}
            -
            <router-link :to="{
                name: 'apartment-show',
                params: { id: apartment.id }
            }">
                {{ apartment.title }}
            </router-link>
            <br>

            {{ apartment.address.address }}

            <div v-for="(apartmentService, index) in apartment.services" :key="index">
                <div>
                    {{ apartmentService.name }}
                </div>
            </div>
        </li>
    </ul>
</template>

<style></style>

