
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';

import Swal from 'sweetalert2';
window.Swal = Swal;
const toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.toast = toast;

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})

// ElementUi
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/pt-br'
Vue.use(ElementUI, { locale })
Vue.use(ElementUI)
// Mask
import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)


// FILTROS
Vue.filter('capitalize', function(value){
  return value.charAt(0).toUpperCase()+value.slice(1);
});
Vue.filter('myDate', function(value){
  return moment(value).subtract(10, 'days').calendar();
});
Vue.filter('upperCase', function(value){
  return value.toUpperCase();
});

// ROTAS
let routes = [
  { path: '/home', component: require('./components/Home.vue') },
  { path: '/sensor', component: require('./components/Sensor.vue') },
  { path: '/sensor_clima', name: 'sensor_clima', component: require('./components/SensorClima.vue') },
  { path: '/dashboard', component: require('./components/Dashboard.vue') },
  { path: '/profile', component: require('./components/Profile.vue') },
  { path: '/users', component: require('./components/Users.vue') },
  { path: '/experimento', name: 'experimento', component: require('./components/Experimento.vue'), props: true },

  { path: '/experimentos', name: 'experimentos', component: require('./components/Experimentos.vue'),
    children:[
      { path: 'detalhes', name: 'experimento-detalhes', component: require('./components/Experimento.vue') },
    ] 
  },

  { path: '*', component: require('./components/Error404.vue') }
]

const router = new VueRouter({
	mode: 'history',
  	routes // short for `routes: routes`
})

window.Fire = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
