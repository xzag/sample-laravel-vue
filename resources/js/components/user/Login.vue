<template>
  <form class="form-signin" @submit.prevent="login()">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus v-model="email">
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required v-model="password">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <div v-if="response" class="text-red">{{response}}</div>
  </form>
</template>

<script>
import AuthService from '@/services/auth.service'

export default {
  name: 'Login',
  data () {
    return {
      email: 'demo@example.com',
      password: '123qwe',
      loading: '',
      response: ''
    }
  },
  created () {
    if (this.$store.getters.isLoggedIn) {
      this.$router.replace({ name: 'dashboard' })
    } else {
    }
  },

  methods: {
    toggleLoading: function () {
      this.loading = (this.loading === '') ? 'loading' : ''
    },
    resetResponse: function () {
      this.response = ''
    },
    login () {
      AuthService.login({
        email: this.email,
        password: this.password
      }).then(response => {
        this.$store.dispatch('login', response.data).then(() => {
          this.$router.push('/')
        })
      }).catch(error => {
        this.$swal({type: 'warning', text: 'Произошла ошибка. Проверьте введенные данные'})
      })
    }
  }
}
</script>

<style>
  .login-container {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
    height: 100%;
  }
</style>

<style scoped>


  .form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: auto;
  }
  .form-signin .checkbox {
    font-weight: 400;
  }
  .form-signin .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
  }
  .form-signin .form-control:focus {
    z-index: 2;
  }
  .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }
  .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }
</style>
