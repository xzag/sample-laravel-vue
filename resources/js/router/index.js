import Vue from 'vue'
import Router from 'vue-router'

import PackageRoutes from '@/components/packages/routes'
import Login from '@/components/user/Login'
import store from '@/store'

Vue.use(Router)

const routes = [
  {
    name: 'dashboard',
    path: '/',
    redirect: '/packages',
  },
  {
    path: '/login',
    name: 'login',
    meta: {
      title: 'Login',
      bodyClass: 'text-center login-container'
    },
    component: Login
  },
  ...PackageRoutes,
]

const router = new Router({
  routes: routes,
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(route => route.meta.auth) && !store.getters.isLoggedIn) {
    router.replace({ name: 'login' })
  } else {
    next()
  }
})

export default router
