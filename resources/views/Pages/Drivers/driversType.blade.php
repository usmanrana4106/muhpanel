
<!-- __________________________________________Header___________________________________________________ -->
@include('layouts.header')


<body class="">
  <div class="wrapper ">
  

<!-- __________________________________________SideBar___________________________________________________ -->



@include('layouts.sidebar')

    <div class="main-panel">
      <!-- __________________________________________NavBar___________________________________________________ -->



@include('layouts.navbar')
      <div class="content">
          <div class="content">
              


          	<div class="row">
                          
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                      <i ><img src="{{url('public/images/muhrahpanel/driver.png')}}"></i>
                    </div>
                    <p class="card-category">Active Drivers</p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">

                      <a href="{{route('Working.Status',1)}}" >
                        <i class="material-icons">place</i> Get Details of Active Drivers
                      </a>

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                      <i ><img src="{{url('public/images/muhrahpanel/driver.png')}}"></i>
                    </div>
                    <p class="card-category">UnActive Drivers</p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">

                      <a href="{{route('Working.Status',0)}}" >
                        <i class="material-icons">place</i>Get Details of UnActive Drivers
                      </a>

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                       <i ><img src="{{url('public/images/muhrahpanel/driver.png')}}"></i>
                    </div>
                    <p class="card-category">Approved Drivers </p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <a href="{{route('Valid.Status',1)}}" >
                        <i class="material-icons">place</i> Get Details of Approved Drivers
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                       <i ><img src="{{url('public/images/muhrahpanel/driver.png')}}"></i>
                    </div>
                    <p class="card-category">Not Approved Drivers</p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <a href="{{route('Valid.Status',0)}}" > 
                        <i class="material-icons">place</i> Get Details of Not Approved Drivers
                      </a>
                    </div>
                  </div>
                </div>
              </div>

               


               
            </div>
            












            





          </div>
      </div>





                 
<!-- __________________________________________Footer___________________________________________________ -->



@include('layouts.footer')









                </div>
              </div>
              








<!-- __________________________________________Footer___________________________________________________ -->



<!-- @include('layouts.sideFilters') -->




<!-- __________________________________________JsFiles___________________________________________________ -->



@include('layouts.js')




</body>

</html>