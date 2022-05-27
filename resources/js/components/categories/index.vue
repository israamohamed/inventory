<template>
<div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Categories</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to = "/home">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Categories</li>
            </ol>
        </div>

        
        <div class="row">
            <div class="col-md-4">
                <input type="text" v-model="search" @keyup = "searchData" class = "form-control" placeholder="Search ..">
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Categories -->
                <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
                    <router-link to = "/category/create" class = "btn btn-primary text-white">Add Category</router-link>
                </div>
                <div class="table-responsive" v-if = "show_table">

                    <table class="table align-items-center table-flush">                  
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="spinner-border text-primary loading-style text-center" role="status" v-show = "loading">
                                <span class="sr-only">Loading...</span>
                            </div>

                            <tr v-for = "category in categories">
                                <td>{{ category.name }}</td>
                                <td>
                                    <router-link :to = "{name: 'category.edit' , params: {id : category.id} }" class="btn btn-info"><i class="fas fa-edit"></i></router-link>

                                    <button class="btn btn-danger" @click = "deleteRecord(category.id)" ><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>

                <div v-if = "!show_table">
                    <p class = "text-danger text-center">No Categories Data</p>
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
        this.getCategories();
    },

    mounted() {
    },
    data() {
        return {
            loading: true,
            show_table: true,
            search: '',
            categories : [],
        }
    },

    methods : {
        getCategories() {
            let data = {params : {'search' : this.search } };

            axios.get('api/category' , data)
            .then(res => {
                this.categories = res.data.data;
                if(this.categories.length < 1 )
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
            this.getCategories();
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

                axios.delete('/api/category/' + id)
                    .then(res => {
                        if(res.data.status === 1) {

                            this.categories = this.categories.filter(category => {
                                    return category.id != id;
                                });
                            this.show_table = this.categories.length > 0 ? true : false;
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
.image_style {
    height: 80px;
    width: 80px;
}
</style>