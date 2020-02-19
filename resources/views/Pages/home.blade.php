
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

                <div class="col-lg-3 col-md-6 col-sm-6"></div>
                  
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons" >weekend</i>
                    </div>
                    <p class="card-category">{{trans('home.In-Progress-Bookings')}}</p>
                      <h5 class="card-title">On the way :{{$ontheWay}}</h5>
                      <h5 class="card-title">Arrived :{{$arrived}}</h5>
                      <h5 class="card-title">Start Trips :{{$startTrip}}</h5>
                      <h5 class="card-title">End Trips :{{$endTrip}}</h5>
                  </div>
                  <div class="card-footer">
                    <div class="stats">

                      <a href="{{route('Booking.DailyBooking')}}" >
                        <i class="material-icons">place</i> {{trans('home.Get-Details-of-Daily-Bookings')}}
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
                            <h3 class="card-category"><a href="{{route('Booking.StatusView')}}" >{{trans('home.All-Bookings')}}</a></h3>
                            <h3 class="card-category"><a href="{{route('Booking.DateBooking')}}" >{{trans('home.Bookings-on-Date')}}</a></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!-- Booking.AllBooking -->

                                    <i class="material-icons">place</i>{{trans('home.Get-Details-of-Daily-Bookings')}}
                                </a>

                            </div>
                        </div>
                    </div>
                </div>









            </div>


              <div class="row">

                  <div class="col-lg-3 col-md-6 col-sm-6"></div>


              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons" >weekend</i>
                    </div>
                    <p class="card-category">{{trans('home.Drivers')}}</p><br>
                    <h5 class="card-title">{{trans('home.Today-Registered')}} {{ $dailRegisteredDrivers }}</h5>
                    <h5 class="card-title">{{trans('home.Online')}} : {{ $onlineDriver }}</h5>

                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <!-- Booking.AllBooking -->
                      <a href="{{route('Drivers')}}" >
                        <i class="material-icons">place</i>Get Daily Registered Drivers
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
                    <p class="card-category">{{trans('home.Passengers')}}</p><br>
                    <h5 class="card-title">{{trans('home.Today-Registered')}} {{ $dailRegisteredPassengers }}</h5>
                    <h5 class="card-title">{{trans('home.Online')}} {{ $onlinePassenger }}</h5>

                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <!-- Booking.AllBooking -->
                      <a href="{{route('Passanger')}}" >
                        <i class="material-icons">place</i>Get Daily Registered Passengers
                      </a>

                    </div>
                  </div>
                </div>
              </div>



              </div>












              {{--<div class="col-lg-3 col-md-6 col-sm-6">--}}
                {{--<div class="card card-stats">--}}
                  {{--<div class="card-header card-header-danger card-header-icon">--}}
                    {{--<div class="card-icon">--}}
                      {{--<i class="material-icons">weekend</i>--}}
                    {{--</div>--}}
                    {{--<p class="card-category">Monthly Bookings</p>--}}
                    {{--<h3 class="card-title">{{$totalmonthlyTrips}}</h3>--}}
                  {{--</div>--}}
                  {{--<div class="card-footer">--}}
                    {{--<div class="stats">--}}
                      {{--<a href="{{route('Booking.MonthlyBooking')}}" > --}}
                        {{--<i class="material-icons">place</i> Get Details of Monthly Bookings--}}
                      {{--</a>--}}
                    {{--</div>--}}
                  {{--</div>--}}
                {{--</div>--}}
              {{--</div>--}}


            












             <div class="row">
              <div class="col-md-12">
                <div class="card ">
                  <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons"></i>
                    </div>
                    <h4 class="card-title">Countries in Which we operate</h4>
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
                                    <img src="./assets/img/flags/BR.png"> </div>
                                </td>
                                <td>Sudan</td>
                                <td class="text-right">
                                  <a href="http://mashaueer.com/muhrah_sudan/"> Link of Panel</a>
                                  
                                </td>
                                <td class="text-right">
                                  Online
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