import filesData from '@/data/files'
import moment from 'moment'

class FileService {
  constructor () {
    this.files = filesData
    this.files.forEach(file => {
      file.isPending = false
    })
  }

  /**
   * Fake fetch
   *
   * @returns {Promise<any>}
   */
  fetchFiles (filter) {
    filter = filter || {}
    return new Promise((resolve) => {
      setTimeout(() => {
        let files = this.files
        if (filter) {
          files = files.filter(file => {
            if (filter.type && filter.type.toLowerCase() !== file.type.toLowerCase()) {
              return false
            }

            if (filter.from && moment(file.created_at).isBefore(moment(filter.from), 'day')) {
              return false
            }

            if (filter.to && moment(file.created_at).isAfter(moment(filter.to), 'day')) {
              return false
            }

            return true
          })
        }

        resolve(files)
      }, 2000)
    })
  }

  addFile (file) {
    return new Promise((resolve) => {
      this.files.unshift(file)
      resolve()
    })
  }

  /**
   * Fake delete
   *
   * @param file
   * @returns {Promise<any>}
   */
  deleteFile (file) {
    return new Promise((resolve) => {
      setTimeout(() => {
        this.files = this.files.filter(f => {
          return f !== file
        })

        resolve(this.files)
      }, 500)
    })
  }

}

const service = FileService
export default service
