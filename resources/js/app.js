import './bootstrap';

import VCalendar from 'v-calendar';
import 'v-calendar/style.css';
// import Vue from 'vue/dist/vue.esm.browser';
import 'vue-loaders/dist/vue-loaders.css';
import VueLoaders from 'vue-loaders';


import { createApp } from 'vue/dist/vue.esm-bundler.js';
import Exemple from "./components/Exemple.vue"
import Chrono from "./components/Chrono.vue"

const app = createApp({
    components:{
        Exemple,
        Chrono,
    }
});
// console.log(VueLoaders);
app.use(VCalendar,VueLoaders).mount("#app")
