
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
                  <h4 class="card-title">{{$title}}</h4>
                  @if(!empty($title))
                    <input type="hidden" id="title" name="title" value="{{$title}}">
                  @endif
                
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          
                        
		                        <th>{{trans('drivers.D-ID')}}</th>
		                        <th>{{trans('drivers.Name')}}</th>
		                        <th>{{trans('drivers.ID-Number')}}</th>
		                        <th>{{trans('drivers.Mobile')}}</th>
		                        <th>deviceType <br> <small> 1: Android<br> 2: iOS</small></th>
		                        <th>{{trans('drivers.Vehicle-No')}} </th>
		                        <th>{{trans('drivers.Identity-Proof')}}</th>
                                <th>{{trans('drivers.License-Proof')}} </th>
                                <th>{{trans('drivers.Reg-Date')}}</th>
		                        <th>{{trans('drivers.Action')}}  </th>
                        
                    
                          
                        </tr>
                      </thead>
                      <!-- <tfoot>
                        <tr>
                          
                          <th >S.No.</th>
                          <th >Passenger </th>
                          <th >Pass Mobile </th>
                          <th >Driver </th>
                          <th >PickUp Address</th>
                          <th >Destination Address</th>
                          <th >Trip Cost </th>
                          <th >Start Date </th>
                          <th >Start Time</th>
                          <th >End Time</th>
                          <th >Duration(min)</th>
                         
                          <th >Ride Status</th>
                      

                        </tr>
                      </tfoot> -->
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
  .size{
    height: 35px;
    width: 100px;
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


    var title=document.getElementById("title").value;


   $('#datatables').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url":"<?= url('api/R_drivers_driversWithStatus') ?>",
          "dataType":"json",
          "type":"POST",
          "data":{
                    "_token":"<?= csrf_token() ?>",
                    "title":title,
                   
                  }
        },
        "columns":[

          {"data":"userId"},
          {"data":"fullName"},
          {"data":"captainIdentityNumber"},
          {"data":"mobileNumber"},
          {"data":"deviceType"},
          {"data":"vihicleNumber"},
          {"data":"identityProofStatus"},
          {"data":"licenceNumberStatus"},
          {"data":"crd"},
          {"data":"action","searchable":false,"orderable":false}

        ]
      } );
  </script>




</body>

</html>