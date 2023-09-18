<script>
import { store } from "../store"

export default {
  name: "AppFooter",
  data() {
    return {
      store
    }
  },

}

</script>

<template>
    <footer>
        <div class="container-fluid text-align-center">
            <div class="row text-center">
                <div class="col-12" id="title"><h2>BoolBnB</h2></div>
            </div>
            <div class="row text-center d-flex justify-content-between text-center" id="name">
                <div class="col-2">
                    <div class="name">Alessandro Belfiore</div>
                    <div class="profile-links">
                        <div><a href="https://www.linkedin.com/in/alessandro-belfiore-695a5328a/">LinkedIn <i class="fa-brands fa-linkedin"></i> </a></div>
                        <div><a href="https://github.com/Alecpu92">GitHub <i class="fa-brands fa-github"></i></a></div>
                    </div>
                </div>
                
                <div class="col-2">
                    <div class="name">Daniele Corrado</div>
                    <div class="profile-links">
                        <div><a href="https://www.linkedin.com/in/daniele-corrado-7217b628a/">LinkedIn <i class="fa-brands fa-linkedin"></i> </a></div>
                        <div><a href="https://github.com/DanieleCorrado">GitHub <i class="fa-brands fa-github"></i></a></div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="name">Fabio di Giacomo Pepe</div>
                    <div class="profile-links">
                        <div><a href="https://www.linkedin.com/in/fabio-di-giacomo-pepe">LinkedIn <i class="fa-brands fa-linkedin"></i> </a></div>
                        <div><a href="https://github.com/fabiodigiacomopepe">GitHub <i class="fa-brands fa-github"></i></a></div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="name">Tilen Simcic</div>
                    <div class="profile-links">
                        <div><a href="https://www.linkedin.com/in/tilen-simcic-043419265/">LinkedIn <i class="fa-brands fa-linkedin"></i> </a></div>
                        <div><a href="https://github.com/Mentabomber">GitHub <i class="fa-brands fa-github"></i></a></div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="name">Antonino Troìa</div>
                    <div class="profile-links">
                        <div><a href="https://www.linkedin.com/in/antonino-troia-140884207">LinkedIn <i class="fa-brands fa-linkedin"></i> </a></div>
                        <div><a href="https://github.com/Ninotro">GitHub <i class="fa-brands fa-github"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    </template>

<style scoped lang="scss">
@use '../styles/partials/variables.scss' as *;
@use '../styles/partials/mixins.scss' as *;

.container-fluid {
  
  height: 250px;
  color: white;
  
  background-color: #0D233D;
  border-bottom: 4px solid black;
  text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.4);
  font-size: 20px;
  

  .row {
    
    width: 90%;
    padding-top: 20px;
    margin: 0 auto;
    font-weight: bold;
    

   h2 {
    color : $colore_primario;
    font-size: 50px;
    
   }

   a {
    text-decoration: none;
    color: inherit;
    
    font-size: 18px
   }
   
  

  }
  
 
}
</style>
