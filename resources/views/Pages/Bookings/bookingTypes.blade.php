
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
                      <i class="material-icons" >weekend</i>
                    </div>
                    <p class="card-category">New Bookings</p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">

                      <a href="{{route('Booking.Status',1)}}" >
                        <i class="material-icons">place</i> Get Details of New Booking
                      </a>

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">weekend</i>
                    </div>
                    <p class="card-category">Driver Reaching Customers</p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <a href="{{route('Booking.Status',6)}}" > 
                        <i class="material-icons">place</i> Get on the Way Details of Bookings
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">weekend</i>
                    </div>
                    <p class="card-category">Driver Arrived </p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <a href="{{route('Booking.Status',8)}}" >
                        <i class="material-icons">place</i> Get Details of Trips where Driver Arrived
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">weekend</i>
                    </div>
                    <p class="card-category">Start Trips </p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <a href="{{route('Booking.Status',3)}}" >
                        <i class="material-icons">place</i> Get Details of Started Trips
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">weekend</i>
                    </div>
                    <p class="card-category">End Trips</p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <a href="{{route('Booking.Status',4)}}" > 
                        <i class="material-icons">place</i> Get Details of End Trips
                      </a>
                    </div>
                  </div>
                </div>
              </div>

               





               <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-blue card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">weekend</i>
                    </div>
                    <p class="card-category">Cancel Booking</p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <a href="{{route('Booking.Status',5)}}" > 
                        <i class="material-icons">place</i> Get Details of Cancel Bookings By Customer
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