

<!-- __________________________________________Header___________________________________________________ -->
@include('layouts.header')


<body class="">
  <div class="wrapper ">
  

<!-- __________________________________________SideBar___________________________________________________ -->
 <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>



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
                  <h4 class="card-title"></h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
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
                  @if(!empty($status))
                    @if($status=='danger')
                          <div class="alert alert-danger">
                                {{$msg}}
                          </div>
                     @else
                         <div class="alert alert-success">
                                {{$msg}}
                          </div> 
                    @endif

                  @endif
                   <form action="{{route('Driver.Payment')}}" method="post" onsubmit="return submitForm(this);">
                  {{csrf_field()}}
                  <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                  <div class="card-header text-center">
                    <h3 class="card-title">
                       Driver Receipt
                    </h3>
                    <h5 class="card-description">Here you can Get Payment from driver. </h5>
                    
                     
                        <br><br>

                  </div>
                     
                     <input type="hidden" class="" name="driverId" value="{{$driverWallet->driverId}}" >

                    <div class="row col-md-12">

                       <div class="col-md-3">
                            <div class="form-group">
                              <label>Total Earn</label>
                              <br>
                              <input type="number" class="" name="totalEarn" value="{{$driverWallet->totalEarn}}" readonly>
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="form-group">
                              <label>Total Pay (paid to company)</label>
                              <br>
                              <input type="number" class="" name="totalPay" value="{{$driverWallet->totalPay}}" readonly>
                            </div>
                        </div>

                      </div>

                        <!-- <div class="col-md-3">
                            <div class="form-group">
                              <label>Total Company Profit</label>
                              <input type="text" class="form-control" name="totalCompanyProfit" value="" readonly>
                            </div>
                        </div> -->
                        <div class="row col-md-12">

                        <div class="col-md-3">
                            <div class="form-group">
                              <label>Current Cash</label>
                              <br>
                              <input type="number" class="" id="currCash" name="currCash" value="{{$driverWallet->currCash}}" readonly>
                            </div>
                        </div>

                         <div class="col-md-3">
                            <div class="form-group">
                              <label>Current Earn</label>
                              <br>
                              <input type="number" class="" id="currentEarn" name="currentEarn" value="{{$driverWallet->currentEarn}}" readonly>
                            </div>
                        </div>

                         <div class="col-md-3">
                            <div class="form-group">
                              <label>Current C.Profit</label>
                              <br>
                              <input type="number" class="" id="currCompanyProfit" name="currCompanyProfit" value="{{$driverWallet->currCompanyProfit}}" readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                              <label>Current Vat</label>
                              <br>
                              <input type="number" class="" id="currVat" name="currVat" value="{{$driverWallet->currVat}}" readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                              <label>Creditor</label>
                              <br>
                              <input type="number" class="" id="creditor" name="creditor" value="{{$driverWallet->creditor}}" readonly>
                            </div>
                        </div>

                      

                    </div>
                  
                    <div id="mydiv" style="display: none;">

                      

                       <div class="col-md-12 ">

                        <div class="form-check pull-right">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="paymentMethod" value="bank" > Bank
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>

                        <div class="form-check pull-right">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="paymentMethod" value="cash" checked> Cash
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                         
                          <div class="col-md-12 pull-right">
                              <div class="form-group pull-right">
                                <label class="">Total Payment Left</label>
                                <br>
                                 <input type="number" class="" id="currentpaymentLeft" name="currentpaymentLeft" value="{{$driverWallet->currentpaymentLeft}}" readonly>
                             </div>
                          </div>
                          <div class="col-md-12 pull-right">
                              <div class="form-group pull-right">
                                <label class="">Date</label>
                                <br>
                                 <input type="date" class="" id="date" name="date">
                             </div>
                          </div>

                      </div>

                      <div class="col-md-12 ">
                          <div class="col-md-12 pull-right">
                              <div class="form-group pull-right">
                                <label class=""> Entered Paid Ammount </label>
                                  <br>
                                  <input type="number" class="" id="collectAmount" name="collectAmount" step=".01" >
                             </div>
                          </div>

                      </div>
                      <div class="col-md-12 pull-right">

                                <button type="submit" class="btn btn-raised pull-right" >save</button>   
                    </div>
                 </div>

                     
                </form>



                </div>
                <!-- end content-->
              </div>
              <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
          </div>
          <!-- end row -->
        </div>
                  <button class="btn btn-raised pull-left" onclick="showPickup12()">Calculate</button>

          </div>
      </div>





                 
<!-- __________________________________________Footer___________________________________________________ -->



@include('layouts.footer')









                </div>
              </div>
              



 <script type="text/javascript">
  

  function showPickup12() 
  {
    var x = document.getElementById("mydiv");
    if (x.style.display === "none") 
    {
        x.style.display = "block";

    } 
    else 
    {
        x.style.display = "none";
    }
  } 

   $(document).ready(function(){
        $('#collectAmount').on('change',function(){
            
            var collectAmount= $(this).val();
            var leftAmmount= document.getElementById("currentpaymentLeft").value;
                console.log('problem');
            
              if(collectAmount <= leftAmmount)
              {
                
              }
              else 
              {
                alert('please Enter the Correct amount');
                $(this).val()=leftAmmount;
              }

                      
                       
      });

   });

   function submitForm() 
  {
     

     // var collectAmount= parseFloat(document.getElementById("collectAmount").value);
     //  var leftAmount= parseFloat(document.getElementById("currentpaymentLeft").value);
     //    if(collectAmount <= leftAmount)
     //    {
     //      console.log('here');
     //         return confirm('هل تريد ان تحفظ هذا العقد ؟ ');
          
     //    }
     //    else{
     //      document.getElementById("collectAmount").value=leftAmmount;
     //       return false;
     //    }
        
  }


</script>






<!-- __________________________________________Footer___________________________________________________ -->



<!-- @include('layouts.sideFilters') -->




<!-- __________________________________________JsFiles___________________________________________________ -->



@include('layouts.js')




</body>

</html>

























































































