
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
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
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
                    {{ $driverUserInfo->email }}<br>
                    {{ $driverUserInfo->crd }}<br>

                  </p>
                 
                </div>
              </div>
            </div>










            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-icon card-header-rose">
                  <div class="card-icon">
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
                      <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist">
                        Vehicle Info
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link2" role="tablist">
                        Reviews
                      </a>
                    </li>
                   
                  </ul>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active" id="link1">
                    <table  class="table table-responsive">
                        <thead>
                            <tr>
                                <td style="width: 33%">Identity Proof</td>
                                <td style="width:5%"></td>

                                <td style="width: 33%">Vehicle Proof</td>
                                <td style="width: 1%"></td>

                                <td style="width: 33%">Vehicle Info</td>
                                
                                                                
                            </tr>
                        </thead>  
                        <tr>
                                <td style="width: 33%">
                                 @if($driverInfo->identityProof == "not Avaliable")
                                      <div class="photo" >
                                        <img src="" alt="..." style="max-width: 300px; height:200px; ">
                                      </div>
                                  @else
                                      <div class="photo" >
                                        <img src="{{ $driverInfo->identityProof }}" alt="..." style="max-width: 250px; height:150px; ">
                                      </div>
                                  @endif
                                 
                                </td>
                                <td style="width: 5%"></td>

                                <td style="width: 33%">

                                  @if($VehicleInfo->vechicleIdentityProof == "not Avaliable")
                                        <img src="" alt="..." style="max-width: 300px; height:200px; ">
                                  @else
                                      <div class="photo" >
                                            <img src="{{ $VehicleInfo->vechicleIdentityProof }}" alt="..." style="max-width: 250px; height:150px; ">
                                      </div>
                                  @endif

                                     
                                </td>
                                <td style="width: 1%"></td>

                                <td style="width: 33%">
                                  @if(!empty($VehicleInfo))
                                      <h5>Vehicle Model :  {{ $VehicleInfo->vehicleModel}}</h5>
                                      <h5>Vehicle Company :  {{ $VehicleInfo->company }}</h5>
                                      <h5>Vehicle Number :  {{ $VehicleInfo->vihicleNumber }}</h5>
                                      <h5>Vehicle PlateNumber :  {{ $VehicleInfo->plateNumber }}</h5>
                                      <h5>Vehicle PlateLetters : {{ $VehicleInfo->plateLetterLeft." ".$VehicleInfo->plateLetterMiddle." ".$VehicleInfo->plateLetterRight }}</h5> 
                                      <h5>Vehicle PlateType : {{ $VehicleInfo->plateType }}</h5> 
                                      <h5>Reference Number :  {{ $VehicleInfo->vehicleReferenceNumber }}</h5>
                                    @else
                                    <h5>No record of vehicle</h5>
                                  @endif
                                </td>    
                        </tr>
                    </table>
                    </div>
                    <div class="tab-pane" id="link2">
                      <br />
                      <br />Dramatically maintain clicks-and-mortar solutions without functional solutions.
                    </div>
                    
                  </div>
                


                </div>
              </div>
            </div>









            </div>




            <div class="row">
                <div class="card">
             <div class="card-header card-header-primary card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title"></h4>
              </div>
              <div class="card-body">
                  <div class="toolbar">
                          <h4> Here you can See the bookings of Driver Mr. {{$driverInfo->fullName}}</h4>             
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          
                        
                          <th >S.No.</th>
                          <th >Pass </th>
                          <th >Pass Mobile </th>
                          <th >Driver </th>
                          <th >PickUp Address</th>
                          <th >Des Address</th>
                          <th >Trip Cost </th>
                          <th >Start Date </th>
                          <th >Start Time</th>
                          <th >End Time</th>
                          <th >Duration</th>
                          
                          <th >Ride Status</th>
                          
                        
                    
                          
                        </tr>
                      </thead>
                      <!-- <tfoot>
                        <tr>
                          
                          <th >S.No.</th>
                          <th >Passenger </th>
                          <th >Pass Mobile </th>
                          <th >Driver </th>
                          <th >PickUp Address</th>
                          <th >Destination Address</th>
                          <th >Trip Cost </th>
                          <th >Start Date </th>
                          <th >Start Time</th>
                          <th >End Time</th>
                          <th >Duration(min)</th>
                         
                          <th >Ride Status</th>
                      

                        </tr>
                      </tfoot> -->
                      <tbody>
                     @if(!empty($Bookings))
                        @foreach($Bookings as $trips)

                                 <tr class="warning" >
                                    <td >{{ $trips->bookingId }}</td>
                                    <td >{{ $trips->userName }}</td>
                                    <td>{{ $trips->mobileNumber }}</td>

                                   
                                    <td style="background-color: #4caf50ad">{{$driverInfo->fullName}}</td>
                                    

                                    <td style="width: 20%">{{ $trips->pickupAddress }}</td>
                                    <td style="width: 20%">{{ $trips->destinationAddress }}</td>
                                     <td style="width: 20%">{{ $trips->Actual_TripTotal }}</td>
                                    <td >{{ $trips->rideStartDate }}</td>
                                    <td >{{ $trips->rideStartTime }}</td>
                                    <td >{{ $trips->rideEndTime }}</td>
                                    <td >{{ $trips->actualDistance }}</td>
                                  
                                    <th  ><?php if($trips->rideStatus==1) { echo "New"; } elseif($trips->rideStatus==2) { echo "Conform"; }elseif($trips->rideStatus==3) { echo "Start"; }elseif($trips->rideStatus==4) { echo "End"; }elseif($trips->rideStatus==5) { echo "Cancel"; }elseif($trips->rideStatus==6) { echo "Onthe way"; }elseif($trips->rideStatus==7) { echo "No Driver Found"; } ?></th>
                                </tr>

                                @endforeach

                       @endif
                      </tbody>
                    </table>
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




<!-- <script type="text/javascript">
                     $(document).ready(function(){
                      
                          $.ajax({
                              url:"{{route('Driver.booking',$driverUserInfo->userId )}}",
                              type:"GET",
                              dataType:'json',
                              success:function(data){
                                var bookingData='';
                               $.each(data,function(key,value){
                                     bookingData +='<tr>';
                                     bookingData +='<td>'+value.bookingId+'</td>';
                                     bookingData +='<td>'+value.userName+'</td>';
                                     bookingData +='<td>'+value.mobileNumber+'</td>';
                                     bookingData +='<td>'+value.userName+'</td>';
                                     bookingData +='<td>'+value.pickupAddress+'</td>';
                                     bookingData +='<td>'+value.destinationAddress+'</td>';
                                     bookingData +='<td>'+value.Actual_TripTotal+'</td>';
                                     bookingData +='<td>'+value.rideStartDate+'</td>';
                                     bookingData +='<td>'+value.rideStartTime+'</td>';
                                     bookingData +='<td>'+value.rideEndTime+'</td>';
                                     bookingData +='<td>'+value.actualDistance+'</td>';
                                     bookingData +='<td>'+value.rideStatus+'</td>';
                                     bookingData +='</tr>';
                                    
                               });
                               $('#datatables').append(bookingData);
                              },
                              error:function(){
                                alert('Error');
                              }
                          });



                       

                     });

                   </script>
 -->










<script>
    $(document).ready(function() {
      $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }
      });

      var table = $('#datatable').DataTable();

      // Edit record
      table.on('click', '.edit', function() {
        $tr = $(this).closest('tr');
        var data = table.row($tr).data();
        alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
      });

      // Delete a record
      table.on('click', '.remove', function(e) {
        $tr = $(this).closest('tr');
        table.row($tr).remove().draw();
        e.preventDefault();
      });

      //Like record
      table.on('click', '.like', function() {
        alert('You clicked on Like button');
      });
    });
  </script>



</body>

</html>