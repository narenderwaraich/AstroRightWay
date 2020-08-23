@extends('layouts.app')
@section('content') 

@if(isset($banner))
<div class="banner">
  <img src="{{asset('/public/images/banner/'.$banner->image)}}" alt="{{$banner->heading}}"/>
  <div class="slider-imge-overlay"></div>
  <div class="caption text-center">
    <div class="container">
      @if($banner->heading)
      <div class="caption-in">
        <div class="caption-ins">
          <h1 class="text-up">{{$banner->heading}}<span>{{$banner->sub_heading}}</span></h1>
          @if($banner->button_text)
          <div class="links"> 
            <a href="{{$banner->button_link}}" class="btns slider-btn"><span>{{$banner->button_text}}</span></a> 
          </div>
          @endif
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@else
<div class="m-t-150"></div>
@endif
<div class="container" style="margin-top: 100px;">
  @foreach($covid as $covidData)
    <section class="chart-section section-top container">
      <h1 class="section-heading-txt heading-color text-center">India Corona Update</h1>
        <div class="last-uptd  m-t-15">
          <div class="last-uptd-txt">Last Update <span style="color: #007bff; font-size: 12px;">({{ $covidData->updated_at->diffForHumans() }})</span></div>
          <div class="last-uptd-data">{{ date('l, d/m/Y', strtotime($covidData->updated_at)) }}</div>
        </div>
      <div class="row m-t-30 m-b-40">
        <div class="col-md-3">
          <div class="covid-box on-hover-shadow" style="background-color: #007bff">
            <div class="covid-txt">Confirmed Case</div>
            <div class="covid-val">{{$covidData->confirmed}}</div>
            <div class="value-diff">{{$covidData->confirmed - $covidData->lastConfirmed}} <i class="fa fa-arrow-up"></i></div>
          </div>
        </div>
        <div class="col-md-3 on-mob-top-30">
          <div class="covid-box on-hover-shadow" style="background-color: #28a745">
            <div class="covid-txt">Recovered Case</div>
            <div class="covid-val">{{$covidData->recovered}}</div>
            <div class="value-diff">{{$covidData->recovered - $covidData->lastRecovered}} <i class="fa fa-arrow-up"></i></div>
          </div>
        </div>
        <div class="col-md-3 on-mob-top-30">
          <div class="covid-box on-hover-shadow" style="background-color: #FF8800">
            <div class="covid-txt">Active Case</div>
            <div class="covid-val">{{$covidData->active}}</div>
            <div class="value-diff">{{$covidData->active - $covidData->lastActive}} <i class="fa fa-arrow-up"></i></div>
          </div>
        </div>
        <div class="col-md-3 on-mob-top-30">
          <div class="covid-box on-hover-shadow" style="background-color: #dc3545">
            <div class="covid-txt">Deceased Case</div>
            <div class="covid-val">{{$covidData->deceased}}</div>
            <div class="value-diff">{{$covidData->deceased - $covidData->lastDeceased}} <i class="fa fa-arrow-up"></i></div>
          </div>
        </div>
      </div>
        <div id="piChart"></div>
    </section>
  @endforeach
  <h1 class="section-heading-txt text-center" style="color: #007bff;margin-top: 50px;">Confirmed Case</h1>
  <div id="confirmChart" style="margin-top: 50px;"></div>
  <h1 class="section-heading-txt text-center" style="color: #28a745">Recovered Case</h1>
  <div id="recoverChart" style="margin-top: 50px;"></div>
  <h1 class="section-heading-txt text-center" style="color: #FF8800">Active Case</h1>
  <div id="activeChart" style="margin-top: 50px;"></div>
  <h1 class="section-heading-txt text-center" style="color: #dc3545">Deceased Case</h1>
  <div id="deceasChart" style="margin-top: 50px;"></div>
  <h2 class="section-heading-txt heading-color text-center">All Data Table</h2>
  <table class="table table-hover on-mob-scroll-table" style="margin-top: 50px;">
        <thead>
        <tr>
            <th>No.</th>
            <th style="color: #007bff">Confirmed</th>
            <th style="color: #28a745">Recovered</th>
            <th style="color: #FF8800">Active</th>
            <th style="color: #dc3545">Deceased</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($covid19 as $key => $covid19Data)
            <tr>
                <td>{{1+$key++}}</td>
                <td style="color: #007bff">{{ $covid19Data->confirmed }}</td>
                <td style="color: #28a745">{{ $covid19Data->recovered }}</td>
                <td style="color: #FF8800">{{ $covid19Data->active }}</td>
                <td style="color: #dc3545">{{ $covid19Data->deceased }}</td>
                <td>{{ date('l, d/m/Y', strtotime($covid19Data->created_at)) }}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
    {!! $covid19->links() !!} 
</div>

<script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>
<script src="/public/amcharts4/core.js"></script>
<script src="/public/amcharts4/charts.js"></script>
<script src="/public/amcharts4/plugins/sunburst.js"></script>
<script src="/public/amcharts4/themes/animated.js"></script>



<!-- Styles -->
<style>
#piChart{
  width: 100%;
  height: 580px;
}
#confirmChart,
#recoverChart,
#deceasChart{
  width: 100%;
  height: 550px;
}

</style>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end



var chart = am4core.create("piChart", am4charts.PieChart3D);


// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "values";
pieSeries.dataFields.category = "type";

// Let's cut a hole in our Pie chart the size of 30% the radius
chart.innerRadius = am4core.percent(50);

// Put a thick white border around each Slice
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template

  // change the cursor on hover to make it apparent the object can be interacted with
  .cursorOverStyle = [
    {
      "property": "cursor",
      "value": "pointer"
    }
  ];

pieSeries.alignLabels = false;
pieSeries.labels.template.bent = true;
pieSeries.labels.template.radius = 3;
pieSeries.labels.template.padding(0,0,0,0);
pieSeries.labels.template.disabled = true;

pieSeries.ticks.template.disabled = true;
pieSeries.colors.list = [
  am4core.color("#007bff"),
  am4core.color("#28a745"),
  am4core.color("#FF8800"),
  am4core.color("#dc3545"),
];
// Create a base filter effect (as if it's not there) for the hover to return to
var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
shadow.opacity = 0;

// Create hover state
var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

// Slightly shift the shadow and make it more prominent on hover
var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
hoverShadow.opacity = 0.7;
hoverShadow.blur = 5;

// Add a legend
chart.legend = new am4charts.Legend();
chart.legend.position = "bottom";
chart.data = [@foreach($covid as $covidChart)
  {
    type: "Confirm",
    values: "{{$covidChart->confirmed}}"
  },
  {
    type: "Recover",
    values: "{{$covidChart->recovered}}"
  },
  {
      type: "Active",
      values: "{{$covidChart->active}}"
  },
  {
    type: "Death",
    values: "{{$covidChart->deceased}}"
  },@endforeach
];























// Create chart instance
var confirmChart = am4core.create("confirmChart", am4charts.XYChart);

// Add data
confirmChart.data = [@foreach($covidAll as $covidData){
  "date": "{{$covidData->created_at}}",
  "value": "{{$covidData->confirmed}}"
},
@endforeach];

// Set input format for the dates
confirmChart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
var dateAxis = confirmChart.xAxes.push(new am4charts.DateAxis());
var valueAxis = confirmChart.yAxes.push(new am4charts.ValueAxis());

// Create series
var confirmSeries = confirmChart.series.push(new am4charts.LineSeries());
confirmSeries.dataFields.valueY = "value";
confirmSeries.dataFields.dateX = "date";
confirmSeries.tooltipText = "{value}"
confirmSeries.strokeWidth = 2;
confirmSeries.minBulletDistance = 15;

// Drop-shaped tooltips
confirmSeries.tooltip.background.cornerRadius = 20;
confirmSeries.tooltip.background.strokeOpacity = 0;
confirmSeries.tooltip.pointerOrientation = "vertical";
confirmSeries.tooltip.label.minWidth = 40;
confirmSeries.tooltip.label.minHeight = 40;
confirmSeries.tooltip.label.textAlign = "middle";
confirmSeries.tooltip.label.textValign = "middle";

// Make bullets grow on hover
var bullet = confirmSeries.bullets.push(new am4charts.CircleBullet());
bullet.circle.strokeWidth = 2;
bullet.circle.radius = 4;
bullet.circle.fill = am4core.color("#fff");

var bullethover = bullet.states.create("hover");
bullethover.properties.scale = 1.3;

// Make a panning cursor
confirmChart.cursor = new am4charts.XYCursor();
confirmChart.cursor.behavior = "panXY";
confirmChart.cursor.xAxis = dateAxis;
confirmChart.cursor.snapToSeries = confirmSeries;

// Create vertical scrollbar and place it before the value axis
confirmChart.scrollbarY = new am4core.Scrollbar();
confirmChart.scrollbarY.parent = confirmChart.leftAxesContainer;
confirmChart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
confirmChart.scrollbarX = new am4charts.XYChartScrollbar();
confirmChart.scrollbarX.series.push(confirmSeries);
confirmChart.scrollbarX.parent = confirmChart.bottomAxesContainer;

dateAxis.start = 0.79;
dateAxis.keepSelection = true;




////recoverChart


// Create chart instance
var recoverChart = am4core.create("recoverChart", am4charts.XYChart);

// Add data
recoverChart.data = [@foreach($covidAll as $covidData){
  "date": "{{$covidData->created_at}}",
  "value": "{{$covidData->recovered}}"
},
@endforeach];

// Set input format for the dates
recoverChart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
var dateAxis = recoverChart.xAxes.push(new am4charts.DateAxis());
var valueAxis = recoverChart.yAxes.push(new am4charts.ValueAxis());

// Create series
var recoverSeries = recoverChart.series.push(new am4charts.LineSeries());
recoverSeries.dataFields.valueY = "value";
recoverSeries.dataFields.dateX = "date";
recoverSeries.tooltipText = "{value}"
recoverSeries.strokeWidth = 2;
recoverSeries.minBulletDistance = 15;

// Drop-shaped tooltips
recoverSeries.tooltip.background.cornerRadius = 20;
recoverSeries.tooltip.background.strokeOpacity = 0;
recoverSeries.tooltip.pointerOrientation = "vertical";
recoverSeries.tooltip.label.minWidth = 40;
recoverSeries.tooltip.label.minHeight = 40;
recoverSeries.tooltip.label.textAlign = "middle";
recoverSeries.tooltip.label.textValign = "middle";

// Make bullets grow on hover
var bullet = recoverSeries.bullets.push(new am4charts.CircleBullet());
bullet.circle.strokeWidth = 2;
bullet.circle.radius = 4;
bullet.circle.fill = am4core.color("#fff");

var bullethover = bullet.states.create("hover");
bullethover.properties.scale = 1.3;

// Make a panning cursor
recoverChart.cursor = new am4charts.XYCursor();
recoverChart.cursor.behavior = "panXY";
recoverChart.cursor.xAxis = dateAxis;
recoverChart.cursor.snapToSeries = recoverSeries;

// Create vertical scrollbar and place it before the value axis
recoverChart.scrollbarY = new am4core.Scrollbar();
recoverChart.scrollbarY.parent = recoverChart.leftAxesContainer;
recoverChart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
recoverChart.scrollbarX = new am4charts.XYChartScrollbar();
recoverChart.scrollbarX.series.push(recoverSeries);
recoverChart.scrollbarX.parent = recoverChart.bottomAxesContainer;

dateAxis.start = 0.79;
dateAxis.keepSelection = true;



////activeChart


// Create chart instance
var activeChart = am4core.create("activeChart", am4charts.XYChart);

// Add data
activeChart.data = [@foreach($covidAll as $covidData){
  "date": "{{$covidData->created_at}}",
  "value": "{{$covidData->active}}"
},
@endforeach];

// Set input format for the dates
activeChart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
var dateAxis = activeChart.xAxes.push(new am4charts.DateAxis());
var valueAxis = activeChart.yAxes.push(new am4charts.ValueAxis());

// Create series
var activeSeries = activeChart.series.push(new am4charts.LineSeries());
activeSeries.dataFields.valueY = "value";
activeSeries.dataFields.dateX = "date";
activeSeries.tooltipText = "{value}"
activeSeries.strokeWidth = 2;
activeSeries.minBulletDistance = 15;

// Drop-shaped tooltips
activeSeries.tooltip.background.cornerRadius = 20;
activeSeries.tooltip.background.strokeOpacity = 0;
activeSeries.tooltip.pointerOrientation = "vertical";
activeSeries.tooltip.label.minWidth = 40;
activeSeries.tooltip.label.minHeight = 40;
activeSeries.tooltip.label.textAlign = "middle";
activeSeries.tooltip.label.textValign = "middle";

// Make bullets grow on hover
var bullet = activeSeries.bullets.push(new am4charts.CircleBullet());
bullet.circle.strokeWidth = 2;
bullet.circle.radius = 4;
bullet.circle.fill = am4core.color("#fff");

var bullethover = bullet.states.create("hover");
bullethover.properties.scale = 1.3;

// Make a panning cursor
activeChart.cursor = new am4charts.XYCursor();
activeChart.cursor.behavior = "panXY";
activeChart.cursor.xAxis = dateAxis;
activeChart.cursor.snapToSeries = activeSeries;

// Create vertical scrollbar and place it before the value axis
activeChart.scrollbarY = new am4core.Scrollbar();
activeChart.scrollbarY.parent = activeChart.leftAxesContainer;
activeChart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
activeChart.scrollbarX = new am4charts.XYChartScrollbar();
activeChart.scrollbarX.series.push(activeSeries);
activeChart.scrollbarX.parent = activeChart.bottomAxesContainer;

dateAxis.start = 0.79;
dateAxis.keepSelection = true;


////deceasChart


// Create chart instance
var deceasChart = am4core.create("deceasChart", am4charts.XYChart);

// Add data
deceasChart.data = [@foreach($covidAll as $covidData){
  "date": "{{$covidData->created_at}}",
  "value": "{{$covidData->deceased}}"
},
@endforeach];

// Set input format for the dates
deceasChart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
var dateAxis = deceasChart.xAxes.push(new am4charts.DateAxis());
var valueAxis = deceasChart.yAxes.push(new am4charts.ValueAxis());

// Create series
var deceasSeries = deceasChart.series.push(new am4charts.LineSeries());
deceasSeries.dataFields.valueY = "value";
deceasSeries.dataFields.dateX = "date";
deceasSeries.tooltipText = "{value}"
deceasSeries.strokeWidth = 2;
deceasSeries.minBulletDistance = 15;

// Drop-shaped tooltips
deceasSeries.tooltip.background.cornerRadius = 20;
deceasSeries.tooltip.background.strokeOpacity = 0;
deceasSeries.tooltip.pointerOrientation = "vertical";
deceasSeries.tooltip.label.minWidth = 40;
deceasSeries.tooltip.label.minHeight = 40;
deceasSeries.tooltip.label.textAlign = "middle";
deceasSeries.tooltip.label.textValign = "middle";

// Make bullets grow on hover
var bullet = deceasSeries.bullets.push(new am4charts.CircleBullet());
bullet.circle.strokeWidth = 2;
bullet.circle.radius = 4;
bullet.circle.fill = am4core.color("#fff");

var bullethover = bullet.states.create("hover");
bullethover.properties.scale = 1.3;

// Make a panning cursor
deceasChart.cursor = new am4charts.XYCursor();
deceasChart.cursor.behavior = "panXY";
deceasChart.cursor.xAxis = dateAxis;
deceasChart.cursor.snapToSeries = deceasSeries;

// Create vertical scrollbar and place it before the value axis
deceasChart.scrollbarY = new am4core.Scrollbar();
deceasChart.scrollbarY.parent = deceasChart.leftAxesContainer;
deceasChart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
deceasChart.scrollbarX = new am4charts.XYChartScrollbar();
deceasChart.scrollbarX.series.push(deceasSeries);
deceasChart.scrollbarX.parent = deceasChart.bottomAxesContainer;

dateAxis.start = 0.79;
dateAxis.keepSelection = true;

}); // end am4core.ready()
</script>

@endsection