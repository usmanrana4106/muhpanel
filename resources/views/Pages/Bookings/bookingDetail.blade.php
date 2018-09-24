
<!-- __________________________________________Header___________________________________________________ -->
@include('layouts.header')
   <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

    <!--   <script src="https://maps.google.com/maps/api/js?key=AIzaSyA-tZCZxS_XL91fdqC3eC14vc6AFGk02n8&libraries=places&region=uk&language=en&sensor=true"></script>
      <script src="{{ url('public/js/maps.min.js') }}" type="text/javascript"></script> -->
 

<!-- <script src='//api.mapbox.com/mapbox.js/v3.0.1/mapbox.js'></script>
<link href='//api.mapbox.com/mapbox.js/v3.0.1/mapbox.css' rel='stylesheet' />
<script src="//cdn.pubnub.com/pubnub-3.15.1.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script> -->

 <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<body class="">
  <div class="wrapper ">
  

<!-- __________________________________________SideBar___________________________________________________ -->



@include('layouts.sidebar')

    <div class="main-panel">
      <!-- __________________________________________NavBar___________________________________________________ -->



@include('layouts.navbar')
      <div class="content">
          <div class="content">
              



            
<input type="hidden" name="pickupLng" id="pickupLng" value="{{$pickupLatLng[1]}}">
<input type="hidden" name="pickupLat" id="pickupLat" value="{{$pickupLatLng[0]}}">

<input type="hidden" name="endTripLng" id="endTripLng" value="{{$endTripLatLng[1]}}">
<input type="hidden" name="endTripLat" id="endTripLat" value="{{$endTripLatLng[0]}}">
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
                  <div class="container-fluid " style="width: 700px; height: 400px;">
                  
                  <div id="map" style="width: 100%; height: 100%;" ></div>
               
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
                      <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist">
                        Booking details
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link2" role="tablist">
                        Map View
                      </a>
                    </li>
                   
                  </ul>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active" id="link1">
                    <table  class="table table-responsive">
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
                        
                                @if(!empty($trips))
			                       

			                                 <tr>
			                                    <td >{{ $trips->bookingId }}</td>
			                                    <td >{{ $customer->userName }}</td>
			                                    <td>{{ $customer->mobileNumber }}</td>

			                                   
			                                    <td style="background-color: #4caf50ad">{{ $driverInfo->fullName }}</td>
			                                  

			                                    <td style="width: 20%">{{ $trips->pickupAddress }}</td>
			                                    <td style="width: 20%">{{ $trips->destinationAddress }}</td>
			                                     <td style="width: 20%">{{ $trips->Actual_TripTotal }}</td>
			                                    <td >{{ $trips->rideStartDate }}</td>
			                                    <td >{{ $trips->rideStartTime }}</td>
			                                    <td >{{ $trips->rideEndTime }}</td>
			                                    <td >{{ $trips->actualDistance }}</td>
			                                  
			                                    <th  ><?php if($trips->rideStatus==1) { echo "New"; } elseif($trips->rideStatus==2) { echo "Conform"; }elseif($trips->rideStatus==3) { echo "Start"; }elseif($trips->rideStatus==4) { echo "End"; }elseif($trips->rideStatus==5) { echo "Cancel"; }elseif($trips->rideStatus==6) { echo "Onthe way"; }elseif($trips->rideStatus==7) { echo "No Driver Found"; } ?></th>
			                                </tr>

			                           @else
			                           <tr class="warning" >
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                                <td >no Record</td>
			                           </tr>
                      			@endif
                     
                    </table>
                    </div>
                    <div class="tab-pane" id="link2">
                      
                    </div>
                    
                  </div>
                


                </div>
              </div>
            </div>




            





			</div>





          </div>
      </div>

<script>
        mapboxgl.accessToken = 'pk.eyJ1IjoibXVocmFoIiwiYSI6ImNqbGRqa3BsdjBiMDczcW10cjJreXBtZjcifQ.Jqz5FYNOVHMV8Yp3tprSrA';
        var map = new mapboxgl.Map({
          container: 'map',
          style: 'mapbox://styles/mapbox/streets-v10',
          center: [ 46.712164,24.689200],
          zoom: 10
        });
        // this is where the code from the next step will go


 
        map.on('load', function() {
      getRoute();
    });

    function getRoute() {
      pickupLat= document.getElementById("pickupLat").value;
     pickupLng= document.getElementById("pickupLng").value;
    
     endTripLat= document.getElementById("endTripLat").value;
     endTripLng= document.getElementById("endTripLng").value;

       var start = [ pickupLng,pickupLat];
      var end = [ endTripLng,endTripLat];
      var directionsRequest = 'https://api.mapbox.com/directions/v5/mapbox/cycling/' + start[0] + ',' + start[1] + ';' + end[0] + ',' + end[1] + '?geometries=geojson&access_token=' + mapboxgl.accessToken;
      $.ajax({
        method: 'GET',
        url: directionsRequest,
      }).done(function(data) {
        
        var route = data.routes[0].geometry;
        map.addLayer({
          id: 'route',
          type: 'line',
          source: {
            type: 'geojson',
            data: {
              type: 'Feature',
              geometry: route
            }
          },
          paint: {
            'line-width': 2
          }
        });
        // this is where the code from the next step will go
      });







      map.addLayer({
        id: 'start',
        type: 'circle',
        source: {
          type: 'geojson',
          data: {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: start
            }
          }
        }
      });
      map.addLayer({
        id: 'end',
        type: 'circle',
        source: {
          type: 'geojson',
          data: {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: end
            }
          }
        }
      });


    }

    
    </script>

<!-- 
<script>

 L.mapbox.accessToken = 'pk.eyJ1IjoibXVocmFoIiwiYSI6ImNqanZsNXE3dTJyNjgzcGxlaWlza3N3cjIifQ.hQ2lONN3iQI_SwXNev6FtA';//
    var map = L.mapbox.map('map', 'mapbox.streets')//'mapbox.light')
            .setView([24.7136,  46.6753], 10);



map.on('load', function() {
  getRoute();
});

function getRoute() {
  var start = [24.689200, 46.712164];
  var end = [24.669819, 46.698689];
  var directionsRequest = 'https://api.mapbox.com/directions/v5/mapbox/cycling/' + start[0] + ',' + start[1] + ';' + end[0] + ',' + end[1] + '?geometries=geojson&access_token=' + mapboxgl.accessToken;
  $.ajax({
    method: 'GET',
    url: directionsRequest,
  }).done(function(data) {
    var route = data.routes[0].geometry;
    map.addLayer({
      id: 'route',
      type: 'line',
      source: {
        type: 'geojson',
        data: {
          type: 'Feature',
          geometry: route
        }
      },
      paint: {
        'line-width': 2
      }
    });
    // this is where the code from the next step will go
  });
}



</script> -->

                 
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