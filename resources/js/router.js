import { createRouter, createWebHistory } from 'vue-router';

import Register from './components/RegisterPage.vue';
import Login from './components/LoginPage.vue';
import Logout from './components/LogoutPage.vue';
import Header from './components/HeaderPage.vue';
import Userdata from './components/UserdataPage.vue';
import Profile from './components/ProfilePage.vue';

const router = createRouter({
    history: createWebHistory(),
    mode:'history',
    routes: [
      { path: '/register', component: Register },
        { path: '/login', component: Login },
        { path: '/logout', component: Logout },
        { path: '/header', component: Header },
        { path: '/userdata', component: Userdata },
        { path: '/profile', component: Profile },
  ],
});

export default router;
