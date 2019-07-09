import PackageList from './List'
import PackageView from './View'

export default [
  {
    path: '/packages',
    name: 'packages',
    component: PackageList,
    meta: {
      auth: true
    },
  },
  {
    path: '/packages/:id',
    name: 'package.view',
    component: PackageView,
    meta: {
      auth:true
    }
  }
]
