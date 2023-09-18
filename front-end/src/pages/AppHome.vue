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
            apartmentsId: [],
            apartmentsIdWithSponsorship: [],
            AppFiltered: [],
            store
        }
    },
    methods: {

        getApartmentsWithSponsorship() {
            axios.get(store.API_URL + "/apartment-with-sponsorship")
                .then(res => {

                    const data = res.data.appartamentiSponsorizzati;
                    this.apartmentsIdWithSponsorship = data;
                    // console.log(this.apartmentsIdWithSponsorship, "app sponsorizzati");
                })
                .catch(err => console.error(err));

        },

        getApartments() {
            axios.get(store.API_URL + "/apartment-index")
                .then(res => {

                    const data = res.data;
                    this.apartments = data.apartments;
                    data.apartments.forEach(element => {
                    this.apartmentsId.push(element.id);
                    });
                    // console.log(this.apartmentsId);
                })
                .catch(err => console.error(err));
        },

        filterSponsorship(){
            
            //presenti in tutti ma non presenti in app con sponsor
            // console.log(this.apartmentsIdWithSponsorship);
            this.AppFiltered = this.apartmentsId.filter((valore) => {
                return !this.apartmentsIdWithSponsorship.some((id) => id == valore);
            });
            console.log(this.AppFiltered);
        },

        postApartment() {
            const position = {
                latitude: this.store.searched_latitude,
                longitude: this.store.searched_longitude,
            };
            axios.post(store.API_URL + '/search', position)
                .then(res => {
                    const data = res.data;
                    this.store.apartmentsSearch = res.data.apartments;
                    this.$router.push({name: 'advanced-search' });
                    console.log(this.store.apartmentsSearch, 'store apartments Search');
                });

        },
    },
    mounted() {
        this.getApartmentsWithSponsorship();
        this.getApartments();
        setTimeout(this.filterSponsorship, 4000);
    },
    created() {
    }
}
</script>


<template>
    <h1>Hello from HOME</h1>
    <AppSearchbarVue @search="postApartment" />

    <h1>Appartamenti</h1>
    <ul>
        <li v-for="(apartment, index) in apartments" :key="index" :class="(this.AppFiltered.includes(apartment.id)) ? 'hidden' : ''">
            <div v-if="!this.AppFiltered.includes(apartment.id)">
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
            </div>
        </li>
    </ul>

    <div>-------------------------------------</div>

    <ul>
        <li v-for="(apartment, index) in apartments" :key="index" :class="!(this.AppFiltered.includes(apartment.id)) ? 'hidden' : ''">
            <div v-if="this.AppFiltered.includes(apartment.id)">
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
            </div>
        </li>
    </ul>
</template>

<style>
    .hidden {
        display: none;
    }
</style>

