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
  <div class="contenitore">
    <form method="POST" @submit.prevent="$emit('search')" enctype='multipart/form-data' autocomplete="off"
      class="d-flex align-items-center">

      <div class="autocomplete">

        <input onkeydown="return event.key != 'Enter';" type="text" name="address" v-model="store.searched_address"
          id="searchInput" placeholder="Ricerca indirizzo" @input="searchbar()">
        <div :class="['dropdown', isActive ? 'hidden' : '']">
          <div class="suggerimenti" v-for="(suggestion, i) in suggestions" :key="i" @click="changeAddress(suggestion)">
            <span class="address">{{ suggestion.address.freeformAddress }}</span>


          </div>
        </div>
      </div>
      <input class="my-3 bottone-cerca" type="submit" :disabled="this.submit == false" value="Cerca">
    </form>
  </div>
</template>

<style scoped lang="scss">
.contenitore {
  background-color: #15ba8f;
  display: flex;
  justify-content: center;
  align-items: center;
}

#searchInput {
  width: 20rem;
  height: 45px;
  padding-left: 10px;
  border-radius: 20px;
  border: 1px solid black;

}

.autocomplete {

  position: relative;
}

.bottone-cerca {

  margin-left: 3rem;
  padding: 5px 40px;
  border-radius: 40px;
  background-color: #0D233D;
  color: white;
  font-size: 1.3rem;
}

.dropdown {
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  background-color: #fff;

  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  max-height: 150px;
  overflow-y: auto;
  z-index: 999;
  border-radius: 10px;

}

.suggerimenti {
  padding: 2px 0;
  border-bottom: 2px solid black;

  .address {
    margin-left: 5px;
  }

}

.suggerimenti:hover {
  background-color: #15ba8f;
  cursor: pointer;
}
</style>