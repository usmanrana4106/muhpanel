
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
                                <h4 class="card-title">Create Car Type</h4>

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

                                @if(!empty($createCompany))
                                    <div class="alert alert-success">
                                        :-> Company Is SuccessFully Created!!!
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="card-body ">
                            <form  action="{{ route('Admin.updateCompanies') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" class="form-control" name="a_id" value="{{$company->a_id}}" required>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Company Name</label>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="companyName" value="{{$company->f_name}}" required>
                                            <span class="bmd-help">Enter here a Company name</span>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Company Email</label>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="email" value="{{$company->email}}" required>
                                            <span class="bmd-help">Enter here a Company Email</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Mobile Number </label>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="mobileNumber" value="{{$company->mobileNumber}}" required>
                                            <span class="bmd-help">Enter here a Mobile Number</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password"  >
                                            <span class="bmd-help">Enter here the password</span>
                                        </div>
                                    </div>
                                </div>




                                <div class="col-sm-12">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-raised btn-danger">Save</button>
                                    </div>
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