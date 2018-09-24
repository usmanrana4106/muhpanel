
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

                  </p>
                 
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
                          <h4> Here you can See the bookings of Driver Mr. {{$passengerInfo->fullName}}</h4>             
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
                                    <td >{{ $passengerInfo->fullName }}</td>
                                    <td>{{ $passengerInfo->mobileNumber }}</td>

                                   
                                    <td style="background-color: #4caf50ad">{{$trips->fullName}}</td>
                                    

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