<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Category</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Add Category</li>
            </ol>
        </div>

          <div class="spinner-border text-primary loading-style" role="status" v-show = "loading">
              <span class="sr-only">Loading...</span>
            </div>


        <div class="row">
            <div class="col-lg-12 mb-4">
               
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gradient-primary">
                        <h6 class="m-0 font-weight-bold text-white">Add Category</h6>
                        <!-- <a router-link = "/employee/create" class = "btn btn-primary text-white">Add Employee</a> -->
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent = "submit" >
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name" class = "text-primary font-weight-bold">Category Name</label>
                                        <input type="text" v-model = "form.name"  class = "form-control" placeholder="Name">
                                        <small class = "text-danger" v-if = "errors.name"> {{errors.name[0]}} </small>
                                    </div>
                                </div>    
                            </div>
                          
                            <button class = "btn btn-primary btn-lg float-end" :disabled = "isButtonDisabled" type = "submit">Add</button>
                                
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
        
    },

    data() {
        return {
            loading: false,
            isButtonDisabled: false,
            form: {
                name: null,
            },
            errors: {},

        }
    },

    methods : {
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
                    this.form.image = event.target.result
                };
                reader.readAsDataURL(file);
            }
        },

        
     submit() {
        this.loading = true;
        this.isButtonDisabled = true;

        axios.post("/api/category" , this.form)
            .then(res => {
                if(res.data.status == 0 && res.data.message == "unauthenticated")
                {
                    this.$router.push({name : '/'})
                }
                else if(res.data.status === 1) //success
                {
                    this.$router.push({ name : 'category.index'})
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