import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from '../App.vue';

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
app.use(router);
app.mount('#app');