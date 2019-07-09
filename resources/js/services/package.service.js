import BaseCrudService from './baseCrud.service'

class PackageService extends BaseCrudService {
  constructor () {
    super('package')
  }

  calculate (address) {
    return this.constructor.post(this.endpoints().calculate, {address: address}).then(response => response.data)
  }
}

export default PackageService
