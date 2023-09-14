<script>
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/v1';

export default {
    name: 'AppHome',
    data() {
        return {
            apartment: [],
            address: [],
            email: {},
        }
    },
    mounted() {
        const apartmentId = this.$route.params.id;

        axios.get(API_URL + "/apartment/" + apartmentId)
            .then(res => {

                const dataApartment = res.data.apartment[0];

                this.apartment = dataApartment;
                this.address = dataApartment.address;
            })
            .catch(err => console.error(err));

        axios.get(API_URL + "/api/get-email")
        .then(res => {

            const dataEmail = res.data;

            console.log(dataEmail);
            this.email = dataEmail;
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

    <form method="POST" action="{{ route('apartment.messages', $apartment->id) }}" enctype='multipart/form-data'>
    
            <label for="name">Nome: </label>
            <input type="text" name="name">
            <br>
            <label for="surname">Cognome: </label>
            <input type="text" name="surname">
            <br>
            
            <label for="email">E-mail: </label>
            <input type="text" name="email" v-model="this.email">
            <br>
            <label for="message">Messaggio: </label>
            <input type="text" name="message">
            <br>
            <input type="submit" value="Spedisci">
            <br>
    </form>
</template>

