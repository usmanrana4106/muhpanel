<div class="sidebar" data-color="rose" data-background-color="black" data-image="{{ url('public/assets/img/sidebar-1.jpg') }}">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo" style="background: #d22619a1;">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <img src="{{ url('public/assets/img/muhrahlogo.png') }}" style="width: 100%; height: 100%;" />
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Muhrah
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="{{ url('public/assets/img/faces/kanke.jpg') }}" />

          </div>

          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                {{session()->get('admin_name')}}
                <br>
                <i class="fa fa-circle text-success"></i> Online
                <b class="caret"></b>
              </span>
            </a>
             <div class="collapse" id="collapseExample">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('Admin.logout')}}">
                    <span class="sidebar-mini"> L </span>
                    <span class="sidebar-normal"> Logout </span>

                  </a>
                </li>
                
              </ul>
            </div>
           
          </div>

        </div>
        <ul class="nav">
          <li class="nav-item active ">
            <a class="nav-link" href="{{route('Home')}}">
              <i class="material-icons">dashboard</i>
              <p> Dashboard </p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
              <i ><img src="{{url('public/images/muhrahpanel/driver.png')}}"></i>
             
              <p> Drivers
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="pagesExamples">
              <ul class="nav">
                
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Drivers')}}">
                    <span class="sidebar-mini"> TD </span>
                    <span class="sidebar-normal"> Total Drivers </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Driver.stat')}}">
                    <span class="sidebar-mini"> ST </span>
                    <span class="sidebar-normal"> Stats </span>
                  </a>
                </li>
               <li class="nav-item ">
                  <a class="nav-link" href="{{route('Driver.Create')}}">
                    <span class="sidebar-mini"> RD </span>
                    <span class="sidebar-normal"> Registed Driver </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Driver.Wallets')}}">
                    <span class="sidebar-mini"> DW </span>
                    <span class="sidebar-normal"> Drivers Wallet </span>
                  </a>
                </li>


              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
              <i ><img src="{{url('public/images/muhrahpanel/passenger.png')}}"></i>
              
              <p> Passengers
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="componentsExamples">
              <ul class="nav">
                
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Booking.StatusView')}}">
                    <span class="sidebar-mini"> BKs </span>
                    <span class="sidebar-normal"> Bookings </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Passanger')}}">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Passengers </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Passanger.Wallets')}}">
                    <span class="sidebar-mini"> PW </span>
                    <span class="sidebar-normal"> Wallets </span>
                  </a>
                </li>


              </ul>
            </div>
          </li>
          
         



          <li class="nav-item">
            <a class="nav-link" href="{{route('Tracking')}}">
              <i ><img src="{{url('public/images/muhrahpanel/eagle.png')}}"></i>
              <p> Birds Eye </p>
            </a>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#mapsExamples">
                 <i ><img src="{{url('public/images/muhrahpanel/map.png')}}"></i>
              <p> Maps
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="mapsExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="../examples/maps/google.html">
                    <span class="sidebar-mini"> GM </span>
                    <span class="sidebar-normal"> Google Maps </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="../examples/maps/fullscreen.html">
                    <span class="sidebar-mini"> FSM </span>
                    <span class="sidebar-normal"> Full Screen Map </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="../examples/maps/vector.html">
                    <span class="sidebar-mini"> VM </span>
                    <span class="sidebar-normal"> Vector Map </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>






          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#tablesExamples">
                 <i ><img src="{{url('public/images/muhrahpanel/admin.png')}}"></i>
              <p> Admin
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="tablesExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Admin.details')}}">
                    <span class="sidebar-mini"> AD </span>
                    <span class="sidebar-normal"> Admin Details </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Admin.create')}}">
                    <span class="sidebar-mini"> AR </span>
                    <span class="sidebar-normal"> Admin Registration </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="../examples/tables/datatables.net.html">
                    <span class="sidebar-mini"> AP </span>
                    <span class="sidebar-normal"> Admin Profiles </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          
          <li class="nav-item ">
            <a class="nav-link" href="{{route('Vehicle.allTypes')}}">
               <i ><img src="{{url('public/images/muhrahpanel/car.png')}}"></i>
              <p> Cars Details</p>
            </a>
          </li>



        </ul>
      </div>
    </div>