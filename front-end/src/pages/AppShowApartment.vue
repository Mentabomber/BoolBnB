<script>
import axios from 'axios';
import { store } from '../store';

export default {
    name: 'AppHome',
    data() {
        return {
            apartment: [],
            address: [],
            store
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
            }
    },
    mounted() {
        const apartmentId = this.$route.params.id;

        axios.get(store.API_URL + "/apartment/" + apartmentId)
            .then(res => {

                const dataApartment = res.data.apartment[0];

                this.apartment = dataApartment;
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
        <label for="surname">Cognome: </label>
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
</template>

