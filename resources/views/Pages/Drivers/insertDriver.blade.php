
<!-- __________________________________________Header___________________________________________________ -->
@include('layouts.header')


<body class="">
  <div class="wrapper ">
  

<!-- __________________________________________SideBar___________________________________________________ -->



@include('layouts.sidebar')

    <div class="main-panel">
      <!-- __________________________________________NavBar___________________________________________________ -->


 <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
@include('layouts.navbar')
      <div class="content">
          







      	<div class="content">
        <div class="container-fluid">

          <div class="col-md-8 col-12 mr-auto ml-auto">
            <!--      Wizard container        -->
            <div class="wizard-container">
              <div class="card card-wizard" data-color="rose" id="wizardProfile">


                <form action="{{route('Driver.Registered')}}" method="post">
                  {{csrf_field()}}
                  <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                  <div class="card-header text-center">
                    <h3 class="card-title">
                      Register Driver
                    </h3>
                    <h5 class="card-description">Here you can register driver with his vehicle. </h5>
                    
                   

                  </div>
                  <div class="wizard-navigation" >
                    <ul class="nav nav-pills" >
                      <li class="nav-item" >
                        <a class="nav-link active" href="#about" data-toggle="tab" role="tab">
                          Driver Profile
                        </a>
                      </li>
                      
                      <li class="nav-item">
                        <a class="nav-link" href="#address" data-toggle="tab" role="tab">
                          Driver Vehicle
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane active" id="about">
                        <h5 class="info-text"> Let's start with the basic information (with validation)</h5>
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

                       @if(!empty($status))
                          <div class="alert alert-danger">
                                {{$status}}
                          </div>
                        @endif
                        <div class="row justify-content-center">
                          <div class="col-sm-4">
                            <div class="picture-container">
                              <div class="picture">
                                <img src="../../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" />
                                <input type="file" id="wizard-picture">
                              </div>
                              <h6 class="description">Choose Picture</h6>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">face</i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput1" class="bmd-label-floating">Full Name (required)</label>
                                <input type="text" class="form-control" name="fullName" required>
                              </div>
                            </div>
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">email</i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Email (required)</label>
                                <input type="email" class="form-control"  name="email" required>
                              </div>
                            </div>
                          </div>
                          

                          <div class="col-lg-8 mt-6">
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">phone</i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput1" class="bmd-label-floating">mobileNumber (required)</label>
                                <input type="number" class="form-control"  name="mobileNumber" required>
                              </div>
                            </div>
                          </div>

                          <div class="row col-md-12">

	                          <div class="col-sm-5">
	                            <div class="input-group form-control-lg">
	                              <div class="input-group-prepend">
	                                <span class="input-group-text">
	                                  <i class="material-icons"></i>
	                                </span>
	                              </div>
	                              <div class="form-group">
	                                <label for="exampleInput1" class="bmd-label-floating">day (required)</label>
	                                <input type="number" class="form-control"  name="day" required>
	                              </div>
	                            </div>
	                          </div>

	                         <div class="col-sm-5">
	                            <div class="input-group form-control-lg">
	                              <div class="input-group-prepend">
	                                <span class="input-group-text">
	                                  <i class="material-icons"></i>
	                                </span>
	                              </div>
	                              <div class="form-group">
	                                <label for="exampleInput1" class="bmd-label-floating">month (required)</label>
	                                <input type="number" class="form-control"  name="month" required>
	                              </div>
	                            </div>
	                          </div>

	                          <div class="col-sm-5">
	                            <div class="input-group form-control-lg">
	                              <div class="input-group-prepend">
	                                <span class="input-group-text">
	                                  <i class="material-icons"></i>
	                                </span>
	                              </div>
	                              <div class="form-group">
	                                <label for="exampleInput1" class="bmd-label-floating">year (required)</label>
	                                <input type="number" class="form-control"  name="year" required>
	                              </div>
	                            </div>
	                          </div>
                             <div class="col-sm-12">
                              <div class="input-group form-control-lg">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons"></i>
                                  </span>
                                </div>
                                <div class="form-group">
                                  <label for="exampleInput1" class="bmd-label-floating">capital Identity Number (required)</label>
                                  <input type="number" class="form-control"  name="captainIdentityNumber" required>
                                </div>
                              </div>
                            </div>
                          </div>

                         


                        </div>
                      </div>
                      
                      <div class="tab-pane" id="address">
                        <div class="row justify-content-center">
                          <div class="col-sm-12">
                            <h5 class="info-text"> Driver Vehicle Information Here </h5>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Vehicle Number</label>
                              <input type="number" class="form-control" id="vihicleNumber" name="vihicleNumber" required>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Company</label>
                              <select class="selectpicker" name="company" id="company"  data-size="7" data-style="select-with-transition" title="Single Select" required>
                                @if(!empty($companies))
                                  @foreach($companies as $company)
                                  <option value="{{$company->companyName}}"> {{$company->companyName}} </option>
                                  @endforeach
                                @endif
                              </select>
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Brands</label>
                              
                              <input list="carbrand" name="brands" id="brands"  class="form-control" >
                                <datalist id="carbrand">
                                     <option value=""></option>
                                </datalist>

                             </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Vehicle Model</label>
                              <input type="number" class="form-control" id="vehicleModel" name="vehicleModel" required>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>plate Letter Right</label>
                              <input type="text" class="form-control" id="plateLetterRight" name="plateLetterRight" required>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>plate Letter Middle</label>
                              <input type="text" class="form-control" id="plateLetterMiddle" name="plateLetterMiddle" required>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> plate Letter Left</label>
                              <input type="text" class="form-control" id="plateLetterLeft" name="plateLetterLeft" required>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>plate Number</label>
                              <input type="text" class="form-control" id="plateNumber" name="plateNumber" required>
                            </div>
                          </div>
                         
                          <div class="col-sm-4">
                            <div class="form-group">
                            
                              <select id="plateType" name="plateType" class="selectpicker" data-size="7" data-style="select-with-transition" title="plate Type" required>
                                    <option value=""></option>
                                    <option value="1">Private car plate</option>
                                    <option value="2">Taxi car plate</option>

                            </select>
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-group select-wizard">
                              <label>vehicle Type</label>
                              <select class="selectpicker" name="vihicleType" data-size="7" data-style="select-with-transition" title="Single Select" required>
                                @if(!empty($carTypes))
                                  @foreach($carTypes as $car)
                                  <option value="{{$car->carId}}"> {{$car->carName}} </option>
                                  @endforeach
                                @endif
                              </select>
                            </div>
                          </div>

                          <div class="col-sm-5">
                          <div class="row">
                            <label class="col-sm-2 col-form-label label-checkbox">Proofs Status</label>
                            <div class="col-sm-10 checkbox-radios">
                              <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" name="identityProofStatus">Identity Proof Status
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" name="licenceNumberStatus"> licence Number Status
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                             
                            </div>
                          </div>
                        </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="mr-auto">
                      <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" value="Previous">
                    </div>
                    <div class="ml-auto">
                      <input type="button" class="btn btn-next btn-fill btn-rose btn-wd" name="next" value="Next">
                        <button type="submit" class="btn btn-finish btn-fill btn-rose btn-wd" style="display: none;">Submit</button>   
                   
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </form>
              </div>
            </div>
            <!-- wizard container -->
          </div>
        </div>
      </div>











      </div>


 <script type="text/javascript">
                     $(document).ready(function(){
                      $('#company').on('change',function(){

                        var companyName= $(this).val();
                        if(companyName !='')
                        {
                          $.ajax({
                              url:"api/getVehicleBrands",
                              type:"POST",
                              data:{'companyName' : companyName},
                              dataType:'json',
                              success:function(data){
                                $('#carbrand').html(data);
                              },
                              error:function(){
                                alert('Error');
                              }
                          });



                        }

                        });

                     });

                   </script>


                 
<!-- __________________________________________Footer___________________________________________________ -->



@include('layouts.footer')









                </div>
              </div>
              








<!-- __________________________________________Footer___________________________________________________ -->



<!-- @include('layouts.sideFilters') -->




<!-- __________________________________________JsFiles___________________________________________________ -->



@include('layouts.js')

<script>
    $(document).ready(function() {
      // Initialise the wizard
      demo.initMaterialWizard();
      setTimeout(function() {
        $('.card.card-wizard').addClass('active');
      }, 600);
    });
  </script>


</body>

</html>