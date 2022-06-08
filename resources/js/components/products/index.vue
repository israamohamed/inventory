<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Products</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Products</li>
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
                <!-- Products -->
                <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Products</h6>
                    <router-link to = "/product/create" class = "btn btn-primary text-white">Add Product</router-link>
                </div>
                <div class="table-responsive" v-if = "show_table">

                    <table class="table align-items-center table-flush">                  
                        <thead class="thead-light">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Category</th>  
                                <th>Selling Price</th>
                                <th>Buying Price</th>
                              
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="spinner-border text-primary loading-style text-center" role="status" v-show = "loading">
                                <span class="sr-only">Loading...</span>
                            </div>

                            <tr v-for = "product in products">
                                <td> <img :src="product.image_path" class = "image_style"> </td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.code }}</td>
                                <td>{{ product.category ? product.category.name : '' }}</td>
                                <td>{{ product.selling_price }} EGP</td>
                                <td>{{ product.buying_price }} EGP</td>
                               
                                <td>
                                    <router-link :to = "{name: 'product.edit' , params: {id : product.id} }" class="btn btn-info"><i class="fas fa-edit"></i></router-link>

                                    <button class="btn btn-danger" @click = "deleteRecord(product.id)" ><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>

                <div v-if = "!show_table">
                    <p class = "text-danger text-center">No Products Data</p>
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
        this.getProducts();
    },

    mounted() {
    },
    data() {
        return {
            loading: true,
            show_table: true,
            search: '',
            products : [],
        }
    },

    methods : {
        getProducts() {
            let data = {params : {'search' : this.search } };

            axios.get('api/product' , data)
            .then(res => {
                this.products = res.data.data;
                if(this.products.length < 1 )
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
            this.getProducts();
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

                axios.delete('/api/product/' + id)
                    .then(res => {
                        if(res.data.status == 0 && res.data.message == "unauthenticated")
                        {
                            this.$router.push({name : '/'})
                        }
                        else if(res.data.status === 1) {

                            this.products = this.products.filter(product => {
                                    return product.id != id;
                                });
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