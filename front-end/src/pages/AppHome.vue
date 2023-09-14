<script>
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/v1';

export default {
    name: 'AppHome',
    data() {
        return {
            apartments: [],
            pages: []
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
        }
    },
    mounted() {
        this.getApartments();
    }
}
</script>

<template>
    <h1>Hello from HOME</h1>
    <!-- <h2>Go to 
        <router-link :to="{ name: 'about' }">ABOUT</router-link>
    </h2>
    <br><br> -->
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

