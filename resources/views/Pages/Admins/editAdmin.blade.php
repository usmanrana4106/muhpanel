
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
              


          	 <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-rose card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Edit Admin</h4>

                       @if(count($errors))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                  </div>
                </div>
                <div class="card-body ">
                		 <form  action="{{ route('Admin.edit') }}" method="post" class="form-horizontal">
                        	 	{{ csrf_field() }}
                          <input type="hidden" name="admin_id" id="admin_id" value="{{$admin->admin_id}}">
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Admin Name</label>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <input type="text" class="form-control" name="admin_name" id="admin_name" value="{{$admin->admin_name}}" required>
                          <span class="bmd-help">Enter here a Admin name</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <input type="email" class="form-control" name="email" id="email" value="{{$admin->email}}" required>
                          <span class="bmd-help">Enter here the Email of Admin</span>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <input type="password" class="form-control" name="password" id="password"  required>
                        </div>
                      </div>
                      
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Confirm Password</label>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <input type="password" class="form-control" name="confirmpassword" id="confirmpassword"  required>
                          <span class="bmd-help">Confirm Password</span>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-sm-12">
                          <button type="submit" class="btn btn-raised ">Submit</button>   
                    </div>
                  </form>
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




</body>

</html>