<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Today Orders</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Today Orders</li>
            </ol>
        </div>

        
        <div class="row">
            <div class="col-md-4">
                <input type="text" v-model="search" @keyup = "searchData" class = "form-control" placeholder="Search ..">
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Today Orders -->
                <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Today Orders</h6>
                    <router-link to = "/pos" class = "btn btn-primary text-white">Add Order</router-link>
                </div>
                <div class="table-responsive" v-if = "show_table">

                    <table class="table align-items-center table-flush">                  
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Discount</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="spinner-border text-primary loading-style text-center" role="status" v-show = "loading">
                                <span class="sr-only">Loading...</span>
                            </div>

                            <tr v-for = "order in orders">
                                <td>{{ order.date }}</td>
                                <td>{{ order.customer.name }}</td>
                                <td>
                                    <span v-if= "order.discount > 0">{{ order.discount }} EGP</span>
                                    <span v-else>--</span>
                                </td>
                                <td>{{ order.total_price }} EGP</td>
                                <td>
                                    <router-link :to = "{name: 'order.show' , params: {id : order.id} }" class="btn btn-warning"><i class="fas fa-eye"></i></router-link>
                                    <!-- <router-link :to = "{name: 'order.edit' , params: {id : order.id} }" class="btn btn-info"><i class="fas fa-edit"></i></router-link>

                                    <button class="btn btn-danger" @click = "deleteRecord(order.id)" ><i class="fas fa-trash"></i></button> -->
                                </td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>

                <div v-if = "!show_table">
                    <p class = "text-danger text-center">No Orders Created Today</p>
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
        this.getOrders();
    },

    mounted() {
    },
    data() {
        return {
            loading: true,
            show_table: true,
            search: '',
            date: '',
            orders : [],
        }
    },

    methods : {
        getOrders() {
            let data = {params : {'search' : this.search , 'today_orders' : true} };

            axios.get('/api/order' , data)
            .then(res => {
                this.orders = res.data.data;
                if(this.orders.length < 1 )
                {
                    this.show_table = false;
                }
                this.loading = false;
            })
            .catch(error => {
                this.loading = false;
            });

        },

        searchData() {
            this.show_table = true;
            this.getOrders();
        },

        deleteRecord(id) {
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {

                axios.delete('/api/order/' + id)
                    .then(res => {
                        if(res.data.status === 1) {

                            this.orders = this.orders.filter(order => {
                                    return order.id != id;
                                });
                            this.show_table = this.orders.length > 0 ? true : false;
                            Swal.fire(
                                'Deleted!',
                                res.data.message,
                                'success'
                            )
                            
                            
                        }
                         

                    })
                    .catch(err => {

                    })
                
               
            }
            })

        }
    }
}
</script>

<style type="text/css">
.image_style {
    height: 80px;
    width: 80px;
}
</style>