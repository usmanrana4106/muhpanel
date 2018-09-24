
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
              



            
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title"></h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          
                        
		                        <th>D ID</th>                        
		                        <th>Reg. Date</th>
		                        <th>Name</th>
		                        <th>ID Number</th>
		                        <th>Mobile</th>
		                        <th>Address</th>
		                        
		                        
		                        <th>Vehicle No.</th>
		                       <th>Bank/ACC.</th>
		                        
		                        
		                        <th>Identity Proof</th>
                            <th>License Proof</th>
		                        <th> Action </th>
                        
                    
                          
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
                       @if(!empty($Drivers))
                        @foreach($Drivers as $driver)

                                 <tr class="warning" >
                                    <td >{{ $driver->driveId }}</td>
                                    <td style="width: 10%">{{ $driver->crd }}</td>
                                    <td >{{ $driver->fullName }}</td>
                                    <td>{{ $driver->captainIdentityNumber }}</td>
                                    <td>{{ $driver->mobileNumber }}</td>                                   
                                    <td >{{ $driver->address }}</td>
                                   

                                    <td >{{ $driver->vihicleNumber }}</td>
                                    <td style="width: 10%">{{ $driver->bankName." / ". $driver->accountNo }}</td>
                                   

                                   @if($driver->identityProofStatus != 0 )
                                      <td ><img src="{{url('images/muhrahpanel/approved.png')}}" alt=""></td>
                                    @else
                                      <td ><img src="{{url('images/muhrahpanel/error.png')}}" alt=""></td>
                                    @endif


                                    @if($driver->licenceNumberStatus != 0 )
                                      <td ><img src="{{url('images/muhrahpanel/approved.png')}}" alt=""></td>
                                    @else
                                      <td ><img src="{{url('images/muhrahpanel/error.png')}}" alt=""></td>
                                    @endif
                                    
                                    <td style="width: 1%;">
                                        <a href="{{ url('/driverProfile',$driver->driveId) }}">
                                        <button  type="button" class="btn btn-info">Profile</button></a>
                                    </td>
                                </tr>

                                @endforeach

                       @endif
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- end content-->
              </div>
              <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
          </div>
          <!-- end row -->
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