import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from '../App.vue';
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
const routes = [
  { path: '/', component: () => import('../pages/Dashboard.vue') },
  { path: '/tags', component: () => import('../pages/Tags.vue') },
  { path: '/hooks', component: () => import('../components/base/Hooks.vue') },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const app = createApp(App);
const options = {
  position: 'top-right',
  timeout: 3000,
  closeOnClick: true,
  pauseOnHover: true,
}
app.use(Toast, options)
app.use(router);
app.mount('#app');