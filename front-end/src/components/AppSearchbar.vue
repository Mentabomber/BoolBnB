<script>
import { store } from "../store"
import axios from 'axios';

export default {
  name: "AppSearchBar",
  data() {
    return {
      store,
      suggestions: [],
      isActive: false,
      submit: false,
      data: {
        latitude: store.searched_latitude,
        longitude: store.searched_longitude
      },
    }
  },
  methods: {

    // Aspetta che l'utente inserisca un valore nella ricerca ed effettua una chiamata axios per restituire eventuali suggerimenti simili all'input dell'utente
    async searchbar() {
      this.suggestions = [];
      this.isActive = false;
      try {
        const response = await axios.get("https://api.tomtom.com/search/2/search/" + this.store.searched_address + ".json?key=tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1&countrySet=IT");
        response.data.results.forEach(addresses => {

          // Si assicura che i suggerimenti presenti siano massimo 10

          if (this.suggestions.length >= 10) {
            this.suggestions.splice(0, 1);
            this.suggestions.push(addresses);
          } else {
            this.suggestions.push(addresses);
          }
        });
      } catch (error) {
        console.error(error);
      }
    },

    // Imposta l'indirizzo selezionato trai i suggestions  nell'input e salva i sui dati di latitudine e longitudine nello store

    changeAddress(suggestion) {

      // Controlla che l'indirizzo presente nell'input di ricerca sia un indirizzo presente nei suggestions

      this.suggestions.forEach(address => {
        if (address.id == suggestion.id) {

          this.submit = true;
        }
      });

      // Nasconde il div contenente i suggerimenti

      this.isActive = true;
      this.store.searched_latitude = suggestion.position.lat;
      this.store.searched_longitude = suggestion.position.lon;
      this.store.searched_address = suggestion.address.freeformAddress;
    },


    // Reinderizza l'utente alla pagina di ricerca avanzata

    onSubmit() {
      this.$router.push({ name: "advanced-search" });
      this.postApartment();
    },

  },
  mounted() {

  }

}

</script>

<template>
  <form method="POST" @submit.prevent="$emit('search')" enctype='multipart/form-data' autocomplete="off">

    <div class="autocomplete">
      <label for="address">Indirizzo</label>
      <input onkeydown="return event.key != 'Enter';" type="text" name="address" v-model="store.searched_address"
        id="searchInput" placeholder="Cerca indirizzo" @input="searchbar()">

    </div>
    <div :class="[isActive ? 'hidden' : '']">
      <span v-for="(suggestion, i) in suggestions" :key="i" @click="changeAddress(suggestion)">
        {{ suggestion.address.freeformAddress }}
        <br>
      </span>
    </div>
    <router-link :to="{name: 'advanced-search'}">
      <input class="my-3" type="submit" :disabled="this.submit == false" value="Cerca">
    </router-link>
    
  </form>
</template>
