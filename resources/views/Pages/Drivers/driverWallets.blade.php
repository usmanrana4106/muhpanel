
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
                  <h4 class="card-title">Drivers Wallets</h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          
                        
		                        <th>D ID</th>                        
		                        <th>D Name</th>
		                        <th>Total Earn</th>
		                        <th>total pay</th>
		                        <th>total CP</th>
		                        <th>total Vat</th>
		                        <th>Curr Cash</th>
		                        <th>Curr Earn</th>
		                        <th>curr CP</th>
                            <th>Curr Vat</th>
                            <th>Creditor</th>
                            <th>Pay Left</th>
		                        <th>Action</th>
                        
                    
                          
                        </tr>
                      </thead>
                 
                      <tbody>
                       @if(!empty($Wallets))
                        @foreach($Wallets as $Wallet)

                                 <tr class="warning" >
                                    <td style="width: 1%">{{ $Wallet->driverId }}</td>
                                    <td style="width: 3%">{{ $Wallet->fullName }}</td>
                                    <td style="width: 1%">{{ $Wallet->totalEarn }}</td>
                                    <td style="width: 1%">{{ $Wallet->totalPay }}</td>
                                    <td style="width: 1%">{{ $Wallet->totalCompanyProfit }}</td>                                   
                                    <td style="width: 1%">{{ $Wallet->totalVatPaid }}</td>
                                    <td style="width: 1%">{{ $Wallet->currCash }}</td>
                                    <td style="width: 1%">{{ $Wallet->currentEarn }}</td>
                                    <td style="width: 1%">{{ $Wallet->currCompanyProfit }}</td>
                                    <td style="width: 1%">{{ $Wallet->currVat }}</td>
                                    <td style="width: 1%">{{ $Wallet->creditor }}</td>
                                    <td style="width: 1%">{{ $Wallet->currentpaymentLeft }}</td>
                                   

                               
                                    
                                    <td style="width: 5%">
                                        <a href="{{ url('/getPayments',$Wallet->driverId) }}">
                                          <button  type="button" class="btn btn-danger ">Get Payment</button>
                                        </a>
                                         <a href="{{ url('/getAllPaymentRecords',$Wallet->driverId) }}">
                                          <button  type="button" class="btn btn-success ">Receipts</button>
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