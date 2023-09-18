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
  <h1>Ricerca avanzata</h1>

  <AppSearchbar @search="postApartment" />

  <label for="km-radius">Raggio Kilometri</label>
  <input v-model="kmFilter" type="range" min="1" max="50" class="slider" id="myRange" @change="this.postApartment()">

  <p>Km: <span id="demo">25</span></p>
  <br>

  <h3>Letti disponibili</h3>

  <div>
    <span v-for="(n, i) in 5" :key="i">
      <input v-model="bedsFilter" type="radio" class="available-beds" @change="this.postApartment()" name="available-beds"
        :value="n">
      {{ n }}
      <span v-if="n === 5">+</span>
    </span>
  </div>

  <h3>Stanze Disponibili</h3>

  <div>
    <span v-for="(n, i) in 5" :key="i">
      <input v-model="roomsFilter" type="radio" class="available-rooms" @change="this.postApartment()"
        name="available-rooms" :value="n">
      {{ n }}
      <span v-if="n === 5">+</span>
    </span>
  </div>


  <h3>Servizi Disponibili</h3>
  <div>
    <div v-for="(service, i) in this.store.services_list" class="form-check" style="max-width: 300px">
      <input v-model="this.store.activeFilterServices" class="form-check-input" type="checkbox" :value="service.id"
        name="services[]" :id="service.id" :key="i" @change="this.postApartment()">

      <label class=" form-check-label" :for="service.id">
        {{ service.name }}
      </label>
    </div>
  </div>
  <br>

  {{ store.searched_address }}
  <div v-if="store.apartments_filtered.length == 0">
    <div v-for="apartment in store.apartmentsSearch">
      <img :src="'http://localhost:8000/storage/uploads/' + apartment.image" alt="immagine">
      {{ apartment.title }}
      stanze:{{ apartment.rooms }}
      letti: {{ apartment.beds }}
    </div>
  </div>
  <div v-else>
    <div v-for="apartment in store.apartments_filtered">
      <img :src="'http://localhost:8000/storage/uploads/' + apartment.image" alt="immagine">
      {{ apartment.title }}
      stanze:{{ apartment.rooms }}
      letti: {{ apartment.beds }}

    </div>
  </div>
</template>

