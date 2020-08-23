@extends('layouts.app')
@section('content') 
  <div class="banner">
  <img src="/public/images/banner/banner_bg.jpg" alt=""/>
  <div class="slider-imge-overlay"></div>
  <div class="caption text-center">
    <div class="container">
      <div class="caption-in">
        <div class="caption-ins">
          <h1>Hello<span>Test</span></h1>
          <div class="links"> 
            <a href="#" class="btns slider-btn"><span>Button</span></a> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 <div class="payOut-box">
    <div class="payOut-box-container">
      <div class="payOut-box-left">
        <button type="button" class="bk-btn-arrow">
          <i class="fa fa-arrow-left icn-back"></i>
        </button>
        <div class="img-box"></div>
        <img src="" class="product-ims" />
      </div>
      <div class="payOut-box-right">
        <h2>Card Details</h2>
        <br>
        <form>
          <ul class="payOut-box-form-list">
            <li class="payOut-box-form-list-row">
              <label>Name</label>
              <input type="text" name="name" required="" placeholder="Card Name" />
            </li>
            <li class="payOut-box-form-list-row">
              <label>Card Number</label>
              <div id="input--cc" class="creditcard-icon">
                <input type="text" name="card_number" required="" placeholder="Card-Number" />
              </div>
            </li>
            <li class="payOut-box-form-list-row payOut-box-form-list-row-in">
              <div>
                <label>Expiration Date</label>
                <div class="payOut-box-form-input-inline">
                  <input type="text" name="cc_month" placeholder="MM"  pattern="\\d*" minlength="2" maxlength="2" required="" />
                  <input type="text" name="cc_year" placeholder="YY"  pattern="\\d*" minlength="2" maxlength="2" required="" />
                </div>
              </div>
              <div>
                <label>CVC</label>
                <input type="text" name="cc_cvc" placeholder="123" pattern="\\d*" minlength="3" maxlength="4" required="" />
              </div>
            </li>
            <li class="payOut-box-form-list-row payOut-box-card-save">
              <label>
                <input type="checkbox" name="save_cc" checked="checked">Save Card
              </label>
            </li>
            <li>
              <button type="submit" class="button sub-btn">Pay Now</button>
            </li>
          </ul>
        </form>
      </div> 
    </div> 
  </div> 

@endsection