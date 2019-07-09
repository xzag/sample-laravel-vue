<template>
  <layout>
    <h1>Редактирование посылки</h1>

    <form class="form-inline" @submit.prevent="submit()">
      <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Город доставки" required="required" v-model="address">

      <button type="submit" class="btn btn-success mb-2">Обновить</button>
    </form>

    <div v-if="calculation" class="alert alert-primary" role="alert">
      Расстояние {{calculation.distance}} км. Стоимость доставки: {{calculation.price}} RUB
    </div>

    <div class="list-group" v-if="pack">
      <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1" v-html="pack.address"></h5>
          <small>{{ pack.created_at }}</small>
        </div>
        <p class="mb-1">{{ pack.price }} RUB</p>
      </div>
    </div>
  </layout>
</template>

<script>
	import PackageService from '@/services/package.service'
	import Layout from '@/components/Layout'

	export default {
		name: 'PackageView',
		components: { Layout },
		data () {
			return {
				id: null,
				loading: null,
				packageService: new PackageService(),
				pack: null,
				address: null,
				calculation: null
			}
		},

		computed: {

		},

		mounted () {
			this.id = this.$route.params.id
			this.packageService.item(this.id).then(data => {
				console.log(data)
				this.pack = data
        this.address = data.address || null
			}).catch(error => {
				this.$swal('Посылка не найдена')
				throw(error)
      })
		},

		methods: {
			calculate () {
				if (!this.address) {
					return false
				}
				return this.packageService.calculate(this.address).then(data => {
					this.calculation = data
				}).catch(error => {
					this.$swal('Не удалось рассчитать стоимость')
					throw(error)
				})
			},

			submit () {
				this.calculate().then(() => {
					this.packageService.update(this.pack.id, {address: this.address}).then(data => {
						this.$router.push({ name: 'packages' })
					}).catch(error => {
						this.$swal('Не удалось обновить посылку')
					})
				})
			},

		}
	}
</script>
