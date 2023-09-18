<script>
import { store } from './store'
import axios from 'axios'
import AppHeader from './components/AppHeader.vue'
import AppShowApartment from './pages/AppShowApartment.vue'
import AppFooter from './components/AppFooter.vue'



export default {
  components: {
    AppHeader,
    AppFooter,
    AppShowApartment,
  },
  data() {
    return {
      store
    }
  },
  methods: {
    getAuth() {
      axios.defaults.withCredentials = true;
      axios.get(this.store.local_host + "/auth")
        .then(response => {

          this.store.user_email = response.data.email;
          this.store.user_name = response.data.name.charAt(0).toUpperCase() + response.data.name.slice(1);
          this.store.user_surname = response.data.surname.charAt(0).toUpperCase() + response.data.surname.slice(1);
          axios.defaults.withCredentials = false;
        })
        .catch(err => {
          axios.defaults.withCredentials = false;
        });
    },

    getServices() {
      console.log(this.store.activeFilterServices, 'filtri funzione');
      axios.get(this.store.API_URL + "/services").then(res => {
        this.store.services_list = res.data.services;
        console.log(this.store.services_list, 'servizi');
      })
    }
  },
  created() {
    this.getAuth();
    this.getServices();
  }
}

</script>

<template>
  <AppHeader />
  <router-view></router-view>
  <AppFooter />
</template>

<style lang="scss">
@use './styles/general.scss' as *;
@use './styles/partials/variables.scss' as *;
@use './styles/partials/mixins.scss' as *;

.hidden {
  display: none;
}
</style>
