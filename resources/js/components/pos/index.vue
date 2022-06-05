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
                            <div class = "col-md-6">
                                <table class = "table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for = "item in cart">
                                            <td>{{item.name}}</td>
                                            <td class = "col-md-5">
                                                <button class = "btn btn-success btn-sm" @click = "increment(item)">+</button>
                                                <input type="text" class = "" :value = "item.quantity" readonly style = "width: 50px;">
                                                <button class = "btn btn-danger btn-sm" @click = "decrement(item)" :disabled = "item.quantity <= 1">-</button>
                                            </td>
                                            <td>{{item.price}}</td>
                                            <td>{{item.subtotal}}</td>
                                            <td><button class = "btn" @click = "remove(item)"><i class = "fas fa-trash text-danger"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- products-->
                             <div class = "col-md-6">
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
                                            <div v-for = "product in products" class="col-lg-3 col-md-6 mb-2 product_card" @click = "addToCart(product)">
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
                                            <div v-for = "product in category.products" class="col-lg-3 col-md-6 mb-2 product_card" @click = "addToCart(product)">
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
            cart: [],
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

        addToCart(product) {
            if(product.quantity < 1) //out of stock
            {
                Notification.error("Product Out Of Stock !");
                return ;
            }

            let item = this.cart.find(o => o.id === product.id);
        
            if(item) //edit quantity
            {
                //check quantity
                if( (item.quantity + 1) >  item.main_quantity )
                {
                    Notification.error("Available quantity is: " + item.main_quantity);
                    return ;
                }
                item = this.cart.find((item, index) => {
                    if (item.id === product.id) 
                    {
                        let new_item = { 
                            id:   product.id,
                            name: product.name,
                            quantity: item.quantity + 1,
                            price: product.selling_price,
                            subtotal: (item.quantity + 1) * product.selling_price,
                            main_quantity: product.quantity,
                        };
                        this.cart.splice(index, 1, new_item)
                        return true; // stop searching
                    }
                });
            }
            else  //create new item
            {
                  this.cart.push({
                    id:   product.id,
                    name: product.name,
                    quantity: 1,
                    price: product.selling_price,
                    subtotal: product.selling_price,
                    main_quantity: product.quantity,
                });
            }
          

        },


         increment(product) {
            let item = this.cart.find(o => o.id === product.id);
            if(item) //edit quantity
            {
                //check quantity
                if( (item.quantity + 1) >  item.main_quantity )
                {
                    Notification.error("Available quantity is: " + item.main_quantity);
                    return ;
                }
                item = this.cart.find((item, index) => {
                    if (item.id === product.id) 
                    {
                        let new_item = { 
                            id:   product.id,
                            name: product.name,
                            quantity: item.quantity + 1,
                            price: product.price,
                            subtotal: (item.quantity + 1) * product.price,
                            main_quantity: product.main_quantity,
                        };
                        this.cart.splice(index, 1, new_item)
                        return true; // stop searching
                    }
                });
            }
        },

        decrement(product) {
            let item = this.cart.find(o => o.id === product.id);
            if(item && item.quantity > 1 ) //edit quantity
            {
                item = this.cart.find((item, index) => {
                    if (item.id === product.id) 
                    {
                        let new_item = { 
                            id:   product.id,
                            name: product.name,
                            quantity: item.quantity - 1,
                            price: product.price,
                            subtotal: (item.quantity - 1) * product.price,
                            main_quantity: product.main_quantity,
                        };
                        this.cart.splice(index, 1, new_item)
                        return true; // stop searching
                    }
                });
            }
        },

        remove(product) {
            let item = this.cart.find(o => o.id === product.id);
            if(item) //edit quantity
            {
                item = this.cart.find((item, index) => {
                    if (item.id === product.id) 
                    {
                        this.cart.splice(index, 1)
                        return true; // stop searching
                    }
                });
            }
        },

       
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

.product_card {
    cursor: pointer;
}
</style>