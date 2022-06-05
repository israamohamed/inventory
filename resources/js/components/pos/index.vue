<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">POS</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">POS</li>
            </ol>
        </div>

  
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Pos -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Pos</h6>
                    </div>

                    <div class = "card-body">

                        <div class="row">
                            <!-- table -->
                            <div class = "col-md-5">

                            </div>

                            <!-- products-->
                             <div class = "col-md-7">
                                 <!-- nav tabs -->
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Products</button>
                                    </li>
                                    <li class="nav-item" role="presentation" v-for = "category in categories">
                                        <button class="nav-link" :id="'category_tab' + category.id" data-bs-toggle="tab" :data-bs-target="'#category' + category.id" type="button" role="tab" aria-controls="profile" aria-selected="false">{{ category.name}}</button>
                                    </li>
                                </ul>
                                <!-- tab content -->
                                <div class="tab-content" id="myTabContent">
                                    <!-- all products tab-->
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                         <!-- search -->
                                        <input type="text" v-model = "search" class = "form-control mb-1" @keyup = "searchData" placeholder="Search">

                                        <div class="row products_section">
                                            <div v-for = "product in products" class="col-lg-3 col-md-6 mb-2">
                                                <div class="card p-1">
                                                    <img class="card-img-top product-image" :src="product.image_path">
                                                    <div class="card-body" style = "padding:0">
                                                        <h6 class="card-title">{{product.name}}</h6>     
                                                        <span class = "badge badge-success" v-if = "product.quantity > 0">Available {{product.quantity}}</span>      
                                                        <span class = "badge badge-danger" v-else>Out Of Stock</span>                  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- category products -->
                                    <div  v-for = "category in categories" class="tab-pane fade mt-3" :id="'category' + category.id" role="tabpanel" :aria-labelledby = " 'category_tab' + category.id">
                                         <!-- search -->
                                        <!-- <input type="text" v-model = "search" class = "form-control mb-1" @keyup = "searchData" placeholder="Search"> -->
                                        <div class="row products_section">
                                            <div v-for = "product in category.products" class="col-lg-3 col-md-6 mb-2">
                                                <div class="card p-1">
                                                  
                                                    <img class="card-img-top product-image" :src="product.image_path">
                                                    <div class="card-body" style = "padding:0">
                                                        <h6 class="card-title">{{product.name}}</h6>
                                                        <span class = "badge badge-success" v-if = "product.quantity > 0">Available {{product.quantity}}</span>      
                                                        <span class = "badge badge-danger" v-else>Out Of Stock</span>   
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                               
                            </div>
                        </div>
                    </div>
              
           
                </div>
            </div>
    </div>
</div>
     
</template>

<script>
export default {
    created() {
        this.getProducts();
        this.getCategories();
    },

    mounted() {
    },
    data() {
        return {
            loading: true,
            show_table: true,
            search: '',
            products : [],
            product_categories: [],
            categories: [],
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

        getCategories() {

            axios.get('api/categories_with_products')
            .then(res => {
                this.categories = res.data.data;
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
                        if(res.data.status === 1) {

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
.product-image {
    height: 80px;
    width: 80px;
    margin: auto;
}

.products_section .card-body {
    
    margin-top: 15px;
    text-align: center;
}

.products_section .card-title {
    font-size: 0.9em;
    font-weight: bold ;

    height: 35px;
    overflow: hidden;
}
</style>