
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




              @if(!empty($vehicleCreate))
                  <div class="alert alert-success">
                      Vehicle Type is Successfully Created!!!!
                  </div>
              @endif

              @if(!empty($updateCarDetails))
                  <div class="alert alert-success">
                      Vehicle Type is Successfully Updated!!!!
                  </div>
              @endif


            <div class="col-md-12">
                <div class="pull-right">
                    <a href="{{ url('/R_car_createCarType') }}">
                        <button  type="button" class="btn btn-success size">Create Vechicle Type</button>
                    </a>
                </div>
              <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">Vehcile Types</i>
                  </div>
                  <h4 class="card-title"></h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          
                        
		                <th>Id</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th><small>Opening Counter Price (SAR)</small></th>
                        <th><small>Distance Cost Rate (SARs / KM)</small></th>
                        <th><small>Time Cost Rate (SARs / Min)</small></th>
                        <th><small>Distance Cost in Rush Hours (SARs / KM)</small> </th>
                        <th><small>Time Cost in Rush Hours (SARs / Min)</small></th>
                        <th><small>Number of Seat</small></th>
                        <th>Status</th>
                        <th class="text-right"><small>Action Buttons</small></th>
                        
                    
                          
                        </tr>
                      </thead>
                     
                      <tbody>
                       @if(!empty($vehicleTypes))
                        @foreach($vehicleTypes as $vehicle)
                                 <tr class="warning" >
                                    <td >{{ $vehicle->carId }}</td>
                                    
                                    <td > <i ><img src="{{url('public/uploads/images/carImage/',$vehicle->carImage)}}" style=" border-radius: 40px; background-color: #62A8EA; height: 60px; width: 70px;"></i></td>

                                    <td >{{ $vehicle->carName }} <font style="size:10px" >({{ $vehicle->arabicName }})</font></td>
                                    <td >{{ $vehicle->Counterprice }}</td>
                                    <td >{{ $vehicle->priceByDistence }}</td>
                                    <td >{{ $vehicle->priceByTime }}</td>
                                    <td >{{ $vehicle->rushHoursPBD }}</td>
                                    <td >{{ $vehicle->rushHoursPBT }}</td>
                                    <td >{{ $vehicle->carSheet }}</td>

                                    @if($vehicle->status == 1)

                                      <td>
                                         <a href="{{route('Vehicle.changeStatus',['id'=>$vehicle->carId,'status'=>$vehicle->status])}}">
                                        <span class="btn btn-icon btn-info btn-outline btn-success ">Active</span>
                                         </a>
                                      </td>
                                    @else
                                      <td >
                                        <a href="{{route('Vehicle.changeStatus',['id'=>$vehicle->carId,'status'=>$vehicle->status])}}">
                                        <span class="btn btn-icon btn-info btn-outline btn-danger">InActive</span>
                                        </a>
                                      </td>
                                    @endif
                                    
                                     <td class="td-actions ">
                                      

                                      <a href="{{route('Vehicle.editShow',$vehicle->carId)}}">
                                      <button type="button" rel="tooltip" class="btn btn-warning"> Edit
                                        <i class="material-icons">edit</i>
                                      </button>
                                      </a>
                                      <a href="{{route('Vehicle.delete',$vehicle->carId)}}">
                                      <button type="button" rel="tooltip" class="btn btn-primary">
                                        <i class="material-icons">delete</i>
                                      </button>
                                      </a>
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