<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Salary</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Salary</li>
            </ol>
        </div>

          <div class="spinner-border text-info loading-style" role="status" v-show = "loading">
              <span class="sr-only">Loading...</span>
            </div>


        <div class="row">
            <div class="col-lg-12 mb-4">
              
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gradient-info">
                        <h6 class="m-0 font-weight-bold text-white">{{employee.name + ( employee.email ?  " - " + employee.email : '' )}} </h6>
                        <!-- <a router-link = "/employee/create" class = "btn btn-info text-white">Add Employee</a> -->
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent = "submit" >
                           
                                <div class="row">
                                    <!-- Month -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="month" class = "text-primary font-weight-bold">Month</label>
                                            <select v-model = "form.month"  class = "form-control" >
                                                <option v-for="month in months" :key = "month">{{month}}</option>
                                            
                                            </select>
                                            <small class = "text-danger" v-if = "errors.month"> {{errors.month[0]}} </small>
                                        </div>
                                    </div>    

                                    <!-- Year -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year" class = "text-primary font-weight-bold">Year</label>
                                            <select v-model = "form.year"  class = "form-control" >
                                                <option :key = "new Date().getFullYear()">{{new Date().getFullYear()}}</option>
                                                <option :key = "new Date().getFullYear() + 1">{{new Date().getFullYear() + 1}}</option>
                                            
                                            
                                            </select>
                                            <small class = "text-danger" v-if = "errors.year"> {{errors.year[0]}} </small>
                                        </div>
                                    </div>    
                            </div>

                            <div class="row">
                                <!-- Salary -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="salary" class = "text-primary font-weight-bold">Salary</label>
                                        <input v-model = "form.salary"  class = "form-control" placeholder="salary">
                                        <small class = "text-danger" v-if = "errors.salary"> {{errors.salary[0]}} </small>
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
        this.getSalary();
        this.form.month = this.months[new Date().getMonth()];
    },

    data() {
        return {
            loading: true,
            isButtonDisabled: false,
            form: {
                year: new Date().getFullYear(),
                salary: null,
                month: null,
            },
            errors: {},
            employee: {
                name: 'Employee Data'
            },
            months: ["January","February","March","April","May","June","July","August","September","October","November","December"],

        }
    },

    methods : {

        getSalary() {
            let id = this.$route.params.id;
            axios.get('/api/salary/' + id)
                .then(res => {
                    if(res.data.status == 0 && res.data.message == "unauthenticated")
                    {
                        this.$router.push({name : '/'})
                    }
                    if(res.data.status === 1)
                    {
                        this.form = res.data.data;
                        this.employee = res.data.data.employee;
                    }
                    this.loading = false;
                })
        },
        

        
     submit() {
        this.loading = true;
        this.isButtonDisabled = true;
        let id = this.$route.params.id;

        axios.patch("/api/salary/" + id , this.form)
            .then(res => {
                if(res.data.status === 1) //success
                {
                    this.$router.push({ name : 'salary.index'})
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