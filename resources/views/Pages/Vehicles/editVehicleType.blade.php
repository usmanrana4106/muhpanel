
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
              


          	 <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-rose card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Edit Car Type</h4>

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

                  </div>
                </div>
                <div class="card-body ">
                		 <form  action="{{ route('Vehicle.edit') }}" method="post" class="form-horizontal">
                        	 	{{ csrf_field() }}
                          <input type="hidden" class="form-control" name="carId" value="{{$carType->carId}}" required>
               
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Car Name</label>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <input type="text" class="form-control" name="carName" value="{{$carType->carName}}" required>
                          <span class="bmd-help">Enter here a Car name</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Car Sheets</label>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <input type="text" class="form-control" name="carSheet" value="{{$carType->carSheet}}" required>
                          <span class="bmd-help">Home many sheets are availiable in car</span>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">counter Price</label>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <input type="text" class="form-control" name="Counterprice" value="{{$carType->Counterprice}}" required>
                          <span class="bmd-help">the Counter Price for vehicle </span>
                        </div>
                      </div>
                      <div class="col-sm-5 ">
                        <div class="form-group " style="padding-left: 20%;">

                        	<i ><img src="{{url('public/uploads/images/carImage',$carType->carImage)}}" style="width: 110px; height: 90px;"></i>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Price By Distance</label>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <input type="text" class="form-control" name="priceByDistence" value="{{$carType->priceByDistence}}" required>
                          <span class="bmd-help">Enter here Price By Distance</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Price By Time</label>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <input type="text" class="form-control" name="priceByTime" value="{{$carType->priceByTime}}" required>
                          <span class="bmd-help">Enter Here Price By Time.</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label label-checkbox">Select Active or Unactive</label>
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="status"  >  (Status is : @if($carType->status)Active @else Unactive @endif )
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                       
                        
                      </div>
                    </div>
                    <div class="col-sm-12">
                                <button type="submit" class="btn btn-raised ">Submit</button>   
                    </div>
                  </form>
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