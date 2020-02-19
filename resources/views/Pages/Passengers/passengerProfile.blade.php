
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
              
          <LEGEND>Passenger</LEGEND>

        <div class="row">

            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                    @if(!empty($passengerInfo->profileImage))
                  
                    <img class="img" src="{{ $passengerInfo->profileImage }}" />
           
                  @else
                    <img class="img" src="../images/muhrahpanel/admin.png" />

                    @endif

                </div>
                <div class="card-body">
                  <h6 class="card-category text-gray">User ID{{ $passengerInfo->userId }}</h6>
                  <h6 class="card-category text-gray">{{ $passengerInfo->userType }}</h6>
                  <h4 class="card-title">{{ $passengerInfo->fullName }}</h4>
                  <p class="card-description">
                    {{ "UserID: ".$passengerInfo->userId }}<br>
                    {{ "PassengersId: ".$passengerInfo->pasengerId }}<br>
                    {{ $passengerInfo->gender }}<br>
                    {{ $passengerInfo->mobileNumber }}<br>
                    {{ $passengerInfo->email }}<br>
                    {{ $passengerInfo->crd }}<br>
                    <input type="hidden" name="name" id="name" value="{{$passengerInfo->fullName}}">
                    <input type="hidden" name="mobile" id="mobile" value="{{$passengerInfo->mobileNumber}}">
                    <input type="hidden" name="userId" id="userId" value="{{$passengerInfo->userId}}">


                    @if(!empty(session()->get('passengerFree')))
                        <div class="row">
                            <div class="alert alert-success">
                                Passenger Session is Successfully Free now
                            </div>
                        </div>
                    @endif

                    <a href="{{route('Passanger.freePassenger',$passengerInfo->userId)}}">
                        <button type="button" rel="tooltip" class="btn btn-warning">
                            <i class="material-icons">edit</i>
                            Free Passenger
                        </button>
                    </a>


                  </p>
                    <table  class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          
                        
                          <th >totalPay</th>
                          <th >credit </th>
                          <th >due </th>
                          
                          
                        </tr>
                      </thead>
                      <tbody>
                        
                           @if(!empty($wallet))
                            <tr class="warning" >
                                    <td >{{ $wallet->totalPay }}</td>
                                    <td >{{ $wallet->credit }}</td>
                                    <td >{{ $wallet->due }}</td>
                            </tr>
                            @else
                            <tr class="warning" >
                                    <td >0.0</td>
                                    <td >0.0</td>
                                    <td >0.0</td>
                            </tr>
                           @endif
                        
                      </tbody>
                    </table>
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
                        Passenger 
                      </a>
                    </li>
                    
                   
                  </ul>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active" id="link1">
                       <table  id="reviews" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>

                              <tr>
                            
                               <th>raiting Id</th>
                               <th>booking Id</th>
                               <th>Driver Id</th>
                               <th>rate</th>
                               <th>review</th>
                               <th>date</th>
                                                
                                                
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




            


          <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-icon card-header-rose">
                  <div class="card-icon">
                    <i class="material-icons">perm_identity</i>
                  </div>
                  <h4 class="card-title">Booking Details -
                    <small class="category"></small>
                  </h4>
                  <h4 class="card-title pull-right">
                  <a href="{{ url('/D_passenger_deletePassegerRecords',$passengerInfo->userId) }}">
                                        <button  type="button" class="btn btn-rose size">Delete All the Records</button></a>
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
                      <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist" onclick="broadcastingTable()">
                         BroadCasting
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link2" role="tablist" onclick="progressTables()">
                        Progress
                      </a>
                    </li>
                   
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link3" role="tablist" onclick="CompleteTables()">
                        Complete
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link4" role="tablist" onclick="CancelledTables()">
                       Cancelled
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link5" role="tablist" onclick="cancelOrNotAcceptTables()">
                       Cancel or Not Accept
                      </a>
                    </li>




                  </ul>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active" id="link1">
                    <table  id="bookingbroadcasting" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>

                            <tr>
                            
                              <th >S.No.</th>
                              <th >PickUp Address</th>
                              <th >Des Address</th>
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
                    <div class="tab-pane" id="link2" >
                      <table  id="bookingProgress" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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



                    <div class="tab-pane" id="link5" >
                      <table  id="cancelOrNotAccept" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>

                            <tr>
                            
                                <th >S.No.</th>
                                <th >PickUp Address</th>
                                <th >Des Address</th>
                                <th >Trip Cost </th>
                                <th >Start Date </th>
                                <th >Start Time</th>
                                <th >Ride Status</th>
                                <th >distance</th>
                               
                                                
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

<script>
var name=document.getElementById("name").value;
    var mobile=document.getElementById("mobile").value;
    var userId=document.getElementById("userId").value;
  



var downloadTimer = setInterval(function(){
  progressTable.ajax.reload();
  broadcasting.ajax.reload();
  console.log(moment().format());
},9000);


    reviews= $('#reviews').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "ajax": {
                        "url":"<?= url('api/R_passenger_Raitings') ?>",
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
                        {"data":"driverId"},
                        {"data":"rate"},
                        {"data":"review"},
                        {"data":"crd"},
                      
                      ]

                    } );

















  function progressTables() 
  {
   progressTable.ajax.reload();
  }

 function broadcastingTable()
 {
    broadcasting.ajax.reload();
 }

 function CompleteTables()
 {
    completeTables.ajax.reload();
 }

 function CancelledTables()
 {
    cancelledTables.ajax.reload();
 } 


 function cancelOrNotAcceptTables()
 {
    cancelAndNotAccept.ajax.reload();
 }

     progressTable =$('#bookingProgress').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "ajax": {
                        "url":"<?= url('api/R_passenger_bookings') ?>",
                        "dataType":"json",
                        "type":"POST",
                        "data":{
                                "_token":"<?= csrf_token() ?>",
                                "rideStatus":'Progress',
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
                       
                      ]

                    });

     

      broadcasting=$('#bookingbroadcasting').DataTable( {
                     "processing": true,
                      "serverSide": true,
                      "ajax": {
                        "url":"<?= url('api/R_passenger_bookings') ?>",
                        "dataType":"json",
                        "type":"POST",
                        "data":{
                                "_token":"<?= csrf_token() ?>",
                                "rideStatus":'BroadCasting',
                                "userId":userId,
                                "name":name,
                                "mobile":mobile
                                }
                      },
                      "columns":[
                        {"data":"bookingId"},
                        {"data":"pickupAddress"},
                        {"data":"destinationAddress"},
                        {"data":"tripTotal"},
                        {"data":"rideStartDate"},
                        {"data":"rideStartTime"},
                        {"data":"rideStatus"},
                       
                      ]

                     }); 


      completeTables =$('#bookingComplete').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "ajax": {
                        "url":"<?= url('api/R_passenger_bookings') ?>",
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
                        "url":"<?= url('api/R_passenger_bookings') ?>",
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

       cancelAndNotAccept =$('#cancelOrNotAccept').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "ajax": {
                        "url":"<?= url('api/R_passenger_bookings') ?>",
                        "dataType":"json",
                        "type":"POST",
                        "data":{
                                "_token":"<?= csrf_token() ?>",
                                "rideStatus":'cancelOrNotAccept',
                                "userId":userId,
                                "name":name,
                                "mobile":mobile
                                }
                      },
                      "columns":[

                        {"data":"bookingId"},
                        {"data":"pickupAddress"},
                        {"data":"destinationAddress"},
                        {"data":"tripTotal"},
                        {"data":"rideStartDate"},
                        {"data":"rideStartTime"},
                        {"data":"rideStatus"},
                        {"data":"distance"},
 
                      ]

                    });

      
</script>



</body>

</html>