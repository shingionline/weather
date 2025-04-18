require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';

// register components
const requireComponent = require.context('./components', true, /\.vue$/);

requireComponent.keys().forEach(fileName => {
    const componentConfig = requireComponent(fileName);
    const componentName = fileName
        .split('/')
        .pop()
        .replace(/\.\w+$/, '');
    Vue.component(componentName, componentConfig.default || componentConfig);
});

Vue.use(require('vue-moment'));

import { BootstrapVue } from 'bootstrap-vue'
Vue.use(BootstrapVue)

import VueTimeago from 'vue-timeago'
Vue.use(VueTimeago, {
    name: 'Timeago', 
    locale: 'en',
    converter(date, locale, { includeSeconds, addSuffix = true }) {
        const distanceInWordsStrict = require('date-fns/distance_in_words_strict')
        return distanceInWordsStrict(Date.now(), date, { locale, addSuffix, includeSeconds });
    } });

import swal from 'sweetalert2';
window.Swal = swal;

import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
Vue.use(Toaster, {timeout: 7000});

import vSelect from "vue-select";
Vue.component("v-select", vSelect);

Vue.mixin({
    methods: {
        
      }
});

new Vue({
    el: '#app',
});

