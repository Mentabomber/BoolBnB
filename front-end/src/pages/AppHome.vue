<script>
import axios from 'axios';
import { store } from '../store'

// const API_URL = 'http://127.0.0.1:8000/api/v1';

export default {
    name: 'AppHome',
    data() {
        return {
            apartments: [],
            pages: [],
            store
        }
    },
    methods: {
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
    <!-- <h2>Go to 
        <router-link :to="{ name: 'about' }">ABOUT</router-link>
    </h2>
    <br><br> -->
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

