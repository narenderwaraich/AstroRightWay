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

<div class="container">
    <section class="member-section section-top container">
  <h1 class="section-heading-txt heading-color text-center">Join Helping Plan</h1>
  <p class="member-subheading">If you achieve pearl level then you will get a gift product and when 20 people below you achieve pearl level then you achieve ruby ​​level and you get ten thousand rupees and honor symbol and when 20 people below you ruby ​​level  If you achieve, you achieve the diamond level and you get 1 lakh rupees.
    <a href="/join-member"><button type="button" class="btn btn-style" style="margin-top: 20px;">Join</button></a></p>
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
<br><br>
<p class="member-subheading">
    आप सभी का दिव्य दृष्टि ज्योतिष भवन में स्वागत है
आप सभी को जानकर ख़ुशी होगी कि "दिव्य दृष्टि ज्योतिष भवन" लेकर आया है एक हेल्पिंग प्लान
जिसमें "दिव्य दृष्टि ज्योतिष भवन" में जुड़ने वाले सभी भक्तों की ज्योतिषीय सहायता के साथ साथ कुछ आर्थिक सहायता भी होगी
आप एस्ट्रो राइट वे वेबसाइट में लॉगिन होकर स्टेप बाय स्टेप प्राप्त कर सकते सकते हैं 1 लाख 20 हज़ार व एक 2100 रुपए तक का गिफ़्ट व स्मान चिन्ह
आइए बताते हैं आपको कैसे करना होगा !

जैसा कि आप जानते हैं कुंडली देखने हमारी वेबसाइट पर कई प्रकार के प्लान है 11 रुपए में 1 प्रश्न, 51 रुपए में 5 प्रश्न, 350 में कुंडली का फ़लादेश, 550/- रुपए में सम्पूर्ण कुंडली का फ़लादेश व आपके हर ज्योतिष विषय के प्रश्न का उत्तर समाधान सहित बताया जाता है,
और आपकी तरफ से दी जाने वाली इस राशी को हमारे भवन के ब्राह्मण जरूरतमन्दो की सहायता में समय समय पर लगाते रहते हैं

पर ये प्लान कुछ अलग है
आपको कुंडली दिखवाने के मात्र 101/- रुपये देने होंगे
आपकी तरफ़ से दिए जाने वाली राशि धर्म कर्म में लगाई जाएगी

आपको वेबसाइट पर 1 महीने के लिए सदस्य बन गए
1 महीने तक अपने बारे पूछ सकतें हैं आप वेबसाइट पर लॉगिन करके अपनी प्रोफाइल बनाते हो तो आपको एक स्पेशल कोड मिलेगा
उस कोड को आप आगे अपने मित्रों बंधुओं में शेयर करोगे
जैसे ही आपके बताए अनुसार 20 व्यक्ति 1 महीने के अंदर अगर 101 रुपये देकर अपने बारे पूछते हैं तो
आपको भवन की तरफ़ से "पर्सल सदस्य" के रूप में स्मानित कर आपको 2100/- तक का कोई भी 1 प्रोडक्ट उपहार स्वरूप दिया जाएगा !
(उदहारण : जैसे कोई राशि रत्न लेबोरेट्री टेस्टड, यन्त्र, लॉकेट, पेंडेंट, माला आदि)
😃😃😃😃

इसी प्रकार आपके 20 सदस्य अगर "पर्सल सदस्य" बनते हैं यानी वो भी महीने तक उपहार प्राप्त कर लेते हैं तो आपको
"रूबी सदस्य" के नाम से स्मानितकर 20 हज़ार रुपए व एक स्मान चिन्ह उपहार स्वरूप दिया जाएगा,
😃😃😃😃

इसी प्रकार अगर आपके 20 सदस्य "रूबी सदस्य" बनते हैं तो आपको "डायमंड सस्यद" नाम से स्मानित कर 1 लाख रुपये उपहार स्वरूप दिए जाएंगे
😃😃😃😃

नॉट:- "पर्ल सदस्य" बनने पर स्मान में मिलने वाला उपहार आप जहां भी जिस भी देश विदेश गांव शहर में मंगवाओगे
कॉरियर का चार्ज आपको देना होगा !

👍🏻👍🏻👍🏻👍🏻👍🏻
अपने लिए व एक दूसरों की सहायता के लिए बहुत ही अच्छा पुण्यदायक काम है
आगे शेयर करें जी 
धन्यवाद 🙏🏻
🙏🏻🙏🏻🙏🏻🙏🏻🙏🏻
</p>
</section>
</div>
@endsection
