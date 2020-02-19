
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
                                    <h4 class="card-title">Completed Trips</h4>
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
                                                <th >Start Date & Start Time</th>
                                                <th >End Date & End Time</th>
                                                <th >Actual dis</th>
                                                <th >actual Cost </th>
                                                <th >Ride Status</th>
                                                <th>Action</th>

                                            </tr>
                                            </thead>

                                            <tbody>
                                            @if(!empty($Bookings))
                                                @foreach($Bookings as $trips)

                                                    <tr class="warning" >
                                                        <td >{{ $trips->bookingId }}</td>
                                                        <td >{{ $trips->passengerName }}</td>
                                                        <td>{{ $trips->passengerMobile }}</td>



                                                        <td style="width: 20% ">
                                                            <button onclick="showPickup({{$trips->bookingId}})">Pickup</button>
                                                            <div id="{{'myDIV'.$trips->bookingId}}" style="display: none;">{{ $trips->pickupAddress }}</div>
                                                        </td>

                                                        <td style="width: 20%">
                                                            <button onclick="showDest({{$trips->bookingId}})">destination</button>
                                                            <div id="{{'myDIV2'.$trips->bookingId}}" style="display: none;">{{ $trips->destinationAddress }}</div>

                                                        </td>

                                                        @if(!empty($trips->driverName))
                                                            <td style="background-color: #4caf50ad">{{ $trips->driverName }}</td>
                                                        @else
                                                            <td style="background-color: #f443368a">No Driver</td>
                                                        @endif

                                                        @if(!empty($trips->driverMobile))
                                                            <td style="background-color: #4caf50ad">{{ $trips->driverMobile }}</td>
                                                        @else
                                                            <td style="background-color: #f443368a">No Driver</td>
                                                        @endif

                                                        <td style="width: 20%">{{ $trips->tripTotal }}</td>
                                                        <td style="width: 20%">{{ $trips->distance }}</td>


                                                        <td >{{ $trips->rideStartDate." ".$trips->rideStartTime }}</td>
                                                        <td >{{ $trips->rideEndDate." ".$trips->rideEndTime }}</td>
                                                        <td >{{ $trips->actualDistance }}</td>
                                                        <td style="width: 20%">{{ $trips->Actual_TripTotal }}</td>

                                                        <th  ><?php if($trips->rideStatus==1) { echo "New"; } elseif($trips->rideStatus==2) { echo "Conform"; }elseif($trips->rideStatus==3) { echo "Start"; }elseif($trips->rideStatus==4) { echo "End"; }elseif($trips->rideStatus==5) { echo "Cancel"; }elseif($trips->rideStatus==6) { echo "Onthe way"; }elseif($trips->rideStatus==7) { echo "No Driver Found"; } ?></th>

                                                        <td style="width: 1%;">
                                                            @if($trips->rideStatus==4)
                                                                <a href="{{ route('Booking.Details',$trips->bookingId) }}">
                                                                    <button  type="button" class="btn btn-info">details</button></a>

                                                            @endif
                                                        </td>
                                                    </tr>

                                                @endforeach
                                                @else
                                                <tr class="warning" >
                                                    <td>no Data</td>
                                                </tr>

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
    function showPickup(id) {
        var x = document.getElementById("myDIV"+id);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function showDest(id) {
        var x = document.getElementById("myDIV2"+id);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>












</body>

</html>