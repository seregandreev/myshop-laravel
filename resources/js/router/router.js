import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import CategoriesPage from '../pages/CategoriesPage'
import CategoryProductsPage from '../pages/CategoryProductsPage'

const Component404 = { template: '<div>Страница не найдена</div>' }

const routes = [
    { path: '*', component: Component404 },
    { path: '/', component: CategoriesPage },
    { path: '/category/:id', component: CategoryProductsPage },
  ]

  const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })

  export default router