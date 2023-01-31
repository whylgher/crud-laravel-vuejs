import Swal from 'sweetalert2';
import { createApp } from 'vue';
import './bootstrap';

import router from "./router/index";

import App from "./components/App.vue";

window.Swal = Swal;
const toast = Swal.mixin({
    toast: true,
    position: 'center',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
});

window.toast = toast;

createApp(App).use(router).mount("#app");
