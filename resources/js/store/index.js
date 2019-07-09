import Vue from 'vue'
import Vuex from 'vuex'

const LOGIN = 'LOGIN'
const LOGIN_SUCCESS = 'LOGIN_SUCCESS'
const LOGOUT = 'LOGOUT'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    isLoggedIn: localStorage.getItem('token'),
  },
  mutations: {
    [LOGIN] (state) {
      state.pending = true
    },
    [LOGIN_SUCCESS] (state) {
      state.isLoggedIn = true

    },
    [LOGOUT] (state) {
      state.isLoggedIn = false
    },

  },
  actions: {
    login ({
      state,
      commit,
      rootState
    }, data) {
      commit(LOGIN) // show spinner
      localStorage.setItem('token', data.token)

      return this.dispatch('setAuthHeader').then(() => {
        commit(LOGIN_SUCCESS)
      })
    },

    logout ({
      commit
    }) {
      return new Promise((resolve) => {
        localStorage.removeItem('token')
        commit(LOGOUT)
        resolve()
      })
    },

    isLogged ({
      commit
    }) {
      if (!localStorage.getItem('token')) {
        commit(LOGOUT)
      }

      return this.state.isLoggedIn
    },

    checkAuth () {
      if (this.state.isLoggedIn) {
        return this.dispatch('setAuthHeader')
      }
    },

    setAuthHeader () {
      return this.dispatch('getAuthHeader').then(headers => {
        console.log(headers)
        window.axios.defaults.headers.common['Authorization'] = headers['Authorization']
      })
    },

    getAuthHeader () {
      return {
        'Authorization': 'Bearer ' + localStorage.getItem('token')
      }
    },


  },
  getters: {
    isLoggedIn: state => {
      return state.isLoggedIn
    },


  }
})

export default store
