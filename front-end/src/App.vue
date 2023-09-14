<script>
import { store } from './store.js'
import axios from 'axios'
import AppHelloWorld from './components/AppHelloWorld.vue'
import AppShowApartment from './pages/AppShowApartment.vue'


export default {
  components: {
    AppHelloWorld,
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
      axios.get("http://localhost:8000/auth")
        .then(response => {
          
          console.log(response, "response");
          this.store.user_email = response.data.email;
          this.store.user_name = response.data.name;
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
  <AppHelloWorld />
  <router-view></router-view>
</template>

<style lang="scss">
@use './styles/general.scss' as *;
@use './styles/partials/variables.scss' as *;
@use './styles/partials/mixins.scss' as *;
</style>
