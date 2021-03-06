<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link href="{{asset('dashboard/img/logo/logo.png')}}" rel="icon">
  <title>Inventory - Dashboard</title>
  <link href="{{asset('dashboard/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('dashboard/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('dashboard/css/ruang-admin.min.css')}}" rel="stylesheet">

  <style>
    .loading-style {
      width: 4em;
      height: 4em;
      border-width: 0.4em;
      display: block;
      margin: 2px auto;
    }
  </style>

  <style>
  @import url('https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@600&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&display=swap');

  </style>

  <style>
    h1,h2,h3,h4,h5,h6,p,span,div,input,select,option,a,li {
      /* font-family: 'Noto Kufi Arabic', sans-serif; */
      font-family: 'Roboto Slab', serif;
    }
  </style>


</head>

<body id="page-top">

  <div id = "app">
    <div id="wrapper">
      <!-- Sidebar -->
      <ul v-if = "is_auth()"  class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
        <router-link class="sidebar-brand d-flex align-items-center justify-content-center" to = "/home">
          <div class="sidebar-brand-icon">
            <img src="{{asset('dashboard/img/logo/logo2.png')}}">
          </div>
          <div class="sidebar-brand-text mx-3">Inventory</div>
        </router-link>

        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
          <router-link class="nav-link" to = "/home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></router-link>
        </li>
        <hr class="sidebar-divider">

        <li class="nav-item active bg-gradient-primary">
          <router-link class="nav-link text-white" to = "/pos">
            <i class="fas fa-fw fa-tachometer-alt text-white"></i>
            <span>POS</span></router-link>
        </li>
        <hr class="sidebar-divider">
       
        <li class="nav-item">
          <a class="nav-link collapsed" href = "#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
            <i class="fas fa-users"></i>
            <span>Employees</span>
          </a>

          <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Employees</h6>
              <router-link class="collapse-item" to="/employee">Employees</router-link>
              <router-link class="collapse-item" to="/employee/create">Add Employee</router-link>
             
            </div>
          </div>
        </li>

        <!-- Suppliers -->
        <li class="nav-item">
          <a class="nav-link collapsed" href = "#" data-toggle="collapse" data-target="#collapseSuppliers" aria-expanded="true" aria-controls="collapseSuppliers">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>Suppliers</span>
          </a>

          <div id="collapseSuppliers" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Suppliers</h6>
              <router-link class="collapse-item" to="/supplier">Suppliers</router-link>
              <router-link class="collapse-item" to="/supplier/create">Add Supplier</router-link>
            </div>
          </div>
        </li>
       
        

        <!-- Categories -->
        <li class="nav-item">
          <a class="nav-link collapsed" href = "#" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">
            <i class="fas fa-tasks"></i>
            <span>Categories</span>
          </a>

          <div id="collapseCategories" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Categories</h6>
              <router-link class="collapse-item" to="/category">Categories</router-link>
              <router-link class="collapse-item" to="/category/create">Add category</router-link>
            </div>
          </div>
        </li>

        <!-- Products -->
        <li class="nav-item">
          <a class="nav-link collapsed" href = "#" data-toggle="collapse" data-target="#collapseProducts" aria-expanded="true" aria-controls="collapseProducts">
            <i class="fab fa-product-hunt"></i>
            <span>Products</span>
          </a>

          <div id="collapseProducts" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Products</h6>
              <router-link class="collapse-item" to="/product">Products</router-link>
              <router-link class="collapse-item" to="/product/create">Add Product</router-link>
            </div>
          </div>
        </li>

        
        <!-- Orders -->
        <li class="nav-item">
          <a class="nav-link collapsed" href = "#" data-toggle="collapse" data-target="#collapseOrders" aria-expanded="true" aria-controls="collapseOrders">
            <i class="fas fa-shopping-cart"></i>
            <span>Orders</span>
          </a>

          <div id="collapseOrders" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Orders</h6>
              <router-link class="collapse-item" to="/today_orders">Today Orders</router-link>
              <router-link class="collapse-item" to="/order">Orders</router-link>

            </div>
          </div>
        </li>

        <!-- Expenses -->
        <li class="nav-item">
          <a class="nav-link collapsed" href = "#" data-toggle="collapse" data-target="#collapseExpenses" aria-expanded="true" aria-controls="collapseExpenses">
            <i class="fas fa-money-bill"></i>
            <span>Expenses</span>
          </a>

          <div id="collapseExpenses" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Expenses</h6>
              <router-link class="collapse-item" to="/expense">Expenses</router-link>
              <router-link class="collapse-item" to="/expense/create">Add expense</router-link>
            </div>
          </div>
        </li>

        <!-- Salaries -->
        <li class="nav-item">
          <a class="nav-link collapsed" href = "#" data-toggle="collapse" data-target="#collapseSalaries" aria-expanded="true" aria-controls="collapseSalaries">
            <i class="fas fa-dollar-sign"></i>
            <span>Salaries</span>
          </a>

          <div id="collapseSalaries" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Salaries</h6>
              <router-link class="collapse-item" to="/salary/get_employees">Pay Salary</router-link>
              <router-link class="collapse-item" to="/salary">Salaries</router-link>
            </div>
          </div>
        </li>
        

      

        <!-- Customers -->
        <li class="nav-item">
          <a class="nav-link collapsed" href = "#" data-toggle="collapse" data-target="#collapseCustomers" aria-expanded="true" aria-controls="collapseCustomers">
            <i class="fas fa-user-friends"></i>
            <span>Customers</span>
          </a>

          <div id="collapseCustomers" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Customers</h6>
              <router-link class="collapse-item" to="/customer">Customers</router-link>
              <router-link class="collapse-item" to="/customer/create">Add Customer</router-link>
            </div>
          </div>
        </li>

        <hr class="sidebar-divider">
       
      
        <div class="version" id="version-ruangadmin"></div>
      </ul>
      <!-- Sidebar -->
      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <!-- TopBar -->
          <nav  v-if = "is_auth()" class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
            <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>
            <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-search fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                  aria-labelledby="searchDropdown">
                  <form class="navbar-search">
                    <div class="input-group">
                      <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                        aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </li>
              <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell fa-fw"></i>
                  <span class="badge badge-danger badge-counter">3+</span>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="alertsDropdown">
                  <h6 class="dropdown-header">
                    Alerts Center
                  </h6>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                      <div class="icon-circle bg-primary">
                        <i class="fas fa-file-alt text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">December 12, 2019</div>
                      <span class="font-weight-bold">A new monthly report is ready to download!</span>
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                      <div class="icon-circle bg-success">
                        <i class="fas fa-donate text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">December 7, 2019</div>
                      $290.29 has been deposited into your account!
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                      <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">December 2, 2019</div>
                      Spending Alert: We've noticed unusually high spending for your account.
                    </div>
                  </a>
                  <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                </div>
              </li>
              <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-envelope fa-fw"></i>
                  <span class="badge badge-warning badge-counter">2</span>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="messagesDropdown">
                  <h6 class="dropdown-header">
                    Message Center
                  </h6>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                      <img class="rounded-circle" src="{{asset('dashboard/img/man.png')}}" style="max-width: 60px" alt="">
                      <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                      <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been
                        having.</div>
                      <div class="small text-gray-500">Udin Cilok ?? 58m</div>
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                      <img class="rounded-circle" src="{{asset('dashboard/img/girl.png')}}" style="max-width: 60px" alt="">
                      <div class="status-indicator bg-default"></div>
                    </div>
                    <div>
                      <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people
                        say this to all dogs, even if they aren't good...</div>
                      <div class="small text-gray-500">Jaenab ?? 2w</div>
                    </div>
                  </a>
                  <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                </div>
              </li>
              <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-tasks fa-fw"></i>
                  <span class="badge badge-success badge-counter">3</span>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="messagesDropdown">
                  <h6 class="dropdown-header">
                    Task
                  </h6>
                  <a class="dropdown-item align-items-center" href="#">
                    <div class="mb-3">
                      <div class="small text-gray-500">Design Button
                        <div class="small float-right"><b>50%</b></div>
                      </div>
                      <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </a>
                  <a class="dropdown-item align-items-center" href="#">
                    <div class="mb-3">
                      <div class="small text-gray-500">Make Beautiful Transitions
                        <div class="small float-right"><b>30%</b></div>
                      </div>
                      <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </a>
                  <a class="dropdown-item align-items-center" href="#">
                    <div class="mb-3">
                      <div class="small text-gray-500">Create Pie Chart
                        <div class="small float-right"><b>75%</b></div>
                      </div>
                      <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </a>
                  <a class="dropdown-item text-center small text-gray-500" href="#">View All Taks</a>
                </div>
              </li>
              <div class="topbar-divider d-none d-sm-block"></div>
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <img class="img-profile rounded-circle" src="{{asset('dashboard/img/boy.png')}}" style="max-width: 60px">
                  <span class="ml-2 d-none d-lg-inline text-white small">Maman Ketoprak</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                  </a>
                  <div class="dropdown-divider"></div>
                  <router-link class="dropdown-item" to = "logout">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                  </router-link>
                </div>
              </li>
            </ul>
          </nav>
          <!-- Topbar -->
  
          <!-- Container Fluid-->
          <div class="container-fluid" id="container-wrapper">

             <!-- component matched by the route will render here -->
            <router-view></router-view>

          </div>
          <!---Container Fluid-->
        </div>
        {{-- <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - developed by
                <b><a href="https://indrijunanda.gitlab.io/" target="_blank">indrijunanda</a></b>
              </span>
            </div>
          </div>
        </footer>
        <!-- Footer --> --}}
      </div>
    </div>
  
  </div>
 
  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src = "{{asset('js/app.js')}}"></script>
  <script src="{{asset('dashboard/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('dashboard/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
  <script src="{{asset('dashboard/js/ruang-admin.min.js')}}"></script>
  <script src="{{asset('dashboard/vendor/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('dashboard/js/demo/chart-area-demo.js')}}"></script>  
  
</body>

</html>