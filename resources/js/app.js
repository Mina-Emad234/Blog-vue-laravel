import './bootstrap.js';

import {createApp} from 'vue'

import App from './App.vue'

import router from './router/index.js';

import axios from 'axios';

import store from './store/store';

createApp(App).use(router,axios).use(store).mount("#app")
