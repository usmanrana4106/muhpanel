
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
                  <h4 class="card-title">{{ $bookingTitle }}</h4>
                  <input type="hidden" name="title" id="title" value="{{$bookingTitle}}">
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="bookingtable" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          
                          <th >S.No.</th>
                          <th >Pass </th>
                          <th >Pass Mobile </th>
                          <th >PickUp Address</th>
                          <th >Des Address</th>
                          <th >Driver </th>
                          <th >Driver mobile</th>
                          <th >Trip Cost </th>
                          <th >distance</th>
                          <th >Start Date </th>
                          <th >Start Time</th>
                          <th >End Date</th>
                          <th >End Time</th>
                          <th >Actual dis</th>
                          <th >actual Cost </th>
                          <th >Ride Status</th>
                          <th>Action</th>

                        </tr>
                      </thead>
                      
                      <tbody>
                       
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

<style type="text/css">
  .danger{
    color: red;
  }

  .success{
    color: green;
  }
</style>



                 
<!-- __________________________________________Footer___________________________________________________ -->



@include('layouts.footer')



                </div>
              </div>
              







<!-- __________________________________________Footer___________________________________________________ -->



<!-- @include('layouts.sideFilters') -->




<!-- __________________________________________JsFiles___________________________________________________ -->



@include('layouts.js')


<script>

  
    $php='api/R_bookings_bookings';
        Table =$('#bookingtable').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "ajax": {
                        "url":"<?= url($url) ?>",
                        "dataType":"json",
                        "type":"POST",
                        "data":{
                                "_token":"<?= csrf_token() ?>",
                                "rideStatus":"<?= $rideStatus ?>",
                                }
                      },
                      "columns":[
                        {"data":"bookingId"},
                        {"data":"passengerName"},
                        {"data":"passengerMobile"},
                        {"data":"pickupAddress"},
                        {"data":"destinationAddress"},
                        {"data":"driverName"},
                        {"data":"driverMobile"},
                        {"data":"tripTotal"},
                        {"data":"distance"},
                        {"data":"rideStartDate"},
                        {"data":"rideStartTime"},
                        {"data":"rideEndDate"},
                        {"data":"rideEndTime"},
                        {"data":"actualDistance"},
                        {"data":"Actual_TripTotal"},
                        {"data":"rideStatus"},
                        {"data":"action","searchable":false,"orderable":false}
                  
                      ],
                      "createdRow":function ( row, data, index )
                      {

                            if ( data['driverName']=='not Yet') 
                                $('td', row).eq(5).addClass('danger');
                            else
                                $('td', row).eq(5).addClass('success');

                            if ( data['driverMobile']=='not Yet') 
                                $('td', row).eq(6).addClass('danger');
                            else
                                $('td', row).eq(6).addClass('success');

                            if ( data['rideEndDate']=='not Yet') 
                                $('td', row).eq(11).addClass('danger');
                            else
                                $('td', row).eq(11).addClass('success');

                            if ( data['rideEndTime']=='not Yet') 
                                $('td', row).eq(12).addClass('danger');
                            else
                                $('td', row).eq(12).addClass('success');
                        }


                    });


  </script>



</body>

</html>