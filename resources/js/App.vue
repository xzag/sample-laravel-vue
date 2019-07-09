<template>
  <router-view></router-view>
</template>

<script>
  import Vue from 'vue'
  import Layout from '@/components/Layout'
  import vbclass from 'vue-body-class'
  import router from '@/router'

  Vue.use( vbclass, router )

  export default {
    name: 'app',
    components: { Layout },

    mounted () {
      // this.$router.push('/packages')
    }
  }
</script>

<style>
  #app {
    font-family: 'Roboto', Helvetica, Arial, sans-serif;
  }

  html, body {
    height: 100%;
  }

  body {
    padding-top: 50px;
  }
</style>
