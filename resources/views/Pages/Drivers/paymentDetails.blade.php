
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
                  <h4 class="card-title">Receipts of Driver</h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                        
                          <th >detailId</th>
                          <th >driverId </th>
                          <th>date</th>
                          <th >currCash</th>
                          <th >currEarn </th>
                          <th >curr C.P</th>
                          <th >currVat</th>
                          <th >creditor </th>
                          <th >curr payment Left</th>
                          <th >payAmount</th>
                          <th >paidTo</th>
                          <th >Method</th>
                          <th >created_at</th>
                        </tr>
                      </thead>
                     
                      <tbody>
                       @if(!empty($details))
                        @foreach($details as $detail)

                                 <tr class="warning" >
                                    <td >{{ $detail->detailId }}</td>
                                    <td >{{ $detail->driverId }}</td>
                                    <td >{{ $detail->date }}</td>
                                    <td >{{ $detail->currCash }}</td>
                                    <td >{{ $detail->currEarn }}</td>
                                    <td >{{ $detail->currCompanyProfit }}</td>
                                    <td >{{ $detail->currVat }}</td>
                                    <td >{{ $detail->creditor }}</td>
                                    <td >{{ $detail->currentpaymentLeft }}</td>
                                    <td >{{ $detail->payAmount }}</td>
                                    <td >{{ $detail->paidTo }}</td>
                                    <td >{{ $detail->paymentMethod }}</td>
                                    <td >{{ $detail->created_at }}</td>

                                   
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
              


<script>
function showPickup(id) {
    var x = document.getElementById("myDIV"+id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function showDest(id) {
    var x = document.getElementById("myDIV2"+id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>





<!-- __________________________________________Footer___________________________________________________ -->



<!-- @include('layouts.sideFilters') -->




<!-- __________________________________________JsFiles___________________________________________________ -->



@include('layouts.js')
<script>
    $(document).ready(function() {
      $('#datatables').DataTable({
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