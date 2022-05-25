let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let logout = require('./components/auth/logout.vue').default;
let home = require('./components/home.vue').default;

let get_employees = require('./components/employess/index.vue').default;
let create_employee = require('./components/employess/create.vue').default;
let edit_employee = require('./components/employess/edit.vue').default;


export const routes = [
    { path: '/', component: login , name: '/' },
    { path: '/register', component: register , name: '/register' },
    { path: '/logout', component: logout , name: '/logout' },
    { path: '/home', component: home , name: 'home' },
    //employess
    { path: '/employee'        , component: get_employees   , name: 'employee.index' },
    { path: '/employee/create' , component: create_employee , name: 'employee.create' },
    { path: '/employee/edit/:id'   , component: edit_employee , name: 'employee.edit' },
  ]