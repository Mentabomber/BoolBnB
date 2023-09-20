<script>
import axios from 'axios';
import { store } from '../store'
import AppSearchbar from '../components/AppSearchbar.vue';
import { ref } from 'vue';

export default {
    name: 'AppHome',
    components: {
        AppSearchbar
    },
    data() {
        return {
            store,
            apartments: [],
            kmFilter: 20,
            bedsFilter: 0,
            roomsFilter: 0,
            defaultValue: 20,
            function: 0
        }
    },
    methods: {
        // Chiede al db tutti gli appartamenti che corrispondono ai filtri base di ricerca (distanza <= 20)

        postApartment() {
            this.store.apartmentsSearch = [];

            const filterData = {
                latitude: this.store.searched_latitude,
                longitude: this.store.searched_longitude,
                kmFilter: this.kmFilter,
                bedsFilter: this.bedsFilter,
                roomsFilter: this.roomsFilter,
                servicesFilter: this.store.activeFilterServices,
            };

            console.log(filterData.servicesFilter, 'prova');
            axios.post(store.API_URL + '/advanced-search', filterData)
                .then(res => {
                    const data = res.data;
                    console.log(data, 'prova');
                    this.store.apartments_filtered = data.apartments;
                    // console.log(this.store.apartments_filtered, 'eccomi');
                });

        },
    },
    mounted() {

    }
}
</script>

<template>
    <AppSearchbar @search="postApartment" />

    <div class="d-flex justify-content-between p-5 gap-5">
        <div class="col-4" style="border: 1.5px solid #15ba8f; border-radius: 10px;">
            <div style="border-bottom: 1.5px solid #15ba8f; padding: 0.8rem;">Filtra per:</div>

            <div style="padding: 0.8rem; border-bottom: 1.5px solid #15ba8f;">
                <div class="categoria">Servizi:</div>
                <div v-for="(service, i) in this.store.services_list" class="form-check" style="max-width: 300px">
                    <input v-model="this.store.activeFilterServices" class="form-check-input" type="checkbox"
                        :value="service.id" name="services[]" :id="service.id" :key="i" @change="this.postApartment()">

                    <label class=" form-check-label" :for="service.id">
                        {{ service.name }}
                    </label>
                </div>

            </div>


            <div style="border-bottom: 1.5px solid #15ba8f; padding: 0.8rem;">
                <div class="categoria">Numero stanze minime:</div>

                <span v-for="(n, i) in 5" :key="i" style="margin-right: 20px;">
                    <input v-model="roomsFilter" type="radio" class="available-rooms" @change="this.postApartment()"
                        name="available-rooms" :value="n" style="scale: 1.5; margin-right: 5px;">
                    {{ n }}
                    <span v-if="n === 5">+</span>
                </span>

            </div>

            <div style="border-bottom: 1.5px solid #15ba8f; padding: 0.8rem;">
                <div class="categoria">Numero posti letto minimi:</div>
                <span v-for="(n, i) in 5" :key="i" style="margin-right: 20px;">
                    <input v-model="bedsFilter" type="radio" class="available-beds" @change="this.postApartment()"
                        name="available-beds" :value="n" style="scale: 1.5; margin-right: 5px;">
                    {{ n }}
                    <span v-if="n === 5">+</span>
                </span>
            </div>


            <div style="padding: 0.8rem;">
                <label for="km-radius" class="categoria">Distanza massima dal luogo ricercato (km):</label>
                <br>
                <span>1</span>
                <input v-model="kmFilter" type="range" min="1" max="50" class="slider" id="myRange"
                    @change="this.postApartment()" style="margin: 0 10px;">
                <span>50</span>

                <p>km selezionati: <span id="demo" style="font-weight: bold; font-size: 20px;">25</span></p>
            </div>
        </div>

        <div class="col-8" style="overflow-y:scroll; max-height: 700px;">
            <div v-if="store.apartments_filtered.length == 0">
                <div v-for="apartment in store.apartmentsSearch">
                    <div class="card_appartamento d-flex justify-content-between">
                        <div class="col-5">
                            <img style="width: 100%; object-fit: cover;"
                                :src="'http://localhost:8000/storage/uploads/' + apartment.image" alt="immagine">
                        </div>
                        <div class="col-7" style="padding-left: 20px; padding-top: 20px;">
                            <div style="font-weight: bold; font-size: 1.5rem;">{{ apartment.title }}</div>
                            <div style="font-weight: bold; font-size: 0.8rem;"><i class="fa-solid fa-location-dot"
                                    style="margin-right: 10px;"></i>{{
                                        apartment.address }}</div>
                            <div class="d-flex gap-3 flex-wrap" style="margin-top: 10px;">
                                <div v-for="service in apartment.services">
                                    <div class="d-flex align-items-center justify-content-center servizio">
                                        {{ service.name }}
                                    </div>
                                </div>
                            </div>
                            <div class="pulsante_info">
                                <router-link :to="{ name: 'apartment-show', params: { id: apartment.id } }" style="text-decoration: none;">
                                    <span style="color: white; text-decoration: none;">Maggiori informazioni</span> 
                                </router-link>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div v-else>
                <div v-for="apartment in store.apartments_filtered">
                    <div class="card_appartamento d-flex justify-content-between">
                        <div class="col-5">
                            <img style="width: 100%; object-fit: cover;"
                                :src="'http://localhost:8000/storage/uploads/' + apartment.image" alt="immagine">
                        </div>
                        <div class="col-7" style="padding-left: 20px; padding-top: 20px;">
                            <div style="font-weight: bold; font-size: 1.5rem;">{{ apartment.title }}</div>
                            <div style="font-weight: bold; font-size: 0.8rem;"><i class="fa-solid fa-location-dot"
                                    style="margin-right: 10px;"></i>{{
                                        apartment.address }}</div>
                            <div class="d-flex gap-3 flex-wrap" style="margin-top: 10px;">
                                <div v-for="service in apartment.services">
                                    <div class="d-flex align-items-center justify-content-center servizio">
                                        {{ service.name }}
                                    </div>
                                </div>
                            </div>
                            <div class="pulsante_info">
                                <router-link :to="{ name: 'apartment-show', params: { id: apartment.id } }" style="text-decoration: none;">
                                    <span style="color: white; text-decoration: none;">Maggiori informazioni</span>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.categoria {
    margin-bottom: 10px;
}

.card_appartamento {
    background-color: white;
    margin-bottom: 2rem;
    width: 90%;
    border: 1px solid #15ba8f;
    border-radius: 10px;
    height: 320px;
}

img {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    height: 100%;
}

.servizio {
    background-color: #15ba8f;
    border-radius: 10px;
    width: 90px;
    height: 40px;
    text-align: center;
    color: white;
    padding: 0.2rem;
    font-size: 0.7rem;
}

.pulsante_info {
    color: white;
    background-color: #0d233d;
    border-radius: 10px;
    width: 180px;
    padding: 0.5rem;
    text-align: center;
    margin-top: 20px;
    cursor: pointer;
}
</style>

