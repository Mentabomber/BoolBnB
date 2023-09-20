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

        filterSponsorship() {

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
                    this.$router.push({ name: 'advanced-search' });
                    console.log(this.store.apartmentsSearch, 'store apartments Search');
                });

        },
    },
    mounted() {
        this.getApartmentsWithSponsorship();
        this.getApartments();
        // this.filterSponsorship();
        // 
        this.store.searchResult = this.$route.path;
        console.log(this.store.searchResult, "rotta");
    },
    created() {
        setTimeout(this.filterSponsorship, 3000);
    }
}
</script>


<template>
    <div class="container-fluid d-flex justify-content-between align-items-center" id="jumbotron">
        <div id="title">
            <h2>Trova la <span class="color-green">Casa Perfetta</span></h2>
            <h2>per le tue esigenze</h2>
        </div>
        <div class="fotohomeappartamento">
            <img :src="'https://www.casevacanzapozzallo.it/images/900/1000009/22_villa-lusso-piscina-ispica-.jpg'"
                alt="immagine">
        </div>

    </div>

    <div id="searchbar" class="d-flex justify-content-center py-3">
        <AppSearchbarVue @search="postApartment" />
    </div>





    <div class="container">
        <h2>Case in <span class="color-green">Evidenza</span></h2>


        <div class="container">
            <div class="row gap-10">

                <div v-for="(apartment, index) in apartments" :key="index"
                    :class="(this.AppFiltered.includes(apartment.id)) ? 'hidden' : 'col-md-4 col-sg-12'">
                    <div class="card" v-if="!this.AppFiltered.includes(apartment.id)">
                        <div class="foto_appartamento">
                            <img :src="'http://localhost:8000/storage/uploads/' + apartment.image" alt="immagine">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="card-body">
                            <router-link :to="{ name: 'apartment-show', params: { id: apartment.id } }">
                                <h5 class="card-title">{{ apartment.title }}</h5>
                            </router-link>
                            <p class="card-text">{{ apartment.address.address }}</p>
                        </div>

                        <div class="d-flex justify-content-between service">
                            <div>{{ apartment.square_meters }} m2</div>
                            <div> Letti:{{ apartment.beds }} </div>
                            <div> Bagni:{{ apartment.bathrooms }} </div>
                        </div>



                    </div>
                </div>

                <div v-for="(apartment, index) in apartments" :key="index"
                    :class="!(this.AppFiltered.includes(apartment.id)) ? 'hidden' : 'col-md-4 col-sg-12'">
                    <div class="card" v-if="this.AppFiltered.includes(apartment.id)">
                        <div class="foto_appartamento">
                            <img :src="'http://localhost:8000/storage/uploads/' + apartment.image" alt="immagine">
                        </div>
                        <div class="card-body">
                            <router-link :to="{ name: 'apartment-show', params: { id: apartment.id } }">
                                <h5 class="card-title">{{ apartment.title }}</h5>
                            </router-link>
                            <p class="card-text">{{ apartment.address.address }}</p>
                        </div>
                        <div class="d-flex justify-content-between service">
                            <div>{{ apartment.square_meters }} m2</div>
                            <div> Letti: {{ apartment.beds }} </div>
                            <div> Bagni: {{ apartment.bathrooms }} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped lang="scss">
.hidden {
    display: none;
    position: absolute
}

#jumbotron {
    height: 300px;
}




.fotohomeappartamento {
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
            color: #15ba8f
        }
    }
}

#searchbar {
    height: 65px;
    background-color: #15ba8f;

}

h2 {
    font-size: 2rem;
    margin: 1%;
    font-weight: bolder;

    span {
        color: #15ba8f
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

.card {
    height: 300px;
    border: 2px solid #15BA8F;
    margin-bottom: 10px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;


    .service {

        height: 2rem;
        border-top: 1px solid #15BA8F;

        div {
            width: 33%;
            padding-left: 3%;
            font-weight: bold;


        }

    }


    .foto_appartamento {
        height: 50%;
        position: relative
    }

    img {
        width: 100%;
        max-height: 100%;
        object-fit: cover;

    }
}

a {
    text-decoration: none;
    color: inherit;
}

i {
    position: absolute;
    top: 0;
    right: 0;
    background-color: #15ba8f;
    /* Aggiungi un background color al tuo elemento <i> se necessario */
    padding: 5px;
    /* Aggiungi un padding al tuo elemento <i> per spaziatura */
    color: white;
    /* Imposta il colore del testo all'interno di <i> */
    font-size: 20px;
    /* Imposta la dimensione del testo all'interno di <i> */

}
</style>

