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

let get_products = require('./components/products/index.vue').default;
let create_product = require('./components/products/create.vue').default;
let edit_product = require('./components/products/edit.vue').default;

let get_expenses = require('./components/expenses/index.vue').default;
let create_expense = require('./components/expenses/create.vue').default;
let edit_expense = require('./components/expenses/edit.vue').default;

let get_employees_for_salaries = require('./components/salaries/get_employees.vue').default;
let pay_salary = require('./components/salaries/pay_salary.vue').default;
let get_salaries = require('./components/salaries/index.vue').default;
let edit_salary = require('./components/salaries/edit.vue').default;

let get_customers = require('./components/customers/index.vue').default;
let create_customer = require('./components/customers/create.vue').default;
let edit_customer = require('./components/customers/edit.vue').default;

let pos = require('./components/pos/index.vue').default;

let get_orders = require('./components/orders/index.vue').default;
let get_today_orders = require('./components/orders/today_orders.vue').default;
let create_order = require('./components/orders/create.vue').default;
let edit_order = require('./components/orders/edit.vue').default;
let show_order = require('./components/orders/show.vue').default;


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

    //products
    { path: '/product'        , component: get_products   , name: 'product.index' },
    { path: '/product/create' , component: create_product , name: 'product.create' },
    { path: '/product/edit/:id'   , component: edit_product , name: 'product.edit' },

    //expenses
    { path: '/expense'        , component: get_expenses   , name: 'expense.index' },
    { path: '/expense/create' , component: create_expense , name: 'expense.create' },
    { path: '/expense/edit/:id'   , component: edit_expense , name: 'expense.edit' },

    //salaries
    { path: '/salary/get_employees' , component: get_employees_for_salaries, name: 'salary.get_employees' },
    { path: '/salary/pay_salary/:id'  , component: pay_salary, name: 'salary.pay_salary'},
    { path: '/salary'  , component: get_salaries, name: 'salary.index'},
    { path: '/salary/edit/:id'   , component: edit_salary , name: 'salary.edit' },


    //customers
    { path: '/customer'        , component: get_customers   , name: 'customer.index' },
    { path: '/customer/create' , component: create_customer , name: 'customer.create' },
    { path: '/customer/edit/:id'   , component: edit_customer , name: 'customer.edit' },

    //pos
    { path: '/pos'        , component: pos   , name: 'pos.index' },

    //orders
    { path: '/order'         , component: get_orders         , name: 'order.index' },
    { path: '/today_orders'  , component: get_today_orders   , name: 'today_orders' },
    { path: '/order/create'  , component: create_order       , name: 'order.create' },
    { path: '/order/edit/:id', component: edit_order         , name: 'order.edit' },
    { path: '/order/show/:id', component: show_order         , name: 'order.show' },
  ]