@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ env('APP_URL') }}/admin_assets/#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ $data['total_visitors'] }}</h3>
          <p>Current Visitors</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('admin.societies.reports.index',auth()->user()->society_id) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ $data['total_guards'] }}</h3>
          <p>Guards</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        @role('society_admin')
        <a href="{{ route('admin.guardes.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        @endrole
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{ $data['total_buildings'] }}</h3>
          <p>Buildings</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>

        @role('society_admin')
          <a href="{{ route('admin.societies.buildings.add',auth()->user()->society_id) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        @endrole
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner" >
          <h3>{{ $data['total_members'] }}</h3>
          <p>Members</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        @role('society_admin')
        <a href="{{ route('admin.societies.members.index',auth()->user()->society_id) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        @endrole
      </div>
    </div>
    <!-- ./col -->
  </div>
 
  <!-- /.row -->
@role('society_admin')
 <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner" >
          <h3>{{ $data['total_two_vehicles'] }}</h3>
          <p>Two Wheeler</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner" >
          <h3>{{ $data['total_four_vehicles'] }}</h3>
          <p>Four Wheeler</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <!-- BAR CHART -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Last Week Visited Visitors</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="barChart" style="height:230px"></canvas>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </div>
    <!-- /.col (RIGHT) -->
  </div>

  <!-- /.row -->
@endrole

</section>
@endsection
@section('custom_js')
  @role('society_admin')
    <script src="{{ env('APP_URL') }}/admin_assets/bower_components/chart.js/Chart.js"></script>
    <script>
      $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
         var labels = '<?php echo  json_encode($data['bar_chart']['labels']) ?>';
         // alert(labels);
         var values = '<?php echo  json_encode($data['bar_chart']['values']) ?>';
         var areaChartData = {

           labels  : JSON.parse(labels),
           datasets: [
             {
               label               : 'Electronics',
               fillColor           : 'rgba(210, 214, 222, 1)',
               strokeColor         : 'rgba(210, 214, 222, 1)',
               pointColor          : 'rgba(210, 214, 222, 1)',
               pointStrokeColor    : '#c1c7d1',
               pointHighlightFill  : '#fff',
               pointHighlightStroke: 'rgba(220,220,220,1)',
               data                : JSON.parse(values)
             },
             // {
             //   label               : 'Digital Goods',
             //   fillColor           : 'rgba(60,141,188,0.9)',
             //   strokeColor         : 'rgba(60,141,188,0.8)',
             //   pointColor          : '#3b8bba',
             //   pointStrokeColor    : 'rgba(60,141,188,1)',
             //   pointHighlightFill  : '#fff',
             //   pointHighlightStroke: 'rgba(60,141,188,1)',
             //   data                : [28, 48, 40, 19, 86, 27, 90]
             // }
           ]
         }
        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
        var barChart                         = new Chart(barChartCanvas)
        var barChartData                     = areaChartData
        // barChartData.datasets[1].fillColor   = '#00a65a'
        // barChartData.datasets[1].strokeColor = '#00a65a'
        // barChartData.datasets[1].pointColor  = '#00a65a'
        var barChartOptions                  = {
          //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
          scaleBeginAtZero        : true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines      : true,
          //String - Colour of the grid lines
          scaleGridLineColor      : 'rgba(0,0,0,.05)',
          //Number - Width of the grid lines
          scaleGridLineWidth      : 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines  : true,
          //Boolean - If there is a stroke on each bar
          barShowStroke           : true,
          //Number - Pixel width of the bar stroke
          barStrokeWidth          : 2,
          //Number - Spacing between each of the X value sets
          barValueSpacing         : 5,
          //Number - Spacing between data sets within X values
          barDatasetSpacing       : 1,
          //String - A legend template
          legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
          //Boolean - whether to make the chart responsive
          responsive              : true,
          maintainAspectRatio     : true
        }

        barChartOptions.datasetFill = false
        barChart.Bar(barChartData, barChartOptions)
      })
    </script>
  @endrole
@endsection
