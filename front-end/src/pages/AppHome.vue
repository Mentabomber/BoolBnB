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
                    this.store.searchResult = data.apartments;
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
        this.store.searchResult = this.$route.path;
        console.log(this.store.searchResult, "rotta");
    },
    created() {
    }
}
</script>


<template>

    <div class="container-fluid d-flex justify-content-between align-items-center" id="jumbotron">
        <div id="title">
            <h2>Trova la <span class="color-green">Casa Perfetta</span></h2>
            <h2>per le tue esigenze</h2>
        </div>
        <div class="foto_appartamento">
            <img :src="'https://www.casevacanzapozzallo.it/images/900/1000009/22_villa-lusso-piscina-ispica-.jpg'" alt="immagine">
        </div>
       
    </div>
    
    <div id="searchbar" class= "d-flex justify-content-center py-3">
        <AppSearchbarVue @search="postApartment" />
    </div>
  




    <div class="container-card-house">
        <h2>Case in <span class="color-green">Evidenza</span></h2>
        <ul>
        <li v-for="(apartment, index) in apartments" :key="index" :class="(this.AppFiltered.includes(apartment.id)) ? 'hidden' : ''">
            <div v-if="!this.AppFiltered.includes(apartment.id)">
               
                
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
                
                <router-link :to="{
                    name: 'apartment-show',
                    params: { id: apartment.id }
                }">
                 <div class="foto_appartamento">
                <img :src="'http://localhost:8000/storage/uploads/' + apartment.image" alt="immagine">
                </div>
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
    </div>
    
</template>
<style scoped lang="scss">
    .hidden {
        display: none;
    }

    #jumbotron {
        height: 400px;
        
        
       
    }

    


    .foto_appartamento {
        max-height: 100%;
        width: 50%;
        height: 100%;
        border: 1px solid #15ba8f;     
        img {
            max-height: 100%;
            min-width: 100%;
            object-fit: cover;
            
        }
    }
    #title {
        margin-left: 10%;
        
        h2 {
            font-size: 3rem;

            span {
                color:#15ba8f
            }
        }
    }

    #searchbar {
        height: 100px;
        background-color: #15ba8f;
        border-bottom: 3px solid #0D233D;
        
    }

    h2 {
            font-size: 2rem;

            span {
                color:#15ba8f
            }
        }

        .container-card-house {
            width: 90%;
            margin: 2rem auto;
            
        }

        ul {
            list-style-type: none;
            a {
                text-decoration: none;
                color: inherit;
            }
        }

</style>

