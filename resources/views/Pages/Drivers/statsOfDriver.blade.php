
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
         <div class="row">
              <div class="card ">
                <div class="card-header ">
                  <h4 class="card-title">{{trans('drivers.Statistics-of-Drivers-of-Muhrah')}}
                  </h4>
                </div>
                <div class="card-body ">
                  <div id="chart_div" ></div>

                  <div id="chart_active_unactive" ></div>

                  <div id="chart_logout_login" ></div>

                  <div id="chart_online_offline" ></div>

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


 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart2);
      google.charts.setOnLoadCallback(drawChart3);
      google.charts.setOnLoadCallback(drawChart4);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      
      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
        

          ['Approved Driver {{$Approved}}', {{$Approved}}],
          ['unApproved Driver {{$unapproved}}', {{$unapproved}}],
      
        ]);

        // Set chart options
        var options = {'title':'Drivers DETAILS'};
 
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row,0);
         
           alert(' user selected ' + topping);
           // if(topping=='Total Driver')
           // {
             
           //  location.href ="detailsdriver";
           // }
           // else if (topping=='Total Driver'){
           //  location.href = "detailsdriver";
           // }
           // else{ 
           //  location.href = "f";

           // }
          }
        }

        google.visualization.events.addListener(chart, 'select', selectHandler);    
        chart.draw(data, options);
      }




      function drawChart2() {

          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Topping');
          data.addColumn('number', 'Slices');
          data.addRows([


              ['Active Driver {{$TotalActiveDrivers}}', {{$TotalActiveDrivers}}],
              ['unACtive Driver {{$TotalUnActiveDrivers}}', {{$TotalUnActiveDrivers}}],

          ]);

          // Set chart options
          var options = {'title':'Active and Unactive Drivers'};

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_active_unactive'));

          function selectHandler() {
              var selectedItem = chart.getSelection()[0];
              if (selectedItem) {
                  var topping = data.getValue(selectedItem.row,0);

                  alert(' user selected ' + topping);
                  // if(topping=='Total Driver')
                  // {

                  //  location.href ="detailsdriver";
                  // }
                  // else if (topping=='Total Driver'){
                  //  location.href = "detailsdriver";
                  // }
                  // else{
                  //  location.href = "f";

                  // }
              }
          }

          google.visualization.events.addListener(chart, 'select', selectHandler);
          chart.draw(data, options);
      }


      function drawChart3() {

          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Topping');
          data.addColumn('number', 'Slices');
          data.addRows([


              ['Login Driver {{$login}}', {{$login}}],
              ['Logout Driver {{$logout}}', {{$logout}}],

          ]);

          // Set chart options
          var options = {'title':'Logout and Login Drivers '};

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_logout_login'));

          function selectHandler() {
              var selectedItem = chart.getSelection()[0];
              if (selectedItem) {
                  var topping = data.getValue(selectedItem.row,0);

                  alert(' user selected ' + topping);
                  // if(topping=='Total Driver')
                  // {

                  //  location.href ="detailsdriver";
                  // }
                  // else if (topping=='Total Driver'){
                  //  location.href = "detailsdriver";
                  // }
                  // else{
                  //  location.href = "f";

                  // }
              }
          }

          google.visualization.events.addListener(chart, 'select', selectHandler);
          chart.draw(data, options);
      }


      function drawChart4() {

          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Topping');
          data.addColumn('number', 'Slices');
          data.addRows([


              ['online Driver {{$online}}', {{$online}}],
              ['offline Driver {{$offline}}', {{$offline}}],

          ]);

          // Set chart options
          var options = {'title':'online and offline Drivers '};

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_online_offline'));

          function selectHandler() {
              var selectedItem = chart.getSelection()[0];
              if (selectedItem) {
                  var topping = data.getValue(selectedItem.row,0);

                  alert(' user selected ' + topping);
                  // if(topping=='Total Driver')
                  // {

                  //  location.href ="detailsdriver";
                  // }
                  // else if (topping=='Total Driver'){
                  //  location.href = "detailsdriver";
                  // }
                  // else{
                  //  location.href = "f";

                  // }
              }
          }

          google.visualization.events.addListener(chart, 'select', selectHandler);
          chart.draw(data, options);
      }

    </script>



@include('layouts.js')




</body>

</html>