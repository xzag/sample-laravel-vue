<template>
  <layout>
    <h1>Посылки</h1>

    <form class="form-inline" @submit.prevent="submit()">
      <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Город доставки" required="required" v-model="address">

      <button type="button" class="btn btn-info mb-2" @click="calculate()">Рассчитать стоимость</button>
      &nbsp;
      <button type="submit" class="btn btn-success mb-2">Отправить</button>
    </form>

    <div v-if="calculation" class="alert alert-primary" role="alert">
      Расстояние {{calculation.distance}} км. Стоимость доставки: {{calculation.price}} RUB
    </div>

    <div class="list-group" v-if="packages">
      <div v-for="(pack, idx) in packages" :key="idx" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1" v-html="pack.address"></h5>
          <small>{{ pack.created_at }}</small>
        </div>
        <p class="mb-1">{{ pack.price }} RUB</p>
        <div class="input-group-btn">
          <router-link :to="{name: 'package.view', params:{id: pack.id}}" type="button" class="btn btn-primary" >Редактировать</router-link>
          <button type="button" class="btn btn-danger" @click="deletePackage(pack)">
            Удалить
          </button>
        </div>
      </div>
      <overlay v-if="packageHandlingInProgress" :compact="true"></overlay>
    </div>
  </layout>
</template>

<script>
  import Overlay from '@/components/_helpers/Overlay'
  import PackageService from '@/services/package.service'
  import Layout from '@/components/Layout'

  export default {
    name: 'PackageList',
    components: { Overlay, Layout },
    data () {
      return {
        loading: null,
        packageService: new PackageService(),
        packages: [],
        address: null,
        calculation: null
      }
    },

    computed: {
      packageHandlingInProgress () {
				return this.loading
      }
    },

    mounted () {
      this.reset()
    },

    methods: {
      validate () {
        return false
      },

      calculate () {
        if (!this.address) {
          return false
        }
				this.loading = true
        return this.packageService.calculate(this.address).then(data => {
          this.loading = false
          this.calculation = data
        }).catch(error => {
          this.loading = false
          this.$swal('Не удалось рассчитать стоимость')
          throw(error)
        })
      },

      reset () {
        this.loading = true
        this.packageService.getList().then(list => {
          this.packages = list
          this.loading = false
        })
      },

      submit () {
        this.calculate().then(() => {
          this.loading = true
          this.packageService.create({address: this.address}).then(data => {
            this.packages.unshift(data)
            this.loading = false
          }).catch(error => {
            this.loading = false
            this.$swal('Не удалось отправить посылку')
          })
        })
      },

      deletePackage (pack) {
        this.packageService.delete(pack.id).then(() => {
					this.packages = this.packages.filter(p => {
					  return p !== pack
          })
        })
      }
    }
  }
</script>
