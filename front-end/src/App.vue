<script>
import { store } from './store'
import axios from 'axios'
import AppHeader from './components/AppHeader.vue'
import AppShowApartment from './pages/AppShowApartment.vue'


export default {
  components: {
    AppHeader,
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
  },
  created() {
    this.getAuth()
  }
}

</script>

<template>
  <AppHeader />
  <router-view></router-view>
</template>

<style lang="scss">
@use './styles/general.scss' as *;
@use './styles/partials/variables.scss' as *;
@use './styles/partials/mixins.scss' as *;
</style>
