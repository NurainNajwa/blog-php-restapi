<template>
  <div id="app">
    <div class="main-background">
      <NavBar />
      <router-view />
    </div>
  </div>
</template>

<script>
import NavBar from './components/NavBar.vue'

export default {
  name: 'App',
  components: {
    NavBar
  }
}
</script>

<style>
.main-background {
  width: 100%;
  background: linear-gradient(to top, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 50%), url('~@/assets/2.jpg');
  background-position: center;
  background-size: cover;
  height: 100vh;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
  color: #2c3e50;
  /* margin-top: 60px; */
}
</style>
