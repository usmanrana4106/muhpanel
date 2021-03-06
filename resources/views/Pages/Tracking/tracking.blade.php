
<!-- __________________________________________Header___________________________________________________ -->
@include('layouts.header')
   



  <script src='//api.mapbox.com/mapbox.js/v3.0.1/mapbox.js'></script>
        <link href='//api.mapbox.com/mapbox.js/v3.0.1/mapbox.css' rel='stylesheet' />
        <script src="//cdn.pubnub.com/pubnub-3.15.1.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>


    <style>
        input:focus, textarea:focus, select:focus{
            outline: none;
        }
    </style>


      <!--    <script src="{{ url('js/mapbox.js') }}"></script>
        <link href="{{ url('css/mapbox.css') }}" rel='stylesheet' />
        <script src="{{ url('js/pubnub.js') }}"></script> -->
<!--         <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script> -->

<body class="">
  <div class="wrapper ">
  

<!-- __________________________________________SideBar___________________________________________________ -->



@include('Pages.Tracking.sidebar')

    <div class="main-panel">
      <!-- __________________________________________NavBar___________________________________________________ -->


@include('Pages.Tracking.navbardriver')




        <div id='map' style=" margin-left: 10px; height: 600px; width: 90%;"></div>


<br>



        <div class="row">
        <div id="driverInfoBlock" class="col-md-4" style="visibility: collapse; margin-left: 10px;">
            <div class="card card-profile">
                <div class="card-avatar">

                    <img class="img" src="./images/muhrahpanel/driver.png" />
                </div>
                <div class="card-body">
                    <table>

                        <tr>
                            <td> Driver Id:</td>
                            <td><input name="userId" id="userId" placeholder="empty" readonly /></td>
                        </tr>
                        <tr>
                            <td> Driver Name:</td>
                            <td><input name="name" id="name" placeholder="empty" readonly/></td>
                        </tr>
                        <tr>
                            <td> Driver Mobile:</td>
                            <td><input name="mobile" id="mobile" placeholder="empty" readonly/></td>
                        </tr>
                        <tr>
                            <td> Car Letters:</td>
                            <td><input name="carLetter" id="carLetter" placeholder="empty" readonly/></td>
                        </tr>
                        <tr>
                            <td>Car Brand:</td>
                            <td><input name="carBrand" id="carBrand" placeholder="empty" readonly/></td>
                        </tr>
                        <tr>
                            <td> Car colours:</td>
                            <td><input name="carColour" id="carColour" placeholder="empty" readonly/></td>
                        </tr>
                        <tr>
                            <td>Car plate:</td>
                            <td><input name="carPlate" id="carPlate" placeholder="empty" readonly/></td>
                        </tr>
                        <tr>
                            <td>Car Type:</td>
                            <td><input name="carType" id="carType" placeholder="empty" readonly/></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>






            <div id="bookingInfoBlock" class="col-md-4" style="visibility: collapse; margin-left: 10px;">
                <div class="card card-profile">
                    <div class="card-avatar">

                        <img class="img" src="./images/muhrahpanel/car.png" />
                    </div>
                    <div class="card-body">
                        <table>

                            <tr>
                                <td> Booking Id:</td>
                                <td><input name="bookingId" id="bookingId" placeholder="empty" readonly /></td>
                            </tr>
                            <tr>
                                <td> PickUp Address:</td>
                                <td><textarea rows="4" cols="30" name="pickup" id="pickup" type="text"  placeholder="empty" readonly></textarea></td>
                            </tr>
                            <tr>
                                <td> Pickup LatLng:</td>
                                <td><input name="pickupLatLng" id="pickupLatLng" type="text" placeholder="empty" readonly/></td>
                            </tr>
                            <tr>
                                <td> Dest Address:</td>
                                <td><textarea rows="4" cols="30" name="destination" id="destination" placeholder="empty" readonly></textarea></td>
                            </tr>
                            <tr>
                                <td>Dest LatLng:</td>
                                <td><input name="destinationLatLng" id="destinationLatLng" placeholder="empty" readonly/></td>
                            </tr>
                            <tr>
                                <td> Ride Date:</td>
                                <td><input name="rideStartDate" id="rideStartDate" placeholder="empty" readonly/></td>
                            </tr>
                            <tr>
                                <td>Ride StartTime:</td>
                                <td><input name="rideStartTime" id="rideStartTime" placeholder="empty" readonly/></td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>






            <div id="passengerInfoBlock" class="col-md-3" style="visibility: collapse; margin-left: 10px;">
                <div class="card card-profile">
                    <div class="card-avatar">

                        <img class="img" src="./images/muhrahpanel/passenger.png" />
                    </div>
                    <div class="card-body">
                        <table>

                            <tr>
                                <td> Passenger Id:</td>
                                <td><input name="passengerId" id="passengerId" placeholder="empty" readonly /></td>
                            </tr>
                            <tr>
                                <td> Passenger Name:</td>
                                <td><input name="passengerName" id="passengerName" placeholder="empty" readonly/></td>
                            </tr>
                            <tr>
                                <td> Passenger Mobile:</td>
                                <td><input name="passengerMobile" id="passengerMobile" placeholder="empty" readonly/></td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>








        </div>




<script type="text/javascript">

// var channel = 'my_channel';

// var pn = new PubNub({
//   publishKey:   'pub-c-590d41c4-e476-4e6a-9830-bff8ac58481f', // replace with your own pub-key
//   subscribeKey: 'sub-c-95101cda-8a8a-11e8-85ee-866938e9174c'  // replace with your own sub-key
// });
var allMarkers = [];
var allDriver = [];
var status = 3;
var appstatus = 3;





var pubnub_sub_key = 'sub-c-78b69e00-da95-11e8-911d-e217929ad048';
    var pubnub_ssl = true;
    var pubnub_chnl = 'my_channel';

 L.mapbox.accessToken = 'pk.eyJ1IjoibXVocmFoIiwiYSI6ImNqanZsNXE3dTJyNjgzcGxlaWlza3N3cjIifQ.hQ2lONN3iQI_SwXNev6FtA';//'sk.eyJ1IjoiYXNoaXNoM2VtYmVkIiwiYSI6ImNpd25jcXZyYTAwMTQyc210d2FqZGI5cHYifQ.ybjGWR_zGpVSc8mHGQbR4w';
    var map = L.mapbox.map('map', 'mapbox.streets')//'mapbox.light')
            .setView([24.7136,  46.6753], 8);

    if (!navigator.geolocation) {
        console.log('Geolocation is not available');
    } else {
        map.locate();
    }
map.on('locationfound', function(e) {
        console.log(e);
//        map.fitBounds(e.bounds);
        map.setView(e.latlng, 10);
    });

    L.AnimatedMarker = L.Marker.extend({
        _setPos: function (pos) {
            // First call the base method of the Marker itself
            L.Marker.prototype._setPos.call(this, pos);
            // Add a CSS transition to the marker icon and the shadow (and any other objects you've added yourself)
            if (L.DomUtil.TRANSITION) {
                var transSpeed = 2000; // The transition speed is set to 2000ms for dramatic effect, normally I'd set this lower
                if (this._icon) { this._icon.style[L.DomUtil.TRANSITION] = ('all ' + transSpeed + 'ms linear'); }
                if (this._shadow) { this._shadow.style[L.DomUtil.TRANSITION] = 'all ' + transSpeed + 'ms linear'; }
            }
        }
    });




    //  $(document).ready(function () 
    // {

    //     $.ajax({
    //                           url:"api/getAllDrivers",
    //                           type:"GET",
    //                           dataType:'json',
    //                           success:function(response){
                        
    //                                  var data = response.data;
                                    

                                   
    //                                     $.each(data, function (ind, val) {
    //                                         if (val.latitude) {
                                            

    //                                         }
    //                                         else
    //                                         {
    //                                             val.latitude=24.870494;
    //                                         }
    //                                         if (val.longitude) 
    //                                         {

    //                                         }
    //                                         else
    //                                         {
    //                                             val.longitude=46.449969;

    //                                         }
    //                                         var adata = {
    //                                             "id": val.driveId,
    //                                             "name": val.fullName,
    //                                             "lat": val.latitude, 
    //                                             "lng": val.longitude,
    //                                             "appstatus": val.apptStatus,
    //                                             "user": val.userId,
    //                                             "status": 3,
    //                                         };
    //                                         allDriver[val.user] = adata;
    //                                       // allDriver.push(adata);

    //                                     show_data(3, 0);


    //                                     });
    //                           },
    //                           error:function(){
    //                             alert('Error');
    //                           }
            
            
    //         //     timestamp = response.time;
            
            
    //         });
    //     });














    // $(document).ready(function () 
    // {
    //     // $.getJSON(baseurl1 + "/get_all_drivers", function (response) {
    //         // if (response.flg == 0) { 
    //         //     timestamp = response.time;
    //         //     var data = response.data;
    //         //     $("#four").html(data.four.length);
    //         //     $("#six").html(data.six.length);
    //         //     $("#seven").html(data.seven.length);
    //         //     $("#eight").html(data.eight.length);
    //         //     $.each(data.all, function (ind, val) {
    //                 var adata = {
    //                     "id": '1',
    //                     "name": 'usman',
    //                     "lat": 24.815179,
    //                     "lng": 46.758486,
    //                     "user": "usman",
    //                     "status": 3,
    //                 };
    //                 allDriver[1] = adata;


    //                 var adata = {
    //                     "id": '2',
    //                     "name": 'sameer',
    //                     "lat": 24.806477, 
    //                     "lng": 46.577486,
    //                     "user": "sameer",
    //                     "status": 3,
    //                 };
    //                 allDriver[2] = adata;



    //              //  allDriver.push(adata);
    //             // });
    //             show_data(3, 0);
    //         //}
    //     // });
    //     });






    function show_data(flg, flg2 = 1) {
        var html = '';
        tab_state = flg;
        var bound = [];

        for (var ind in allDriver) {
            var val = allDriver[ind];
    //    $.each(allDriver, function (ind, val) {
            var a = 0;
            var colorcode = "";
            var markericong = '';
  
            switch (val.status) {

                case 3:

                    a = 3;
                    colorcode = "#78ac2c";
                    break;
               break;
            }
          
            var adata = val;

            if (a != 0) {
               
                if (flg2 == 0) {
                    if(allMarkers['D_' + adata.user]==null)
                    {
                        allMarkers['D_' + adata.user] = new L.marker(L.latLng(parseFloat(adata.lat), parseFloat(adata.lng)), {
                                                            icon: L.mapbox.marker.icon({
                                                                'marker-color': "#4caf50"
                                                            }), data: adata
                                                        })
                                                                .bindPopup('<b>' + adata.name + '</b>')
                                                                .addTo(map);
                    }
                    
                }
            }
    //    });
        }
  
    }















     pubnub = PUBNUB({
        subscribe_key: pubnub_sub_key,
        ssl: pubnub_ssl
    });

    /* Subscribe to pubnub using channel name
     @envelope will contain the raw message or data along with timestamp
     */
    pubnub.subscribe({
        channel: pubnub_chnl,
        presence: function (msg) {
    
        },
        message: function (m) {
             console.log(m);
            if (m) {



                var allMarkers=[];
                var mark=0;


               // allMarkers[mark]= L.marker(L.latLng(parseFloat(m.lat), parseFloat(m.lng)), {
               //                          icon: L.mapbox.marker.icon({
               //                              'marker-color': "#4caf50"
               //                          }),
               //                      }).bindPopup('<b>' + "usman" + '</b>')
               //                  .addTo(map);

            

                
                    // var id = m.o2._id;
                    var data = m.set;
                    if (typeof data != "undefined") 
                    {

                        var updated = [];
                        //            $.each(data.all, function (ind, val) {
                        var adata = {
                            "id": data.Id,
                           "appstatus": data.appStatus,
                           "status": data.status,
                           "name" : data.name,
                           "location": data.location,
                           "user":data.user,
                           'lat':data.lat,
                           'lng':data.lng,
                           "bookingId": data.bookingId
                        };
                        data=[];
                        // if (adata.bookingId == null || adata.bookingId==0)
                        // {
                        //     adata.bookingId=0;
                        //     // bookingInfoBlock.style.visibility="collapse";
                        //     // passengerInfoBlock.style.visibility="collapse";
                        // }


                        updated.push(adata);
                        allDriver[adata.user] = adata;
                                          // allDriver.push(adata);
                        //console.log(allDriver[adata.user]);

                        show_data(3, 0);
                     
                        //            });
                         update_data(updated);
                        // update_status_no();
                    }
                
            }
        }
    });






     function update_data(updated) {
         var count=0;

         $.each(updated, function (index, dr_data) {
            var flag = 0;
            var id = dr_data.id;
            for (var ind in allDriver) {

                if(allDriver[ind].user==dr_data.user){
                var val = allDriver[ind];


                   // console.log("User name is"+allDriver[ind].user);


                flag = 1;
                var data = dr_data;
                allDriver[ind].status = (typeof (data.status) != 'undefined') ? data.status : allDriver[ind].status;
                allDriver[ind].appstatus = (typeof (data.appstatus) != 'undefined') ? data.appstatus : allDriver[ind].appstatus;
                allDriver[ind].lat = (typeof (data.location) != 'undefined') ? parseFloat(data.location.latitude) : allDriver[ind].lat;
                allDriver[ind].lng = (typeof (data.location) != 'undefined') ? parseFloat(data.location.longitude) : allDriver[ind].lng;
                //allDriver[ind].lastTs = (typeof (data.lastTs) != 'undefined') ? parseFloat(data.lastTs) : allDriver[ind].lastTs;
                var a = 0;
                var colorcode = "";
                var markericong = '';
                val = allDriver[ind];
                //                console.log(val);

                // #d21336 red colour
                a = 3;
                if (allDriver[ind].status == 1) {
                    colorcode = "#4caf50";
                } else if (allDriver[ind].status == 3) {
                    colorcode = "#D3182F";
                } else if (allDriver[ind].status == 6) {
                    colorcode = "#1DD9D8";
                } else if (allDriver[ind].status == 8) {
                    colorcode = "#E3DF16";
                } else {
                    colorcode = "#4caf50";
                }
                allDriver[ind].name = data.name;
                allDriver[ind].user = data.user;
                var adata = allDriver[ind];

                if (a != 0) {
                    if (adata.status == 4) {
                        if (typeof (allMarkers['D_' + adata.user]) == 'undefined') {

                        } else {
                            map.removeLayer(allMarkers['D_' + adata.user]);
                            delete allMarkers['D_' + adata.user];
                        }
                    } else if ((allDriver[ind].status == 1) || (allDriver[ind].status == 3) || (allDriver[ind].status == 6) || (allDriver[ind].status == 8)) {
                        if (typeof (allMarkers['D_' + adata.user]) == 'undefined') {
                            console.log("getDriverData: driverId:" + allDriver[ind].user + " bookingId: " + allDriver[ind].bookingId);

                            allMarkers['D_' + adata.user] = L.marker(L.latLng(parseFloat(adata.lat), parseFloat(adata.lng)), {
                                icon: L.mapbox.marker.icon({
                                    'marker-color': colorcode
                                }), data: adata
                            })
                                .bindPopup('<b>' + '<button id="" name="driver_' + allDriver[ind].user + '" class="btn btn-dark" onclick="getdriverData(' + allDriver[ind].user + ',' + allDriver[ind].bookingId + ')" >' + allDriver[ind].name + '</button>' + '</b>')
                                .addTo(map);
                        } else {
                            allMarkers['D_' + adata.user].bindPopup('<b>'+'<button id="" name="driver_'+allDriver[ind].user+'" class="btn btn-dark" onclick="getdriverData('+ allDriver[ind].user+','+allDriver[ind].bookingId+')" >'+ allDriver[ind].name+'</button>'+'</b>');
                            var z = allMarkers['D_' + adata.user].getLatLng();
                            var position = [z.lat, z.lng];
                            var re = L.latLng(parseFloat(adata.lat), parseFloat(adata.lng));
                            re = [re.lat, re.lng];
                            transition(re, position, 'D_' + adata.user, colorcode, adata);
                            //                            allMarkers['D_' + adata.user].setLatLng(L.latLng(parseFloat(adata.lat), parseFloat(adata.lng)));
                            //                            allMarkers['D_' + adata.user].setIcon(L.mapbox.marker.icon({
                            //                                'marker-color': colorcode
                            //                            }));
                        }
                    } else {
                        if (typeof (allMarkers['D_' + adata.user]) == 'undefined') {

                        } else {
                            map.removeLayer(allMarkers['D_' + adata.user]);
                            //                            delete allMarkers['D_' + adata.user];
                        }
                    }

                    //  var html = '<tr id="D_' + adata.user + '">\
                    //         <td> \n\
                    //             <div onclick="get_driver_data(' + adata.user + ');popupmodel();">\n\
                    //                <p class="p-l-10 col-xs-height col-middle" style="width: 80%">\n\
                    //                     <span class="text-master" style="padding-right: 30px;">\n\
                    //                          ' + adata.name + '&nbsp;(ID:' + adata.user + ')<br/>' + adata.mobile + '<br/><b class="sec_D"> sec.</b><font style="float:right;"></font>\n\
                    //                     </span>\n\
                    //                 </p>\n\
                    //                 \n\
                    //             </div>\n\
                    //         </td>\n\
                    //     </tr>';
                    // if (a != 0) {

                    //         $('#D_' + adata.user).remove();
                    //         $('.drivertableNewOne').append(html);

                    // }
                } else {

                    if (typeof (allMarkers['D_' + adata.user]) != 'undefined') {
                        map.removeLayer(allMarkers['D_' + adata.user]);
                        delete allMarkers['D_' + adata.user];
                    }
                }
            }
         
            }
    //         if (flag == 0) {
    //             $.getJSON(baseurl1 + "/getSpecificDriver/" + id, function (response) {
    //                 if (response.flg == 0) {
    //                     var val = response.data;
    //                     var adata = {
    //                         "id": val._id.$id,
    //                         "name": val.name + " " + val.lname,
    //                         "proPic": val.image,
    //                         "bid": '',
    //                         "email": val.email,
    //                         "mobile": val.mobile,
    //                         "user": val.user,
    //                         "status": val.status,
    //                         "appstatus": val.apptStatus,
    //                         "lastTs": val.lastTs,
    //                         "lat": parseFloat(val.location.latitude),
    //                         "lng": parseFloat(val.location.longitude)
    //                     };
    //                     allDriver[val.user] = adata;
    // //                    allDriver.push(adata);
    //                     var a = 0;
    //                     var colorcode = "";
    //                     var markericong = '';
    //                     switch (adata.status) {
    //                         case 3:
    //                             a = 3;
    //                             colorcode = "#78AC2C";
    //                             markericong = baseurl + 'icons/green.png';
    //                             break;
    //                         case 5:
    //                             switch (adata.appstatus) {
    //                                 case 6:
    //                                     a = 5;
    //                                     colorcode = "#BE0411";
    //                                     markericong = baseurl + 'icons/red.png';
    //                                     break;
    //                                 case 7:
    //                                     a = 5;
    //                                     colorcode = "#4D93C7";
    //                                     markericong = baseurl + 'icons/blue.png';
    //                                     break;
    //                                 case 8:
    //                                     a = 5;
    //                                     colorcode = "#FFD50B";
    //                                     markericong = baseurl + 'icons/yellow.png';
    //                                     break;
    //                             }
    //                             break;
    //                     }
    // //                    var adata = val;
                      
    //                     if (a != 0) {
                           
    //                         if ((status == 0 && appstatus == 0) || (adata.status == status && appstatus == 0) || (adata.status == status && adata.appstatus == appstatus)) {
    //                             allMarkers['D_' + adata.user] = L.marker([parseFloat(adata.lat), parseFloat(adata.lng)], {
    //                                     icon: L.mapbox.marker.icon({
    //                                         'marker-color': colorcode
    //                                     }), data: adata
    //                                 })
    //                                 .bindPopup('<b>' + adata.name + '</b>')
    //                                 .addTo(map);
    //                         }
    //                     }
    //                 }
    //             });
    //         }
        });


     }


    function getdriverData($data,$bookingId)
    {
        console.log("getDriverData: driverId:"+$data+" bookingId: "+$bookingId);
        $.getJSON("api/getdriverData/"+$data, function (response) {

                var data = response.array.driver;
                 //console.log(data[0].userId);
            document.getElementById("userId").value=data[0].userId;
            document.getElementById("name").value=data[0].fullName;
            document.getElementById("mobile").value=data[0].mobileNumber;
            document.getElementById("carBrand").value=data[0].brands;
            document.getElementById("carColour").value=data[0].colour;
            document.getElementById("carLetter").value=data[0].plateLetterRight+" "+data[0].plateLetterMiddle+" "+data[0].plateLetterLeft;
            document.getElementById("carPlate").value=data[0].plateNumber;
            document.getElementById("carType").value=data[0].carName;

    });
        var driverInfoBlock = document.getElementById('driverInfoBlock');
        var bookingInfoBlock = document.getElementById('bookingInfoBlock');
        var passengerInfoBlock = document.getElementById('passengerInfoBlock');

        driverInfoBlock.style.visibility="visible";
        //console.log("bookingId: "+$bookingId);
        if ($bookingId!=0)
        {
            bookingInfoBlock.style.visibility="visible";
            passengerInfoBlock.style.visibility="visible";
            //Booking Information
            $.getJSON("api/getBookingDetails/"+$bookingId, function (response) {

                var data = response.array.booking;
                //console.log("bookingId"+data.bookingId);
                document.getElementById("bookingId").value=data.bookingId;
                document.getElementById("pickup").value=data.pickupAddress;
                document.getElementById("pickupLatLng").value=data.pickupLatLong;
                document.getElementById("destination").value=data.destinationAddress;
                document.getElementById("destinationLatLng").value=data.destinationLatLong;
                document.getElementById("rideStartDate").value=data.rideStartDate;
                document.getElementById("rideStartTime").value=data.rideStartTime;
               // document.getElementById("rideEndTime").value=data.rideEndTime;

                var passengerData=response.array.passenger;
                document.getElementById("passengerId").value=passengerData.userId;
                document.getElementById("passengerName").value=passengerData.fullName;
                document.getElementById("passengerMobile").value=passengerData.mobileNumber;


            });

        }
        else
        {
            bookingInfoBlock.style.visibility="collapse";
            passengerInfoBlock.style.visibility="collapse";
        }


    }






































     //marker moving smoothly  
    var x;
    var numDeltas = 50;
    var delay = 60; //milliseconds
    var i = 0;
    var deltaLat;
    var deltaLng;
    var pos;
    var clr,adt;
     function transition(result, position, ids, color, adata1) {
        x = ids;
        i = 0;
        pos = position;
        clr = color;
        adt = adata1;
        deltaLat = (result[0] - position[0]) / numDeltas;
        deltaLng = (result[1] - position[1]) / numDeltas;
        moveMarker();
    }

    function moveMarker() {
        pos[0] += deltaLat;
        pos[1] += deltaLng;
        var latlng1 = L.latLng(parseFloat(pos[0]), parseFloat(pos[1]));

        if (allMarkers[x]) {
            allMarkers['D_' + adt.user].setLatLng(latlng1);
            allMarkers['D_' + adt.user].setIcon(L.mapbox.marker.icon({
                'marker-color': clr
            }));
        }

        if (i != numDeltas) {
            i++;
            setTimeout(moveMarker, delay);
        }
    }





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

