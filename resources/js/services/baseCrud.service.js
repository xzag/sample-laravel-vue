import _BaseHttpService from './baseHttp.service'

class BaseCrudService extends _BaseHttpService {
  constructor (key = null) {
    super(key)
  }

  endpoints () {
    return this.constructor._endpoints(this.__key)
  }

  create (data) {
    return this.constructor.post(this.endpoints().create, data).then(response => response.data)
  }

  update (itemId, data) {
    return this.constructor.put(this.endpoints().update.replace('{:id}', itemId), data).then(response => response.data)
  }

  getList (params) {
    return this.constructor.get(
      this.endpoints().list,
      {}
    ).then(response => response.data)
  }

  delete (itemId) {
    return this.constructor.delete(this.endpoints().update.replace('{:id}', itemId))
  }

  item (itemId) {
    return this.constructor.get(this.endpoints().get.replace('{:id}', itemId), {})
      .then(response => response.data)
      .then(data => data.data)
  }
}

export default BaseCrudService
