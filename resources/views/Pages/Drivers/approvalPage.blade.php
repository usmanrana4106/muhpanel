
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





            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-icon card-header-rose">
                  <div class="card-icon" style="background: #d22619a1;">
                    <i class="material-icons">perm_identity</i>
                  </div>
                  <h4 class="card-title">Images Related for the Driver Registration-
                    <small class="category">Complete His profile</small>
                  </h4>
                </div>
                <div class="card-body">
                    <!-- <table>
                        <thead>
                            <tr>
                                <td>Identity Proof</td>
                                <td>Vehicle Proof</td>
                                <td>image</td>
                                <td>image</td>
                                                                
                            </tr>
                        </thead>  
                        <tr>
                                <td>
                            
                                        <img src="./assets/img/product3.jpg" alt="..." style=" width=20px; height=20px ">
                                    </td>
                                    
                        </tr>
                    </table> -->


            
              
                  <ul class="nav nav-pills nav-pills-warning" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist" onclick="">
                        Identity Image
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link2" role="tablist" onclick="">
                        Iqama Image
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link3" role="tablist" onclick="">
                        Vehicle Proof Image
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link4" role="tablist" onclick="">
                        Licence Proof Image
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link5" role="tablist" onclick="">
                        Car Image
                      </a>
                    </li>

                  </ul>
                  <div class="tab-content tab-space">
                    <div class="row">
                      @if(!empty($uploadImage))
                        <div class="alert alert-success">
                                   {{$uploadImage}}
                        </div>
                        @endif 
                    </div>
                    
                    <div class="tab-pane active" id="link1">

                       @if(!empty($driverUser->profileImage))
                        <div class="logo" >
                          <img src="{{ url('public/uploads/images/driverImage/'.$driverUser->profileImage) }}" style="width: 600px; height: 400px;"/>
                        </div>
                        @else
                        <div class="logo" >
                          <img src="{{ url('public/assets/img/muhrahlogo.png') }}" style="width: 10%; height: 70%;" />
                        </div>
                        @endif
                          <form action="{{route('Driver.profileImage')}}" method="post" enctype="multipart/form-data">
                           


                            {{csrf_field()}}
                            <div class="col-sm-4">
                            <div class="picture-container">
                              <div class="picture">
                                <img src="../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" style=" width: 20px; height: 20px;" />
                                <input type="file" id="profileImage" name="profileImage" required>
                                <input type="hidden" name="driverId" value="{{$driverDetails->driveId}}">
                                <input type="hidden" name="userId" value="{{$driverDetails->userId}}">
                              </div>
                              <h6 class="description">Choose Picture of ProfileImage</h6>
                            </div>
                          </div> 
                              <button type="submit" class="btn btn-default">Submit</button> 
                          </form> 
                    </div>
                    <div class="tab-pane" id="link2">
                      
                      @if(!empty($driverDetails->identityProof))
                        <div class="logo" >
                          <img src="{{ url('public/uploads/images/identityProof/'.$driverDetails->identityProof) }}" style="width: 600px; height: 400px;"/>
                        </div>
                        @else
                        <div class="logo" >
                          <img src="{{ url('public/assets/img/muhrahlogo.png') }}" style="width: 10%; height: 70%;" />
                        </div>
                        @endif
                        <form action="{{route('Driver.identityProof')}}" method="post" enctype="multipart/form-data"> 
                            {{csrf_field()}}
                            <div class="col-sm-4">
                            <div class="picture-container">
                              <div class="picture">
                                <img src="../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" style=" width: 20px; height: 20px;" />
                                <input type="file" id="identityProof" name="identityProof" required>
                                <input type="hidden" name="driverId" value="{{$driverDetails->driveId}}">
                                <input type="hidden" name="userId" value="{{$driverDetails->userId}}">
                              </div>
                              <h6 class="description">Choose Picture of Iqama</h6>
                            </div>
                          </div> 
                              <button type="submit" class="btn btn-default">Submit</button> 
                        </form>
                    </div>

                    <div class="tab-pane" id="link3">
                      
                      @if(!empty($vehicleDetails->vechicleIdentityProof))
                        <div class="logo" >
                          <img src="{{ url('public/uploads/images/vehicleProof/'.$vehicleDetails->vechicleIdentityProof) }}"  style="width: 600px; height: 400px;"/>
                        </div>
                        @else
                        <div class="logo" >
                          <img src="{{ url('public/assets/img/muhrahlogo.png') }}" style="width: 10%; height: 70%;" />
                        </div>
                        @endif
                        <form action="{{route('Driver.vehicleidentityProof')}}" method="post" enctype="multipart/form-data"> 
                            {{csrf_field()}}
                            <div class="col-sm-4">
                            <div class="picture-container">
                              <div class="picture">
                                <img src="../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" style=" width: 20px; height: 20px;" />
                                <input type="file" id="vechicleIdentityProof" name="vechicleIdentityProof" required>
                                <input type="hidden" name="driverId" value="{{$driverDetails->driveId}}">
                                <input type="hidden" name="userId" value="{{$driverDetails->userId}}">
                              </div>
                              <h6 class="description">Choose Picture of vehicle Identity Proof</h6>
                            </div>
                          </div> 
                              <button type="submit" class="btn btn-default">Submit</button> 
                        </form>
                    </div>

                    <div class="tab-pane" id="link4">
                      
                      @if($driverDetails->licenseProof != 'undefined')
                        <div class="logo" >
                          <img src="{{ url('public/uploads/images/licenseProof/'.$driverDetails->licenseProof) }}" style="width: 600px; height: 400px;" />
                        </div>
                        @else
                        <div class="logo" >
                          <img src="{{ url('public/assets/img/muhrahlogo.png') }}" style="width: 10%; height: 70%;" />
                        </div>
                        @endif
                        <form action="{{route('Driver.licenseProof')}}" method="post" enctype="multipart/form-data"> 
                            {{csrf_field()}}
                            <div class="col-sm-4">
                            <div class="picture-container">
                              <div class="picture">
                                <img src="../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" style=" width: 20px; height: 20px;" />
                                <input type="file" id="licenseProof" name="licenseProof" required>
                                <input type="hidden" name="driverId" value="{{$driverDetails->driveId}}">
                                <input type="hidden" name="userId" value="{{$driverDetails->userId}}">
                              </div>
                              <h6 class="description">Choose Picture of license Proof</h6>
                            </div>
                          </div> 
                              <button type="submit" class="btn btn-default">Submit</button> 
                        </form>
                    </div>


                    <div class="tab-pane" id="link5">
                      
                      @if(!empty($vehicleDetails->driverCarImage))
                        <div class="logo" >
                          <img src="{{ url('public/uploads/images/driverCarImage/'.$vehicleDetails->driverCarImage) }}"  style="width: 600px; height: 400px;"/>
                        </div>
                        @else
                        <div class="logo" >
                          <img src="{{ url('public/assets/img/muhrahlogo.png') }}" style="width: 10%; height: 70%;" />
                        </div>
                        @endif

                        <form action="{{route('Driver.driverCarImage')}}" method="post" enctype="multipart/form-data"> 
                            {{csrf_field()}}
                            <div class="col-sm-4">
                            <div class="picture-container">
                              <div class="picture">
                                <img src="../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" style=" width: 20px; height: 20px;" />
                                <input type="file" id="driverCarImage" name="driverCarImage" required>
                                <input type="hidden" name="driverId" value="{{$driverDetails->driveId}}">
                                <input type="hidden" name="userId" value="{{$driverDetails->userId}}">
                              </div>
                              <h6 class="description">Choose Picture of Driver Car Image</h6>
                            </div>
                          </div> 
                              <button type="submit" class="btn btn-default">Submit</button> 
                        </form>
                    </div>






                    
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
                                  <input type="number" class="form-control"  name="day" required value="<?php if(!empty($dateOfBirth[2]))
                                  echo $dateOfBirth[2];?>">
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
                                  <input type="number" class="form-control"  name="month" required value="<?php if(!empty($dateOfBirth[1]))
                                  echo $dateOfBirth[1];?>">
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
                                  <input type="number" class="form-control"  name="year" required value="<?php if(!empty($dateOfBirth[0]))
                                  echo $dateOfBirth[0];?>">
                                </div>
                              </div>
                            </div>

                            </div>


                            <div class="form-group">
                                  <label for="exampleInput1" class="bmd-label-floating">Nationality :  </label>
                                <br>
                                <select class="selectpicker" name="nationality" data-size="7" data-style="select-with-transition"  required>
                                        <option value="{{$driverDetails->nationality}}">{{$driverDetails->nationality}}</option>

                                      @if(!empty($nationalities))
                                        @foreach($nationalities as $nationality)
                                        <option value="{{$nationality->nat_name}}"> {{$nationality->nat_name}} </option>
                                        @endforeach
                                      @endif
                                </select>
                            </div>
                                <br>
                            

                                <div class="form-group">
                                  <label for="exampleInput1" class="bmd-label-floating">capital Identity Number (required)</label>
                                  <input type="number" class="form-control"  name="captainIdentityNumber" required value="{{$driverDetails->captainIdentityNumber}}" >
                                </div>

                              <div class="form-group">
                                    <label for="exampleInput1" class="bmd-label-floating">Account No</label>
                                    <input type="text" class="form-control"  name="accountNo" id="accountNo" value="{{$driverDetails->accountNo}}" >
                              </div>

                              <div class="form-group">
                                    <label for="exampleInput1" class="bmd-label-floating">Driver Reference Number</label>
                                    <input type="text" class="form-control"  name="driverReferenceNumber" id="driverReferenceNumber" value="{{$driverDetails->driverReferenceNumber}}" readonly >
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
                              
                              
                              <label>Company</label>
                                 <select class="form-control"  id="company" name="company" title="Single Company of Car" required>

                                  @if(!empty($vehicleDetails->company))
                                    <option value="{{$vehicleDetails->company}}" selected> {{$vehicleDetails->company}} </option>
                                  @endif


                                @if(!empty($companies))
                                  @foreach($companies as $company)
                                  <option value="{{$company->companyName}}"> {{$company->companyName}} </option>
                                  @endforeach
                                @endif
                              </select>
                              
                             
                            </div>
                          </div>



                          <div class="col-md-12">
                           <div class="form-group">
                           
                              <label>Brands</label>
                              
                              <input list="brand" name="brands" id="brands" value="@if(!empty($vehicleDetails->brands)){{$vehicleDetails->brands}}@endif" class="form-control" required>
                                <datalist id="brand">
                                   
                                     <option value=""></option>
                                </datalist>
                                
                             </div>
                          </div>






                          <div class="col-md-12">
                            <div class="form-group">
                             
                              
                              <label>PlateType</label>
                              <select id="plateType" name="plateType" class="form-control" title="plate Type" required>
                                     @if(!empty($vehicleDetails->plateType))
                                      <option value="{{$vehicleDetails->plateType}}">{{$vehicleDetails->plateType}}</option>
                                     @endif
                                    <option value=""></option>
                                    <option value="1">Private car plate</option>
                                    <option value="2">Taxi car plate</option>

                            </select>
                           
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


                        <div class="form-group">
                                    <label for="exampleInput1" class="bmd-label-floating">Driver Reference Number</label>
                                    <input type="text" class="form-control"  name="vehicleReferenceNumber" id="vehicleReferenceNumber" value="{{$vehicleDetails->vehicleReferenceNumber}}" readonly >
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


                      <div class="form-check form-check-inline">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" checked name="motDriver"> Hit MOT For Driver
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                        </label>
                      </div>

                      <div class="form-check form-check-inline">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" checked name="motVehicle"> Hit MOT For Vehicle
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                        </label>
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