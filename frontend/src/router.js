import { createRouter, createWebHistory } from 'vue-router'
import DefaultLayout from './components/DefaultLayout.vue'
import Home from './pages/Home.vue'
import Images from './pages/Images.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import NotFound from './pages/NotFound.vue'
const routes = [
  {
  path: '/',
  component:  DefaultLayout,
  children: [ 
    {path: '/', name: 'Home', component: Home},
    {path: '/images', name: 'Images', component: Images},
  ]
  },
  { path: '/login', name: 'Login', component: Login},
  { path: '/register', name: 'Register', component: Register},
  { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound}
];
const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {

    const token = localStorage.getItem('token')

    if (to.meta.requiresAuth && !token) {
        next('/login')
    } else {
        next()
    }

})

export default router