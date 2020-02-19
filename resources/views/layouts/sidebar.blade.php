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
                <i class="fa fa-circle text-success"></i> {{trans('sideBar.Admin-Status')}}
                <b class="caret"></b>
              </span>
            </a>
             <div class="collapse" id="collapseExample">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('Admin.logout')}}">
                    <span class="sidebar-mini"> L </span>
                    <span class="sidebar-normal"> {{trans('sideBar.Logout')}} </span>

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
              <p> {{trans('sideBar.Dashboard')}} </p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
              <i ><img src="{{url('public/images/muhrahpanel/driver.png')}}"></i>
             
              <p> {{trans('sideBar.Drivers')}}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="pagesExamples">
              <ul class="nav">




                <li class="nav-item ">
                  <a class="nav-link" data-toggle="collapse" href="#componentsCollapse">
                    <span class="sidebar-mini"> SOD </span>
                    <span class="sidebar-normal"> {{trans('sideBar.State-Of-Driver')}}
                      <b class="caret"></b>
                    </span>
                  </a>
                  <div class="collapse" id="componentsCollapse">
                    <ul class="nav">
                      <li class="nav-item ">
                        <a class="nav-link" href="{{route('Drivers')}}">
                          <span class="sidebar-mini"> TD </span>
                          <span class="sidebar-normal"> {{trans('sideBar.Types-Of-Drivers')}} </span>
                        </a>
                      </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="{{route('Working.Status',['status'=>'1'])}}" >
                            <span class="sidebar-mini"> AD </span>
                            <span class="sidebar-normal"> {{trans('sideBar.Active-Drivers')}} </span>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="{{route('Working.Status',['status'=>'0'])}}" >
                            <span class="sidebar-mini"> UAD </span>
                            <span class="sidebar-normal"> {{trans('sideBar.UnActive-Drivers')}} </span>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="{{route('Valid.Status',['status'=>'1'])}}" >
                            <span class="sidebar-mini"> AD </span>
                            <span class="sidebar-normal"> {{trans('sideBar.Approved-Drivers')}} </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{route('Valid.Status',['status'=>'0'])}}" >
                        <span class="sidebar-mini"> NAD </span>
                            <span class="sidebar-normal"> {{trans('sideBar.Not-Approved-Drivers')}} </span>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="{{route('Registered.Today')}}" >
                        <span class="sidebar-mini"> DR </span>
                            <span class="sidebar-normal"> {{trans('sideBar.Daily-Register')}} </span>
                        </a>
                    </li>

                    </ul>
                  </div>
                    <hr>
                </li>






                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Driver.stat')}}">
                    <span class="sidebar-mini"> ST </span>
                    <span class="sidebar-normal">{{trans('sideBar.Driver-Reports')}} </span>
                  </a>
                </li>
               <li class="nav-item ">
                  <a class="nav-link" href="{{route('Driver.Create')}}">
                    <span class="sidebar-mini"> RD </span>
                    <span class="sidebar-normal"> {{trans('sideBar.Registed-Driver')}} </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Driver.Wallets')}}">
                    <span class="sidebar-mini"> DW </span>
                    <span class="sidebar-normal"> {{trans('sideBar.Drivers-Wallet')}} </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Vehicle.vehicleRegistration')}}">
                    <span class="sidebar-mini"> CT </span>
                    <span class="sidebar-normal"> CarTypes </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Driver.searchView')}}">
                    <span class="sidebar-mini"> SD </span>
                    <span class="sidebar-normal"> {{trans('sideBar.Search-Drivers')}} </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
              <i ><img src="{{url('public/images/muhrahpanel/passenger.png')}}"></i>
              
              <p> {{trans('sideBar.Passengers')}}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="componentsExamples">
              <ul class="nav">
                
                
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Passanger')}}">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> {{trans('sideBar.Passengers')}} </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Passanger.Wallets')}}">
                    <span class="sidebar-mini"> PW </span>
                    <span class="sidebar-normal"> {{trans('sideBar.Wallets')}} </span>
                  </a>
                </li>
                 <li class="nav-item ">
                  <a class="nav-link" href="{{route('Passanger.stat')}}">
                    <span class="sidebar-mini"> PS </span>
                    <span class="sidebar-normal"> {{trans('sideBar.Statistics')}} </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="{{route('Booking.StatusView')}}">
              <i ><img src="{{url('public/images/muhrahpanel/bookings.png')}}"></i>
              <p> {{trans('sideBar.Bookings')}} </p>
            </a>
          </li>



          <li class="nav-item">
            <a class="nav-link" href="{{route('Tracking')}}">
              <i ><img src="{{url('public/images/muhrahpanel/eagle.png')}}"></i>
              <p> {{trans('sideBar.Birds-Eye-D')}} </p>
            </a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="{{route('Tracking.Passenger')}}">
              <i ><img src="{{url('public/images/muhrahpanel/eagle.png')}}"></i>
              <p> {{trans('sideBar.Birds-Eye-P')}} </p>
            </a>
          </li>







        @if(!empty(session()->get('systemrole')['role_name'] == 'superAdmin'))
           
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#tablesExamples">
                 <i ><img src="{{url('public/images/muhrahpanel/admin.png')}}"></i>
              <p> {{trans('sideBar.Admin')}}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="tablesExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Admin.details')}}">
                    <span class="sidebar-mini"> AD </span>
                    <span class="sidebar-normal"> {{trans('sideBar.Admin-Details')}} </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Admin.create')}}">
                    <span class="sidebar-mini"> AR </span>
                    <span class="sidebar-normal">{{trans('sideBar.Admin-Registration')}}  </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{route('Admin.roles')}}">
                    <span class="sidebar-mini"> AP </span>
                    <span class="sidebar-normal"> {{trans('sideBar.Admin-Roles')}} </span>
                  </a>
                </li>




                <li class="nav-item ">
                  <a class="nav-link" data-toggle="collapse" href="#componentsCollapses">
                    <span class="sidebar-mini"> Com </span>
                    <span class="sidebar-normal"> Companies
                      <b class="caret"></b>
                    </span>
                  </a>
                  <div class="collapse" id="componentsCollapses">
                    <ul class="nav">
                      <li class="nav-item ">
                        <a class="nav-link" href="{{route('Admin.newCompanies')}}">
                          <span class="sidebar-mini"> CR </span>
                          <span class="sidebar-normal"> Create </span>
                        </a>
                      </li>

                      <li class="nav-item ">
                        <a class="nav-link" href="{{route('Admin.Companies')}}" >
                          <span class="sidebar-mini"> AD </span>
                          <span class="sidebar-normal"> Companies </span>
                        </a>
                      </li>



                    </ul>
                  </div>
                  <hr>
                </li>



















              </ul>
            </div>
          </li>
          @endif 
          
          <li class="nav-item ">
            <a class="nav-link" href="{{route('Vehicle.allTypes')}}">
               <i ><img src="{{url('public/images/muhrahpanel/car.png')}}"></i>
              <p> {{trans('sideBar.Cars-Details')}}</p>
            </a>
          </li>

          <li class="nav-item ">
            <a class="nav-link" href="{{route('distance.createView')}}">
              <i ><img src="{{url('public/images/muhrahpanel/map.png')}}"></i>
              <p> {{trans('sideBar.Distance')}}</p>
            </a>
          </li>

          <li class="nav-item ">
            <a class="nav-link" href="{{route('version.get')}}">
              <i ><img src="{{url('public/images/muhrahpanel/version.png')}}" style="width: 32px; height: 32px;" ></i>
              <p> Version Check</p>
            </a>
          </li>

        </ul>
      </div>
    </div>