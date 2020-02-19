
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
         <div class="row">
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header ">
                  <h4 class="card-title">Get Bookings Based on Dates
                    <br>
                    <small class="description"> Enter the Date in the Field and Select the booking Type you will See the Bookings</small>
                  </h4>
                </div>
                <div class="card-body ">
                  <ul class="nav nav-pills nav-pills-warning" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist">
                        Enter Date Of Bookings
                      </a>
                    </li>
                    
                  </ul>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active" id="link1">
                     <form class="form" method="post" action="{{url('R_bookings_dateBookings')}}">
             {{csrf_field()}}
            <div class="card card-login card-hidden">
              
              <div class="card-body ">
                  @if(count($errors))
              <div class="alert alert-danger">
                  <ul>
                      @foreach($errors->all() as $error)
                      <li>
                          {{ $error }}
                      </li>
                      @endforeach
                  </ul>
              </div>
              @endif
              <div class="col-md-12">

                    <div class="col-md-5">
                    <span class="bmd-form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">insert_invitation</i>
                          </span>
                        </div>
                        <label class="form-control">Start Date </label>
                        <input type="date" id="date" name="date" class="form-control" required>
                      </div>
                    </span>
                  </div>

                  <div class="col-md-5">
                    <span class="bmd-form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">insert_invitation</i>
                          </span>
                        </div>
                        <label class="form-control">End Date</label><br>
                        <input type="date" id="endDate" name="endDate" class="form-control" >
                      </div>
                    </span>
                  </div>

                  <div class="col-md-5">
                    <span class="bmd-form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">insert_invitation</i>
                          </span>
                        </div>
                          <select id="rideStatus" name="rideStatus" class="form-control" required >
                                      <option value="4">End Bookings</option>
                                      <option value="3">Start Bookings</option>
                                      <option value="6">On The Way</option>
                                      <option value="8">Driver Arrived</option>
                                      <option value="1">New</option>
                                      <option value="5">Cancel</option>
                                      <option value="2">not Accepted</option>
                                      <option value="7">no Driver</option>
                                      <option value="9">Quit or Crash</option>
                           </select>
                      </div>
                    </span>
                  </div>



                  <div class="col-md-5">

                    <span class="bmd-form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">clear_all</i>
                          </span>
                        </div>
                          <select id="rideType" name="rideType" class="form-control" required >
                                      <option value="TN">Daily Trips</option>
                                      <option value="TM">Monthly Trips</option>
                           </select>
                      </div>
                    </span>
                  </div>

                  <br><br><br>

                  <legend>(Optional)</legend>





                   <div class="col-md-5">

                    <span class="bmd-form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">clear_all</i>
                          </span>
                        </div>
                        
                          <select class="selectpicker" name="carType" data-size="7" data-style="select-with-transition" title="Car Type" required>
                                        <option value=""></option>

                                      @if(!empty($carTypes))
                                        @foreach($carTypes as $carType)
                                        <option value="{{$carType->carId}}"> {{$carType->carName}} </option>
                                        @endforeach
                                      @endif
                                    </select>
                      </div>
                    </span>
                  </div>
















                  <div class="col-md-5">
                    <span class="bmd-form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">clear_all</i>
                          </span>
                        </div>
                          
                          <label class="form-control">Driver ID : </label>
                          <input type="number" id="driverId" name="driverId" value="0" class="form-control" >

                      </div>
                    </span>
                  </div>


                  <div class="col-md-5">
                    <span class="bmd-form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">clear_all</i>
                          </span>
                        </div>
                          
                          <label class="form-control">Booking ID : </label>
                          <input type="number" id="bookingId" name="bookingId" value="0" class="form-control" >

                      </div>
                    </span>
                  </div>

                  <div class="col-md-5">
                    <span class="bmd-form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">clear_all</i>
                          </span>
                        </div>
                          
                          <label class="form-control">Passenger ID : </label>
                          <input type="number" id="passengerId" name="passengerId" value="0" class="form-control" >

                      </div>
                    </span>
                  </div>



              </div>
              
              </div>
              <div class="card-footer justify-content-center">
                <button type="submit" class="btn btn-rose btn-link btn-lg">Submit</button> 
              
              </div>
            </div>
          </form>
                   
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