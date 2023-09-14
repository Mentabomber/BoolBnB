<script>
import { store } from "../store"
import axios from 'axios'

export default {
  name: "AppHelloWorld",
  data(){
    return{
      store
    }
  }
}

</script>

<template>
  <h1>HEADER</h1>

  <a href="http://localhost:8000/login" >Accedi</a>
  
  <br>
  <a href="http://127.0.0.1:8000/register">Registrati</a>
</template>

<style scoped lang="scss">
@use '../styles/partials/variables.scss' as *;
@use '../styles/partials/mixins.scss' as *;
</style>
