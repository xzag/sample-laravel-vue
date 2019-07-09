<template>
  <transition name="content">
    <div>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <div class="">

        <form class="form-inline my-2 my-lg-0">
          <button class="btn btn-primary my-2 my-sm-0" type="button" @click="logoutRedirect">Выход</button>
        </form>
      </div>
    </nav>

    <!-- Begin page content -->
    <main role="main" class="container">
        <!-- Dashboard content -->
        <slot></slot>
        <!-- /dashboard content -->
    </main>
    </div>
  </transition>
</template>

<script>
import Vuex from 'vuex'

export default {
  name: 'Layout',
  components: {  },
  props: ['title'],
  data () {
    return {
    }
  },

  computed: {
    ...Vuex.mapGetters(['isLoggedIn'])
  },

  methods: {
    ...Vuex.mapActions(['logout']),

    logoutRedirect() {
        // Force vuex reset with $router.go
        this.logout().then(() => this.$router.go({ name: 'login' }))
    },
  }
}
</script>

<style scoped>
  .container {
    width: auto;
    max-width: 680px;
    padding: 30px 15px;
  }
</style>
