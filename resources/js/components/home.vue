<template>
    <div>
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Today Orders -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Today Orders</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{dashboard.number_of_today_orders}}</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span>Since last month</span> -->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- TODAY INCOME -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Today Income</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{dashboard.total_income_today}} EGP</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span>Since last years</span> -->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- TOTAL ORDERS -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Orders</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{dashboard.number_of_total_orders}}</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                        <span>Since last month</span> -->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shopping-cart fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- TODAY EXPENSES -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Today Expenses</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{dashboard.today_expenses}} EGP</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                        <span>Since yesterday</span> -->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-bill fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          
            <!-- Products Out Of Stock -->
            <div class="col-xl-12 mb-4">
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Products Out Of Stock</h6>
                  <router-link class="m-0 float-right btn btn-danger btn-sm" to="/product">View More <i
                      class="fas fa-chevron-right"></i></router-link>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Code</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for = "product in products_out_of_stock">
                        <td>{{product.name}}</td>
                        <td><img class = "image_style" :src = "product.image_path"></td>
                        <td>{{product.code}}</td>
                        <td>
                          <span class = "badge badge-success" v-if = "product.quantity > 0">Available {{product.quantity}}</span>      
                          <span class = "badge badge-danger" v-else>Out Of Stock</span>   
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
         
          </div>
          <!--Row-->

          <!-- <div class="row">
            <div class="col-lg-12 text-center">
              <p>Do you like this template ? you can download from <a href="https://github.com/indrijunanda/RuangAdmin"
                  class="btn btn-primary btn-sm" target="_blank"><i class="fab fa-fw fa-github"></i>&nbsp;GitHub</a></p>
            </div>
          </div> -->
    </div>
</template>

<script>
export default {

  data() {
    return {
      dashboard: {

          number_of_today_orders: '',
          total_income_today: '',
          number_of_total_orders: '',
          today_expenses: '',
      },

      products_out_of_stock: [],
    
    }
    
  },
  created() {
    if(!localStorage.getItem('token'))
    {
      this.$router.push({name : '/'});
    }

    this.statistics();
    this.get_products_out_of_stock();
    
  },

  methods : {
    statistics() {
      axios.get('/api/statistics')
            .then(res => {
              if(res.data.status == 0 && res.data.message == "unauthenticated")
              {
                this.$router.push({name : '/'})
              }
              this.dashboard = res.data.data;
            })
            .catch(error => {

            }) 
    },
    get_products_out_of_stock() {

      axios.get('/api/products_out_of_stock')
            .then(res => {
              this.products_out_of_stock = res.data.data;
            })
            .catch(error => {

            }) 

    }
  
  }

}
</script>

<style>
.image_style {
  width: 80px;
  height: 80px;
}
</style>
