let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let logout = require('./components/auth/logout.vue').default;
let home = require('./components/home.vue').default;

let get_employees = require('./components/employees/index.vue').default;
let create_employee = require('./components/employees/create.vue').default;
let edit_employee = require('./components/employees/edit.vue').default;

let get_suppliers = require('./components/suppliers/index.vue').default;
let create_supplier = require('./components/suppliers/create.vue').default;
let edit_supplier = require('./components/suppliers/edit.vue').default;

let get_categories = require('./components/categories/index.vue').default;
let create_category = require('./components/categories/create.vue').default;
let edit_category = require('./components/categories/edit.vue').default;



export const routes = [
    { path: '/', component: login , name: '/' },
    { path: '/register', component: register , name: '/register' },
    { path: '/logout', component: logout , name: '/logout' },
    { path: '/home', component: home , name: 'home' },
    //employess
    { path: '/employee'        , component: get_employees   , name: 'employee.index' },
    { path: '/employee/create' , component: create_employee , name: 'employee.create' },
    { path: '/employee/edit/:id'   , component: edit_employee , name: 'employee.edit' },

    //suppliers
    { path: '/supplier'        , component: get_suppliers   , name: 'supplier.index' },
    { path: '/supplier/create' , component: create_supplier , name: 'supplier.create' },
    { path: '/supplier/edit/:id'   , component: edit_supplier , name: 'supplier.edit' },

    //categories
    { path: '/category'        , component: get_categories   , name: 'category.index' },
    { path: '/category/create' , component: create_category , name: 'category.create' },
    { path: '/category/edit/:id'   , component: edit_category , name: 'category.edit' },
  ]