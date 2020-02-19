
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
                                <h4 class="card-title">Driver Car Distance</h4>

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

                        @if(!empty($distanceCreate))
                            @if($distanceCreate == 'yes')
                                <div class="alert alert-success">
                                    Distance is Successfully Changed!!!
                                </div>
                            @endif
                        @endif
                        <div class="card-body ">
                            <form  action="{{ route('distance.create') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Distance</label>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="distance" value="{{$distance}}" required>
                                            <span class="bmd-help">Enter here a Car name</span>
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