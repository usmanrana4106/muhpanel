
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
              
<LEGEND>Drivers Profile</LEGEND>
  
        <div class="row">
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="{{  $driverUserInfo->profileImage }}">
                    <img class="img" src="{{  $driverUserInfo->profileImage }}" />
                  </a>
                </div>
                <div class="card-body">
                  <h6 class="card-category text-gray">User ID{{ $driverUserInfo->userId }}</h6>
                  <h6 class="card-category text-gray">{{ $driverUserInfo->userType }}</h6>
                  <h4 class="card-title">{{ $driverInfo->fullName }}</h4>
                  <p class="card-description">
                    {{ "UserID: ".$driverInfo->userId }}<br>
                    {{ "DriverID: ".$driverInfo->driveId }}<br>

                    {{ $driverUserInfo->gender }}<br>
                    {{ $driverInfo->mobileNumber }}<br>
                    Iqama : {{ $driverInfo->captainIdentityNumber }}<br>
                    {{ $driverUserInfo->email }}<br>
                    <p>{{ $driverInfo->rating }}<i class="material-icons">star</i></p> <br>
                    {{ $driverUserInfo->crd }}<br>
                    <textarea> {{ "Driver Ride Status : ".$driverInfo->driverStatus }} </textarea><br>
                    Status: @if($driverUserInfo->loginStatus == 1)online @else Offline @endif
                     <input type="hidden" name="name" id="name" value="{{$driverInfo->fullName}}">
                   
                    <input type="hidden" name="mobile" id="mobile" value="{{$driverInfo->mobileNumber}}">
                    <input type="hidden" name="userId" id="userId" value="{{$driverUserInfo->userId}}">

                    @if(!empty(session()->get('driverFree')))
                    <div class="row">
                      <div class="alert alert-success">
                          Driver is Successfully Free now
                      </div>
                    </div>
                    @endif

                    <a href="{{route('Driver.freeDriver',$driverUserInfo->userId)}}">
                        <button type="button" rel="tooltip" class="btn btn-warning">
                          <i class="material-icons">edit</i>
                          Free Driver
                        </button>
                    </a>

                  </p>
                 
                </div>
              </div>
            </div>








            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-icon card-header-rose">
                  <div class="card-icon" style="background: #d22619a1;">
                    <i class="material-icons">perm_identity</i>
                  </div>
                  <h4 class="card-title">Edit Profile -
                    <small class="category">Complete your profile</small>
                  </h4>
                      <div class="row pull-right">
                                <a href="{{route('Driver.logoutDriver',$driverUserInfo->userId)}}">
                                            <button type="button" rel="tooltip" class="btn btn-danger ">
                                              
                                              logout
                                            </button>
                                        </a>
                      </div>

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
                        Vehicle Info
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link2" role="tablist" onclick="">
                        Reviews
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link3" role="tablist" onclick="">
                        wallet
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active" id="link1">
                    <table  class="table table-responsive table-striped table-bordered table-bordered">
                        <thead>
                            <tr>
                                <td style="width: 33%">Identity Proof</td>
                                

                                <td style="width: 33%">Vehicle Proof</td>
                               

                                <td style="width: 33%">Vehicle Info</td>
                                
                                                                
                            </tr>
                        </thead>  
                        <tr>
                                <td style="width: 33%">
                                @if(!empty($driverInfo->identityProof))
                                 @if($driverInfo->identityProof == "not Avaliable")
                                      <div class="photo" >
                                        <img src="" alt="..." style="max-width: 300px; height:200px; ">
                                      </div>
                                  @else
                                      <div class="photo" >
                                        <img src="{{ $driverInfo->identityProof }}" alt="..." style="max-width: 250px; height:150px; ">
                                      </div>
                                  @endif
                                @endif
                                </td>
                              

                                <td style="width: 33%">
                                @if(!empty($VehicleInfo->vechicleIdentityProof))
                                  @if($VehicleInfo->vechicleIdentityProof == "not Avaliable")
                                        <img src="" alt="..." style="max-width: 300px; height:200px; ">
                                  @else
                                      <div class="photo" >
                                            <img src="{{ $VehicleInfo->vechicleIdentityProof }}" alt="..." style="max-width: 250px; height:150px; ">
                                      </div>
                                  @endif
                                @endif

                                     
                                </td>
                                

                                <td style="width: 33%">
                                  @if(!empty($VehicleInfo))
                                      @if(!empty($VehicleInfo->vehicleModel))
                                      <h5>Vehicle Model :  {{ $VehicleInfo->vehicleModel}}</h5>
                                        @else
                                            <h5>NOT FOUND</h5>
                                        @endif
                                            @if(!empty($VehicleInfo->company))
                                             <h5>Vehicle Company :  {{ $VehicleInfo->company }}</h5>
                                          @else
                                              <h5>NOT FOUND</h5>
                                          @endif
                                            @if(!empty($VehicleInfo->vihicleNumber))
                                             <h5>Vehicle Number :  {{ $VehicleInfo->vihicleNumber }}</h5>
                                          @else
                                              <h5>NOT FOUND</h5>
                                          @endif

                                      @if(!empty($VehicleInfo->vihicleType))

                                          @if($VehicleInfo->vihicleType == '1')
                                            <h5>Vehicle Type :  Taxi</h5>
                                          @elseif($VehicleInfo->vihicleType == '2')
                                            <h5>Vehicle Type :  Sedan</h5>
                                          @elseif($VehicleInfo->vihicleType == '3')
                                            <h5>Vehicle Type :  SUV</h5>
                                          @elseif($VehicleInfo->vihicleType == '4')
                                            <h5>Vehicle Type :  Tow Hydrulic</h5>
                                          @elseif($VehicleInfo->vihicleType == '5')
                                            <h5>Vehicle Type :  VAN</h5>
                                          @elseif($VehicleInfo->vihicleType == '7')
                                            <h5>Vehicle Type :  Tow Car</h5>
                                          @else
                                                            <h5>NOT FOUND</h5>
                                          @endif

                                    @else
                                        <h5>NOT FOUND</h5>
                                    @endif

                                          @if(!empty($VehicleInfo->vihicleType))
                                      <h5>vehicle Type : {{ $VehicleInfo->vihicleType }}</h5>
                                          @else
                                              <h5>NOT FOUND</h5>
                                          @endif
                                          @if(!empty($VehicleInfo->plateNumber))
                                      <h5>Vehicle PlateNumber :  {{ $VehicleInfo->plateNumber }}</h5>
                                          @else
                                              <h5>NOT FOUND</h5>
                                          @endif
                                          @if(!empty($VehicleInfo->plateLetterRight))
                                      <h5>Vehicle PlateLetters : {{ $VehicleInfo->plateLetterRight." ".$VehicleInfo->plateLetterMiddle." ".$VehicleInfo->plateLetterLeft }}</h5>
                                          @else
                                              <h5>NOT FOUND</h5>
                                          @endif
                                          @if(!empty($VehicleInfo->plateType))
                                      <h5>Vehicle PlateType : {{ $VehicleInfo->plateType }}</h5>
                                          @else
                                              <h5>NOT FOUND</h5>
                                          @endif
                                          @if(!empty($VehicleInfo->vehicleReferenceNumber))
                                      <h5>Reference Number :  {{ $VehicleInfo->vehicleReferenceNumber }}</h5>
                                          @else
                                              <h5>NOT FOUND</h5>
                                          @endif
                                    @else
                                    <h5>No record of vehicle</h5>
                                  @endif
                                </td>    
                        </tr>
                    </table>
                    </div>
                    <div class="tab-pane" id="link2">
                      
                      <table  id="reviews" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>

                              <tr>
                            
                               <th>raiting Id</th>
                               <th>booking Id</th>
                               <th>Passenger Id</th>
                               <th>rate</th>
                               <th>review</th>
                               <th>date</th>
                                                
                                                
                            </tr>

                        </thead>  
                        <tbody>
                          
                        </tbody>
                               
                     
                    </table>
                   

                    </div>
                    





                    <div class="tab-pane " id="link3" >
                      <table  id="wallet" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>

                              <tr>
                            
                                <th>D ID</th>                        
                                <th>D Name</th>
                                <th>Total Earn</th>
                                <th>total pay</th>
                                <th>total CP</th>
                                <th>total Vat</th>
                                <th>Curr Cash</th>
                                <th>Curr Earn</th>
                                <th>curr CP</th>
                                <th>Curr Vat</th>
                                <th>Creditor</th>
                                <th>Pay Left</th>
                                <th>Action</th>
                                                
                                                
                            </tr>

                        </thead>  
                        <tbody>
                             @if(!empty($Wallet))
                        

                                 <tr class="warning" >
                                    <td style="width: 1%">{{ $Wallet->driverId }}</td>
                                    <td style="width: 3%">{{ $Wallet->fullName }}</td>
                                    <td style="width: 1%">{{ $Wallet->totalEarn }}</td>
                                    <td style="width: 1%">{{ $Wallet->totalPay }}</td>
                                    <td style="width: 1%">{{ $Wallet->totalCompanyProfit }}</td>                                   
                                    <td style="width: 1%">{{ $Wallet->totalVatPaid }}</td>
                                    <td style="width: 1%">{{ $Wallet->currCash }}</td>
                                    <td style="width: 1%">{{ $Wallet->currentEarn }}</td>
                                    <td style="width: 1%">{{ $Wallet->currCompanyProfit }}</td>
                                    <td style="width: 1%">{{ $Wallet->currVat }}</td>
                                    <td style="width: 1%">{{ $Wallet->creditor }}</td>
                                    <td style="width: 1%">{{ $Wallet->currentpaymentLeft }}</td>
                                   
                                    
                                    <td style="width: 5%">
                                        <a href="{{ url('/R_drivers_getPayments',$Wallet->driverId) }}">
                                          <button  type="button" class="btn btn-danger ">Get Payment</button>
                                        </a>
                                         <a href="{{ url('/R_drivers_getAllPaymentRecords',$Wallet->driverId) }}">
                                          <button  type="button" class="btn btn-success ">Receipts</button>
                                        </a>

                                    </td>
                                </tr>

                             @endif
                        </tbody>
                               
                     
                    </table>
                    </div>










                  </div>
                


                </div>
              </div>
            </div>









            </div>










              










            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-icon card-header-rose">
                  <div class="card-icon">
                    <i class="material-icons">perm_identity</i>
                  </div>
                  <h4 class="card-title">Booking Details -
                    <small class="category"></small>
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
                      <a class="nav-link active" data-toggle="tab" href="#link5" role="tablist" onclick="progressTable()">
                       Progress
                      </a>
                    </li>



                    <li class="nav-item ">
                      <a class="nav-link " data-toggle="tab" href="#link3" role="tablist" onclick="CompleteTables()">
                        Complete
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link4" role="tablist" onclick="CancelledTables()">
                       Cancelled
                      </a>
                    </li>

                   



                  </ul>
                  <div class="tab-content tab-space">
                   
                  

                    <div class="tab-pane active" id="link5" >
                      <table  id="progress" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>

                              <tr>
                            
                               <th >S.No.</th>
                                <th >PickUp Address</th>
                                <th >Des Address</th>
                                <th >Driver</th>
                                <th >driver mobile</th>
                                <th >Trip Cost </th>
                                <th >Start Date </th>
                                <th >Start Time</th>
                                <th >Ride Status</th>
                                                
                                                
                            </tr>

                        </thead>  
                        <tbody>
                          
                        </tbody>
                               
                     
                    </table>
                    </div>









                    <div class="tab-pane" id="link3" >
                      <table  id="bookingComplete" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>

                            <tr>
                            
                                <th >S.No.</th>
                                <th >PickUp Address</th>
                                <th >Des Address</th>
                                <th >Driver</th>
                                <th >driver mobile</th>
                                <th >Trip Cost </th>
                                <th >Actual Cost </th>
                                <th >Start Date </th>
                                <th >Start Time</th>
                                <th >End Date </th>
                                <th >End Time</th>
                                <th >Distance</th>
                                <th >Ride Status</th>
                                                
                            </tr>

                        </thead>  
                        <tbody>
                          
                        </tbody>
                               
                     
                    </table>
                    </div>




                    <div class="tab-pane" id="link4" >
                      <table  id="bookingCancelled" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>

                            <tr>
                            
                                <th >S.No.</th>
                                <th >PickUp Address</th>
                                <th >Des Address</th>
                                <th >Driver</th>
                                <th >driver mobile</th>
                                <th >Trip Cost </th>
                                <th >Start Date </th>
                                <th >Start Time</th>
                                <th >Ride Status</th>
                                <th >Rejected By</th>
                                <th >Reason</th>
                                                
                            </tr>

                        </thead>  
                        <tbody>
                          
                        </tbody>
                               
                     
                    </table>
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








<script type="text/javascript">



  var timeleft = 10;
var downloadTimer = setInterval(function(){
   progressTables.ajax.reload();
  console.log(moment().format());
},9000);





   var name=document.getElementById("name").value;
    var mobile=document.getElementById("mobile").value;
    var userId=document.getElementById("userId").value;
  


    reviews= $('#reviews').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "ajax": {
                        "url":"<?= url('api/R_drivers_driverRaitings') ?>",
                        "dataType":"json",
                        "type":"POST",
                        "data":{
                                "_token":"<?= csrf_token() ?>",
                                "rideStatus":'Progress',
                                "userId":userId,
                                
                                }
                      },
                      "columns":[

                        {"data":"ratingId"},
                        {"data":"bookingId"},
                        {"data":"passangerId"},
                        {"data":"rate"},
                        {"data":"review"},
                        {"data":"crd"},
                      
                      ]

                    } );




  progressTables =$('#progress').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "ajax": {
                        "url":"<?= url('api/R_drivers_bookings') ?>",
                        "dataType":"json",
                        "type":"POST",
                        "data":{
                                "_token":"<?= csrf_token() ?>",
                                "rideStatus":'Progress',
                                "userId":userId,
                                
                                }
                      },
                      "columns":[
                        {"data":"bookingId"},
                        {"data":"pickupAddress"},
                        {"data":"destinationAddress"},
                        {"data":"fullName"},
                        {"data":"mobileNumber"},
                        {"data":"tripTotal"},
                        {"data":"rideStartDate"},
                        {"data":"rideStartTime"},
                        {"data":"rideStatus"},
                      
                      ]

                    } );








  


   completeTables =$('#bookingComplete').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "ajax": {
                        "url":"<?= url('api/R_drivers_bookings') ?>",
                        "dataType":"json",
                        "type":"POST",
                        "data":{
                                "_token":"<?= csrf_token() ?>",
                                "rideStatus":'Complete',
                                "userId":userId,
                                "name":name,
                                "mobile":mobile
                                }
                      },
                      "columns":[
                        {"data":"bookingId"},
                        {"data":"pickupAddress"},
                        {"data":"destinationAddress"},
                        {"data":"fullName"},
                        {"data":"mobileNumber"},
                        {"data":"tripTotal"},
                        {"data":"Actual_TripTotal"},
                        {"data":"rideStartDate"},
                        {"data":"rideStartTime"},
                        {"data":"rideEndDate"},
                        {"data":"rideEndTime"},
                        {"data":"actualDistance"},
                        {"data":"rideStatus"},
                      
                      ]

                    } );


   






      cancelledTables =$('#bookingCancelled').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "ajax": {
                        "url":"<?= url('api/R_drivers_bookings') ?>",
                        "dataType":"json",
                        "type":"POST",
                        "data":{
                                "_token":"<?= csrf_token() ?>",
                                "rideStatus":'Cancelled',
                                "userId":userId,
                                "name":name,
                                "mobile":mobile
                                }
                      },
                      "columns":[

                        {"data":"bookingId"},
                        {"data":"pickupAddress"},
                        {"data":"destinationAddress"},
                        {"data":"fullName"},
                        {"data":"mobileNumber"},
                        {"data":"tripTotal"},
                        {"data":"rideStartDate"},
                        {"data":"rideStartTime"},
                        {"data":"rideStatus"},
                        {"data":"rejectBy"},
                        {"data":"reason"},
 
                      ]

                    });

  function progressTable() 
  {
    var userId=document.getElementById("userId").value;
   progressTables.ajax.reload();
  

  }

  function CompleteTables()
  {
    var userId=document.getElementById("userId").value;

     completeTables.ajax.reload();
  }

  function CancelledTables()
  {
    var userId=document.getElementById("userId").value;
     cancelledTables.ajax.reload();
  } 
</script>








</body>

</html>