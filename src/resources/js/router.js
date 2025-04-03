import { createMemoryHistory, createRouter } from 'vue-router'

import HomeView from './components/HomeView.vue'
import GetByIdView from './components/GetByIdView.vue'
import RandomView from './components/RandomView.vue'

const routes = [
  { path: '/', component: HomeView },
  { path: '/get-by-id/:id?', component: GetByIdView },
  { path: '/random', component: RandomView },
]

const router = createRouter({
  history: createMemoryHistory(),
  routes,
})

export default router;
