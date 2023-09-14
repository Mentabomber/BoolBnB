<script>
import { store } from './store.js'
import axios from 'axios'
import AppHelloWorld from './components/AppHelloWorld.vue'


export default {
  components: {
    AppHelloWorld,
  },
  data() {
    return {
      store
    }
  },
  methods: {

  },
  created() {

  }
}
</script>

<template>
  <AppHelloWorld />
</template>

<style lang="scss">
@use './styles/general.scss' as *;
@use './styles/partials/variables.scss' as *;
@use './styles/partials/mixins.scss' as *;
</style>
