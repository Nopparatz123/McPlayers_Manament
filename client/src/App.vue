<template>
  <Header />
  <router-view />
  <home />
</template>

<script>
import Header from './components/Header.vue'
import home from './components/home.vue'

// const year = new Date().getFullYear();
// console.log(year)ฃ


export default {
  data() {
    return {
      currentYear: new Date().getFullYear(),
    }
  },
  components: {
    Header
  }
}
AOS.init();
</script>
