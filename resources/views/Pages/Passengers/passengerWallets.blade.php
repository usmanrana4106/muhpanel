
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
                  <h4 class="card-title">Passenger Wallets</h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          
                        
                            <th>Wallet ID</th>                        
		                        <th>UserId</th>                        
		                        <th>Passenger Name</th>
		                        <th>Total Pay</th>
		                        <th>credit</th>
		                        <th>Due</th>
                        
                    
                          
                        </tr>
                      </thead>
                 
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
      $('#datatables').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url":"api/R_passenger_wallets",
          "dataType":"json",
          "type":"POST",
          "data":{"_token":"<?= csrf_token() ?>"}
        },
        "columns":[
          {"data":"walletId"},
          {"data":"userId"},
          {"data":"fullName"},
          {"data":"totalPay"},
          {"data":"credit"},
          {"data":"due"}
        ]
      } );
    </script>




</body>

</html>