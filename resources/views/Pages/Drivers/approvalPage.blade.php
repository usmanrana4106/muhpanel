
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
            <div class="card ">
              <div class="row">
                <div class="container-fluid">
              <div class="col-md-12">

                <table cellspacing="10">
                  <thead>
                    <th>Profile Image</th>
                    <th></th>
                    <th>Identity Proof</th>
                    <th></th>
                    <th>Vehicle Identity Proof</th>

                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        @if(!empty($driverUser->profileImage))
                        <div class="logo" >
                          <img src="{{ url('public/uploads/images/driverImage/'.$driverUser->profileImage) }}" style="width: 150px; height: 150px;" />
                        </div>
                        @else
                        <div class="logo" >
                          <img src="{{ url('public/assets/img/muhrahlogo.png') }}" style="width: 10%; height: 70%;" />
                        </div>
                        @endif
                      </td>

                      <td style="width: 150px"></td>
                      <td>
                        @if(!empty($driverDetails->identityProof))
                        <div class="logo" >
                          <img src="{{ url('public/uploads/images/identityProof/'.$driverDetails->identityProof) }}" style="width: 250px; height: 150px;" />
                        </div>
                        @else
                        <div class="logo" >
                          <img src="{{ url('public/assets/img/muhrahlogo.png') }}" style="width: 10%; height: 70%;" />
                        </div>
                        @endif
                      </td>
                      <td style="width: 150px"></td>


                      <td>
                         @if(!empty($vehicleDetails->vehicleidentityProof))
                        <div class="logo" >
                          <img src="{{ url('public/uploads/images/vehicleProof/'.$vehicleDetails->vehicleidentityProof) }}" style="width: 250px; height: 150px;" />
                        </div>
                        @else
                        <div class="logo" >
                          <img src="{{ url('public/assets/img/muhrahlogo.png') }}" style="width: 10%; height: 70%;" />
                        </div>
                        @endif
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
                  </div>
              </div>
          </div>

          <div class="card">
            <div class="row">
              <div class="container-fluid">
            
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
                <div class="alert alert-success">
                    
                           {{$status}}
                    
                </div>
                @endif
            </div>
          </div>
          </div>

    <div class="row">
                           
              <div class="col-md-6">
                  <div class="card ">
                    <div class="card-header card-header-danger card-header-icon">
                      <div class="card-icon">
                        <i class="material-icons">mail_outline</i>
                      </div>
                      <h4 class="card-title">Driver Info</h4>
                    </div>
                    <div class="card-body ">
                      <form action="{{route('Driver.editProfile')}}" method="post">
                       {{csrf_field()}}
                       <div class="form-group">
                            <label for="exampleInput1" class="bmd-label-floating">Full Name (required)</label>
                            <input type="text" class="form-control" name="fullName" value="{{$driverDetails->fullName}}" required>
                          </div>



                           <input type="hidden" class="form-control" name="driverId" value="{{$driverDetails->driveId}}" required>
                            <input type="hidden" class="form-control" name="userId" value="{{$driverUser->userId}}" required>
                            <input type="hidden" class="form-control" name="vihicleId" value="{{$vehicleDetails->vihicleId}}" required>






                          <div class="row">
                        <div class="col-md-6">
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Email (required)</label>
                                <input type="email" class="form-control"  name="email" value="{{$driverUser->email}}" required>
                              </div>
                            </div>

                           
                        <div class="col-md-6">
                              <div class="form-group">
                                <label for="exampleInput1" class="bmd-label-floating">mobileNumber (required)</label>
                                <input type="number" class="form-control"  name="mobileNumber" value="{{$driverDetails->mobileNumber}}" required>
                              </div>
                            </div>
                          </div>


                          <br>

                          <div class="row col-md-12">
                            <div class="row"> 
                              <h4>Date of Birth Hijri</h4>
                          </div>
                          <div class="col-sm-3">
                              <div class="input-group form-control-lg">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons"></i>
                                  </span>
                                </div>
                                <div class="form-group">
                                  <label for="exampleInput1" class="bmd-label-floating">day (required)</label>
                                  <input type="number" class="form-control"  name="day" required value="{{$dateOfBirth[2]}}">
                                </div>
                              </div>
                            </div>

                           <div class="col-sm-3">
                              <div class="input-group form-control-lg">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons"></i>
                                  </span>
                                </div>
                                <div class="form-group">
                                  <label for="exampleInput1" class="bmd-label-floating">month (required)</label>
                                  <input type="number" class="form-control"  name="month" required value="{{$dateOfBirth[1]}}">
                                </div>
                              </div>
                            </div>

                            <div class="col-sm-3">
                              <div class="input-group form-control-lg">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons"></i>
                                  </span>
                                </div>
                                <div class="form-group">
                                  <label for="exampleInput1" class="bmd-label-floating">year (required)</label>
                                  <input type="number" class="form-control"  name="year" required value="{{$dateOfBirth[0]}}">
                                </div>
                              </div>
                            </div>

                            </div>



                                <div class="form-group">
                                  <label for="exampleInput1" class="bmd-label-floating">capital Identity Number (required)</label>
                                  <input type="number" class="form-control"  name="captainIdentityNumber" required value="{{$driverDetails->captainIdentityNumber}}" >
                                </div>

                              <div class="form-group">
                                    <label for="exampleInput1" class="bmd-label-floating">Account No</label>
                                    <input type="text" class="form-control"  name="accountNo" id="accountNo" value="{{$driverDetails->accountNo}}" >
                              </div>

                              <!-- <div class="col-sm-4">
                                <div class="picture-container">
                                  <div class="picture">
                                    <img src="../../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" />
                                    <input type="file" id="wizard-picture">
                                  </div>
                                  <h6 class="description">Choose Picture</h6>
                                </div>
                            </div> -->
                     
                    </div>
                   
                  </div>
                </div>  


                <div class="col-md-6">
                  <div class="card ">
                    <div class="card-header card-header-danger card-header-icon">
                      <div class="card-icon">
                        <i class="material-icons">contacts</i>
                      </div>
                      <h4 class="card-title">Vehicle Info</h4>
                    </div>
                    <div class="card-body ">
                     
                       
                   <div class="row">
                      <div class="col-md-6">
                              <div class="form-group">
                                <label  for="exampleInput1" class="bmd-label-floating">Vehicle Number</label>
                                <input type="number" class="form-control" id="vihicleNumber" name="vihicleNumber" value="{{$vehicleDetails->vihicleNumber}}" required>
                              </div>
                          </div>


                        

                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="exampleInput1" class="bmd-label-floating">Vehicle Model</label>
                              <input type="number" class="form-control" id="vehicleModel" name="vehicleModel" value="{{$vehicleDetails->vehicleModel}}" required>
                            </div>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="exampleInput1" class="bmd-label-floating">plate Letter Right</label>
                              <input type="text" class="form-control" id="plateLetterRight" name="plateLetterRight" value="{{$vehicleDetails->plateLetterRight}}" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="exampleInput1" class="bmd-label-floating">plate Letter Middle</label>
                              <input type="text" class="form-control" id="plateLetterMiddle" name="plateLetterMiddle" value="{{$vehicleDetails->plateLetterMiddle}}" required>
                            </div>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="exampleInput1" class="bmd-label-floating"> plate Letter Left</label>
                              <input type="text" class="form-control" id="plateLetterLeft" name="plateLetterLeft" value="{{$vehicleDetails->plateLetterLeft}}" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="exampleInput1" class="bmd-label-floating">plate Number</label>
                              <input type="text" class="form-control" id="plateNumber" name="plateNumber" value="{{$vehicleDetails->plateNumber}}" required>
                            </div>
                          </div>
                        </div>



                        <div class="row">

                           <div class="col-md-12">
                            <div class="form-group">
                              @if(!empty($vehicleDetails->company))
                              <label>Company</label>
                              <input type="text" class="form-control" id="company" name="company" value="{{$vehicleDetails->company}}" required>
                              @else
                              <label>Company</label>
                                 <select class="form-control"  id="company" name="company" title="Single Company of Car" required>
                                @if(!empty($companies))
                                  @foreach($companies as $company)
                                  <option value="{{$company->companyName}}"> {{$company->companyName}} </option>
                                  @endforeach
                                @endif
                              </select>
                              @endif
                             
                            </div>
                          </div>



                          <div class="col-md-12">
                           <div class="form-group">

                            @if(!empty($vehicleDetails->brands))
                              <input type="text" class="form-control" id="brands" name="brands" value="{{$vehicleDetails->brands}}" required>
                              @else
                              <label>Brands</label>
                              
                              <input list="brand" name="brands" id="brands"  class="form-control" required>
                                <datalist id="brand">
                                     <option value=""></option>
                                </datalist>
                                @endif
                             </div>
                          </div>






                          <div class="col-md-12">
                            <div class="form-group">
                             @if(!empty($vehicleDetails->plateType))
                              <label  for="exampleInput1" class="bmd-label-floating">plate Type</label>
                              <input type="text" class="form-control" id="plateType" name="plateType" value="{{$vehicleDetails->plateType}}" required>
                              @else
                              <label>PlateType</label>
                              <select id="plateType" name="plateType" class="form-control" title="plate Type" required>
                                    <option value=""></option>
                                    <option value="1">Private car plate</option>
                                    <option value="2">Taxi car plate</option>

                            </select>
                            @endif
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-group select-wizard">
                              @if(!empty($vehicleDetails->vihicleType))
                              <label  for="exampleInput1" class="bmd-label-floating">Vehicle Type</label>
                              <input type="text" class="form-control" id="vihicleType" name="vihicleType" value="{{$vehicleDetails->vihicleType}}" required>
                              @else
                              <label  for="exampleInput1" class="bmd-label-floating">Vehicle Type</label>
                              <select class="form-control" name="vihicleType" title="vehicle Type" required>
                                @if(!empty($carTypes))
                                  @foreach($carTypes as $car)
                                  <option value="{{$car->carId}}"> {{$car->carName}} </option>
                                  @endforeach
                                @endif
                              </select>
                              @endif
                            </div>
                          </div>
                        </div>


                        <label class="col-sm-2 col-form-label label-checkbox">Proofs Status</label>
                        <div class="col-md-12">
                          <div class="row">
                            
                            <div class="col-sm-10 checkbox-radios">
                              <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                  @if(!empty($driverDetails->identityProofStatus))
                                    <input class="form-check-input" type="checkbox" checked name="identityProofStatus">Identity Proof Status
                                  @else
                                    <input class="form-check-input" type="checkbox"  name="identityProofStatus">Identity Proof Status
                                  @endif
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                  @if(!empty($driverDetails->licenceNumberStatus))
                                    <input class="form-check-input" type="checkbox" checked name="licenceNumberStatus"> licence Number Status
                                  @else
                                    <input class="form-check-input" type="checkbox" name="licenceNumberStatus"> licence Number Status
                                  @endif
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                             
                            </div>
                          </div>
                        </div>


                            <div class="col-sm-10 checkbox-radios">
                                  
                                  <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="checkbox" name="hitMot"> Hit MOT
                                      <span class="form-check-sign">
                                        <span class="check"></span>
                                      </span>
                                    </label>
                                  </div>
                                 
                            </div>

                    </div>
                    <div class="card-footer ">
                      <div class="row">
                        <div class="col-md-9">
                         <button type="submit" class="btn btn-finish btn-fill btn-rose btn-wd" >Submit</button>   
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                      </form>

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
                              url:"{{route('VehicleBrands')}}",
                              type:"POST",
                              data:{'companyName' : companyName},
                              dataType:'json',
                              success:function(data){
                                $('#brand').html(data);
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




</body>

</html>