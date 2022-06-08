/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import {routes} from './routes' ;
const router = new VueRouter({
    routes, // short for `routes: routes`,
    mode: 'history'
})

import Swal from 'sweetalert2' ;
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

window.Toast = Toast;


import Notification from './Helpers/Notification';
window.Notification = Notification

window.jQuery = window.$ = require('jquery');
require('select2');



const app = new Vue({
    el: '#app',
    data: {

    },
    created() {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
    },
    /*computed : {

        is_auth : function() {
            return localStorage.getItem('token') ? true : false;
        }
    },*/
    methods: {
        is_auth : function() {
            return localStorage.getItem('token') ? true : false;
        }
    },
    router
});
