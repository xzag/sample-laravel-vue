import Vue from 'vue'
import BaseService from './base.service'

class BaseHttpService extends BaseService {
  constructor (key = null) {
    super()
    this.__key = key || ''
  }

  static _http () {
    return window.axios
  }

  static _endpoints (key = null) {
    if (key) {
      return Vue.config.endpoints[key] || {}
    }
    return {}
  }

  static get (url, params) {
    return BaseHttpService._http().get(url, params)
  }

  static post (url, data) {
    return BaseHttpService._http().post(url, data)
  }

  static put (url, data, ...callbacks) {
    return BaseHttpService._http().put(url, data)
  }

  static patch (url, data, ...callbacks) {
    return BaseHttpService._http().patch(url, data)
  }

  static delete (url, ...callbacks) {
    return BaseHttpService._http().delete(url, {})
  }
}

export default BaseHttpService
