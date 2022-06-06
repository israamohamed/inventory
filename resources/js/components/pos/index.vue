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
                                <table class = "table table-responsive cart_table table-sm">

                                    <p v-if = "cart.length <= 0" class = "bg-gradient-primary text-center text-light p-3">Add Items to Cart</p> 
                                    <thead v-if = "cart.length > 0">
                                        <tr>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody v-if = "cart.length > 0">
                                        <tr v-for = "item in cart">
                                            <td class = "item-name col-md-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img :src="item.image_path"><br>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{item.name}}
                                                    </div>
                                                </div>
                                                
                                               
                                                </td>
                                            <td class = "item-quantity">
                                                <button class = "btn btn-sm" @click = "increment(item)">+</button>
                                                <span>{{item.quantity}}</span>
                                                <!-- <input type="text" class = "" :value = "item.quantity" readonly style = "width: 20px;"> -->
                                                <button class = "btn btn-sm" @click = "decrement(item)" :disabled = "item.quantity <= 1">-</button>
                                            </td>
                                            <td class = "item-price">{{item.price}} EGP</td>
                                            <td class = "item-price">{{item.subtotal}} EGP</td>
                                            <td><button class = "btn" @click = "remove(item)"><i class = "fas fa-trash text-danger"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>


                            
                                <ul class="list-group total">
                                    <li class="list-group-item">Quantities: <span class = "total_value">{{ quantities }}</span></li>

                                    <li v-if = "discount > 0" class="list-group-item">Discount: <span class = "total_value">  {{ discount }} EGP </span></li>
                                    <li class="list-group-item">Subtotal Price: <span class = "total_value">  {{ subtotalPrice }} <span v-if = "subtotalPrice > 0">EGP</span> </span></li>
                                    <li class="list-group-item">Total Price: <span class = "total_value">  {{ totalPrice }} <span v-if = "totalPrice > 0">EGP</span> </span></li>
                                    
                                </ul>


                                <form>
                                    <div class="form-group mt-1">
                                        <label>Customer</label>
                                         <select class = "form-control">
                                            <option v-for = "customer in customers" :key = "customer.id">{{customer.name}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-1">
                                        <label>Discount</label>
                                        <input type="number" class = "form-control" v-model = "discount" placeholder="Discount">
                                    </div>

                                    <input type="submit" class = "btn btn-success btn-block" value = "Save" >
                                </form>                              
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
                                    <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">

                                         <!-- search -->
                                        <input type="text" v-model = "search" class = "form-control my-2" @keyup = "searchData" placeholder="Search">

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
        this.getCustomers();
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
            discount: 0,
            customers: [],
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

        getCustomers() {
            let data = {params : {'search' : this.search } };

            axios.get('api/customer' , data)
            .then(res => {
                this.customers = res.data.data;
                if(this.customers.length < 1 )
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
                            image_path: product.image_path,
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
                    image_path: product.image_path,
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
                            image_path: product.image_path,
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
                            image_path: product.image_path,
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
    },

    computed: {
        subtotalPrice() {
            let subtotalPrice = 0;
            for(let i=0; i<this.cart.length; i++)
            {
                subtotalPrice += this.cart[i].subtotal;
            }
            return subtotalPrice;
        },

        totalPrice() {
            let totalPrice = 0;
            for(let i=0; i<this.cart.length; i++)
            {
                totalPrice += this.cart[i].subtotal;
            }
            if(totalPrice > 0 && this.discount && this.discount > 0 )
            {
                totalPrice -= this.discount;
            }
            return totalPrice;
        },

        quantities() {
            let quantities = 0;
            for(let i=0; i<this.cart.length; i++)
            {
                quantities += this.cart[i].quantity;
            }
            return quantities;
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

.cart_table {
    height: 300px;
    margin-bottom: 20px;
}
.cart_table thead {
    background: #d8d4dc;
}

.cart_table td , .cart_table th {
    padding-right: 0.8rem !important;
    padding-left: 0.8rem !important;
    
}

.cart_table .item-name {
    font-size: 0.8em;
    font-weight: bold;
    color: #7577ef;
}

.cart_table .item-quantity button {
    border: solid 2px #7577ef;
    font-size: 0.8em;
    font-weight: bold;
}

.cart_table .item-quantity span {
    font-size: 1em;
    font-weight: bold;
    color: #7577ef;
    margin: 0 1px;
}

.cart_table .item-price {
    font-size: 0.8em;
    font-weight: bold;
    color: #7577ef;
}

.cart_table img {
   height: 30px;
}

.total li {
    color: #86827a;
    font-weight: bold;
    padding: 0.3rem 1.25rem;
}

.total .total_value {
    margin-left: 20px;
    font-size: 1.2em;
    color: #19151a
}
</style>