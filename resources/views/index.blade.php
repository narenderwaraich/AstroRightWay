@extends('layouts.app')
@section('content') 

<!-- Slider Section -->
<section class="home-slider">
    <div id="home-slider" class="carousel slide" data-ride="carousel">

        <!-- The slideshow -->
        <div class="carousel-inner">
            @foreach($bannerSlide as $key => $slide)
            <div class="carousel-item {{ $key == 0 ? 'active':'' }} ">
                @if($slide->heading)
                <div class="slide-imge-overlay"></div>
                @endif
                <img src="{{asset('/public/images/banner/'.$slide->image)}}" alt="{{$slide->heading}}">
                <div class="caption">
                    <div class="container">
                        @if($slide->heading)
                        <div class="caption-in">
                            <div class="caption-ins">
                                <h1 class="text-up">{{$slide->heading}}<span>{{$slide->sub_heading}}</span></h1>
                                @if($slide->button_text)
                                <div class="links"> 
                                    <a href="{{$slide->button_link}}" class="btns slider-btn"><span>{{$slide->button_text}}</span></a> 
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#home-slider" aria-label="slide-next-btn" data-slide="prev">
            <span class="fa fa-angle-left"></span>
        </a>
        <a class="carousel-control-next" href="#home-slider" aria-label="slide-back-btn" data-slide="next">
            <span class="fa fa-angle-right"></span>
        </a>
    </div>
</section>

<section class="chat-service-section section-top container">
  <h1 class="section-heading-txt heading-color text-center text-up">Talk to Astrologer</h1>
  <p class="member-subheading" style="margin-top: 30px;">
          <ul class="service-list animation-css">
            <li>Get your love back</li>
            <li>Love marriage specialist</li>
            <li>Love Problem</li>
            <li>Court Case Problem</li>
            <li>Relationship Problem</li>
            <li>Love Issue</li>
            <li>Manglik Dosh</li>
            <li>Family Problem</li>
            <li>Children Problem</li>
            <li>Kundli Matching Services</li>
            <li>Husband Wife Disputes</li>
          </ul>
    <a href="/talk-astro"><button type="button" class="btn btn-style on-mob-bottom-30" style="margin-top: 40px;">Chat with Astrologer</button></a>
  </p>

</section>

<section class="member-section section-top container">
  <h1 class="section-heading-txt heading-color text-center">Join Helping Plan</h1>
  <p class="member-subheading">If you achieve pearl level then you will get a gift product and when 20 people below you achieve pearl level then you achieve ruby ​​level and you get ten thousand rupees and honor symbol and when 20 people below you ruby ​​level  If you achieve, you achieve the diamond level and you get 1 lakh rupees.
  <br><br>
  आप सभी का दिव्य दृष्टि ज्योतिष भवन में स्वागत है
आप सभी को जानकर ख़ुशी होगी कि "दिव्य दृष्टि ज्योतिष भवन" लेकर आया है एक हेल्पिंग प्लान
जिसमें "दिव्य दृष्टि ज्योतिष भवन" में जुड़ने वाले सभी भक्तों की ज्योतिषीय सहायता के साथ साथ कुछ आर्थिक सहायता भी होगी... <a href="/help-plan" style="color: #ce2350;font-size: 18px;font-weight: 700;">Read More</a> 
    <a href="/join-member"><button type="button" class="btn btn-style on-mob-bottom-30" style="margin-top: 20px;">Join</button></a></p>
  <table id="members">
  <tr>
    <th>Level</th>
    <th>Members</th>
    <th>Achievement</th>
  </tr>
  <tr>
    <td>1. Pearl</td>
    <td>20</td>
    <td>You achieve pearl lavel Get <br>
      One gift voucher Rs.2100 A product
    </td>
  </tr>
  <tr>
    <td>2. Ruby</td>
    <td>400</td>
    <td>Your down 20 pearls <br>
You achieve Ruby Level get Rs. 20.000
    </td>
  </tr>
  <tr>
    <td>3. Diamond</td>
    <td>8000</td>
    <td>Your down 20 Ruby's <br>
You achieve Diamond lavel get 1 lacks 
    </td>
  </tr>
</table>

</section>
<!-- @if(isset($covid))
@foreach($covid as $covidData)
    <section class="chart-section section-top container">
      <h1 class="section-heading-txt heading-color text-center">India Corona Update</h1>
        <div class="last-uptd  m-t-15">
          <div class="last-uptd-txt">Last Update <span style="color: #007bff; font-size: 12px;">({{ $covidData->updated_at->diffForHumans() }})</span>
          <a href="/covid19-update" style="float: right;color: #007bff;font-weight: bold;font-size: 12px;">more..</a>
          </div>
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
        <div id="userChart"></div>
        <input type="hidden" id="confirmed" value="{{$covidData->confirmed}}">
        <input type="hidden" id="recovered" value="{{$covidData->recovered}}">
        <input type="hidden" id="deceased" value="{{$covidData->deceased}}">
        <input type="hidden" id="active" value="{{$covidData->active}}">
    </section>
  @endforeach
  @endif
 -->

<!-- Daily Rashi Section -->
<!--  @if(isset($rashi))
@foreach($rashi as $todayRashi)
    <section class="daily-rashi-section section-top container">
        <h1 class="section-heading-txt heading-color text-center">आज का राशिफल</h1>
            <div class="today-date">{{ date('l, d/m/Y', strtotime($todayRashi->today_date)) }}</div>
            <p class="rashi-sub-heading">कैसा रहेगा आज का दिन आपके लिए? क्या कहते हैं आज के सितारे?</p>
        <div class="row m-t-30">
            <div class="col-sm-12 col-md-8 col-lg-9">

                <div class="row">
                   <div class="col-auto">
                    <a href="/today-rashifal/mesh">
                       <div class="rashi-box">
                           <div class="rashi-name">मेष</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/vrishabh">
                       <div class="rashi-box">
                           <div class="rashi-name">वृषभ</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/mithun">
                       <div class="rashi-box">
                           <div class="rashi-name">मिथुन</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/kark">
                       <div class="rashi-box">
                           <div class="rashi-name">कर्क</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/simha">
                       <div class="rashi-box">
                           <div class="rashi-name">सिंह</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/kanya">
                       <div class="rashi-box">
                           <div class="rashi-name">कन्या</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/tula">
                       <div class="rashi-box">
                           <div class="rashi-name">तुला</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/vrishchik">
                       <div class="rashi-box">
                           <div class="rashi-name">वृश्चिक</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/dhanu">
                       <div class="rashi-box">
                           <div class="rashi-name">धनु</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/makar">
                       <div class="rashi-box">
                           <div class="rashi-name">मकर</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/kumbh">
                       <div class="rashi-box">
                           <div class="rashi-name">कुंभ</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/meen">
                       <div class="rashi-box">
                           <div class="rashi-name">मीन</div>
                       </div>
                     </a>
                   </div>
               </div> 
            </div>
            <div class="col-sm-12 col-md-4 col-lg-3">
              <iframe width="100%" height="100%" src="https://www.youtube.com/embed/bpTzSylho_8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="margin-top: 20px;"></iframe>
              <script src="https://apis.google.com/js/platform.js"></script>
        <div class="g-ytsubscribe" data-channelid="UChU_RSRt7IiqxZTBg577yeQ" data-layout="default" data-count="default"></div>
            </div>
        </div>
    </section>
  @endforeach 
@endif-->

    <!-- Product Show Section Start -->

    <section class="programs-section section-top container">
      <h1 class="section-heading-txt heading-color text-center">Products</h1>
      <div class="row m-t-50">
        @foreach($products->take(6) as $product)
        <div class="col-md-4 mb-cols">
          <div class="product-view-window-div {{ ($product->product_types_id ==2) ? 'block2-labelnew' : '' }} {{ ($product->product_types_id ==1) ? 'block2-labelsale' : '' }}" style="background-image: url(/public/images/products/{{$product->image}});">
              <div class="slide-imge-overlay"></div>
            <div class="product-content">
                <a href="/product-details/{{$product->id}}"><h2 class="m-top heading-color2">{{$product->name}}</h2></a>
                <br>
                <p class="offer-text">₹{{$product->price}}</p>
                <button type="button" class="btn secondary_btn mt40 add-on-cart" addId="{{ $product->id }}">Add to Cart</button>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <a href="/product" class="btn btn-style on-mob-bottom-30" style="margin-top: 20px;width:150px !important;">View More</a>
<!--     <div class="row m-t-50">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="row">
            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-4 p-b-50">
                    <div class="product-block">
                        <div class="block2-img wrap-pic-w of-hidden pos-relative {{ ($product->product_types_id ==2) ? 'block2-labelnew' : '' }} {{ ($product->product_types_id ==1) ? 'block2-labelsale' : '' }}">
                            <img src="{{asset('/public/images/products/'.$product->image)}}" alt="{{$product->name}}">
                            <div class="block2-overlay trans-0-4">
                                <div class="block2-btn-addcart w-size1 trans-0-4">
                                    <button class="flex-c-m trans-0-4 btn secondary_btn mt40 add-on-cart" addId="{{ $product->id }}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="product-content p-t-20">
                            <a href="/product-details/{{$product->id}}" class="dis-block p-b-5">
                                <div class="title">{{$product->name}}</div>
                            </a>
                            <span class="product-price-txt">
                                ₹{{$product->price}}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!--<div class="col-sm-12 col-md-4 col-lg-3">-->
               
        <!--</div>-->
    </div>

    </section>

    <section>
        <div class="parallax-container" id="para_sec">
           <div class="row">
               <div class="col-md-6">
                   <div class="offer-section">
                       <div class="top-tile">
                            Offer
                       </div>
                       <div class="content">
                           <p>First user for special offer get 20% discount on first order.
                            Register Now or apply <span>GET20</span> Coupan Voucher Code.
                           </p>
                       </div>
                   </div>
               </div>
               <div class="col-md-6">
    <div class="form-box-sec">
        <div class="top-tile">
            Register
        </div>
        <form method="POST" action="{{ route('register') }}" class="parallax-form" autocomplete="off">
            @csrf

            <label for="fname" class="dis-none">FName</label>
            <input  type="text" id="fname" class="form-box-input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Name" required>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
            <label for="eaddress" class="dis-none">EAddress</label>
            <input type="email" id="eaddress" class="form-box-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <label for="password" class="dis-none">Password</label>
            <input id="password" type="password" class="form-box-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

            <label class="dis-none" for="phone">Phone</label>
            <input id="phone" type="number" class="form-box-input form-control" name="phone_no" placeholder="Phone">
            <select name="gender" id="select" required class="form-box-input form-control " style="height: 50px;">
              <option value="">-- Select Gender--</option>    
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
 
        <button type="submit" class="btn btn-style btn-top" >Submit</button>
        </form>
    </div>
               </div>
           </div>
        </div>
    </section>

    <section class="m-t-70 container">
        <div class="sec-title p-b-52">
                <div class="t-center heading-color section-heading-txt">
                    Gallery
                </div>
            </div>
        <div class="row">
                <div class="col-md-12 col-lg-12">
                    @foreach($gellery->take(2) as $item)
                    <div class="p-r-50 p-r-0-lg">
                        <!-- item blog -->
                        <div class="item-blog">
                            <a href="#" class="item-blog-img pos-relative dis-block hov-img-zoom">
                                <img src="{{asset('/public/images/gellery/'.$item->image)}}" alt="{{ $item->title }}">

                                <span class="item-blog-date dis-block flex-c-m pos1 size17 bg4 s-text1">{{$item->created_at->format('j M, Y')}}
                                </span>
                            </a>

                            <div class="item-blog-txt p-t-33">
                                <div class="heading-title p-b-11">
                                    <a href="#" class="m-text24" aria-label="{{ $item->title }}">
                                        {{ $item->title }}
                                    </a>
                                </div>

                                <p class="p-b-12">
                                    {{ $item->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!--<div class="col-md-4 col-lg-3">-->
                    
                <!--</div>-->
            </div>
            <a href="/gallery" class="btn btn-style on-mob-bottom-30" style="margin-top: 20px;width:150px !important;">View More</a>
    </section>

    

    <!-- Blog -->
    <section class="blog bgwhite m-t-70">
        <div class="container">
            <div class="sec-title p-b-52">
                <div class="t-center heading-color section-heading-txt">
                    Videos
                </div>
            </div>
            <div class="row">
              @foreach ($videos->take(3) as $videoData)
                <div class="col-sm-10 col-md-4 p-b-30 m-l-r-auto">

                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoData->url}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>  

                        <div class="block3-txt p-t-14">
                            <div class="heading-title p-b-7">
                                    {{ $videoData->title}}
                            </div>

                            <span class="s-text6">By</span> <span class="s-text7">{{ $videoData->auth}}</span>
                            <span class="s-text6">on</span> <span class="s-text7">{{$videoData->created_at->format('j M, Y')}}</span>
                        </div>
                    
                </div>
             @endforeach
            </div>
            <a href="/youtube-videos" class="btn btn-style on-mob-bottom-30" style="margin-top: 20px;width:150px !important;">View More</a>
        </div>
    </section>

<!--     <div id="startUpModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">How to Register Account</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <iframe width="100%" height="100%" src="https://www.youtube.com/embed/bpTzSylho_8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <p>Subscribe to our channel</p>
               <script src="https://apis.google.com/js/platform.js"></script>
        <div class="g-ytsubscribe" data-channelid="UChU_RSRt7IiqxZTBg577yeQ" data-layout="default" data-count="default"></div>
            </div>
        </div>
    </div>
</div> -->

<script src="/public/js/parallax.js"></script>
 <script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>
 <script> 
    // $(document).ready(function(){
    //     setTimeout(function(){
    //         $("#startUpModal").modal('show');
    //     }, 5000);
        
    // });



        $('.add-on-cart').on('click', function(){
                var product_id = $(this).attr("addId");
                    // console.log(product_id);
                $.ajax({

                //type: "POST",

                dataType: 'json',
                url: "cart",
                method : 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: 'id='+product_id,
                success: function (data) {
                    if (data['success']) {
                       toastr.success("Product Add on Cart","Successfuly");
                        window.location.href = '/cart';
                    } else if (data['error']) {
                       toastr.error(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                    
                },
                error: function (data) {
                    toastr.error(data.responseText,"error");
                }
                });
            });

        // Nothing new here...it's all in the CSS!
    var scene = document.getElementById('para_sec');
    var parallax = new Parallax(scene);
            
</script>

<style>
/*#userChart {
  width: 100%;
  height: 580px;
}*/
ul.service-list{
  border: 4px solid #ce2350;
  padding: 40px; width: 100%;
  min-width: 280px;
  max-width: 500px;
  margin: auto;
  font-size: 16px;
    font-weight: 600;
    color: #007bff;
}
@keyframes blink { 
   50% { color: #fff;
    font-weight: 400;
   background-color:  #000;} 
}
.animation-css{ 
    animation: blink .6s step-end infinite alternate;
}
</style>

<!-- <script src="/public/amcharts4/core.js"></script>
<script src="/public/amcharts4/charts.js"></script>
<script src="/public/amcharts4/plugins/sunburst.js"></script>
<script src="/public/amcharts4/themes/animated.js"></script>
 -->
<!-- Chart code -->
<script>
// am4core.ready(function() {

// // Themes begin
// am4core.useTheme(am4themes_animated);
// // Themes end

// var ConfirmedCase = document.getElementById("confirmed").value;
// var RecoveredCase = document.getElementById("recovered").value;
// var DeceasedCase = document.getElementById("deceased").value;
// var ActiveCase = document.getElementById("active").value;


// /**
//  * COVID19 Status Chart
//  */

// var chart = am4core.create("userChart", am4charts.PieChart);

// // Add and configure Series
// var pieSeries = chart.series.push(new am4charts.PieSeries());
// pieSeries.dataFields.value = "values";
// pieSeries.dataFields.category = "type";

// // Let's cut a hole in our Pie chart the size of 30% the radius
// chart.innerRadius = am4core.percent(50);

// // Put a thick white border around each Slice
// pieSeries.slices.template.stroke = am4core.color("#fff");
// pieSeries.slices.template.strokeWidth = 2;
// pieSeries.slices.template.strokeOpacity = 1;
// pieSeries.slices.template

//   // change the cursor on hover to make it apparent the object can be interacted with
//   .cursorOverStyle = [
//     {
//       "property": "cursor",
//       "value": "pointer"
//     }
//   ];

// pieSeries.alignLabels = false;
// pieSeries.labels.template.bent = true;
// pieSeries.labels.template.radius = 3;
// pieSeries.labels.template.padding(0,0,0,0);
// pieSeries.labels.template.disabled = true;

// pieSeries.ticks.template.disabled = true;
// pieSeries.colors.list = [
//   am4core.color("#007bff"),
//   am4core.color("#28a745"),
//   am4core.color("#FF8800"),
//   am4core.color("#dc3545"),
// ];
// // Create a base filter effect (as if it's not there) for the hover to return to
// var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
// shadow.opacity = 0;

// // Create hover state
// var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

// // Slightly shift the shadow and make it more prominent on hover
// var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
// hoverShadow.opacity = 0.7;
// hoverShadow.blur = 5;

// // Add a legend
// chart.legend = new am4charts.Legend();
// chart.legend.position = "bottom";
// chart.data = [
//     {
//       type: "Confirm",
//       values: ConfirmedCase
//     },
//     {
//       type: "Recover",
//       values: RecoveredCase
//     },
//     {
//       type: "Active",
//       values: ActiveCase
//     },
//     {
//       type: "Death",
//       values: DeceasedCase
//     } 
//   ];

// }); // end am4core.ready()

</script>

 @endsection