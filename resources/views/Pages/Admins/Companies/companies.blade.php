
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


                @if(!empty($deleteCompany))
                    <div class="row alert alert-success">
                        {{$deleteCompany}}
                    </div>
                @endif

                @if(!empty($updateCompany))
                    <div class="row alert alert-success">
                        {{$updateCompany}}
                    </div>
                @endif



                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-12">
                            <a href="{{ url('/C_admin_companies') }}">
                                <button  type="button" class="btn btn-success size pull-right">Add Companies</button>
                            </a>
                            <div class="card">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">{{trans('adminDetails.Company-Details')}}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>

                                            <tr>

                                                <th >{{trans('adminDetails.CompanyId')}}</th>
                                                <th >{{trans('adminDetails.CompanyName')}} </th>
                                                <th >{{trans('adminDetails.Email')}}</th>
                                                <th >{{trans('adminDetails.mobileNumber')}}</th>
                                                <th >{{trans('adminDetails.created_at')}}</th>
                                                <th >{{trans('adminDetails.action')}}</th>

                                            </tr>

                                            </thead>

                                            <tbody>
                                            @if(!empty($companies))
                                                @foreach($companies as $company)

                                                    <tr class="warning" >
                                                        <td >{{ $company->a_id }}</td>
                                                        <td >{{ $company->f_name }}</td>
                                                        <td >{{ $company->email }}</td>
                                                        <td >{{ $company->mobileNumber }}</td>
                                                        <td >{{ $company->created_at }}</td>
                                                        <td >
                                                            <a href="{{ url('/R_admin_deletecompanies',$company->a_id) }}">
                                                                <button  type="button" class="btn btn-danger size">Delete</button>
                                                            </a>

                                                            <a href="{{ url('/U_admin_updateCompanies',$company->a_id) }}">
                                                                <button  type="button" class="btn btn-primary size">Edit</button>
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