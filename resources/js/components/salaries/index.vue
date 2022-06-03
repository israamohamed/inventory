<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Salaries</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Salaries</li>
            </ol>
        </div>

        
        <div class="row">
            <div class="col-md-3">
                <input type="text" v-model="search" @keyup = "searchData" class = "form-control" placeholder="Search ..">
            </div>

            <div class="col-md-3">
                <input type="date" v-model="date" @change = "searchData" class = "form-control">
            </div>

            <div class="col-md-3">
                <select v-model = "month"  class = "form-control" @change = "searchData" >
                    <option v-for="month in months" :key = "month">{{month}}</option>                
                </select>
            </div>

            <div class="col-md-3">
                <select v-model = "year"  class = "form-control" @change = "searchData" >
                    <option :key = "new Date().getFullYear()">{{new Date().getFullYear()}}</option>
                    <option :key = "new Date().getFullYear() + 1">{{new Date().getFullYear() + 1}}</option>                  
                </select>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Salaries -->
                <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Salaries</h6>
                    <router-link to = "/salary/get_employees" class = "btn btn-primary text-white">Add Salary</router-link>
                </div>
                <div class="table-responsive" v-if = "show_table">

                    <table class="table align-items-center table-flush">                  
                        <thead class="thead-light">
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Date</th>
                                <th>Salary</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="spinner-border text-primary loading-style text-center" role="status" v-show = "loading">
                                <span class="sr-only">Loading...</span>
                            </div>

                            <tr v-for = "salary in salaries">
                                <td>{{ salary.employee.name }}</td>
                                <td>{{ salary.month + " " + salary.year }}</td>
                                <td>{{ salary.date }}</td>
                                <td><b>{{ salary.salary }} EGP</b></td>
                                <td>
                                    <router-link :to = "{name: 'salary.edit' , params: {id : salary.id} }" class="btn btn-info"><i class = "fas fa-edit"></i></router-link>
                                </td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>

                <div v-if = "!show_table">
                    <p class = "text-danger text-center">No Salaries Data</p>
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
        this.month = this.months[new Date().getMonth()];
        this.getSalaries();
        
    },

    mounted() {
    },
    data() {
        return {
            loading: true,
            show_table: true,
            search: '',
            date: '',
            month: '',
            year: new Date().getFullYear(),
            salaries : [],
            months: ["January","February","March","April","May","June","July","August","September","October","November","December"],
        }
    },

    methods : {
        getSalaries() {
            let data = {params : {'search':this.search, 'date':this.date, 'month':this.month, 'year':this.year } };

            axios.get('api/salary' , data)
            .then(res => {
                this.salaries = res.data.data;
                if(this.salaries.length < 1 )
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
            this.getSalaries();
        },

      
    }
}
</script>

<style type="text/css">
.image_style {
    height: 80px;
    width: 80px;
}
</style>