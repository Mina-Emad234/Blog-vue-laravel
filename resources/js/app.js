import './bootstrap';

import {createApp} from 'vue'

import App from './App.vue'

import router from './router/index.js';

import axios from 'axios';

import store from './store/store';

import LaravelVuePagination from 'laravel-vue-pagination';

createApp(App).use(router,axios).use(store).component('Pagination',LaravelVuePagination).mount("#app")
