import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from '../App.vue';

const routes = [
  { path: '/', component: () => import('../components/Home.vue') },
  { path: '/about', component: () => import('../components/About.vue') },
  { path: '/hooks', component: () => import('../components/base/Hooks.vue') },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const app = createApp(App);
app.use(router);
app.mount('#app');