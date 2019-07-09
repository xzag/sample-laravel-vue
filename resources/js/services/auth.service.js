import _BaseHttpService from './baseHttp.service'

class AuthService extends _BaseHttpService {
  constructor () {
    super('auth')
  }

  login (credentials) {
    return this.constructor.post(this.constructor._endpoints(this.__key).login, credentials)
  }
}

export default new AuthService()
