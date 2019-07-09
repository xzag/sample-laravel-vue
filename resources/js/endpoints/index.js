import Vue from 'vue'

const endpoints = {
  auth: {
    login: 'auth/login',
  },
  package: {
    create: 'packages',
    list: 'packages',
    get: 'packages/{:id}',
    update: 'packages/{:id}',
    calculate: 'packages/calculate'
  }
}


Vue.config.API_BASE_URL = '/api/'

const appendBase = function (list) {
  Object.keys(list).map(key => {
    if (typeof list[key] === 'object') {
      appendBase(list[key])
    } else {
      list[key] = Vue.config.API_BASE_URL + list[key]
    }
  })
}

appendBase(endpoints)

export default endpoints
