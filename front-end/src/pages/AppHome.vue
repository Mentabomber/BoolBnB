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
    },
    mounted() {
        this.getApartments();
    }
}
</script>


<template>
    <h1>Hello from HOME</h1>
    <AppSearchbarVue />

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

