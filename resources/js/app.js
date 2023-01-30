import './bootstrap';

import { createApp } from 'vue';

import router from "./router/index";

import App from "./components/App.vue";

createApp(App).use(router).mount("#app")
