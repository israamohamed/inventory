<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
            </ol>
        </div>

          <div class="spinner-border text-info loading-style" role="status" v-show = "loading">
              <span class="sr-only">Loading...</span>
            </div>


        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Products -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gradient-info">
                        <h6 class="m-0 font-weight-bold text-white">Edit Product</h6>
                        <!-- <a router-link = "/employee/create" class = "btn btn-info text-white">Add Employee</a> -->
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent = "submit" >
                             <div class="row">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class = "text-primary font-weight-bold">Product Name</label>
                                        <input type="text" v-model = "form.name"  class = "form-control" placeholder="Name">
                                        <small class = "text-danger" v-if = "errors.name"> {{errors.name[0]}} </small>
                                    </div>
                                </div>
                                <!-- Code -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code" class = "text-primary font-weight-bold">Product code</label>
                                        <input type="text" v-model = "form.code"  class = "form-control" placeholder="Code">
                                        <small class = "text-danger" v-if = "errors.code"> {{errors.code[0]}} </small>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <!-- Category -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_id" class = "text-primary font-weight-bold">Category</label>
                                      
                                        <select v-model = "form.category_id" class = "form-control select2">
                                            <option :value = "category.id" v-for = "category in categories">{{ category.name }}</option>
                                        </select>
                                        <small class = "text-danger" v-if = "errors.category_id"> {{errors.category_id[0]}} </small>
                                    </div>
                                </div>
                                <!-- Supplier -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="supplier_id" class = "text-primary font-weight-bold">Supplier</label>
                                      
                                        <select v-model = "form.supplier_id" class = "form-control select2">
                                           
                                            <option :value = "supplier.id" v-for = "supplier in suppliers">{{ supplier.name }}</option>
                                        </select>
                                        <small class = "text-danger" v-if = "errors.supplier_id"> {{errors.supplier_id[0]}} </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Selling Price -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="selling_price" class = "text-primary font-weight-bold">Selling Price</label>
                                        <input type="number" v-model = "form.selling_price"  class = "form-control" placeholder="Selling Price">
                                        <small class = "text-danger" v-if = "errors.selling_price"> {{errors.selling_price[0]}} </small>
                                    </div>
                                </div>
                              <!-- Buying Price -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="buying_price" class = "text-primary font-weight-bold">Buying Price</label>
                                        <input type="number" v-model = "form.buying_price"  class = "form-control" placeholder="Buying Price">
                                        <small class = "text-danger" v-if = "errors.buying_price"> {{errors.buying_price[0]}} </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Quantity -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quantity" class = "text-primary font-weight-bold">Quantity</label>
                                        <input type="number" v-model = "form.quantity"  class = "form-control" placeholder="quantity">
                                        <small class = "text-danger" v-if = "errors.quantity"> {{errors.quantity[0]}} </small>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <!-- Image -->
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                            <label class="custom-file-label text-info font-weight-bold" for="customFile">Product Image</label>
                                            <small class = "text-danger" v-if = "errors.image"> {{errors.image[0]}} </small>
                                        </div>
                                      
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <img :src="form.image" style = "width: 80px; height: 80px;">
                                </div>
                               
                            </div>

                            <button class = "btn btn-info btn-lg float-end" :disabled = "isButtonDisabled" type = "submit">Edit</button>
                                
                        </form>
                    </div>

          
                </div>
             </div>
        </div>
</div>
     
</template>

<script>
import axios from 'axios';

export default {
    created() {
        this.getCategories();
        this.getSuppliers();
        this.getProduct();
    },

    data() {
        return {
            loading: true,
            isButtonDisabled: false,
            form: {
                name: null,
                code: null,
                category_id: null,
                supplier_id: null,
                selling_price: null,
                buying_price: null,
                quantity: null,
                image: null,
                new_image: null,
            },
            errors: {},
            categories: [],
            suppliers: [],

        }
    },

    methods : {

        getProduct() {
            let id = this.$route.params.id;
            axios.get('/api/product/' + id)
                .then(res => {
                    if(res.data.status === 1)
                    {
                        this.form = res.data.data;
                        this.form.image = res.data.data.image_path;
                    }
                    this.loading = false;
                })
        },
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) 
            {
                Notification.error("image size must be less than 1048770");
            }
            else
            {
                let reader = new FileReader();
                reader.onload = event =>{
                    this.form.new_image = event.target.result;
                    this.form.image = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        getCategories() {
            axios.get('/api/category')
            .then(res => {
                if(res.data.status == 0 && res.data.message == "unauthenticated")
                {
                    this.$router.push({name : '/'})
                }
                this.categories = res.data.data;
            })
            .catch(error => {
            });
        },

        getSuppliers() {
            axios.get('/api/supplier')
            .then(res => {
                this.suppliers = res.data.data;
            })
            .catch(error => {
            });
        },

        
     submit() {
        this.loading = true;
        this.isButtonDisabled = true;
        let id = this.$route.params.id;

        axios.patch("/api/product/" + id , this.form)
            .then(res => {
                if(res.data.status === 1) //success
                {
                    this.$router.push({ name : 'product.index'})
                    Toast.fire({
                            icon: 'success',
                            title: res.data.message
                        })
                }

                else //error occured
                {
                    this.loading = false;
                    this.isButtonDisabled = false;
                    this.errors = res.data.data;
                    Notification.error(res.data.message);
                }
            })
            .catch(error => {
                this.loading = false;
                this.isButtonDisabled = false;
            })
    }

    },

   
}
</script>

<style type="text/css">
.image_style {
    height: 80px;
    width: 80px;
}
</style>