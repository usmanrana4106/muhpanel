
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
                  <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons" >weekend</i>
                    </div>
                    <p class="card-category">Daily Bookings</p>
                    <h3 class="card-title">{{$totalTodayBookings}}</h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">

                      <a href="{{route('Booking.DailyBooking')}}" >
                        <i class="material-icons">place</i> Get Details of Daily Bookings
                      </a>

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons" >weekend</i>
                    </div>
                    <p class="card-category">All Bookings</p>
                    <h3 class="card-title">{{$totalTrips}}</h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
<!-- Booking.AllBooking -->
                      <a href="{{route('Booking.StatusView')}}" >
                        <i class="material-icons">place</i>Get Details of Daily Bookings
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
                    <p class="card-category">Bookings on Date </p>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <a href="{{route('Booking.DateBooking')}}" >
                        <i class="material-icons">place</i> Get Details of Daily Booking on
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
                    <p class="card-category">Monthly Bookings</p>
                    <h3 class="card-title">{{$totalmonthlyTrips}}</h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <a href="{{route('Booking.MonthlyBooking')}}" > 
                        <i class="material-icons">place</i> Get Details of Monthly Bookings
                      </a>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            












             <div class="row">
              <div class="col-md-12">
                <div class="card ">
                  <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons"></i>
                    </div>
                    <h4 class="card-title">Global Sales by Top Locations</h4>
                  </div>
                  <div class="card-body ">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="table-responsive table-sales">
                          <table class="table">
                            <tbody>
                              
                             
                             
                              <tr>
                                <td>
                                  <div class="flag">
                                    <img src="./assets/img/flags/RO.png" </div>
                                </td>
                                <td>Rome</td>
                                <td class="text-right">
                                 pending
                                </td>
                                <td class="text-right">
                                  pending
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="flag">
                                    <img src="./assets/img/flags/BR.png" </div>
                                </td>
                                <td>Eygpt</td>
                                <td class="text-right">
                                  pending
                                </td>
                                <td class="text-right">
                                  pending
                                </td>
                              </tr>


                            </tbody>
                          </table>
                          </div>
                          </div>
                          <div class="col-md-6 ml-auto mr-auto">
                            <div id="worldMap" style="height: 300px;"></div>
                          </div>
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