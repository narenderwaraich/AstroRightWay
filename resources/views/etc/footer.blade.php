<div class="container-fluid footer">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <div class="footer-text">
                about AstroRightWay
              </div>
              <center>
              <a class="" href="/" aria-label="home">
              <img src="/public/images/icons/logo.png"  class="footer-logo" alt="footer-web-logo"> 
              </a>
            </center>
             <div class="social-icon">
                  <a href="https://www.facebook.com/Astrorightway" aria-label="Facebook"><i class="fa fa-facebook-f"></i></a>
                  <a href="https://www.instagram.com/astrorightway" aria-label="Instagram"><i class="fa fa-instagram"></i></a>
                  <a href="https://www.youtube.com/channel/UC0qHv0_3Dtcu2A-3ei6lNbw" aria-label="YouTube"><i class="fa fa-youtube"></i></a>
            </div>
            <a class="footer-email-address" href="mailto:info@astrorightway.com">info@astrorightway.com</a>
              <!-- <div class="footer-copyright-text"> AstroRightWays @ all right reserved</div> -->
            </div>

            <div class="col-md-4">
              <div class="footer-text">
                Links
              </div>
              <div class="footer-text2">
                <div class="menu-link {{ (request()->is('about-us')) ? 'active' : '' }}">
                  <a href="/about-us" class="footer-nav">About Us</a>
                </div>
                <div class="menu-link {{ (request()->is('term-of-services')) ? 'active' : '' }}">
                  <a href="/term-of-services" class="footer-nav">Term-of-Service</a>
                </div>
                <div class="menu-link {{ (request()->is('privacy-policy')) ? 'active' : '' }}">
                  <a href="/privacy-policy" class="footer-nav">Privacy Policy</a>
                </div>
              </div>
              <div>
                
              </div>
            </div>

            <div class="col-md-4 footer-form">
              <div class="footer-text">
                CONTACT US
              </div>
              <form action="/contact-us" method="post">
                        {{ csrf_field() }}
              <div class="form-group" style="margin-top: 15px;">
                <label for="name" class="dis-none">Name</label>
                  <input type="text" id="name" class="form-control footer-input-filed {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"  placeholder="Name" required value="{{ old('name') }}">
                  @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $errors->first('name') }}</strong>
                    </span>
                 @endif
              </div>
              <div class="form-group">
                <label for="email" class="dis-none">Email</label>
                  <input type="text" id="email" class="form-control footer-input-filed {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"  placeholder="Email" required value="{{ old('email') }}">
                  @if ($errors->has('email'))
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('email') }}</strong>
                       </span>
                 @endif
              </div>
              <div class="form-group">
                <label for="message" class="dis-none">Message</label>
                  <textarea id="message" class="form-control footer-text-filed {{ $errors->has('message') ? ' is-invalid' : '' }}" rows="3"  name="message"  placeholder="Message" required></textarea>
                   @if ($errors->has('message'))
                   <span class="invalid-feedback" role="alert">
                       <strong>{{ $errors->first('message') }}</strong>
                   </span>
               @endif
              </div>
              <center>
                <button type="submit" class="btn btn-block btn-lg footer-sub-btn">Send</button>
              </center>
            </form>
              </div>
            </div>
          </div>
        </div>