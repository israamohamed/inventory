<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Employee</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Employee</li>
            </ol>
        </div>

          <div class="spinner-border text-info loading-style" role="status" v-show = "loading">
              <span class="sr-only">Loading...</span>
            </div>


        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Employees -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gradient-info">
                        <h6 class="m-0 font-weight-bold text-white">Edit Employee</h6>
                        <!-- <a router-link = "/employee/create" class = "btn btn-info text-white">Add Employee</a> -->
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent = "submit" >
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class = "text-info font-weight-bold">Employee Name</label>
                                        <input type="text" v-model = "form.name"  class = "form-control" placeholder="Name">
                                        <small class = "text-danger" v-if = "errors.name"> {{errors.name[0]}} </small>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class = "text-info font-weight-bold">Email Address</label>
                                        <input type="email" v-model = "form.email" class = "form-control" placeholder="Email">
                                        <small class = "text-danger" v-if = "errors.email"> {{errors.email[0]}} </small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class = "text-info font-weight-bold">Phone Number</label>
                                        <input type="text" v-model = "form.phone" class = "form-control" placeholder="Phone">
                                        <small class = "text-danger" v-if = "errors.phone"> {{errors.phone[0]}} </small>
                                    </div>
                                </div>
                                 <!-- Salary -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary" class = "text-info font-weight-bold">Salary</label>
                                        <input type="number" v-model = "form.salary" class = "form-control" placeholder="salary">
                                        <small class = "text-danger" v-if = "errors.salary"> {{errors.salary[0]}} </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Address -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address" class = "text-info font-weight-bold">Address</label>
                                        <textarea type="text" v-model = "form.address" class = "form-control" placeholder="Address"></textarea>
                                        <small class = "text-danger" v-if = "errors.address"> {{errors.address[0]}} </small>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <!-- Joining Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="joining_date" class = "text-info font-weight-bold">Joining Date</label>
                                        <input type="date" v-model = "form.joining_date" class = "form-control" placeholder="Joining Date">
                                        <small class = "text-danger" v-if = "errors.joining_date"> {{errors.joining_date[0]}} </small>
                                    </div>
                                </div>
                                 <!-- nid -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nid" class = "text-info font-weight-bold">National ID</label>
                                        <input type="text" v-model = "form.nid" class = "form-control" placeholder="National ID">
                                        <small class = "text-danger" v-if = "errors.nid"> {{errors.nid[0]}} </small>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <!-- Image -->
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                            <label class="custom-file-label text-info font-weight-bold" for="customFile">Profile Picture</label>
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
        this.getEmployee();
    },

    data() {
        return {
            loading: true,
            isButtonDisabled: false,
            form: {
                name: null,
                email: null,
                phone: null,
                salary: null,
                address: null,
                joining_date: null,
                nid: null,
                image: null,
                new_image: null,
            },
            errors: {},

        }
    },

    methods : {

        getEmployee() {
            let id = this.$route.params.id;
            axios.get('/api/employee/' + id)
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

        
     submit() {
        this.loading = true;
        this.isButtonDisabled = true;
        let id = this.$route.params.id;

        axios.patch("/api/employee/" + id , this.form)
            .then(res => {
                if(res.data.status == 0 && res.data.message == "unauthenticated")
                {
                    this.$router.push({name : '/'})
                }

                else if(res.data.status === 1) //success
                {
                    this.$router.push({ name : 'employee.index'})
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