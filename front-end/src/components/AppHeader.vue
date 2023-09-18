<script>
import { store } from "../store"

export default {
  name: "AppHeader",
  data() {
    return {
      store
    }
  },

}

</script>

<template>
<header>
    <div class="container-fluid">
        <div class="row d-flex align-items-center justify-content-between">
            <div class="col-4"  id="title"><h2>BoolBnB</h2></div>
            <a class="col-1 text-center" href="http://localhost:5174/">Home</a>
            <div v-if="this.store.user_name === 'undefined' || this.store.user_name == null" class="col-3 d-flex gap-5 text-center">
              <a class="col-2" href="http://localhost:8000/login">Login</a>
              <a  class="col-2" href="http://127.0.0.1:8000/register">Signup</a>
            </div>
            <div v-else class="col-3 text-center">
              <a href="http://127.0.0.1:8000/dashboard">{{ this.store.user_name }}</a>
            </div>
        </div>
    </div>
</header>

</template>

<style scoped lang="scss">
@use '../styles/partials/variables.scss' as *;
@use '../styles/partials/mixins.scss' as *;

header {
  background-color: white;
}
.container-fluid {
  
  height: 100px;
  border-bottom: 4px solid black;
  text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.3);
  

  .row {
    height: 100%;
    width: 90%;
   
    margin: 0 auto;

   h2 {
    color : $colore_primario;
    font-size: 50px;
    
   }

   a {
    text-decoration: none;
    color: inherit;
    font-weight: bold;
    font-size: 25px

   

   }

   a:hover {
    color: $colore_primario;
   }
  }

  

}
</style>
