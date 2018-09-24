
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
              

          	 <div id="chart_div" style="width: 900px; height: 700px;"></div>




          </div>
      </div>





                 
<!-- __________________________________________Footer___________________________________________________ -->



@include('layouts.footer')









                </div>
              </div>
              








<!-- __________________________________________Footer___________________________________________________ -->



<!-- @include('layouts.sideFilters') -->




<!-- __________________________________________JsFiles___________________________________________________ -->


 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      
      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
        
          ['Total Driver',  {{$Driver}} ],
          ['Online Driver', {{$online}} ],
          ['Offline Driver',  {{$offline}} ],
          ['Login Driver', {{$login}} ],
          ['Logout Driver', {{$logout}} ],
          ['Free Driver', {{$free}}],
          ['Ride Driver', {{$ride}}],
          ['Accept Driver', {{$accept}} ],
          ['On Th Way Driver', {{$ontheway}}],
          ['Approved Driver', {{$Approve}}],
          ['Unapproved Driver', {{$unapprove}}],
          ['Passengers',{{$passenger}}],
          ['Unapproved MOT  Drivers', {{$notapprovedMOT}}],
      
        ]);

        // Set chart options
        var options = {'title':'USER DETAILS'};
 
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row,0);
         
           alert(' user selected ' + topping);
           if(topping=='Total Driver')
           {
             
            location.href ="detailsdriver";
           }
        
           else if (topping=='Total Driver'){
            location.href = "detailsdriver";
           }
         
           else if (topping=='Online Driver'){
            location.href = "onlineDriver";
           }
           else if (topping=='Offline Driver'){
            location.href = "Offlinedriver";
           }
           else if (topping=='Login Driver'){
            location.href = "LoginDriver";
           }
           else if (topping=='Logout Driver'){
            location.href = "Logoutdriver";
           }
           else if (topping=='Free Driver'){
            location.href = "FreeDriver";
           }  
            else if (topping=='Accept Driver'){
            location.href = "AcceptDriver";
           }
           else if (topping=='Approved Driver'){
            location.href = "ApprovedDriver";
           }
           else if (topping=='Unapproved Driver'){
            location.href = "UnapprovedDriver";
           }
           else if (topping=='Passengers'){
            location.href = "Passengers";
           }
           else if (topping=='Unapproved MOT  Drivers'){
            location.href = "UnapprovedMOT";
           }
           else if (topping=='Ride Driver'){
            location.href = "RideDriver";
           }
           else{ 
            location.href = "f";

           }
          }
        }

        google.visualization.events.addListener(chart, 'select', selectHandler);    
        chart.draw(data, options);
      }
      

    </script>



@include('layouts.js')




</body>

</html>