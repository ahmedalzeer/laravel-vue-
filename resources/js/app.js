
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import moment from 'moment'
import { Form, HasError, AlertError } from 'vform'
import VueAgile from 'vue-agile'
Vue.use(VueAgile)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'))

import Gate from './Gate'
Vue.prototype.$gate = new Gate(window.user)

import swal from 'sweetalert2'
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000
});
window.toast = toast;

window.Form = Form;
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
})

let routes = [
    { path: '/developer', component: require('./components/Developer.vue') },
    { path: '/dashboard', component: require('./components/Dashboard.vue') },
    { path: '/profile', component: require('./components/Profile.vue') },
    { path: '/user', component: require('./components/Users.vue') },
    { path: '/category', component: require('./components/Category.vue') },
    { path: '/item', component: require('./components/Item.vue') },
    { path: '/sale', component: require('./components/Sale.vue') },
    { path: '/buy', component: require('./components/Buy.vue') },
    { path: '/sreport', component: require('./components/Sreport.vue') },
    { path: '/breport', component: require('./components/Breport.vue') },
    { path: '/outlay', component: require('./components/Outlay.vue') },
    { path: '/login', component: require('./components/Login.vue') },
    { path: '/register', component: require('./components/Register.vue') },
    { path: '*', component: require('./components/NotFound.vue') },
]
const router = new VueRouter({
    mode :'history',
    routes // short for `routes: routes`
})
Vue.filter('uptext',function(te){
    return te.charAt(0).toUpperCase()+te.slice(1)
})
Vue.filter('mydate',function(text){
    return moment(text).format('L')
})

window.fire = new Vue()
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);
Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);
Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);
Vue.component(
    'not-found',
    require('./components/NotFound.vue')
);
const app = new Vue({
    el: '#app',
    router,
    data:{
        item:false,
        search:'',
    },
    methods:{
        searchit: _.debounce(()=>{
            fire.$emit('searching')
        },1000)
    }
});
