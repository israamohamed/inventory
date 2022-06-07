<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Order Details</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item"><router-link to = "/order">Orders</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Order Details</li>
            </ol>
        </div>

     
        <div class="row">
            <!-- customer details-->
            <div class="col-lg-6 mb-4">
                <!-- Orders -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gradient-info text-white  font-weight-bold">
                       Customer Details
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Name: <b>{{order.customer.name}}</b></li>
                            <li class="list-group-item">Phone: <b>{{order.customer.phone}}</b></li>
                            <li class="list-group-item">Email: <b>{{order.customer.email}}</b></li>
                            <li class="list-group-item">Address: <b>{{order.customer.address}}</b></li>
                            <li class="list-group-item">No Of Orders: <b>{{order.customer.number_of_orders}}</b></li>
                        </ul>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>

            <!-- order details-->
            <div class="col-lg-6 mb-4">
                <!-- Orders -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gradient-info text-white  font-weight-bold">
                       Order Details
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Date: <b>{{order.date}}</b></li>
                            <li class="list-group-item">Price Before Discount: <b>{{order.total_price - order.discount}} EGP</b></li>
                            <li class="list-group-item">Discount: <b>{{order.discount}} EGP</b></li>
                            <li class="list-group-item">Total Price: <b>{{order.total_price}} EGP</b></li>
                            <li class="list-group-item">Notes: <b>{{order.notes}}</b></li>
                        </ul>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- order details-->
            <div class="col-lg-12 mb-4">
                <!-- Orders -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gradient-info text-white font-weight-bold">
                       Items ({{order.total_quantities}})
                    </div>
                    <div class="card-body">
                       <div class="table-responsive" v-if = "show_table">
                            <table class="table align-items-center table-flush">  
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for = "product in order.products">
                                        <td> <img class = "image_style" :src = "product.image_path"> </td>
                                        <td>{{product.name}}</td>
                                        <td>{{product.pivot.quantity}}</td>
                                        <td>{{product.pivot.price}} EGP</td>
                                        <td>{{ parseFloat(product.pivot.price) * parseFloat(product.pivot.quantity) }} EGP</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
</div>
     
</template>

<script>
export default {
    created() {
        this.getOrder();
    },

    mounted() {
    },
    data() {
        return {
            loading: true,
            show_table: true,
            search: '',
            order : {},
        }
    },

    methods : {
        getOrder() {
            let id = this.$route.params.id;

            axios.get('/api/order/' + id)
            .then(res => {
                console.log('hello');
                console.log(res);
               if(res.data.status === 1)
               {
                   this.order = res.data.data;
               }
               this.loading = false;
            })
            .catch(error => {
                this.loading = false;
            });

        },

     
    
    }
}
</script>

<style type="text/css">
.image_style {
    height: 80px;
    width: 80px;
}
</style>