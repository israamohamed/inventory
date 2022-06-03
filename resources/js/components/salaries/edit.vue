<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Expense</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Expense</li>
            </ol>
        </div>

          <div class="spinner-border text-info loading-style" role="status" v-show = "loading">
              <span class="sr-only">Loading...</span>
            </div>


        <div class="row">
            <div class="col-lg-12 mb-4">
              
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gradient-info">
                        <h6 class="m-0 font-weight-bold text-white">Edit Expense</h6>
                        <!-- <a router-link = "/employee/create" class = "btn btn-info text-white">Add Employee</a> -->
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent = "submit" >
                             <div class="row">
                                <!-- Amount -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="amount" class = "text-primary font-weight-bold">Amount</label>
                                        <input type="text" v-model = "form.amount"  class = "form-control" placeholder="Amount">
                                        <small class = "text-danger" v-if = "errors.amount"> {{errors.amount[0]}} </small>
                                    </div>
                                </div>    
                            </div>

                            <div class="row">
                                <!-- Details -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="details" class = "text-primary font-weight-bold">Details</label>
                                        <textarea v-model = "form.details"  class = "form-control" placeholder="Details"></textarea>
                                        <small class = "text-danger" v-if = "errors.details"> {{errors.details[0]}} </small>
                                    </div>
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
        this.getExpense();
    },

    data() {
        return {
            loading: true,
            isButtonDisabled: false,
            form: {
                name: null,
                email: null,
                phone: null,
                shop_name: null,
                address: null,
                image: null,
                new_image: null,
            },
            errors: {},

        }
    },

    methods : {

        getExpense() {
            let id = this.$route.params.id;
            axios.get('/api/expense/' + id)
                .then(res => {
                    if(res.data.status === 1)
                    {
                        this.form = res.data.data;
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

        
     submit() {
        this.loading = true;
        this.isButtonDisabled = true;
        let id = this.$route.params.id;

        axios.patch("/api/expense/" + id , this.form)
            .then(res => {
                if(res.data.status === 1) //success
                {
                    this.$router.push({ name : 'expense.index'})
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