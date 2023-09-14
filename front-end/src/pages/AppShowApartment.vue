<script>
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/v1';

export default {
    name: 'AppHome',
    data() {
        return {
            apartment: [],
            address: [],
        }
    },
    mounted() {
        const apartmentId = this.$route.params.id;

        axios.get(API_URL + "/apartment/" + apartmentId)
            .then(res => {

                const dataApartment = res.data.apartment[0];

                this.apartment = dataApartment;
                console.log(this.apartment.image);
                this.address = dataApartment.address;
            })
            .catch(err => console.error(err));
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

    {{ apartment.id }}
    <br>
    {{ apartment.title }}

    {{ address.address }}

    <img :src="'http://localhost:8000/storage/' + apartment.image" alt="">

    <div v-for="(apartmentService, index) in apartment.services" :key="index">
        <div>
            {{ apartmentService.name }}

        </div>
    </div>
</template>

