<template>
    <div>
         <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="login-form">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                </div>
                                <form class="user" v-on:submit.prevent = "login()">

                                    <div class="form-group">
                                        <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address" v-model = "form.email">
                                        <small class = "text-danger" v-if = "errors.email"> {{errors.email[0]}} </small>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" v-model = "form.password">
                                        <small class = "text-danger" v-if = "errors.password"> {{errors.password[0]}} </small>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type = "submit" class="btn btn-primary btn-block">Login</button>
                                    </div>
                                  
                                </form>
                                <hr>
                                <div class="text-center">
                                    <router-link to = "/register" class="font-weight-bold small">Create an Account!</router-link>
                                </div>
                                <div class="text-center">
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
import axios from 'axios'

export default {

    created() {
        if(localStorage.getItem('token'))
        {
            this.$router.push({name : 'home'});
        }
        
    },
    data() {
        return {
            form : {
                email : null,
                password : null,
            },
            errors : {},
        }
    },

    methods : {
        
        login() {
            axios.post("api/auth/login" , this.form)
                .then(res => {
                    console.log(res.data);

                    if(res.data.status === 1) //success
                    {
                        Toast.fire({
                            icon: 'success',
                            title: res.data.message
                        })
                        this.$router.push({name : 'home'});
                        localStorage.setItem('token' ,  res.data.data.token );
                        localStorage.setItem('user' ,  res.data.data.user );
                    }

                    else //failed
                    {
                        Toast.fire({
                            icon: 'error',
                            title: res.data.message
                        })
                        this.errors = res.data.data;
                    }
                })
                .catch(error => {
                    Toast.fire({
                        icon: 'error',
                        //title: error.response.data
                        title: 'Error Occured'
                    })
                })
        }
    }
}
</script>
