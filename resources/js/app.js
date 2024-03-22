import './bootstrap';
import {createApp} from 'vue'

import App from './components/App.vue';
import * as VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import routes from './routes'; 

const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes,
})
const app = createApp(App)
.use(router)
.use(VueAxios, axios)
.mount('#app')