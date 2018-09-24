
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
            <div class="col-md-9">
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
                     <form class="form" method="post" action="{{url('dateBookings')}}">
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
              <div class="col-md-5">
                <span class="bmd-form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">insert_invitation</i>
                      </span>
                    </div>
                    <input type="date" id="date" name="date" class="form-control" required>
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
                                  <option value="">...</option>
                                  <option value="TN">Daily Trips</option>
                                  <option value="TM">Monthly Trips</option>
                       </select>
                  </div>
                </span>
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