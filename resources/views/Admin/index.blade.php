@extends('layouts.master')
@section('content')
    <div class="content mt-3">

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-user text-primary border-primary"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text">New User</div>
                                <div class="stat-digit">{{$newUser}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-user text-success border-success"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text">Active User</div>
                                <div class="stat-digit">{{$activeUser}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-user text-danger border-danger"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text">Deactive User</div>
                                <div class="stat-digit">{{$deActiveUser}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-user text-info border-info"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text">Total User</div>
                                <div class="stat-digit">{{$totalUser}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

              <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="fa fa-inr text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Total Profit</div>
                                        <div class="stat-digit">{{$totalCollectPayment}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="fa fa-inr text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Message Payment</div>
                                        <div class="stat-digit">{{$totalProfit}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="fa fa-inr text-warning border-warning"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Direct Payment</div>
                                        <div class="stat-digit">{{$directPayment}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="fa fa-inr text-danger border-danger"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Member Payment</div>
                                        <div class="stat-digit">{{$memberPayment}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>







                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-user text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Active Member</div>
                                        <div class="stat-digit">{{$member}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-user text-danger border-danger"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Deactive Member</div>
                                        <div class="stat-digit">{{$deActiveMember}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-user text-info border-info"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Total Member</div>
                                        <div class="stat-digit">{{$totalMember}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-email text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Message</div>
                                        <div class="stat-digit">{{$totalMessage}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-user text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Active Astrologer</div>
                                        <div class="stat-digit">{{$activeAstrologer}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-user text-danger border-danger"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Deactive Astrologer</div>
                                        <div class="stat-digit">{{$deActiveAstrologer}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-user text-info border-info"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Total Astrologer</div>
                                        <div class="stat-digit">{{$totalAstrologer}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-email text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Empty</div>
                                        <div class="stat-digit"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center">USER</h1>
                        <!-- HTML -->
                        <div id="userChart"></div>
                    </div>
                    <div class="card-footer">
       
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center">RECENT USER</h1>
                        <!-- HTML -->
                        <div id="recentUserChart"></div>
                    </div>
                    <div class="card-footer">
       
                    </div>
                </div>
            </div>

    </div> <!-- .content -->
</div><!-- /#right-panel -->

    <!-- Right Panel -->

<!-- Styles -->
<style>
#userChart,
#recentUserChart{
  width: 100%;
  height: 500px;
}

</style>

<script src="/public/amcharts4/core.js"></script>
<script src="/public/amcharts4/charts.js"></script>
<script src="/public/amcharts4/plugins/sunburst.js"></script>
<script src="/public/amcharts4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("userChart", am4charts.PieChart3D);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.legend = new am4charts.Legend();

chart.data = [
  {
    type: "New",
    values: "{{$newUser}}"
  },
  {
    type: "Active",
    values: "{{$activeUser}}"
  },
  {
    type: "Deactive",
    values: "{{$deActiveUser}}"
  },
  {
    type: "Total",
    values: "{{$totalUser}}"
  }
];

var series = chart.series.push(new am4charts.PieSeries3D());
series.dataFields.value = "values";
series.dataFields.category = "type";

// Add legend
chart.legend = new am4charts.Legend();
chart.legend.valueLabels.template.text = "";
chart.legend.fontSize = 15;
series.colors.list = [
  am4core.color("#ea7e00"),
  am4core.color("#28a745"),
  am4core.color("#dc3545"),
  am4core.color("#007bff"),
];

}); // end am4core.ready()

////// Recent Users Chart
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("recentUserChart", am4charts.XYChart);

// Add data
chart.data = [@foreach($userData as $userValue)
{
  "date": "{{$userValue->month}}",
  "value":"{{$userValue->user_num}}"
}, @endforeach];

// Set input format for the dates
chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.maxPrecision = 0;
// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "value";
series.dataFields.dateX = "date";
series.tooltipText = "{value}"
series.strokeWidth = 2;
series.minBulletDistance = 15;

// Drop-shaped tooltips
series.tooltip.background.cornerRadius = 20;
series.tooltip.background.strokeOpacity = 0;
series.tooltip.pointerOrientation = "vertical";
series.tooltip.label.minWidth = 40;
series.tooltip.label.minHeight = 40;
series.tooltip.label.textAlign = "middle";
series.tooltip.label.textValign = "middle";

// Make bullets grow on hover
var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.circle.strokeWidth = 2;
bullet.circle.radius = 4;
bullet.circle.fill = am4core.color("#fff");

var bullethover = bullet.states.create("hover");
bullethover.properties.scale = 1.3;

// Make a panning cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.behavior = "panXY";
chart.cursor.xAxis = dateAxis;
chart.cursor.snapToSeries = series;

// Create vertical scrollbar and place it before the value axis
chart.scrollbarY = new am4core.Scrollbar();
chart.scrollbarY.parent = chart.leftAxesContainer;
chart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
chart.scrollbarX = new am4charts.XYChartScrollbar();
chart.scrollbarX.series.push(series);
chart.scrollbarX.parent = chart.bottomAxesContainer;

dateAxis.start = 0.79;
dateAxis.keepSelection = true;


}); // end am4core.ready()
</script>
@endsection